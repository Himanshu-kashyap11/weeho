<?php
/**
 * Final test for Team Feedback form with direct database connection
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Team Feedback Final Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;} .test-form{background:#fff;padding:20px;border:1px solid #ccc;margin:15px 0;} input,select,textarea{padding:8px;margin:5px 0;width:200px;} button{padding:10px 15px;margin:5px;background:#007bff;color:white;border:none;cursor:pointer;}</style>";
echo "</head><body>";

echo "<h1>Team Feedback Final Test</h1>";

require_once 'config.php';

// Test 1: Direct database connection test
echo "<div class='test-section'>";
echo "<h2>1. Direct Database Connection Test</h2>";

try {
    $pdo = getDB();
    if ($pdo) {
        echo "<p class='success'>✓ getDB() function works - connection established</p>";
        
        // Test table structure
        $stmt = $pdo->query("DESCRIBE team_feedback");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<p class='success'>✓ team_feedback table accessible</p>";
        echo "<p>Table columns:</p><pre>";
        foreach ($columns as $column) {
            echo $column['Field'] . " (" . $column['Type'] . ")\n";
        }
        echo "</pre>";
        
        // Test count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM team_feedback");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>Current records: <strong>" . $count['count'] . "</strong></p>";
        
    } else {
        echo "<p class='error'>✗ getDB() returned null</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Database connection error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 2: Test fixed insertData function
echo "<div class='test-section'>";
echo "<h2>2. Fixed insertData Function Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_submit'])) {
    echo "<h3>Testing Fixed insertData...</h3>";
    
    $test_data = [
        'name' => sanitizeInput($_POST['test_name']),
        'email' => sanitizeInput($_POST['test_email']),
        'rating' => (int)$_POST['test_rating'],
        'message' => sanitizeInput($_POST['test_message']),
        'status' => 'active'
    ];
    
    echo "<p>Test data:</p><pre>" . print_r($test_data, true) . "</pre>";
    
    try {
        echo "<p>Calling insertData('team_feedback', \$test_data)...</p>";
        $result = insertData('team_feedback', $test_data);
        
        if ($result) {
            echo "<p class='success'>✓ insertData returned: " . ($result === true ? 'TRUE' : $result) . "</p>";
            
            // Verify insertion
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT * FROM team_feedback WHERE email = :email ORDER BY created_at DESC LIMIT 1");
            $stmt->execute(['email' => $test_data['email']]);
            $inserted = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($inserted) {
                echo "<p class='success'>✓ Record verified in database:</p>";
                echo "<pre>" . print_r($inserted, true) . "</pre>";
            } else {
                echo "<p class='error'>✗ Record not found after insertion</p>";
            }
            
        } else {
            echo "<p class='error'>✗ insertData returned FALSE</p>";
        }
        
        // Now test createTeamFeedback
        echo "<hr><p>Testing createTeamFeedback()...</p>";
        $test_data2 = [
            'name' => 'CreateTeamFeedback Test',
            'email' => 'createtest2@test.com',
            'rating' => 4,
            'message' => 'Testing createTeamFeedback function',
            'status' => 'active'
        ];
        
        $result2 = createTeamFeedback($test_data2);
        if ($result2) {
            echo "<p class='success'>✓ createTeamFeedback also works!</p>";
        } else {
            echo "<p class='error'>✗ createTeamFeedback still fails</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
    }
}

// Test form
echo "<div class='test-form'>";
echo "<h3>Submit Final Test</h3>";
echo "<form method='POST'>";
echo "<label>Name:</label><br>";
echo "<input type='text' name='test_name' value='Final Test User' required><br>";
echo "<label>Email:</label><br>";
echo "<input type='email' name='test_email' value='final@test.com' required><br>";
echo "<label>Rating:</label><br>";
echo "<select name='test_rating' required>";
echo "<option value='5'>5 - Excellent</option>";
echo "<option value='4' selected>4 - Very Good</option>";
echo "<option value='3'>3 - Good</option>";
echo "<option value='2'>2 - Fair</option>";
echo "<option value='1'>1 - Poor</option>";
echo "</select><br>";
echo "<label>Message:</label><br>";
echo "<textarea name='test_message' rows='4' required>Final test of the fixed team feedback form functionality.</textarea><br>";
echo "<button type='submit' name='test_submit'>Submit Final Test</button>";
echo "</form>";
echo "</div>";

echo "</div>";

// Test 3: Show updated feedback list
echo "<div class='test-section'>";
echo "<h2>3. Updated Feedback List</h2>";

try {
    $feedbacks = getAllTeamFeedback();
    
    if (!empty($feedbacks)) {
        echo "<p class='success'>✓ Total feedback entries: " . count($feedbacks) . "</p>";
        
        // Sort by created_at descending
        usort($feedbacks, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        echo "<h3>Recent Feedback (Top 3):</h3>";
        foreach (array_slice($feedbacks, 0, 3) as $feedback) {
            echo "<div style='border:1px solid #ddd;padding:10px;margin:5px 0;background:#fff;'>";
            echo "<strong>" . htmlspecialchars($feedback['name']) . "</strong> ";
            echo "<span style='color:#f59e0b;'>";
            for ($i = 1; $i <= 5; $i++) {
                echo ($i <= $feedback['rating']) ? '★' : '☆';
            }
            echo "</span><br>";
            echo "<em>" . htmlspecialchars($feedback['email']) . "</em><br>";
            echo "<p>" . htmlspecialchars($feedback['message']) . "</p>";
            echo "<small>Created: " . $feedback['created_at'] . "</small>";
            echo "</div>";
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Error retrieving feedback: " . $e->getMessage() . "</p>";
}

echo "</div>";

echo "<div class='test-section'>";
echo "<h2>4. Final Team Feedback Page</h2>";
echo "<p>If the test above works, your team feedback form is now fixed!</p>";
echo "<p><a href='teamFeedback.php' target='_blank' style='background:#28a745;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;font-weight:bold;'>🎉 Test Live Team Feedback Page</a></p>";
echo "</div>";

echo "</body></html>";
?>
