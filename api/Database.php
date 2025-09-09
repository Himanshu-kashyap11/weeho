<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'weeho_db';
    private $username = 'root';
    private $password = '';
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                                $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Fallback to JSON file storage if database is not available
            error_log("Database connection failed: " . $exception->getMessage());
        }
        
        return $this->conn;
    }
    
    public function createTables() {
        $queries = [
            "CREATE TABLE IF NOT EXISTS events (
                id VARCHAR(50) PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                performer VARCHAR(255) NOT NULL,
                city VARCHAR(100) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS registrations (
                id VARCHAR(50) PRIMARY KEY,
                event_id VARCHAR(50),
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                role VARCHAR(100),
                city VARCHAR(100),
                status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
            )",
            
            "CREATE TABLE IF NOT EXISTS feedback (
                id VARCHAR(50) PRIMARY KEY,
                event_id VARCHAR(50),
                name VARCHAR(255) NOT NULL,
                rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
                feedback TEXT NOT NULL,
                status ENUM('active', 'hidden') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
            )",
            
            "CREATE TABLE IF NOT EXISTS team_feedback (
                id VARCHAR(50) PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS memories (
                id VARCHAR(50) PRIMARY KEY,
                image VARCHAR(500) NOT NULL,
                caption TEXT NOT NULL,
                status ENUM('active', 'hidden') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            "CREATE TABLE IF NOT EXISTS admin_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL,
                role ENUM('admin', 'moderator') DEFAULT 'moderator',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )"
        ];
        
        try {
            foreach ($queries as $query) {
                $this->conn->exec($query);
            }
            return true;
        } catch(PDOException $exception) {
            error_log("Table creation failed: " . $exception->getMessage());
            return false;
        }
    }
}
?>
