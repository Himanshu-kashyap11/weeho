<?php
/**
 * Comprehensive Database Debug and Test Script
 * This will help identify any issues with the database integration
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Database Debug Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;}</style>";
echo "</head><body>";

echo "<h1>Weeho Database Debug Test</h1>";
echo "<p>Testing all database components step by step...</p>";

$errors = [];
$warnings = [];
$success = [];

// Test 1: Basic PHP Configuration
echo "<h2>1. PHP Configuration</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>PDO Available: " . (extension_loaded('pdo') ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>') . "</p>";
echo "<p>PDO MySQL Available: " . (extension_loaded('pdo_mysql') ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>') . "</p>";

// Test 2: File Includes
echo "<h2>2. File Includes Test</h2>";
try {
    if (file_exists('config.php')) {
        echo "<p class='success'>✓ config.php exists</p>";
        require_once 'config.php';
        echo "<p class='success'>✓ config.php loaded successfully</p>";
    } else {
        echo "<p class='error'>✗ config.php not found</p>";
        $errors[] = "config.php not found";
    }
    
    if (file_exists('database_config.php')) {
        echo "<p class='success'>✓ database_config.php exists</p>";
    } else {
        echo "<p class='error'>✗ database_config.php not found</p>";
        $errors[] = "database_config.php not found";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Error loading config: " . $e->getMessage() . "</p>";
    $errors[] = "Config loading error: " . $e->getMessage();
}

// Test 3: Function Availability
echo "<h2>3. Function Availability Test</h2>";
$required_functions = [
    'getDB', 'fetchOne', 'fetchAll', 'createRegistration', 
    'createFeedback', 'initializeDatabase', 'generateId', 
    'sanitizeInput', 'jsonResponse'
];

foreach ($required_functions as $func) {
    if (function_exists($func)) {
        echo "<p class='success'>✓ Function $func exists</p>";
    } else {
        echo "<p class='error'>✗ Function $func missing</p>";
        $errors[] = "Missing function: $func";
    }
}

// Test 4: Database Connection
echo "<h2>4. Database Connection Test</h2>";
try {
    // Test raw PDO connection first
    $pdo = new PDO(
        "mysql:host=localhost;charset=utf8mb4",
        'root',
        '',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
    echo "<p class='success'>✓ Raw PDO connection successful</p>";
    
    // Test database existence
    $result = $pdo->query("SHOW DATABASES LIKE 'weeho_db'");
    if ($result && $result->rowCount() > 0) {
        echo "<p class='success'>✓ Database 'weeho_db' exists</p>";
    } else {
        echo "<p class='warning'>⚠ Database 'weeho_db' does not exist - creating it...</p>";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS weeho_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "<p class='success'>✓ Database 'weeho_db' created</p>";
    }
    
    // Test connection to specific database
    $pdo = new PDO(
        "mysql:host=localhost;dbname=weeho_db;charset=utf8mb4",
        'root',
        '',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
    echo "<p class='success'>✓ Connection to weeho_db successful</p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    $errors[] = "Database connection error: " . $e->getMessage();
}

// Test 5: Function-based Database Connection
echo "<h2>5. Function-based Database Connection Test</h2>";
if (function_exists('getDB')) {
    try {
        $db = getDB();
        if ($db) {
            echo "<p class='success'>✓ getDB() function works</p>";
            
            // Test a simple query
            $result = $db->query("SELECT 1 as test");
            if ($result) {
                echo "<p class='success'>✓ Database query test passed</p>";
            } else {
                echo "<p class='error'>✗ Database query test failed</p>";
                $errors[] = "Database query test failed";
            }
        } else {
            echo "<p class='error'>✗ getDB() returned null</p>";
            $errors[] = "getDB() returned null";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ getDB() error: " . $e->getMessage() . "</p>";
        $errors[] = "getDB() error: " . $e->getMessage();
    }
} else {
    echo "<p class='error'>✗ getDB() function not available</p>";
}

// Test 6: Database Initialization
echo "<h2>6. Database Initialization Test</h2>";
if (function_exists('initializeDatabase')) {
    try {
        $init_result = initializeDatabase();
        if ($init_result) {
            echo "<p class='success'>✓ Database initialization successful</p>";
        } else {
            echo "<p class='error'>✗ Database initialization failed</p>";
            $errors[] = "Database initialization failed";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ Database initialization error: " . $e->getMessage() . "</p>";
        $errors[] = "Database initialization error: " . $e->getMessage();
    }
} else {
    echo "<p class='error'>✗ initializeDatabase() function not available</p>";
}

// Test 7: Table Structure
echo "<h2>7. Table Structure Test</h2>";
$required_tables = ['events', 'registrations', 'feedback', 'team_feedback', 'memories', 'contact_messages'];

if (isset($db) && $db) {
    foreach ($required_tables as $table) {
        try {
            $result = $db->query("SHOW TABLES LIKE '$table'");
            if ($result && $result->rowCount() > 0) {
                echo "<p class='success'>✓ Table '$table' exists</p>";
                
                // Show table structure
                $structure = $db->query("DESCRIBE $table");
                if ($structure) {
                    $columns = $structure->fetchAll();
                    echo "<details><summary>View $table structure</summary><pre>";
                    foreach ($columns as $col) {
                        echo $col['Field'] . " - " . $col['Type'] . "\n";
                    }
                    echo "</pre></details>";
                }
            } else {
                echo "<p class='error'>✗ Table '$table' missing</p>";
                $errors[] = "Missing table: $table";
            }
        } catch (Exception $e) {
            echo "<p class='error'>✗ Error checking table '$table': " . $e->getMessage() . "</p>";
            $errors[] = "Table check error for $table: " . $e->getMessage();
        }
    }
}

// Test 8: Sample Data Test
echo "<h2>8. Sample Data Test</h2>";
if (function_exists('fetchOne') && isset($db)) {
    try {
        $event_count = fetchOne("SELECT COUNT(*) as count FROM events");
        if ($event_count) {
            echo "<p class='success'>✓ Events table accessible - Count: " . $event_count['count'] . "</p>";
        } else {
            echo "<p class='warning'>⚠ No events found or query failed</p>";
        }
        
        $reg_count = fetchOne("SELECT COUNT(*) as count FROM registrations");
        if ($reg_count) {
            echo "<p class='success'>✓ Registrations table accessible - Count: " . $reg_count['count'] . "</p>";
        }
        
        $feedback_count = fetchOne("SELECT COUNT(*) as count FROM feedback");
        if ($feedback_count) {
            echo "<p class='success'>✓ Feedback table accessible - Count: " . $feedback_count['count'] . "</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ Sample data test error: " . $e->getMessage() . "</p>";
        $errors[] = "Sample data test error: " . $e->getMessage();
    }
}

// Test 9: Form Submission Simulation
echo "<h2>9. Form Submission Simulation</h2>";
if (function_exists('createRegistration') && function_exists('generateId')) {
    try {
        $test_reg = [
            'id' => generateId('test_reg_'),
            'event_id' => 'test_event_001',
            'name' => 'Test User Debug',
            'email' => 'debug@test.com',
            'phone' => '+91-1234567890',
            'role' => 'Audience',
            'city' => 'Test City',
            'status' => 'confirmed'
        ];
        
        echo "<p>Attempting to create test registration...</p>";
        echo "<pre>Registration data: " . print_r($test_reg, true) . "</pre>";
        
        $reg_result = createRegistration($test_reg);
        if ($reg_result) {
            echo "<p class='success'>✓ Test registration created successfully</p>";
            
            // Verify it exists
            $verify = fetchOne("SELECT * FROM registrations WHERE id = ?", [$test_reg['id']]);
            if ($verify) {
                echo "<p class='success'>✓ Test registration verified in database</p>";
                echo "<pre>Saved data: " . print_r($verify, true) . "</pre>";
                
                // Clean up test data
                $db->prepare("DELETE FROM registrations WHERE id = ?")->execute([$test_reg['id']]);
                echo "<p>Test data cleaned up</p>";
            } else {
                echo "<p class='error'>✗ Test registration not found in database</p>";
                $errors[] = "Test registration not saved properly";
            }
        } else {
            echo "<p class='error'>✗ Test registration creation failed</p>";
            $errors[] = "Test registration creation failed";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ Form simulation error: " . $e->getMessage() . "</p>";
        $errors[] = "Form simulation error: " . $e->getMessage();
    }
}

// Test 10: Error Log Check
echo "<h2>10. Error Log Information</h2>";
echo "<p>PHP Error Log Location: " . ini_get('error_log') . "</p>";
echo "<p>Log Errors Enabled: " . (ini_get('log_errors') ? 'Yes' : 'No') . "</p>";
echo "<p>Display Errors: " . (ini_get('display_errors') ? 'Yes' : 'No') . "</p>";

// Summary
echo "<h2>Summary</h2>";
if (empty($errors)) {
    echo "<p class='success'>✓ All tests passed! Database integration should be working.</p>";
} else {
    echo "<p class='error'>✗ Found " . count($errors) . " error(s):</p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
}

if (!empty($warnings)) {
    echo "<p class='warning'>⚠ " . count($warnings) . " warning(s):</p>";
    echo "<ul>";
    foreach ($warnings as $warning) {
        echo "<li class='warning'>$warning</li>";
    }
    echo "</ul>";
}

echo "<h3>Next Steps:</h3>";
echo "<ul>";
echo "<li><a href='index.php'>Test the main website</a></li>";
echo "<li><a href='setup_db.php'>Run database setup</a></li>";
echo "<li><a href='test_forms.php'>Test form functionality</a></li>";
echo "</ul>";

echo "</body></html>";
?>
