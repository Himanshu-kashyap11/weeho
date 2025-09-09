<?php
/**
 * Database Setup Script for Weeho Cultural Events Platform
 * This script will create the database and tables if they don't exist
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Weeho Database Setup</h2>\n";

try {
    // First, connect without specifying database to create it if needed
    $pdo = new PDO(
        "mysql:host=localhost;charset=utf8mb4",
        'root',
        '',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
    
    echo "<p>✓ Connected to MySQL server</p>\n";
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS weeho_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✓ Database 'weeho_db' created/verified</p>\n";
    
    // Switch to the database
    $pdo->exec("USE weeho_db");
    echo "<p>✓ Using database 'weeho_db'</p>\n";
    
    // Now include the config and test functions
    require_once 'config.php';
    
    // Initialize database tables
    $result = initializeDatabase();
    if ($result) {
        echo "<p>✓ Database tables created/verified successfully</p>\n";
    } else {
        echo "<p>✗ Failed to create database tables</p>\n";
    }
    
    // Test database functions
    echo "<h3>Testing Database Functions</h3>\n";
    
    // Test basic connection
    $testPdo = getDB();
    if ($testPdo) {
        echo "<p>✓ Database connection function works</p>\n";
    } else {
        echo "<p>✗ Database connection function failed</p>\n";
    }
    
    // Test table existence
    $tables = ['events', 'registrations', 'feedback', 'team_feedback', 'memories', 'contact_messages'];
    foreach ($tables as $table) {
        $result = $testPdo->query("SHOW TABLES LIKE '$table'");
        if ($result && $result->rowCount() > 0) {
            echo "<p>✓ Table '$table' exists</p>\n";
        } else {
            echo "<p>✗ Table '$table' missing</p>\n";
        }
    }
    
    // Test sample data
    $eventCount = fetchOne("SELECT COUNT(*) as count FROM events")['count'] ?? 0;
    echo "<p>Events in database: $eventCount</p>\n";
    
    if ($eventCount > 0) {
        echo "<p>✓ Sample data loaded</p>\n";
    } else {
        echo "<p>⚠ No events found - sample data may not be loaded</p>\n";
    }
    
    echo "<h3>Database Setup Complete!</h3>\n";
    echo "<p><a href='index.php'>Go to Homepage</a></p>\n";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>\n";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>\n";
}
?>
