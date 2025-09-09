<?php
/**
 * Test the Team Feedback form functionality
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Team Feedback Form Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;} .test-form{background:#fff;padding:20px;border:1px solid #ccc;margin:15px 0;} input,select,textarea{padding:8px;margin:5px 0;width:200px;} button{padding:10px 15px;margin:5px;background:#007bff;color:white;border:none;cursor:pointer;}</style>";
echo "</head><body>";

echo "<h1>Team Feedback Form Testing</h1>";

require_once 'config.php';

// Test 1: Check if required functions exist
echo "<div class='test-section'>";
echo "<h2>1. Function Availability Test</h2>";

if (function_exists('createTeamFeedback')) {
    echo "<p class='success'>✓ createTeamFeedback() function exists</p>";
} else {
    echo "<p class='error'>✗ createTeamFeedback() function missing</p>";
}

if (function_exists('getAllTeamFeedback')) {
    echo "<p class='success'>✓ getAllTeamFeedback() function exists</p>";
} else {
    echo "<p class='error'>✗ getAllTeamFeedback() function missing</p>";
}

if (function_exists('sanitizeInput')) {
    echo "<p class='success'>✓ sanitizeInput() function exists</p>";
} else {
    echo "<p class='error'>✗ sanitizeInput() function missing</p>";
}

echo "</div>";

// Test 2: Database connection test
echo "<div class='test-section'>";
echo "<h2>2. Database Connection Test</h2>";

try {
    initializeDatabase();
    echo "<p class='success'>✓ Database connection successful</p>";
    
    // Check if team_feedback table exists
    global $conn;
    if ($conn) {
        $stmt = $conn->query("SHOW TABLES LIKE 'team_feedback'");
        if ($stmt->rowCount() > 0) {
            echo "<p class='success'>✓ team_feedback table exists</p>";
            
            // Show table structure
            $stmt = $conn->query("DESCRIBE team_feedback");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<p>Table structure:</p><pre>";
            foreach ($columns as $column) {
                echo $column['Field'] . " - " . $column['Type'] . "\n";
            }
            echo "</pre>";
        } else {
            echo "<p class='error'>✗ team_feedback table does not exist</p>";
        }
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 3: Test form submission
echo "<div class='test-section'>";
echo "<h2>3. Form Submission Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_submit'])) {
    echo "<h3>Processing Test Submission...</h3>";
    
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
        $result = createTeamFeedback($test_data);
        if ($result) {
            echo "<p class='success'>✓ Team feedback created successfully!</p>";
            echo "<p>Result: " . ($result === true ? 'TRUE' : $result) . "</p>";
        } else {
            echo "<p class='error'>✗ Failed to create team feedback</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error creating team feedback: " . $e->getMessage() . "</p>";
    }
}

// Test form
echo "<div class='test-form'>";
echo "<h3>Submit Test Feedback</h3>";
echo "<form method='POST'>";
echo "<label>Name:</label><br>";
echo "<input type='text' name='test_name' value='Test User' required><br>";
echo "<label>Email:</label><br>";
echo "<input type='email' name='test_email' value='test@example.com' required><br>";
echo "<label>Rating:</label><br>";
echo "<select name='test_rating' required>";
echo "<option value='5'>5 - Excellent</option>";
echo "<option value='4'>4 - Very Good</option>";
echo "<option value='3'>3 - Good</option>";
echo "<option value='2'>2 - Fair</option>";
echo "<option value='1'>1 - Poor</option>";
echo "</select><br>";
echo "<label>Message:</label><br>";
echo "<textarea name='test_message' rows='4' required>This is a test feedback message to verify the form functionality.</textarea><br>";
echo "<button type='submit' name='test_submit'>Submit Test Feedback</button>";
echo "</form>";
echo "</div>";

echo "</div>";

// Test 4: Display existing feedback
echo "<div class='test-section'>";
echo "<h2>4. Existing Feedback Test</h2>";

try {
    $feedbacks = getAllTeamFeedback();
    
    if (!empty($feedbacks)) {
        echo "<p class='success'>✓ Found " . count($feedbacks) . " feedback entries</p>";
        echo "<h3>Recent Feedback:</h3>";
        
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
    } else {
        echo "<p class='warning'>⚠ No feedback entries found</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Error retrieving feedback: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 5: Test the actual teamFeedback.php page
echo "<div class='test-section'>";
echo "<h2>5. Main Page Test</h2>";
echo "<p>Test the actual team feedback page:</p>";
echo "<p><a href='teamFeedback.php' target='_blank' style='background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>Open Team Feedback Page</a></p>";
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>Instructions</h2>";
echo "<ol>";
echo "<li>Check all tests above - they should show green checkmarks</li>";
echo "<li>Submit the test form above to verify database insertion</li>";
echo "<li>Click 'Open Team Feedback Page' to test the actual form</li>";
echo "<li>If any tests fail, we'll need to fix the issues</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";
?>
