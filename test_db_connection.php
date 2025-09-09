<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing Database Connection...\n";

// Test 1: Include config
try {
    require_once 'config.php';
    echo "✓ Config loaded successfully\n";
} catch (Exception $e) {
    echo "✗ Config loading failed: " . $e->getMessage() . "\n";
    exit;
}

// Test 2: Check if functions exist
$functions = ['getDB', 'createRegistration', 'createFeedback', 'fetchOne', 'initializeDatabase'];
foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "✓ Function $func exists\n";
    } else {
        echo "✗ Function $func missing\n";
    }
}

// Test 3: Test database connection
try {
    $pdo = getDB();
    if ($pdo) {
        echo "✓ Database connection successful\n";
        
        // Test query
        $result = $pdo->query("SELECT 1 as test");
        if ($result) {
            echo "✓ Database query test passed\n";
        } else {
            echo "✗ Database query test failed\n";
        }
    } else {
        echo "✗ Database connection failed\n";
    }
} catch (Exception $e) {
    echo "✗ Database connection error: " . $e->getMessage() . "\n";
}

// Test 4: Initialize database
try {
    $init = initializeDatabase();
    if ($init) {
        echo "✓ Database initialization successful\n";
    } else {
        echo "✗ Database initialization failed\n";
    }
} catch (Exception $e) {
    echo "✗ Database initialization error: " . $e->getMessage() . "\n";
}

// Test 5: Check tables
try {
    $tables = ['events', 'registrations', 'feedback'];
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($result && $result->rowCount() > 0) {
            echo "✓ Table $table exists\n";
        } else {
            echo "✗ Table $table missing\n";
        }
    }
} catch (Exception $e) {
    echo "✗ Table check error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";
?>
