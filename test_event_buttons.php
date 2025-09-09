<?php
/**
 * Test the event buttons and modal functionality
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Event Buttons Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-button{background:#007cba;color:white;padding:10px;border:none;margin:5px;cursor:pointer;}</style>";
echo "</head><body>";

echo "<h1>Event Buttons Test</h1>";

require_once 'config.php';
initializeDatabase();

// Get actual events from database
$events = getAllEvents();

echo "<h2>Available Events</h2>";
foreach ($events as $event) {
    echo "<div style='border:1px solid #ddd;padding:10px;margin:10px 0;'>";
    echo "<h3>" . $event['title'] . "</h3>";
    echo "<p>Event ID: <strong>" . $event['id'] . "</strong></p>";
    echo "<p>Date: " . $event['date'] . " | City: " . $event['city'] . "</p>";
    echo "<p>" . $event['description'] . "</p>";
    
    // Test buttons
    echo "<button class='test-button' onclick='testRegistration(\"" . $event['id'] . "\")'>Test Registration</button>";
    echo "<button class='test-button' onclick='testFeedback(\"" . $event['id'] . "\")'>Test Feedback</button>";
    echo "</div>";
}

echo "<h2>Test Results</h2>";
echo "<div id='testResults'></div>";

echo "<script>
function testRegistration(eventId) {
    console.log('Testing registration for event:', eventId);
    
    // Create form data
    const formData = new FormData();
    formData.append('eventId', eventId);
    formData.append('name', 'Test User ' + Date.now());
    formData.append('email', 'test' + Date.now() + '@example.com');
    formData.append('phone', '+91-9876543210');
    formData.append('role', 'Audience');
    formData.append('city', 'Test City');
    
    // Log form data
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Submit to register.php
    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Registration response:', data);
        const resultDiv = document.getElementById('testResults');
        if (data.success) {
            resultDiv.innerHTML += '<p style=\"color:green;\">✓ Registration successful for event ' + eventId + ': ' + data.message + '</p>';
        } else {
            resultDiv.innerHTML += '<p style=\"color:red;\">✗ Registration failed for event ' + eventId + ': ' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Registration error:', error);
        document.getElementById('testResults').innerHTML += '<p style=\"color:red;\">✗ Registration error for event ' + eventId + ': ' + error + '</p>';
    });
}

function testFeedback(eventId) {
    console.log('Testing feedback for event:', eventId);
    
    // Create form data
    const formData = new FormData();
    formData.append('eventId', eventId);
    formData.append('name', 'Test Reviewer ' + Date.now());
    formData.append('rating', '5');
    formData.append('feedback', 'This is a test feedback message for event ' + eventId);
    
    // Log form data
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Submit to feedback.php
    fetch('feedback.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Feedback response:', data);
        const resultDiv = document.getElementById('testResults');
        if (data.success) {
            resultDiv.innerHTML += '<p style=\"color:green;\">✓ Feedback successful for event ' + eventId + ': ' + data.message + '</p>';
        } else {
            resultDiv.innerHTML += '<p style=\"color:red;\">✗ Feedback failed for event ' + eventId + ': ' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Feedback error:', error);
        document.getElementById('testResults').innerHTML += '<p style=\"color:red;\">✗ Feedback error for event ' + eventId + ': ' + error + '</p>';
    });
}
</script>";

echo "<h2>Instructions</h2>";
echo "<p>1. Click the 'Test Registration' and 'Test Feedback' buttons above</p>";
echo "<p>2. Check the browser console (F12) for detailed logs</p>";
echo "<p>3. Results will appear in the 'Test Results' section</p>";
echo "<p>4. If tests pass, the issue is with the modal event ID population on your main site</p>";

echo "</body></html>";
?>
