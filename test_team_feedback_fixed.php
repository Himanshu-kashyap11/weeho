<?php
/**
 * Test the fixed Team Feedback form functionality
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Team Feedback Fixed Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;} .test-form{background:#fff;padding:20px;border:1px solid #ccc;margin:15px 0;} input,select,textarea{padding:8px;margin:5px 0;width:200px;} button{padding:10px 15px;margin:5px;background:#007bff;color:white;border:none;cursor:pointer;}</style>";
echo "</head><body>";

echo "<h1>Team Feedback Fixed Test</h1>";

require_once 'config.php';

// Test 1: Database connection and table check
echo "<div class='test-section'>";
echo "<h2>1. Database Connection Test</h2>";

try {
    initializeDatabase();
    global $conn;
    
    if ($conn) {
        echo "<p class='success'>✓ Database connected successfully</p>";
        
        // Check table structure
        $stmt = $conn->query("DESCRIBE team_feedback");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<p class='success'>✓ team_feedback table structure:</p><pre>";
        foreach ($columns as $column) {
            echo $column['Field'] . " - " . $column['Type'] . " - " . ($column['Null'] == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
        }
        echo "</pre>";
    } else {
        echo "<p class='error'>✗ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 2: Test form submission with fixed insertData
echo "<div class='test-section'>";
echo "<h2>2. Fixed Form Submission Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_submit'])) {
    echo "<h3>Processing Fixed Test Submission...</h3>";
    
    $test_data = [
        'name' => sanitizeInput($_POST['test_name']),
        'email' => sanitizeInput($_POST['test_email']),
        'rating' => (int)$_POST['test_rating'],
        'message' => sanitizeInput($_POST['test_message']),
        'status' => 'active'
    ];
    
    echo "<p>Test data prepared:</p>";
    echo "<pre>" . print_r($test_data, true) . "</pre>";
    
    try {
        echo "<p>Calling createTeamFeedback()...</p>";
        $result = createTeamFeedback($test_data);
        
        if ($result) {
            echo "<p class='success'>✓ Team feedback created successfully!</p>";
            echo "<p>Result: " . ($result === true ? 'TRUE' : $result) . "</p>";
            
            // Verify the record was inserted
            $stmt = $conn->prepare("SELECT * FROM team_feedback WHERE email = :email ORDER BY created_at DESC LIMIT 1");
            $stmt->execute(['email' => $test_data['email']]);
            $inserted_record = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($inserted_record) {
                echo "<p class='success'>✓ Record verified in database:</p>";
                echo "<pre>" . print_r($inserted_record, true) . "</pre>";
            } else {
                echo "<p class='warning'>⚠ Record not found in database verification</p>";
            }
            
        } else {
            echo "<p class='error'>✗ Failed to create team feedback</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error creating team feedback: " . $e->getMessage() . "</p>";
    }
}

// Test form
echo "<div class='test-form'>";
echo "<h3>Submit Test Feedback (Fixed Version)</h3>";
echo "<form method='POST'>";
echo "<label>Name:</label><br>";
echo "<input type='text' name='test_name' value='Fixed Test User' required><br>";
echo "<label>Email:</label><br>";
echo "<input type='email' name='test_email' value='fixed@test.com' required><br>";
echo "<label>Rating:</label><br>";
echo "<select name='test_rating' required>";
echo "<option value='5'>5 - Excellent</option>";
echo "<option value='4'>4 - Very Good</option>";
echo "<option value='3'>3 - Good</option>";
echo "<option value='2'>2 - Fair</option>";
echo "<option value='1'>1 - Poor</option>";
echo "</select><br>";
echo "<label>Message:</label><br>";
echo "<textarea name='test_message' rows='4' required>This is a test feedback message with the fixed insertData function.</textarea><br>";
echo "<button type='submit' name='test_submit'>Submit Fixed Test Feedback</button>";
echo "</form>";
echo "</div>";

echo "</div>";

// Test 3: Display all feedback to verify
echo "<div class='test-section'>";
echo "<h2>3. All Feedback Verification</h2>";

try {
    $feedbacks = getAllTeamFeedback();
    
    if (!empty($feedbacks)) {
        echo "<p class='success'>✓ Total feedback entries: " . count($feedbacks) . "</p>";
        echo "<h3>All Feedback (Most Recent First):</h3>";
        
        // Sort by created_at descending
        usort($feedbacks, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
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
            echo "<small>Created: " . $feedback['created_at'] . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p class='warning'>⚠ No feedback entries found</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Error retrieving feedback: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 4: Test the actual teamFeedback.php page
echo "<div class='test-section'>";
echo "<h2>4. Main Team Feedback Page Test</h2>";
echo "<p>Now test the actual team feedback page:</p>";
echo "<p><a href='teamFeedback.php' target='_blank' style='background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>Open Fixed Team Feedback Page</a></p>";
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>Summary</h2>";
echo "<p><strong>Fixed Issues:</strong></p>";
echo "<ul>";
echo "<li>✅ Added automatic created_at timestamp to insertData function</li>";
echo "<li>✅ Fixed database connection handling</li>";
echo "<li>✅ Team feedback form should now work properly</li>";
echo "</ul>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Submit the test form above to verify the fix works</li>";
echo "<li>Click 'Open Fixed Team Feedback Page' to test the actual form</li>";
echo "<li>Submit feedback on the main page to confirm everything is working</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";
?>
