<?php
/**
 * Debug the actual main website by checking what's happening in real-time
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Live Site Debug</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;overflow-x:auto;} .debug-section{border:1px solid #ccc;margin:10px 0;padding:15px;background:#f9f9f9;}</style>";
echo "</head><body>";

echo "<h1>Live Site Debugging</h1>";

// Test 1: Check if the main site loads
echo "<div class='debug-section'>";
echo "<h2>1. Main Site Content Check</h2>";

$index_content = file_get_contents('index.php');

// Check for events grid
if (strpos($index_content, 'eventsGrid') !== false) {
    echo "<p class='success'>✓ eventsGrid element found in index.php</p>";
} else {
    echo "<p class='error'>✗ eventsGrid element missing from index.php</p>";
}

// Check for loadEvents function
if (strpos($index_content, 'loadEvents') !== false) {
    echo "<p class='success'>✓ loadEvents function found in index.php</p>";
} else {
    echo "<p class='error'>✗ loadEvents function missing from index.php</p>";
}

// Check for displayEvents function
if (strpos($index_content, 'displayEvents') !== false) {
    echo "<p class='success'>✓ displayEvents function found in index.php</p>";
} else {
    echo "<p class='error'>✗ displayEvents function missing from index.php</p>";
}

echo "</div>";

// Test 2: Create a minimal test page that mimics the main site
echo "<div class='debug-section'>";
echo "<h2>2. Minimal Test Implementation</h2>";
echo "<div id='testEventsGrid'></div>";
echo "<div id='testResults'></div>";

echo "<script>
console.log('Starting live site debug...');

// Test the exact same API call as main site
async function testLoadEvents() {
    const resultsDiv = document.getElementById('testResults');
    let log = 'Testing API call...\\n';
    
    try {
        console.log('Fetching from API...');
        const response = await fetch('api/EventsAPI.php');
        log += 'API Response received\\n';
        
        const result = await response.json();
        log += 'JSON parsed successfully\\n';
        log += 'Result success: ' + result.success + '\\n';
        log += 'Result has data: ' + (result.data ? 'YES' : 'NO') + '\\n';
        
        if (result.success && result.data) {
            log += 'Events count: ' + result.data.length + '\\n';
            
            // Test displayEvents function
            testDisplayEvents(result.data);
            log += 'displayEvents called\\n';
        } else {
            log += 'ERROR: API success=false or no data\\n';
            log += 'Full result: ' + JSON.stringify(result) + '\\n';
        }
    } catch (error) {
        log += 'ERROR: ' + error.message + '\\n';
        console.error('API Error:', error);
    }
    
    resultsDiv.innerHTML = '<pre>' + log + '</pre>';
}

function testDisplayEvents(events) {
    const grid = document.getElementById('testEventsGrid');
    
    if (!events || events.length === 0) {
        grid.innerHTML = '<p class=\"error\">No events to display</p>';
        return;
    }
    
    let html = '<h3>Events Loaded Successfully:</h3>';
    
    events.forEach(event => {
        html += '<div style=\"border:1px solid #ddd;padding:10px;margin:10px 0;background:#fff;\">';
        html += '<h4>' + event.title + '</h4>';
        html += '<p>📅 ' + event.date + ' | 🎭 ' + event.performer + ' | 📍 ' + event.city + '</p>';
        html += '<p>' + event.description + '</p>';
        html += '<button onclick=\"testModal(\\'' + event.id + '\\')\" style=\"margin:5px;padding:5px 10px;background:#007bff;color:white;border:none;cursor:pointer;\">Test Register</button>';
        html += '<button onclick=\"testModal(\\'' + event.id + '\\')\" style=\"margin:5px;padding:5px 10px;background:#6c757d;color:white;border:none;cursor:pointer;\">Test Feedback</button>';
        html += '<small style=\"display:block;margin-top:5px;color:#666;\">Event ID: ' + event.id + '</small>';
        html += '</div>';
    });
    
    grid.innerHTML = html;
}

function testModal(eventId) {
    alert('Modal test for event: ' + eventId + '\\n\\nThis would normally open the registration/feedback modal.');
}

// Run the test
testLoadEvents();
</script>";

echo "</div>";

// Test 3: Check what happens when we load the main site
echo "<div class='debug-section'>";
echo "<h2>3. Main Site iframe Test</h2>";
echo "<p>Loading main site in iframe to see what actually displays:</p>";
echo "<iframe src='index.php' width='100%' height='400' style='border:1px solid #ccc;'></iframe>";
echo "</div>";

echo "<div class='debug-section'>";
echo "<h2>4. Instructions</h2>";
echo "<ol>";
echo "<li>Check the test results above - this shows if the API is working</li>";
echo "<li>Look at the iframe to see what the main site actually shows</li>";
echo "<li>If events show in the test but not in the iframe, there's a JavaScript error on the main site</li>";
echo "<li>Open browser developer tools (F12) and check the Console tab for errors</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";
?>
