<?php
/**
 * Debug the team feedback insertion issue
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Team Feedback Insert Debug</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;overflow-x:auto;} .debug-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;}</style>";
echo "</head><body>";

echo "<h1>Team Feedback Insert Debug</h1>";

require_once 'config.php';

// Test 1: Check table structure
echo "<div class='debug-section'>";
echo "<h2>1. Table Structure Analysis</h2>";

try {
    initializeDatabase();
    global $conn;
    
    if ($conn) {
        echo "<p class='success'>✓ Database connected</p>";
        
        // Check if table exists
        $stmt = $conn->query("SHOW TABLES LIKE 'team_feedback'");
        if ($stmt->rowCount() > 0) {
            echo "<p class='success'>✓ team_feedback table exists</p>";
            
            // Show detailed table structure
            $stmt = $conn->query("DESCRIBE team_feedback");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<p><strong>Table Structure:</strong></p><pre>";
            foreach ($columns as $column) {
                echo sprintf("%-15s %-15s %-8s %-8s %s\n", 
                    $column['Field'], 
                    $column['Type'], 
                    $column['Null'], 
                    $column['Key'],
                    $column['Default'] ?? 'NULL'
                );
            }
            echo "</pre>";
            
            // Check existing data
            $stmt = $conn->query("SELECT COUNT(*) as count FROM team_feedback");
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>Existing records: <strong>" . $count['count'] . "</strong></p>";
            
        } else {
            echo "<p class='error'>✗ team_feedback table does not exist</p>";
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 2: Test insertData function directly
echo "<div class='debug-section'>";
echo "<h2>2. Direct insertData Function Test</h2>";

$test_data = [
    'name' => 'Debug Test User',
    'email' => 'debug@test.com',
    'rating' => 4,
    'message' => 'This is a debug test message',
    'status' => 'active'
];

echo "<p>Test data:</p><pre>" . print_r($test_data, true) . "</pre>";

try {
    echo "<p>Calling insertData('team_feedback', \$test_data)...</p>";
    $result = insertData('team_feedback', $test_data);
    
    if ($result) {
        echo "<p class='success'>✓ insertData returned: " . ($result === true ? 'TRUE' : $result) . "</p>";
    } else {
        echo "<p class='error'>✗ insertData returned FALSE</p>";
    }
    
    // Check if record was actually inserted
    $stmt = $conn->prepare("SELECT * FROM team_feedback WHERE email = :email ORDER BY created_at DESC LIMIT 1");
    $stmt->execute(['email' => 'debug@test.com']);
    $inserted_record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($inserted_record) {
        echo "<p class='success'>✓ Record found in database:</p>";
        echo "<pre>" . print_r($inserted_record, true) . "</pre>";
    } else {
        echo "<p class='error'>✗ No record found in database after insertion</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>✗ insertData error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 3: Test createTeamFeedback function
echo "<div class='debug-section'>";
echo "<h2>3. createTeamFeedback Function Test</h2>";

$test_data2 = [
    'name' => 'CreateTeamFeedback Test',
    'email' => 'createtest@test.com',
    'rating' => 5,
    'message' => 'Testing createTeamFeedback function',
    'status' => 'active'
];

echo "<p>Test data:</p><pre>" . print_r($test_data2, true) . "</pre>";

try {
    echo "<p>Calling createTeamFeedback(\$test_data2)...</p>";
    $result = createTeamFeedback($test_data2);
    
    if ($result) {
        echo "<p class='success'>✓ createTeamFeedback returned: " . ($result === true ? 'TRUE' : $result) . "</p>";
    } else {
        echo "<p class='error'>✗ createTeamFeedback returned FALSE</p>";
    }
    
    // Check if record was actually inserted
    $stmt = $conn->prepare("SELECT * FROM team_feedback WHERE email = :email ORDER BY created_at DESC LIMIT 1");
    $stmt->execute(['email' => 'createtest@test.com']);
    $inserted_record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($inserted_record) {
        echo "<p class='success'>✓ Record found in database:</p>";
        echo "<pre>" . print_r($inserted_record, true) . "</pre>";
    } else {
        echo "<p class='error'>✗ No record found in database after createTeamFeedback</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>✗ createTeamFeedback error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 4: Manual SQL insert test
echo "<div class='debug-section'>";
echo "<h2>4. Manual SQL Insert Test</h2>";

try {
    $manual_data = [
        'name' => 'Manual Test User',
        'email' => 'manual@test.com',
        'rating' => 3,
        'message' => 'Manual SQL insert test',
        'status' => 'active'
    ];
    
    echo "<p>Attempting manual SQL insert...</p>";
    
    $sql = "INSERT INTO team_feedback (name, email, rating, message, status, created_at) VALUES (:name, :email, :rating, :message, :status, NOW())";
    $stmt = $conn->prepare($sql);
    
    $result = $stmt->execute($manual_data);
    
    if ($result) {
        echo "<p class='success'>✓ Manual SQL insert successful</p>";
        echo "<p>Rows affected: " . $stmt->rowCount() . "</p>";
    } else {
        echo "<p class='error'>✗ Manual SQL insert failed</p>";
        $errorInfo = $stmt->errorInfo();
        echo "<p>Error: " . $errorInfo[2] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Manual SQL error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 5: Check insertData function implementation
echo "<div class='debug-section'>";
echo "<h2>5. insertData Function Analysis</h2>";

echo "<p>Let's examine the insertData function implementation:</p>";

// Read the insertData function from database_config.php
$config_content = file_get_contents('database_config.php');
$start = strpos($config_content, 'function insertData');
if ($start !== false) {
    $end = strpos($config_content, '}', $start);
    $function_code = substr($config_content, $start, $end - $start + 1);
    echo "<pre>" . htmlspecialchars($function_code) . "</pre>";
} else {
    echo "<p class='error'>insertData function not found in database_config.php</p>";
}

echo "</div>";

echo "</body></html>";
?>
