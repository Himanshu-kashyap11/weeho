<?php
/**
 * Debug the insertData function specifically
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Insert Function Debug</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;}</style>";
echo "</head><body>";

echo "<h1>Insert Function Debug Test</h1>";

require_once 'config.php';

// Initialize database
initializeDatabase();

echo "<h2>Testing insertData function step by step</h2>";

// Test data
$test_data = [
    'id' => 'debug_test_' . time(),
    'event_id' => 'test_event_001',
    'name' => 'Debug Test User',
    'email' => 'debug@test.com',
    'phone' => '+91-1234567890',
    'role' => 'Audience',
    'city' => 'Test City',
    'status' => 'confirmed'
];

echo "<h3>Test Data:</h3>";
echo "<pre>" . print_r($test_data, true) . "</pre>";

// Test the insertData function directly
echo "<h3>Testing insertData function directly:</h3>";

try {
    $pdo = getDB();
    echo "<p class='success'>✓ Database connection obtained</p>";
    
    // Manual SQL construction to debug
    $table = 'registrations';
    $columns = implode(',', array_keys($test_data));
    $placeholders = ':' . implode(', :', array_keys($test_data));
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    
    echo "<p><strong>Generated SQL:</strong></p>";
    echo "<pre>$sql</pre>";
    
    echo "<p><strong>Parameters:</strong></p>";
    echo "<pre>" . print_r($test_data, true) . "</pre>";
    
    // Try the insertion
    $stmt = $pdo->prepare($sql);
    echo "<p class='success'>✓ SQL prepared successfully</p>";
    
    $result = $stmt->execute($test_data);
    echo "<p class='success'>✓ SQL executed successfully</p>";
    
    $rowCount = $stmt->rowCount();
    echo "<p>Rows affected: $rowCount</p>";
    
    if ($rowCount > 0) {
        echo "<p class='success'>✓ Data inserted successfully</p>";
        
        // Verify the data
        $verify = $pdo->prepare("SELECT * FROM registrations WHERE id = ?");
        $verify->execute([$test_data['id']]);
        $saved_data = $verify->fetch();
        
        if ($saved_data) {
            echo "<p class='success'>✓ Data verified in database</p>";
            echo "<pre>" . print_r($saved_data, true) . "</pre>";
            
            // Clean up
            $pdo->prepare("DELETE FROM registrations WHERE id = ?")->execute([$test_data['id']]);
            echo "<p>Test data cleaned up</p>";
        } else {
            echo "<p class='error'>✗ Data not found after insertion</p>";
        }
    } else {
        echo "<p class='error'>✗ No rows affected</p>";
    }
    
} catch (PDOException $e) {
    echo "<p class='error'>✗ PDO Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Error Code:</strong> " . $e->getCode() . "</p>";
    echo "<p><strong>Error Info:</strong></p>";
    echo "<pre>" . print_r($e->errorInfo ?? 'No error info', true) . "</pre>";
} catch (Exception $e) {
    echo "<p class='error'>✗ General Error: " . $e->getMessage() . "</p>";
}

// Test the actual insertData function
echo "<h3>Testing insertData function from database_config.php:</h3>";

try {
    $result = insertData('registrations', $test_data);
    if ($result) {
        echo "<p class='success'>✓ insertData function works</p>";
        
        // Verify and clean up
        $verify = fetchOne("SELECT * FROM registrations WHERE id = ?", [$test_data['id']]);
        if ($verify) {
            echo "<p class='success'>✓ Data verified via insertData</p>";
            $pdo->prepare("DELETE FROM registrations WHERE id = ?")->execute([$test_data['id']]);
            echo "<p>Test data cleaned up</p>";
        }
    } else {
        echo "<p class='error'>✗ insertData function returned false</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ insertData function error: " . $e->getMessage() . "</p>";
}

// Test createRegistration function
echo "<h3>Testing createRegistration function:</h3>";

try {
    $result = createRegistration($test_data);
    if ($result) {
        echo "<p class='success'>✓ createRegistration function works</p>";
        
        // Verify and clean up
        $verify = fetchOne("SELECT * FROM registrations WHERE id = ?", [$test_data['id']]);
        if ($verify) {
            echo "<p class='success'>✓ Data verified via createRegistration</p>";
            $pdo->prepare("DELETE FROM registrations WHERE id = ?")->execute([$test_data['id']]);
            echo "<p>Test data cleaned up</p>";
        }
    } else {
        echo "<p class='error'>✗ createRegistration function returned false</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ createRegistration function error: " . $e->getMessage() . "</p>";
}

// Show the actual insertData function code
echo "<h3>insertData Function Source:</h3>";
$reflection = new ReflectionFunction('insertData');
$filename = $reflection->getFileName();
$start_line = $reflection->getStartLine();
$end_line = $reflection->getEndLine();

echo "<p>Function defined in: $filename (lines $start_line-$end_line)</p>";

if (file_exists($filename)) {
    $lines = file($filename);
    $function_code = array_slice($lines, $start_line - 1, $end_line - $start_line + 1);
    echo "<pre>" . htmlspecialchars(implode('', $function_code)) . "</pre>";
}

echo "</body></html>";
?>
