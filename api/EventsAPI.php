<?php
require_once 'BaseAPI.php';

class EventsAPI extends BaseAPI {
    public function __construct() {
        parent::__construct('events');
    }
    
    public function handleRequest() {
        $this->setHeaders();
        
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        
        try {
            switch ($method) {
                case 'GET':
                    $id = $_GET['id'] ?? null;
                    $this->read($id);
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
        $required_fields = ['title', 'date', 'performer', 'city', 'description'];
        $this->validateRequired($data, $required_fields);
        
        // Validate date format
        if (!DateTime::createFromFormat('Y-m-d', $data['date'])) {
            throw new Exception('Invalid date format. Use YYYY-MM-DD');
        }
        
        $event_id = $this->generateId('event_');
        
        $event_data = [
            'id' => $event_id,
            'title' => $this->sanitizeInput($data['title']),
            'date' => $data['date'],
            'performer' => $this->sanitizeInput($data['performer']),
            'city' => $this->sanitizeInput($data['city']),
            'description' => $this->sanitizeInput($data['description'])
        ];
        
        if ($this->conn) {
            // Database storage
            $query = "INSERT INTO events (id, title, date, performer, city, description) 
                     VALUES (:id, :title, :date, :performer, :city, :description)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($event_data);
        } else {
            // JSON file fallback
            $events = $this->getJsonFile('events.json');
            array_unshift($events, $event_data);
            $this->saveJsonFile('events.json', $events);
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Event created successfully',
            'event' => $event_data
        ], 201);
    }
    
    public function read($id = null) {
        if ($this->conn) {
            // Database storage
            if ($id) {
                $query = "SELECT * FROM events WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $event = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$event) {
                    $this->sendError('Event not found', 404);
                }
                
                $this->sendResponse(['success' => true, 'event' => $event]);
            } else {
                $query = "SELECT * FROM events ORDER BY date DESC";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $this->sendResponse(['success' => true, 'data' => $events]);
            }
        } else {
            // JSON file fallback
            $events = $this->getJsonFile('events.json');
            
            if ($id) {
                $event = array_filter($events, function($e) use ($id) {
                    return $e['id'] === $id;
                });
                
                if (empty($event)) {
                    $this->sendError('Event not found', 404);
                }
                
                $this->sendResponse(['success' => true, 'event' => array_values($event)[0]]);
            } else {
                $this->sendResponse(['success' => true, 'data' => $events]);
            }
        }
    }
    
    public function update($id, $data) {
        if (!$id) {
            throw new Exception('Event ID is required');
        }
        
        $allowed_fields = ['title', 'date', 'performer', 'city', 'description'];
        $update_data = [];
        
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                if ($field === 'date' && !DateTime::createFromFormat('Y-m-d', $data[$field])) {
                    throw new Exception('Invalid date format. Use YYYY-MM-DD');
                }
                $update_data[$field] = $this->sanitizeInput($data[$field]);
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
            
            $query = "UPDATE events SET $set_clause WHERE id = :id";
            $update_data['id'] = $id;
            
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($update_data);
            
            if ($stmt->rowCount() === 0) {
                $this->sendError('Event not found or no changes made', 404);
            }
        } else {
            // JSON file fallback
            $events = $this->getJsonFile('events.json');
            $found = false;
            
            foreach ($events as &$event) {
                if ($event['id'] === $id) {
                    foreach ($update_data as $field => $value) {
                        $event[$field] = $value;
                    }
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $this->sendError('Event not found', 404);
            }
            
            $this->saveJsonFile('events.json', $events);
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Event updated successfully'
        ]);
    }
    
    public function delete($id) {
        if (!$id) {
            throw new Exception('Event ID is required');
        }
        
        if ($this->conn) {
            // Database storage
            $query = "DELETE FROM events WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                $this->sendError('Event not found', 404);
            }
        } else {
            // JSON file fallback
            $events = $this->getJsonFile('events.json');
            $original_count = count($events);
            
            $events = array_filter($events, function($event) use ($id) {
                return $event['id'] !== $id;
            });
            
            if (count($events) === $original_count) {
                $this->sendError('Event not found', 404);
            }
            
            $this->saveJsonFile('events.json', array_values($events));
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }
}

// Handle API requests
if (basename($_SERVER['PHP_SELF']) === 'EventsAPI.php') {
    $api = new EventsAPI();
    $api->handleRequest();
}
?>
