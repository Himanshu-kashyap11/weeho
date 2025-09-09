<?php
require_once 'BaseAPI.php';

class RegistrationsAPI extends BaseAPI {
    public function __construct() {
        parent::__construct('registrations');
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
        $required_fields = ['name', 'email', 'phone'];
        $this->validateRequired($data, $required_fields);
        
        // Validate email
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new Exception('Invalid email address');
        }
        
        $registration_id = $this->generateId('reg_');
        
        $registration_data = [
            'id' => $registration_id,
            'event_id' => isset($data['eventId']) ? $this->sanitizeInput($data['eventId']) : (isset($data['event_id']) ? $this->sanitizeInput($data['event_id']) : ''),
            'name' => $this->sanitizeInput($data['name']),
            'email' => $email,
            'phone' => $this->sanitizeInput($data['phone']),
            'role' => isset($data['role']) ? $this->sanitizeInput($data['role']) : '',
            'city' => isset($data['city']) ? $this->sanitizeInput($data['city']) : '',
            'status' => 'confirmed'
        ];
        
        // Check for duplicate registration
        if ($this->isDuplicateRegistration($registration_data['event_id'], $registration_data['email'])) {
            throw new Exception('You have already registered for this event');
        }
        
        if ($this->conn) {
            // Database storage
            $query = "INSERT INTO registrations (id, event_id, name, email, phone, role, city, status) 
                     VALUES (:id, :event_id, :name, :email, :phone, :role, :city, :status)";
            
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($registration_data);
            
            if (!$result) {
                throw new Exception('Failed to save registration to database');
            }
        } else {
            // JSON file fallback
            $registration_data['timestamp'] = date('Y-m-d H:i:s');
            $registrations = $this->getJsonFile('registrations.json');
            $registrations[] = $registration_data;
            $success = $this->saveJsonFile('registrations.json', $registrations);
            
            if (!$success) {
                throw new Exception('Failed to save registration to file');
            }
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Registration successful!',
            'registration_id' => $registration_id
        ], 201);
    }
    
    public function read($id = null, $event_id = null) {
        if ($this->conn) {
            // Database storage
            if ($id) {
                $query = "SELECT r.*, e.title as event_title FROM registrations r 
                         LEFT JOIN events e ON r.event_id = e.id WHERE r.id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $registration = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$registration) {
                    $this->sendError('Registration not found', 404);
                }
                
                $this->sendResponse(['success' => true, 'registration' => $registration]);
            } else {
                $query = "SELECT r.*, e.title as event_title FROM registrations r 
                         LEFT JOIN events e ON r.event_id = e.id";
                $params = [];
                
                if ($event_id) {
                    $query .= " WHERE r.event_id = :event_id";
                    $params['event_id'] = $event_id;
                }
                
                $query .= " ORDER BY r.created_at DESC";
                
                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $this->sendResponse(['success' => true, 'registrations' => $registrations]);
            }
        } else {
            // JSON file fallback
            $registrations = $this->getJsonFile('registrations.json');
            
            if ($event_id) {
                $registrations = array_filter($registrations, function($r) use ($event_id) {
                    return $r['event_id'] === $event_id;
                });
            }
            
            if ($id) {
                $registration = array_filter($registrations, function($r) use ($id) {
                    return $r['id'] === $id;
                });
                
                if (empty($registration)) {
                    $this->sendError('Registration not found', 404);
                }
                
                $this->sendResponse(['success' => true, 'registration' => array_values($registration)[0]]);
            } else {
                $this->sendResponse(['success' => true, 'registrations' => array_values($registrations)]);
            }
        }
    }
    
    public function update($id, $data) {
        if (!$id) {
            throw new Exception('Registration ID is required');
        }
        
        $allowed_fields = ['name', 'email', 'phone', 'role', 'city', 'status'];
        $update_data = [];
        
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                if ($field === 'email') {
                    $email = filter_var(trim($data[$field]), FILTER_VALIDATE_EMAIL);
                    if (!$email) {
                        throw new Exception('Invalid email address');
                    }
                    $update_data[$field] = $email;
                } elseif ($field === 'status' && !in_array($data[$field], ['pending', 'confirmed', 'cancelled'])) {
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
            
            $query = "UPDATE registrations SET $set_clause WHERE id = :id";
            $update_data['id'] = $id;
            
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($update_data);
            
            if ($stmt->rowCount() === 0) {
                $this->sendError('Registration not found or no changes made', 404);
            }
        } else {
            // JSON file fallback
            $registrations = $this->getJsonFile('registrations.json');
            $found = false;
            
            foreach ($registrations as &$registration) {
                if ($registration['id'] === $id) {
                    foreach ($update_data as $field => $value) {
                        $registration[$field] = $value;
                    }
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $this->sendError('Registration not found', 404);
            }
            
            $this->saveJsonFile('registrations.json', $registrations);
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Registration updated successfully'
        ]);
    }
    
    public function delete($id) {
        if (!$id) {
            throw new Exception('Registration ID is required');
        }
        
        if ($this->conn) {
            // Database storage
            $query = "DELETE FROM registrations WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                $this->sendError('Registration not found', 404);
            }
        } else {
            // JSON file fallback
            $registrations = $this->getJsonFile('registrations.json');
            $original_count = count($registrations);
            
            $registrations = array_filter($registrations, function($registration) use ($id) {
                return $registration['id'] !== $id;
            });
            
            if (count($registrations) === $original_count) {
                $this->sendError('Registration not found', 404);
            }
            
            $this->saveJsonFile('registrations.json', array_values($registrations));
        }
        
        $this->sendResponse([
            'success' => true,
            'message' => 'Registration deleted successfully'
        ]);
    }
    
    private function isDuplicateRegistration($event_id, $email) {
        if ($this->conn) {
            $query = "SELECT COUNT(*) FROM registrations WHERE event_id = :event_id AND email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['event_id' => $event_id, 'email' => $email]);
            return $stmt->fetchColumn() > 0;
        } else {
            $registrations = $this->getJsonFile('registrations.json');
            foreach ($registrations as $registration) {
                if ($registration['event_id'] === $event_id && $registration['email'] === $email) {
                    return true;
                }
            }
            return false;
        }
    }
}

// Handle API requests
if (basename($_SERVER['PHP_SELF']) === 'RegistrationsAPI.php') {
    $api = new RegistrationsAPI();
    $api->handleRequest();
}
?>
