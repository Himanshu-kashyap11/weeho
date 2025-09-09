<?php
// Database Configuration for Weeho Cultural Events Platform

class Database {
    private $host = 'localhost';
    private $db_name = 'weeho_db';
    private $username = 'root';
    private $password = '';
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                )
            );
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            die("Database connection failed. Please check your database configuration.");
        }
        
        return $this->conn;
    }
}

// Global database helper functions
function getDB() {
    static $database = null;
    if ($database === null) {
        $database = new Database();
    }
    return $database->getConnection();
}

function executeQuery($sql, $params = []) {
    try {
        $pdo = getDB();
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);
        if (!$result) {
            error_log("Database execute failed: " . print_r($stmt->errorInfo(), true));
            return false;
        }
        return $stmt;
    } catch (PDOException $e) {
        error_log("Database error in executeQuery: " . $e->getMessage());
        error_log("SQL: " . $sql);
        error_log("Params: " . print_r($params, true));
        return false;
    }
}

function fetchAll($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt ? $stmt->fetchAll() : [];
}

function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt ? $stmt->fetch() : null;
}

function insertData($table, $data) {
    // Add created_at timestamp if not provided
    if (!isset($data['created_at'])) {
        $data['created_at'] = date('Y-m-d H:i:s');
    }
    
    try {
        $pdo = getDB();
        if (!$pdo) {
            error_log("insertData: Failed to get database connection");
            return false;
        }
        
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($data);
        
        if (!$result) {
            error_log("insertData failed: " . print_r($stmt->errorInfo(), true));
            return false;
        }
        
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("insertData error: " . $e->getMessage());
        return false;
    }
}

function updateData($table, $data, $where, $whereParams = []) {
    $setParts = [];
    foreach (array_keys($data) as $key) {
        $setParts[] = "{$key} = :{$key}";
    }
    $setClause = implode(', ', $setParts);
    
    $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
    $params = array_merge($data, $whereParams);
    
    $stmt = executeQuery($sql, $params);
    return $stmt ? $stmt->rowCount() : false;
}

// Event functions
function getAllEvents() {
    return fetchAll("SELECT * FROM events ORDER BY date ASC");
}

function getEventById($id) {
    return fetchOne("SELECT * FROM events WHERE id = ?", [$id]);
}

function createEvent($data) {
    return insertData('events', $data);
}

// Registration functions
function createRegistration($data) {
    return insertData('registrations', $data);
}

function getRegistrationsByEvent($eventId) {
    return fetchAll("SELECT * FROM registrations WHERE event_id = ? ORDER BY created_at DESC", [$eventId]);
}

// Feedback functions
function createFeedback($data) {
    return insertData('feedback', $data);
}

function getFeedbackByEvent($eventId) {
    return fetchAll("SELECT * FROM feedback WHERE event_id = ? ORDER BY created_at DESC", [$eventId]);
}

// Team feedback functions
function createTeamFeedback($data) {
    // Generate unique ID if not provided
    if (!isset($data['id'])) {
        $data['id'] = 'feedback_' . uniqid();
    }
    
    return insertData('team_feedback', $data);
}

function getAllTeamFeedback() {
    return fetchAll("SELECT * FROM team_feedback ORDER BY created_at DESC");
}

// Workshop functions
function createWorkshop($data) {
    // Generate unique ID if not provided
    if (!isset($data['id'])) {
        $data['id'] = 'workshop_' . uniqid();
    }
    
    return insertData('workshops', $data);
}

function getAllWorkshops() {
    return fetchAll("SELECT * FROM workshops WHERE status = 'active' ORDER BY name");
}

function getWorkshopById($id) {
    return fetchOne("SELECT * FROM workshops WHERE id = ?", [$id]);
}

function createWorkshopRegistration($data) {
    // Generate unique ID if not provided
    if (!isset($data['id'])) {
        $data['id'] = 'workshop_reg_' . uniqid();
    }
    
    return insertData('workshop_registrations', $data);
}

function getWorkshopRegistrations($workshopId = null) {
    if ($workshopId) {
        return fetchAll("SELECT * FROM workshop_registrations WHERE workshop_id = ? ORDER BY created_at DESC", [$workshopId]);
    }
    return fetchAll("SELECT wr.*, w.name as workshop_name FROM workshop_registrations wr LEFT JOIN workshops w ON wr.workshop_id = w.id ORDER BY wr.created_at DESC");
}

function getWorkshopRegistrationCount($workshopId) {
    $result = fetchOne("SELECT COUNT(*) as count FROM workshop_registrations WHERE workshop_id = ? AND status != 'cancelled'", [$workshopId]);
    return $result ? $result['count'] : 0;
}

// Contact functions
function createContactMessage($data) {
    return insertData('contact_messages', $data);
}

function getAllContactMessages() {
    return fetchAll("SELECT * FROM contact_messages ORDER BY created_at DESC");
}

// Memory functions
function getAllMemories() {
    return fetchAll("SELECT * FROM memories WHERE status = 'active' ORDER BY sort_order ASC, created_at DESC");
}

function createMemory($data) {
    return insertData('memories', $data);
}

// Admin functions
function getAdminStats() {
    $stats = [];
    $stats['total_events'] = fetchOne("SELECT COUNT(*) as count FROM events")['count'] ?? 0;
    $stats['total_registrations'] = fetchOne("SELECT COUNT(*) as count FROM registrations")['count'] ?? 0;
    $stats['total_feedback'] = fetchOne("SELECT COUNT(*) as count FROM feedback")['count'] ?? 0;
    $stats['total_team_feedback'] = fetchOne("SELECT COUNT(*) as count FROM team_feedback")['count'] ?? 0;
    $stats['total_contacts'] = fetchOne("SELECT COUNT(*) as count FROM contact_messages")['count'] ?? 0;
    $stats['avg_rating'] = fetchOne("SELECT AVG(rating) as avg FROM feedback")['avg'] ?? 0;
    return $stats;
}

function getRecentActivity($limit = 10) {
    $sql = "
        (SELECT 'registration' as type, name, created_at, 'Event Registration' as description FROM registrations ORDER BY created_at DESC LIMIT ?)
        UNION ALL
        (SELECT 'feedback' as type, name, created_at, CONCAT('Event Feedback (', rating, '/5)') as description FROM feedback ORDER BY created_at DESC LIMIT ?)
        UNION ALL
        (SELECT 'team_feedback' as type, name, created_at, CONCAT('Team Feedback (', rating, '/5)') as description FROM team_feedback ORDER BY created_at DESC LIMIT ?)
        UNION ALL
        (SELECT 'contact' as type, name, created_at, 'Contact Message' as description FROM contact_messages ORDER BY created_at DESC LIMIT ?)
        ORDER BY created_at DESC LIMIT ?
    ";
    return fetchAll($sql, [$limit, $limit, $limit, $limit, $limit]);
}

// Database setup function
function setupDatabase() {
    try {
        $pdo = getDB();
        
        // Create events table
        $pdo->exec("CREATE TABLE IF NOT EXISTS events (
            id VARCHAR(50) PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            performer VARCHAR(255) NOT NULL,
            city VARCHAR(100) NOT NULL,
            description TEXT,
            image_url VARCHAR(500) DEFAULT NULL,
            status ENUM('upcoming', 'ongoing', 'completed', 'cancelled') DEFAULT 'upcoming',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        // Create registrations table
        $pdo->exec("CREATE TABLE IF NOT EXISTS registrations (
            id VARCHAR(50) PRIMARY KEY,
            event_id VARCHAR(50) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            role VARCHAR(100) DEFAULT NULL,
            city VARCHAR(100) DEFAULT NULL,
            status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'confirmed',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create feedback table
        $pdo->exec("CREATE TABLE IF NOT EXISTS feedback (
            id VARCHAR(50) PRIMARY KEY,
            event_id VARCHAR(50) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) DEFAULT NULL,
            rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
            feedback TEXT NOT NULL,
            status ENUM('active', 'hidden') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create team_feedback table
        $pdo->exec("CREATE TABLE IF NOT EXISTS team_feedback (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
            message TEXT NOT NULL,
            status ENUM('active', 'hidden') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create contact_messages table
        $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) DEFAULT NULL,
            message TEXT NOT NULL,
            status ENUM('new', 'read', 'responded') DEFAULT 'new',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create memories table
        $pdo->exec("CREATE TABLE IF NOT EXISTS memories (
            id VARCHAR(50) PRIMARY KEY,
            title VARCHAR(255) DEFAULT NULL,
            image VARCHAR(500) NOT NULL,
            caption TEXT NOT NULL,
            event_id VARCHAR(50) DEFAULT NULL,
            status ENUM('active', 'hidden') DEFAULT 'active',
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create workshops table
        $pdo->exec("CREATE TABLE IF NOT EXISTS workshops (
            id VARCHAR(50) PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            max_participants INT DEFAULT 0,
            status ENUM('active', 'inactive', 'cancelled') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        // Create workshop_registrations table
        $pdo->exec("CREATE TABLE IF NOT EXISTS workshop_registrations (
            id VARCHAR(50) PRIMARY KEY,
            workshop_id VARCHAR(50) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) DEFAULT NULL,
            experience_level VARCHAR(50) DEFAULT NULL,
            preferred_schedule VARCHAR(255) DEFAULT NULL,
            special_requirements TEXT DEFAULT NULL,
            status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'confirmed',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (workshop_id) REFERENCES workshops(id) ON DELETE CASCADE
        )");
        
        return true;
    } catch (PDOException $e) {
        error_log("Database setup error: " . $e->getMessage());
        return false;
    }
}

// Initialize database on first load
function initializeDatabase() {
    if (!setupDatabase()) {
        return false;
    }
    
    // Check if sample data exists
    $eventCount = fetchOne("SELECT COUNT(*) as count FROM events")['count'] ?? 0;
    
    if ($eventCount == 0) {
        // Insert sample events
        $sampleEvents = [
            [
                'id' => 'evt_001',
                'title' => 'Classical Sitar Concert',
                'date' => '2025-01-15',
                'performer' => 'Pandit Ravi Kumar',
                'city' => 'Mumbai',
                'description' => 'Experience the soul-stirring melodies of classical Indian sitar music with renowned maestro Pandit Ravi Kumar.'
            ],
            [
                'id' => 'evt_002',
                'title' => 'Bharatanatyam Dance Recital',
                'date' => '2025-01-20',
                'performer' => 'Priya Nair',
                'city' => 'Chennai',
                'description' => 'A mesmerizing evening of traditional Bharatanatyam dance showcasing ancient stories through graceful movements.'
            ],
            [
                'id' => 'evt_003',
                'title' => 'Folk Music Festival',
                'date' => '2025-01-25',
                'performer' => 'Rajasthani Folk Ensemble',
                'city' => 'Delhi',
                'description' => 'Celebrate India\'s rich folk heritage with vibrant performances from Rajasthan\'s most talented musicians.'
            ]
        ];
        
        foreach ($sampleEvents as $event) {
            createEvent($event);
        }
        
        // Insert sample memories
        $sampleMemories = [
            [
                'id' => 'mem_001',
                'title' => 'Classical Evening',
                'image' => 'images/memory1.jpg',
                'caption' => 'A magical evening of classical music that touched everyone\'s hearts.',
                'event_id' => 'evt_001',
                'sort_order' => 1
            ],
            [
                'id' => 'mem_002',
                'title' => 'Dance Performance',
                'image' => 'images/memory2.jpg',
                'caption' => 'Graceful Bharatanatyam performance showcasing Indian cultural heritage.',
                'event_id' => 'evt_002',
                'sort_order' => 2
            ]
        ];
        
        foreach ($sampleMemories as $memory) {
            createMemory($memory);
        }
        
        // Insert sample workshops
        $sampleWorkshops = [
            [
                'id' => 'workshop_classical_dance',
                'name' => 'Classical Dance',
                'description' => 'Learn the fundamentals of classical Indian dance forms including Bharatanatyam, Kathak, and Odissi.',
                'max_participants' => 20,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_traditional_music',
                'name' => 'Traditional Music',
                'description' => 'Explore the rich heritage of Indian classical music with instruments like sitar, tabla, and flute.',
                'max_participants' => 15,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_music_appreciation',
                'name' => 'Music Appreciation',
                'description' => 'Develop your understanding and appreciation of various musical genres and styles.',
                'max_participants' => 25,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_folk_arts',
                'name' => 'Folk Arts & Crafts',
                'description' => 'Discover traditional folk arts, crafts, and cultural practices from different regions of India.',
                'max_participants' => 18,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_cultural_history',
                'name' => 'Cultural History',
                'description' => 'Dive deep into the rich cultural history and heritage of India through interactive sessions.',
                'max_participants' => 30,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_artisan_skills',
                'name' => 'Artisan Skills',
                'description' => 'Learn traditional artisan skills and techniques from master craftsmen.',
                'max_participants' => 12,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_heritage_tours',
                'name' => 'Heritage Tours',
                'description' => 'Join guided tours to explore historical sites and cultural landmarks.',
                'max_participants' => 40,
                'status' => 'active'
            ]
        ];
        
        foreach ($sampleWorkshops as $workshop) {
            createWorkshop($workshop);
        }
    }
    
    return true;
}
?>
