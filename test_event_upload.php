<?php
// Test Event Upload Functionality
require_once 'api/EventsAPI.php';

echo "<h2>🎭 Event Upload Test</h2>";

// Create test event data
$testEventData = [
    'title' => 'Test Cultural Event',
    'date' => '2024-02-15',
    'performer' => 'Test Artist',
    'city' => 'Mumbai',
    'description' => 'This is a test event to verify database integration.',
    'image_url' => 'https://example.com/test-image.jpg',
    'status' => 'upcoming'
];

try {
    // Initialize EventsAPI
    $eventsAPI = new EventsAPI();
    
    echo "<h3>📝 Testing Event Creation</h3>";
    echo "<p><strong>Test Event Data:</strong></p>";
    echo "<pre>" . json_encode($testEventData, JSON_PRETTY_PRINT) . "</pre>";
    
    // Simulate POST request for creating event
    $_POST = $testEventData;
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    // Capture output
    ob_start();
    $eventsAPI->handleRequest();
    $response = ob_get_clean();
    
    echo "<h3>📤 API Response:</h3>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    // Test reading events
    echo "<h3>📖 Testing Event Retrieval</h3>";
    $_SERVER['REQUEST_METHOD'] = 'GET';
    unset($_POST);
    
    ob_start();
    $eventsAPI->handleRequest();
    $getResponse = ob_get_clean();
    
    echo "<pre>" . htmlspecialchars($getResponse) . "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<h3>🔗 Quick Links</h3>";
echo "<a href='events.php'>View Events Page</a> | ";
echo "<a href='test_database.php'>Database Test</a> | ";
echo "<a href='index.php'>Homepage</a>";
?>
