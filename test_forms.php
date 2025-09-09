<?php
/**
 * Test script for registration and feedback forms
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Form Submissions</h2>\n";

require_once 'config.php';

try {
    // Initialize database
    initializeDatabase();
    echo "<p>✓ Database initialized</p>\n";
    
    // Test 1: Registration Form Submission
    echo "<h3>Test 1: Registration Form</h3>\n";
    
    $testRegistration = [
        'id' => generateId('reg_'),
        'event_id' => 'evt_001',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '+91-9876543210',
        'role' => 'Audience',
        'city' => 'Mumbai',
        'status' => 'confirmed'
    ];
    
    $regResult = createRegistration($testRegistration);
    if ($regResult) {
        echo "<p>✓ Registration created successfully</p>\n";
        
        // Verify it was saved
        $verify = fetchOne("SELECT * FROM registrations WHERE id = ?", [$testRegistration['id']]);
        if ($verify) {
            echo "<p>✓ Registration verified in database</p>\n";
            echo "<p>Registration ID: " . $verify['id'] . "</p>\n";
        } else {
            echo "<p>✗ Registration not found in database</p>\n";
        }
    } else {
        echo "<p>✗ Registration creation failed</p>\n";
    }
    
    // Test 2: Feedback Form Submission
    echo "<h3>Test 2: Feedback Form</h3>\n";
    
    $testFeedback = [
        'id' => generateId('feedback_'),
        'event_id' => 'evt_001',
        'name' => 'Test Reviewer',
        'rating' => 5,
        'feedback' => 'This is a test feedback message.',
        'status' => 'active'
    ];
    
    $feedbackResult = createFeedback($testFeedback);
    if ($feedbackResult) {
        echo "<p>✓ Feedback created successfully</p>\n";
        
        // Verify it was saved
        $verify = fetchOne("SELECT * FROM feedback WHERE id = ?", [$testFeedback['id']]);
        if ($verify) {
            echo "<p>✓ Feedback verified in database</p>\n";
            echo "<p>Feedback ID: " . $verify['id'] . "</p>\n";
        } else {
            echo "<p>✗ Feedback not found in database</p>\n";
        }
    } else {
        echo "<p>✗ Feedback creation failed</p>\n";
    }
    
    // Test 3: Check Events
    echo "<h3>Test 3: Events Data</h3>\n";
    
    $events = getAllEvents();
    if ($events && count($events) > 0) {
        echo "<p>✓ Found " . count($events) . " events</p>\n";
        foreach ($events as $event) {
            echo "<p>Event: " . $event['title'] . " (ID: " . $event['id'] . ")</p>\n";
        }
    } else {
        echo "<p>✗ No events found</p>\n";
    }
    
    // Test 4: Database Statistics
    echo "<h3>Test 4: Database Statistics</h3>\n";
    
    $stats = getAdminStats();
    if ($stats) {
        echo "<p>Total Events: " . $stats['total_events'] . "</p>\n";
        echo "<p>Total Registrations: " . $stats['total_registrations'] . "</p>\n";
        echo "<p>Total Feedback: " . $stats['total_feedback'] . "</p>\n";
        echo "<p>Average Rating: " . number_format($stats['avg_rating'], 2) . "</p>\n";
    }
    
    echo "<h3>All Tests Complete!</h3>\n";
    echo "<p><a href='index.php'>Go to Homepage</a> | <a href='setup_db.php'>Setup Database</a></p>\n";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>\n";
    echo "<p>Stack trace:</p><pre>" . $e->getTraceAsString() . "</pre>\n";
}
?>
