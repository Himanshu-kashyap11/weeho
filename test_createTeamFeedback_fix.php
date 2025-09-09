<?php
/**
 * Test the fixed createTeamFeedback function
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>CreateTeamFeedback Fix Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;} .test-form{background:#fff;padding:20px;border:1px solid #ccc;margin:15px 0;} input,select,textarea{padding:8px;margin:5px 0;width:200px;} button{padding:10px 15px;margin:5px;background:#007bff;color:white;border:none;cursor:pointer;}</style>";
echo "</head><body>";

echo "<h1>CreateTeamFeedback Fix Test</h1>";

require_once 'config.php';

// Test 1: Test createTeamFeedback with ID generation
echo "<div class='test-section'>";
echo "<h2>1. Test Fixed createTeamFeedback Function</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_submit'])) {
    echo "<h3>Testing Fixed createTeamFeedback...</h3>";
    
    $test_data = [
        'name' => sanitizeInput($_POST['test_name']),
        'email' => sanitizeInput($_POST['test_email']),
        'rating' => (int)$_POST['test_rating'],
        'message' => sanitizeInput($_POST['test_message']),
        'status' => 'active'
    ];
    
    echo "<p>Test data (without ID):</p><pre>" . print_r($test_data, true) . "</pre>";
    
    try {
        echo "<p>Calling createTeamFeedback(\$test_data)...</p>";
        $result = createTeamFeedback($test_data);
        
        if ($result) {
            echo "<p class='success'>✓ createTeamFeedback returned: " . ($result === true ? 'TRUE' : $result) . "</p>";
            
            // Verify insertion
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT * FROM team_feedback WHERE email = :email ORDER BY created_at DESC LIMIT 1");
            $stmt->execute(['email' => $test_data['email']]);
            $inserted = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($inserted) {
                echo "<p class='success'>✓ Record verified in database:</p>";
                echo "<pre>" . print_r($inserted, true) . "</pre>";
                echo "<p class='success'>✓ ID was auto-generated: <strong>" . $inserted['id'] . "</strong></p>";
            } else {
                echo "<p class='error'>✗ Record not found after insertion</p>";
            }
            
        } else {
            echo "<p class='error'>✗ createTeamFeedback returned FALSE</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
    }
}

// Test form
echo "<div class='test-form'>";
echo "<h3>Submit createTeamFeedback Test</h3>";
echo "<form method='POST'>";
echo "<label>Name:</label><br>";
echo "<input type='text' name='test_name' value='CreateTeamFeedback Fixed User' required><br>";
echo "<label>Email:</label><br>";
echo "<input type='email' name='test_email' value='createfixed@test.com' required><br>";
echo "<label>Rating:</label><br>";
echo "<select name='test_rating' required>";
echo "<option value='5' selected>5 - Excellent</option>";
echo "<option value='4'>4 - Very Good</option>";
echo "<option value='3'>3 - Good</option>";
echo "<option value='2'>2 - Fair</option>";
echo "<option value='1'>1 - Poor</option>";
echo "</select><br>";
echo "<label>Message:</label><br>";
echo "<textarea name='test_message' rows='4' required>Testing the fixed createTeamFeedback function with auto-generated ID.</textarea><br>";
echo "<button type='submit' name='test_submit'>Test createTeamFeedback</button>";
echo "</form>";
echo "</div>";

echo "</div>";

// Test 2: Show all feedback to verify
echo "<div class='test-section'>";
echo "<h2>2. All Team Feedback Entries</h2>";

try {
    $feedbacks = getAllTeamFeedback();
    
    if (!empty($feedbacks)) {
        echo "<p class='success'>✓ Total feedback entries: " . count($feedbacks) . "</p>";
        
        echo "<h3>All Feedback (Most Recent First):</h3>";
        foreach ($feedbacks as $feedback) {
            echo "<div style='border:1px solid #ddd;padding:10px;margin:5px 0;background:#fff;'>";
            echo "<strong>" . htmlspecialchars($feedback['name']) . "</strong> ";
            echo "<span style='color:#f59e0b;'>";
            for ($i = 1; $i <= 5; $i++) {
                echo ($i <= $feedback['rating']) ? '★' : '☆';
            }
            echo "</span><br>";
            echo "<em>" . htmlspecialchars($feedback['email']) . "</em><br>";
            echo "<p>" . htmlspecialchars($feedback['message']) . "</p>";
            echo "<small>ID: " . htmlspecialchars($feedback['id']) . " | Created: " . $feedback['created_at'] . "</small>";
            echo "</div>";
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Error retrieving feedback: " . $e->getMessage() . "</p>";
}

echo "</div>";

echo "<div class='test-section'>";
echo "<h2>3. Final Test - Live Team Feedback Page</h2>";
echo "<p>If the test above shows ✓ createTeamFeedback works, your form is completely fixed!</p>";
echo "<p><a href='teamFeedback.php' target='_blank' style='background:#28a745;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;font-weight:bold;'>🎉 Test Live Team Feedback Form</a></p>";
echo "<p><small>The live form should now work perfectly - try submitting feedback!</small></p>";
echo "</div>";

echo "</body></html>";
?>
