<?php
require_once __DIR__ . '/../database/database_config.php';

abstract class BaseAPI {
    protected $db;
    protected $conn;
    protected $table_name;
    
    public function __construct($table_name) {
        $this->table_name = $table_name;
        
        // Initialize database connection using the global function
        $this->conn = getDB();
        
        // Initialize database tables if connection exists
        if ($this->conn) {
            setupDatabase();
        }
    }
    
    protected function setHeaders() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }
    
    protected function getInput() {
        $input = file_get_contents('php://input');
        return json_decode($input, true);
    }
    
    protected function validateRequired($data, $required_fields) {
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                throw new Exception("Missing required field: $field");
            }
        }
    }
    
    protected function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    protected function generateId($prefix = '') {
        return $prefix . time() . '_' . rand(1000, 9999);
    }
    
    protected function sendResponse($data, $status_code = 200) {
        http_response_code($status_code);
        echo json_encode($data);
        exit();
    }
    
    protected function sendError($message, $status_code = 400) {
        http_response_code($status_code);
        echo json_encode(['success' => false, 'message' => $message]);
        exit();
    }
    
    // Fallback to JSON file storage if database is not available
    protected function getJsonFile($filename) {
        $file_path = __DIR__ . "/../$filename";
        if (file_exists($file_path)) {
            $content = file_get_contents($file_path);
            return json_decode($content, true) ?: [];
        }
        return [];
    }
    
    protected function saveJsonFile($filename, $data) {
        $file_path = __DIR__ . "/../$filename";
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents($file_path, $json_data) !== false;
    }
    
    // Abstract methods to be implemented by child classes
    abstract public function create($data);
    abstract public function read($id = null);
    abstract public function update($id, $data);
    abstract public function delete($id);
}
?>
