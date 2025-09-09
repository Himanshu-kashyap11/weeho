<?php
require_once 'BaseAPI.php';

class AdminAPI extends BaseAPI {
    public function __construct() {
        parent::__construct('admin_users');
    }
    
    public function handleRequest() {
        $this->setHeaders();
        
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? '';
        
        try {
            switch ($action) {
                case 'login':
                    if ($method === 'POST') {
                        $data = $this->getInput();
                        $this->login($data);
                    } else {
                        $this->sendError('Method not allowed', 405);
                    }
                    break;
                case 'dashboard':
                    $this->getDashboardData();
                    break;
                case 'stats':
                    $this->getStats();
                    break;
                default:
                    $this->sendError('Invalid action', 400);
            }
        } catch (Exception $e) {
            $this->sendError($e->getMessage());
        }
    }
    
    public function login($data) {
        $required_fields = ['username', 'password'];
        $this->validateRequired($data, $required_fields);
        
        $username = $this->sanitizeInput($data['username']);
        $password = $data['password'];
        
        // Default admin credentials (in production, use hashed passwords)
        $default_admins = [
            'admin' => 'weeho2024',
            'moderator' => 'weeho123'
        ];
        
        if (isset($default_admins[$username]) && $default_admins[$username] === $password) {
            // Generate session token (simple implementation)
            $token = bin2hex(random_bytes(32));
            
            // In production, store this in database or session
            $_SESSION['admin_token'] = $token;
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_role'] = $username === 'admin' ? 'admin' : 'moderator';
            
            $this->sendResponse([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'username' => $username,
                'role' => $_SESSION['admin_role']
            ]);
        } else {
            $this->sendError('Invalid credentials', 401);
        }
    }
    
    public function getDashboardData() {
        // Get counts and recent data
        $data = [
            'events' => $this->getEventsData(),
            'registrations' => $this->getRegistrationsData(),
            'feedback' => $this->getFeedbackData(),
            'team_feedback' => $this->getTeamFeedbackData()
        ];
        
        $this->sendResponse(['success' => true, 'data' => $data]);
    }
    
    public function getStats() {
        $stats = [
            'total_events' => 0,
            'total_registrations' => 0,
            'total_feedback' => 0,
            'average_rating' => 0,
            'recent_activity' => []
        ];
        
        if ($this->conn) {
            // Database queries
            $queries = [
                'total_events' => "SELECT COUNT(*) FROM events",
                'total_registrations' => "SELECT COUNT(*) FROM registrations",
                'total_feedback' => "SELECT COUNT(*) FROM feedback",
                'average_rating' => "SELECT AVG(rating) FROM feedback WHERE status = 'active'"
            ];
            
            foreach ($queries as $key => $query) {
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                $stats[$key] = $stmt->fetchColumn();
            }
            
            // Recent activity
            $activity_query = "
                SELECT 'event' as type, title as name, created_at FROM events
                UNION ALL
                SELECT 'registration' as type, name, created_at FROM registrations
                UNION ALL
                SELECT 'feedback' as type, name, created_at FROM feedback
                ORDER BY created_at DESC LIMIT 10
            ";
            $stmt = $this->conn->prepare($activity_query);
            $stmt->execute();
            $stats['recent_activity'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // JSON file fallback
            $events = $this->getJsonFile('events.json');
            $registrations = $this->getJsonFile('registrations.json');
            $feedback = $this->getJsonFile('feedback.json');
            
            $stats['total_events'] = count($events);
            $stats['total_registrations'] = count($registrations);
            $stats['total_feedback'] = count($feedback);
            
            // Calculate average rating
            $ratings = array_column($feedback, 'rating');
            $stats['average_rating'] = !empty($ratings) ? array_sum($ratings) / count($ratings) : 0;
        }
        
        $this->sendResponse(['success' => true, 'stats' => $stats]);
    }
    
    private function getEventsData() {
        if ($this->conn) {
            $query = "SELECT * FROM events ORDER BY created_at DESC LIMIT 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $events = $this->getJsonFile('events.json');
            return array_slice($events, 0, 5);
        }
    }
    
    private function getRegistrationsData() {
        if ($this->conn) {
            $query = "SELECT r.*, e.title as event_title FROM registrations r 
                     LEFT JOIN events e ON r.event_id = e.id 
                     ORDER BY r.created_at DESC LIMIT 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $registrations = $this->getJsonFile('registrations.json');
            return array_slice($registrations, 0, 5);
        }
    }
    
    private function getFeedbackData() {
        if ($this->conn) {
            $query = "SELECT f.*, e.title as event_title FROM feedback f 
                     LEFT JOIN events e ON f.event_id = e.id 
                     WHERE f.status = 'active' ORDER BY f.created_at DESC LIMIT 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $feedback = $this->getJsonFile('feedback.json');
            return array_slice($feedback, 0, 5);
        }
    }
    
    private function getTeamFeedbackData() {
        if ($this->conn) {
            $query = "SELECT * FROM team_feedback ORDER BY created_at DESC LIMIT 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $team_feedback = $this->getJsonFile('teamFeedback.json');
            return array_slice($team_feedback, 0, 5);
        }
    }
    
    // Placeholder methods for BaseAPI abstract requirements
    public function create($data) {
        throw new Exception('Not implemented for AdminAPI');
    }
    
    public function read($id = null) {
        throw new Exception('Not implemented for AdminAPI');
    }
    
    public function update($id, $data) {
        throw new Exception('Not implemented for AdminAPI');
    }
    
    public function delete($id) {
        throw new Exception('Not implemented for AdminAPI');
    }
}

// Handle API requests
if (basename($_SERVER['PHP_SELF']) === 'AdminAPI.php') {
    session_start();
    $api = new AdminAPI();
    $api->handleRequest();
}
?>
