<?php
require_once 'BaseAPI.php';

class FeedbackAPI extends BaseAPI {
    public function __construct() {
        parent::__construct('feedback');
    }
    
    public function handleRequest() {
        $this->setHeaders();
        
        $method = $_SERVER['REQUEST_METHOD'];
        
        try {
            switch ($method) {
                case 'GET':
                    $id = $_GET['id'] ?? null;
                    $event_id = $_GET['event_id'] ?? null;
                    $this->read($id, $event_id);
                    break;
                case 'POST':
                    $data = $this->getInput();
                    $this->create($data);
                    break;
                case 'PUT':
                    $id = $_GET['id'] ?? null;
                    $data = $this->getInput();
                    $this->update($id, $data);
                    break;
                case 'DELETE':
                    $id = $_GET['id'] ?? null;
                    $this->delete($id);
                    break;
                default:
                    $this->sendError('Method not allowed', 405);
            }
        } catch (Exception $e) {
            $this->sendError($e->getMessage());
        }
    }
    
    public function create($data) {
        $required_fields = ['eventId', 'name', 'rating', 'feedback'];
        $this->validateRequired($data, $required_fields);
        
        // Validate rating
        $rating = intval($data['rating']);
        if ($rating < 1 || $rating > 5) {
            throw new Exception('Rating must be between 1 and 5');
        }
        
        $feedback_id = $this->generateId('feedback_');
        
        $feedback_data = [
            'id' => $feedback_id,
            'event_id' => $this->sanitizeInput($data['eventId']),
            'name' => $this->sanitizeInput($data['name']),
            'rating' => $rating,
            'feedback' => $this->sanitizeInput($data['feedback']),
            'status' => 'active'
        ];
        
        if ($this->conn) {
            // Database storage
            $query = "INSERT INTO feedback (id, event_id, name, rating, feedback, status) 
                     VALUES (:id, :event_id, :name, :rating, :feedback, :status)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($feedback_data);
        } else {
            // JSON file fallback
            $feedback_data['timestamp'] = date('Y-m-d H:i:s');
            $feedback_list = $this->getJsonFile('feedback.json');
            $feedback_list[] = $feedback_data;
            $this->saveJsonFile('feedback.json', $feedback_list);
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Feedback submitted successfully',
            'feedback_id' => $feedback_id
        ], 201);
    }
    
    public function read($id = null, $event_id = null) {
        if ($this->conn) {
            // Database storage
            if ($id) {
                $query = "SELECT f.*, e.title as event_title FROM feedback f 
                         LEFT JOIN events e ON f.event_id = e.id WHERE f.id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $feedback = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$feedback) {
                    $this->sendError('Feedback not found', 404);
                }
                
                $this->sendResponse(['success' => true, 'feedback' => $feedback]);
            } else {
                $query = "SELECT f.*, e.title as event_title FROM feedback f 
                         LEFT JOIN events e ON f.event_id = e.id WHERE f.status = 'active'";
                $params = [];
                
                if ($event_id) {
                    $query .= " AND f.event_id = :event_id";
                    $params['event_id'] = $event_id;
                }
                
                $query .= " ORDER BY f.created_at DESC";
                
                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                $feedback_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $this->sendResponse(['success' => true, 'feedback' => $feedback_list]);
            }
        } else {
            // JSON file fallback
            $feedback_list = $this->getJsonFile('feedback.json');
            
            // Filter active feedback
            $feedback_list = array_filter($feedback_list, function($f) {
                return !isset($f['status']) || $f['status'] === 'active';
            });
            
            if ($event_id) {
                $feedback_list = array_filter($feedback_list, function($f) use ($event_id) {
                    return $f['event_id'] === $event_id;
                });
            }
            
            if ($id) {
                $feedback = array_filter($feedback_list, function($f) use ($id) {
                    return $f['id'] === $id;
                });
                
                if (empty($feedback)) {
                    $this->sendError('Feedback not found', 404);
                }
                
                $this->sendResponse(['success' => true, 'feedback' => array_values($feedback)[0]]);
            } else {
                $this->sendResponse(['success' => true, 'feedback' => array_values($feedback_list)]);
            }
        }
    }
    
    public function update($id, $data) {
        if (!$id) {
            throw new Exception('Feedback ID is required');
        }
        
        $allowed_fields = ['name', 'rating', 'feedback', 'status'];
        $update_data = [];
        
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                if ($field === 'rating') {
                    $rating = intval($data[$field]);
                    if ($rating < 1 || $rating > 5) {
                        throw new Exception('Rating must be between 1 and 5');
                    }
                    $update_data[$field] = $rating;
                } elseif ($field === 'status' && !in_array($data[$field], ['active', 'hidden'])) {
                    throw new Exception('Invalid status value');
                } else {
                    $update_data[$field] = $this->sanitizeInput($data[$field]);
                }
            }
        }
        
        if (empty($update_data)) {
            throw new Exception('No valid fields to update');
        }
        
        if ($this->conn) {
            // Database storage
            $set_clause = implode(', ', array_map(function($field) {
                return "$field = :$field";
            }, array_keys($update_data)));
            
            $query = "UPDATE feedback SET $set_clause WHERE id = :id";
            $update_data['id'] = $id;
            
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($update_data);
            
            if ($stmt->rowCount() === 0) {
                $this->sendError('Feedback not found or no changes made', 404);
            }
        } else {
            // JSON file fallback
            $feedback_list = $this->getJsonFile('feedback.json');
            $found = false;
            
            foreach ($feedback_list as &$feedback) {
                if ($feedback['id'] === $id) {
                    foreach ($update_data as $field => $value) {
                        $feedback[$field] = $value;
                    }
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $this->sendError('Feedback not found', 404);
            }
            
            $this->saveJsonFile('feedback.json', $feedback_list);
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Feedback updated successfully'
        ]);
    }
    
    public function delete($id) {
        if (!$id) {
            throw new Exception('Feedback ID is required');
        }
        
        if ($this->conn) {
            // Database storage
            $query = "DELETE FROM feedback WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                $this->sendError('Feedback not found', 404);
            }
        } else {
            // JSON file fallback
            $feedback_list = $this->getJsonFile('feedback.json');
            $original_count = count($feedback_list);
            
            $feedback_list = array_filter($feedback_list, function($feedback) use ($id) {
                return $feedback['id'] !== $id;
            });
            
            if (count($feedback_list) === $original_count) {
                $this->sendError('Feedback not found', 404);
            }
            
            $this->saveJsonFile('feedback.json', array_values($feedback_list));
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Feedback deleted successfully'
        ]);
    }
}

// Handle API requests
if (basename($_SERVER['PHP_SELF']) === 'FeedbackAPI.php') {
    $api = new FeedbackAPI();
    $api->handleRequest();
}
?>
