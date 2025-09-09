<?php
/**
 * Debug the main website event loading and button functionality
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Main Site Debug</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .event-card{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;}</style>";
echo "</head><body>";

echo "<h1>Main Website Event Loading Debug</h1>";

require_once 'config.php';

// Test 1: Check if events are loading via API
echo "<h2>1. Testing EventsAPI.php</h2>";

if (file_exists('api/EventsAPI.php')) {
    echo "<p class='success'>✓ EventsAPI.php exists</p>";
    
    // Test API call
    $api_url = 'http://localhost/we/we/api/EventsAPI.php';
    $api_response = file_get_contents($api_url);
    
    if ($api_response) {
        echo "<p class='success'>✓ API responds</p>";
        $api_data = json_decode($api_response, true);
        
        if ($api_data && isset($api_data['success']) && $api_data['success']) {
            echo "<p class='success'>✓ API returns success</p>";
            $events_key = isset($api_data['events']) ? 'events' : 'data';
            if (isset($api_data[$events_key])) {
                echo "<p>Events returned: " . count($api_data[$events_key]) . "</p>";
                echo "<p>Events key used: <strong>$events_key</strong></p>";
            } else {
                echo "<p class='warning'>⚠ No events/data key found</p>";
            }
        } else {
            echo "<p class='error'>✗ API returns error or no data</p>";
            echo "<pre>" . htmlspecialchars($api_response) . "</pre>";
        }
    } else {
        echo "<p class='error'>✗ API not responding</p>";
    }
} else {
    echo "<p class='error'>✗ EventsAPI.php missing</p>";
}

// Test 2: Check events.json fallback
echo "<h2>2. Testing events.json fallback</h2>";

if (file_exists('events.json')) {
    echo "<p class='success'>✓ events.json exists</p>";
    $json_content = file_get_contents('events.json');
    $json_data = json_decode($json_content, true);
    
    if ($json_data) {
        echo "<p class='success'>✓ events.json is valid JSON</p>";
        echo "<p>Events in JSON: " . count($json_data) . "</p>";
    } else {
        echo "<p class='error'>✗ events.json is invalid</p>";
    }
} else {
    echo "<p class='warning'>⚠ events.json missing (using database only)</p>";
}

// Test 3: Simulate the exact JavaScript event loading
echo "<h2>3. Simulating JavaScript Event Loading</h2>";

initializeDatabase();
$events = getAllEvents();

echo "<p>Database events count: " . count($events) . "</p>";

echo "<h3>Generated Event Cards (as JavaScript would create them):</h3>";

foreach ($events as $event) {
    echo "<div class='event-card'>";
    echo "<h4>" . htmlspecialchars($event['title']) . "</h4>";
    echo "<div class='event-meta'>";
    echo "<span>📅 " . $event['date'] . "</span> ";
    echo "<span>🎭 " . $event['performer'] . "</span> ";
    echo "<span>📍 " . $event['city'] . "</span>";
    echo "</div>";
    echo "<div class='event-description'>" . htmlspecialchars($event['description']) . "</div>";
    echo "<div class='event-actions'>";
    echo "<button class='btn btn-primary btn-sm' onclick='testRegModal(\"" . $event['id'] . "\")'>Register</button> ";
    echo "<button class='btn btn-secondary btn-sm' onclick='testFeedModal(\"" . $event['id'] . "\")'>Feedback</button>";
    echo "</div>";
    echo "<p><small>Event ID: <strong>" . $event['id'] . "</strong></small></p>";
    echo "</div>";
}

echo "<div id='modalTest'></div>";

echo "<script>
function testRegModal(eventId) {
    console.log('Testing registration modal for:', eventId);
    
    // Test if the modal elements exist
    const modal = document.getElementById('registrationModal');
    const eventIdInput = document.getElementById('regEventId');
    
    let result = 'Testing Registration Modal for event: ' + eventId + '\\n';
    
    if (!modal) {
        result += '✗ Registration modal not found\\n';
    } else {
        result += '✓ Registration modal found\\n';
    }
    
    if (!eventIdInput) {
        result += '✗ regEventId input not found\\n';
    } else {
        result += '✓ regEventId input found\\n';
        eventIdInput.value = eventId;
        result += '✓ Event ID set to: ' + eventIdInput.value + '\\n';
    }
    
    document.getElementById('modalTest').innerHTML = '<pre>' + result + '</pre>';
}

function testFeedModal(eventId) {
    console.log('Testing feedback modal for:', eventId);
    
    const modal = document.getElementById('feedbackModal');
    const eventIdInput = document.getElementById('feedbackEventId');
    
    let result = 'Testing Feedback Modal for event: ' + eventId + '\\n';
    
    if (!modal) {
        result += '✗ Feedback modal not found\\n';
    } else {
        result += '✓ Feedback modal found\\n';
    }
    
    if (!eventIdInput) {
        result += '✗ feedbackEventId input not found\\n';
    } else {
        result += '✓ feedbackEventId input found\\n';
        eventIdInput.value = eventId;
        result += '✓ Event ID set to: ' + eventIdInput.value + '\\n';
    }
    
    document.getElementById('modalTest').innerHTML = '<pre>' + result + '</pre>';
}
</script>";

// Test 4: Check if modals exist on this page
echo "<h2>4. Modal Elements Test</h2>";

$index_content = file_get_contents('index.php');

if (strpos($index_content, 'id="registrationModal"') !== false) {
    echo "<p class='success'>✓ Registration modal HTML found in index.php</p>";
} else {
    echo "<p class='error'>✗ Registration modal HTML missing from index.php</p>";
}

if (strpos($index_content, 'id="feedbackModal"') !== false) {
    echo "<p class='success'>✓ Feedback modal HTML found in index.php</p>";
} else {
    echo "<p class='error'>✗ Feedback modal HTML missing from index.php</p>";
}

// Add the actual modals to this page for testing
echo "<!-- Adding modals for testing -->";
echo "<div id='registrationModal' style='display:none;'>";
echo "<input type='hidden' id='regEventId' name='eventId'>";
echo "</div>";

echo "<div id='feedbackModal' style='display:none;'>";
echo "<input type='hidden' id='feedbackEventId' name='eventId'>";
echo "</div>";

echo "<h3>Instructions:</h3>";
echo "<p>1. Click the Register/Feedback buttons above to test modal functionality</p>";
echo "<p>2. Check the test results that appear below the buttons</p>";
echo "<p>3. If modals work here but not on main site, the issue is with event loading on index.php</p>";

echo "</body></html>";
?>
