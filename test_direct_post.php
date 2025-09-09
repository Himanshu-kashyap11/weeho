<?php
/**
 * Test direct POST to registration and feedback endpoints
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Direct POST Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;}</style>";
echo "</head><body>";

echo "<h1>Direct POST Test</h1>";

// Test 1: Direct POST to register.php
echo "<h2>1. Testing register.php directly</h2>";

$registration_data = [
    'eventId' => 'event_1704067200_1001',
    'name' => 'Direct POST Test User',
    'email' => 'directpost' . time() . '@test.com',
    'phone' => '+91-8888888888',
    'role' => 'Audience',
    'city' => 'Direct Test City'
];

echo "<p>POST data being sent:</p>";
echo "<pre>" . print_r($registration_data, true) . "</pre>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/we/we/register.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($registration_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>HTTP Status:</strong> $http_code</p>";
echo "<p><strong>Response:</strong></p>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

// Test 2: Direct POST to feedback.php
echo "<h2>2. Testing feedback.php directly</h2>";

$feedback_data = [
    'eventId' => 'event_1704067200_1001',
    'name' => 'Direct POST Feedback User',
    'rating' => '4',
    'feedback' => 'This is a direct POST test feedback message.'
];

echo "<p>POST data being sent:</p>";
echo "<pre>" . print_r($feedback_data, true) . "</pre>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/we/we/feedback.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($feedback_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>HTTP Status:</strong> $http_code</p>";
echo "<p><strong>Response:</strong></p>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

// Test 3: Check if data was actually saved
echo "<h2>3. Verify Data in Database</h2>";

require_once 'config.php';
initializeDatabase();

$recent_registrations = fetchAll("SELECT * FROM registrations ORDER BY created_at DESC LIMIT 5");
echo "<p><strong>Recent Registrations:</strong></p>";
foreach ($recent_registrations as $reg) {
    echo "<p>• " . $reg['name'] . " (" . $reg['email'] . ") - " . $reg['created_at'] . "</p>";
}

$recent_feedback = fetchAll("SELECT * FROM feedback ORDER BY created_at DESC LIMIT 5");
echo "<p><strong>Recent Feedback:</strong></p>";
foreach ($recent_feedback as $fb) {
    echo "<p>• " . $fb['name'] . " (Rating: " . $fb['rating'] . ") - " . $fb['created_at'] . "</p>";
}

echo "</body></html>";
?>
