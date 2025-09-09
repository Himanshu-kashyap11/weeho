<?php
/**
 * Database Configuration File for Weeho Cultural Events Platform
 * This file contains database connection settings and helper functions
 */

// Database Configuration Constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'weeho_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Database Connection Class
class DatabaseConnection {
    private static $instance = null;
    private $connection;
    private $host;
    private $db_name;
    private $charset;

    private function __construct() {
        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->charset = DB_CHARSET;
        
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            $this->connection = null;
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function testConnection() {
        try {
            $stmt = $this->connection->query("SELECT 1");
            return $stmt !== false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDatabaseInfo() {
        try {
            $stmt = $this->connection->query("SELECT VERSION() as version");
            $result = $stmt->fetch();
            return [
                'version' => $result['version'],
                'host' => $this->host,
                'database' => $this->db_name,
                'charset' => $this->charset
            ];
        } catch (PDOException $e) {
            return null;
        }
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    private function __wakeup() {}
}

// Database Helper Functions
class DatabaseHelper {
    private $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    /**
     * Execute a prepared statement with parameters
     */
    public function execute($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            throw new Exception("Database operation failed");
        }
    }

    /**
     * Fetch a single row
     */
    public function fetchOne($query, $params = []) {
        $stmt = $this->execute($query, $params);
        return $stmt->fetch();
    }

    /**
     * Fetch all rows
     */
    public function fetchAll($query, $params = []) {
        $stmt = $this->execute($query, $params);
        return $stmt->fetchAll();
    }

    /**
     * Insert data and return last insert ID
     */
    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->execute($query, $data);
        
        return $this->db->lastInsertId();
    }

    /**
     * Update data
     */
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach (array_keys($data) as $key) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);
        
        $query = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        
        $stmt = $this->execute($query, $params);
        return $stmt->rowCount();
    }

    /**
     * Delete data
     */
    public function delete($table, $where, $params = []) {
        $query = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->execute($query, $params);
        return $stmt->rowCount();
    }

    /**
     * Check if table exists
     */
    public function tableExists($tableName) {
        $query = "SHOW TABLES LIKE :table";
        $stmt = $this->execute($query, ['table' => $tableName]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Get table structure
     */
    public function getTableStructure($tableName) {
        $query = "DESCRIBE {$tableName}";
        return $this->fetchAll($query);
    }

    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit() {
        return $this->db->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->db->rollBack();
    }

    /**
     * Get database statistics
     */
    public function getDatabaseStats() {
        $stats = [];
        
        $tables = ['events', 'registrations', 'feedback', 'team_feedback', 'memories', 'contact_messages'];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                $query = "SELECT COUNT(*) as count FROM {$table}";
                $result = $this->fetchOne($query);
                $stats[$table] = $result['count'];
            }
        }
        
        return $stats;
    }
}

// Migration Helper Class
class DatabaseMigration {
    private $db;
    private $helper;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
        $this->helper = new DatabaseHelper();
    }

    /**
     * Run database migrations from SQL file
     */
    public function runMigration($sqlFile) {
        if (!file_exists($sqlFile)) {
            throw new Exception("Migration file not found: {$sqlFile}");
        }

        $sql = file_get_contents($sqlFile);
        $statements = $this->splitSQLStatements($sql);

        $this->helper->beginTransaction();
        
        try {
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement) && !$this->isComment($statement)) {
                    $this->db->exec($statement);
                }
            }
            
            $this->helper->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->helper->rollback();
            error_log("Migration failed: " . $e->getMessage());
            throw new Exception("Migration failed: " . $e->getMessage());
        }
    }

    /**
     * Split SQL file into individual statements
     */
    private function splitSQLStatements($sql) {
        // Remove comments and split by semicolon
        $sql = preg_replace('/--.*$/m', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
        
        return array_filter(explode(';', $sql), function($statement) {
            return !empty(trim($statement));
        });
    }

    /**
     * Check if line is a comment
     */
    private function isComment($line) {
        $line = trim($line);
        return empty($line) || substr($line, 0, 2) === '--' || substr($line, 0, 2) === '/*';
    }

    /**
     * Check if database is properly set up
     */
    public function isDatabaseSetup() {
        $requiredTables = ['events', 'registrations', 'feedback', 'team_feedback', 'memories'];
        
        foreach ($requiredTables as $table) {
            if (!$this->helper->tableExists($table)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get migration status
     */
    public function getMigrationStatus() {
        $status = [
            'database_exists' => false,
            'tables_created' => false,
            'sample_data_loaded' => false,
            'ready' => false
        ];

        try {
            // Check if database connection works
            $dbInfo = DatabaseConnection::getInstance()->getDatabaseInfo();
            $status['database_exists'] = !empty($dbInfo);

            // Check if tables exist
            $status['tables_created'] = $this->isDatabaseSetup();

            // Check if sample data exists
            if ($status['tables_created']) {
                $eventCount = $this->helper->fetchOne("SELECT COUNT(*) as count FROM events");
                $status['sample_data_loaded'] = $eventCount['count'] > 0;
            }

            $status['ready'] = $status['database_exists'] && $status['tables_created'];

        } catch (Exception $e) {
            error_log("Migration status check failed: " . $e->getMessage());
        }

        return $status;
    }
}

// Utility Functions
function getDBConnection() {
    return DatabaseConnection::getInstance()->getConnection();
}

function getDB() {
    return DatabaseConnection::getInstance()->getConnection();
}

function getDBHelper() {
    return new DatabaseHelper();
}

function setupDatabase() {
    try {
        $db = getDB();
        if (!$db) {
            return false;
        }

        // Create events table if it doesn't exist
        $createEventsTable = "
            CREATE TABLE IF NOT EXISTS events (
                id VARCHAR(50) PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                performer VARCHAR(255) NOT NULL,
                city VARCHAR(100) NOT NULL,
                description TEXT NOT NULL,
                image_url VARCHAR(500) DEFAULT NULL,
                status VARCHAR(20) DEFAULT 'upcoming',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";

        // Create registrations table if it doesn't exist
        $createRegistrationsTable = "
            CREATE TABLE IF NOT EXISTS registrations (
                id VARCHAR(50) PRIMARY KEY,
                event_id VARCHAR(50) NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                role VARCHAR(50) NOT NULL,
                city VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";

        // Create feedback table if it doesn't exist
        $createFeedbackTable = "
            CREATE TABLE IF NOT EXISTS feedback (
                id VARCHAR(50) PRIMARY KEY,
                event_id VARCHAR(50) NOT NULL,
                name VARCHAR(255) NOT NULL,
                rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
                feedback TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";

        $db->exec($createEventsTable);
        $db->exec($createRegistrationsTable);
        $db->exec($createFeedbackTable);

        return true;
    } catch (PDOException $e) {
        error_log("Database setup failed: " . $e->getMessage());
        return false;
    }
}

function testDatabaseConnection() {
    try {
        $db = DatabaseConnection::getInstance();
        return $db->testConnection();
    } catch (Exception $e) {
        return false;
    }
}

function getDatabaseInfo() {
    try {
        $db = DatabaseConnection::getInstance();
        return $db->getDatabaseInfo();
    } catch (Exception $e) {
        return null;
    }
}
?>
