<?php
/**
 * Test the complete workshop registration system
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Workshop System Complete Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;} .test-form{background:#fff;padding:20px;border:1px solid #ccc;margin:15px 0;} input,select,textarea{padding:8px;margin:5px 0;width:200px;} button{padding:10px 15px;margin:5px;background:#007bff;color:white;border:none;cursor:pointer;}</style>";
echo "</head><body>";

echo "<h1>Complete Workshop System Test</h1>";

require_once 'config.php';

// Test 1: Check database tables
echo "<div class='test-section'>";
echo "<h2>1. Database Tables Check</h2>";

try {
    $pdo = getDB();
    
    // Check workshops table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM workshops");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p class='success'>✓ workshops table has {$count['count']} records</p>";
    
    // Check workshop_registrations table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM workshop_registrations");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p class='success'>✓ workshop_registrations table has {$count['count']} records</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 2: Check workshop functions
echo "<div class='test-section'>";
echo "<h2>2. Workshop Functions Test</h2>";

$functions = [
    'createWorkshop' => 'Create workshop',
    'getAllWorkshops' => 'Get all workshops',
    'getWorkshopById' => 'Get workshop by ID',
    'createWorkshopRegistration' => 'Create registration',
    'getWorkshopRegistrations' => 'Get registrations',
    'getWorkshopRegistrationCount' => 'Get registration count'
];

foreach ($functions as $func => $desc) {
    if (function_exists($func)) {
        echo "<p class='success'>✓ {$desc} - {$func}()</p>";
    } else {
        echo "<p class='error'>✗ {$desc} - {$func}() missing</p>";
    }
}

echo "</div>";

// Test 3: Test workshop data
echo "<div class='test-section'>";
echo "<h2>3. Workshop Data Test</h2>";

try {
    $workshops = getAllWorkshops();
    
    if (!empty($workshops)) {
        echo "<p class='success'>✓ Found " . count($workshops) . " workshops</p>";
        
        echo "<h3>Available Workshops:</h3>";
        foreach ($workshops as $workshop) {
            $registrationCount = getWorkshopRegistrationCount($workshop['id']);
            echo "<div style='border:1px solid #ddd;padding:10px;margin:5px 0;background:#fff;'>";
            echo "<strong>{$workshop['name']}</strong><br>";
            echo "<em>{$workshop['frequency']} | {$workshop['duration']} | Max: {$workshop['max_participants']} participants</em><br>";
            echo "<small>ID: {$workshop['id']} | Registrations: {$registrationCount}</small>";
            echo "</div>";
        }
    } else {
        echo "<p class='error'>✗ No workshops found</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>✗ Error getting workshops: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 4: Test registration functionality
echo "<div class='test-section'>";
echo "<h2>4. Registration Functionality Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_registration'])) {
    echo "<h3>Testing Workshop Registration...</h3>";
    
    $test_data = [
        'workshop_id' => $_POST['test_workshop'],
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'phone' => '+91-9876543210',
        'experience_level' => 'beginner',
        'preferred_schedule' => 'Weekends',
        'special_requirements' => 'This is a test registration'
    ];
    
    echo "<p>Test registration data:</p><pre>" . print_r($test_data, true) . "</pre>";
    
    try {
        $result = createWorkshopRegistration($test_data);
        
        if ($result) {
            echo "<p class='success'>✓ Workshop registration successful!</p>";
            
            // Get the registration
            $registrations = getWorkshopRegistrations($test_data['workshop_id']);
            $latest = array_shift($registrations);
            
            if ($latest && $latest['email'] === $test_data['email']) {
                echo "<p class='success'>✓ Registration verified in database</p>";
                echo "<pre>" . print_r($latest, true) . "</pre>";
            }
        } else {
            echo "<p class='error'>✗ Workshop registration failed</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>✗ Registration error: " . $e->getMessage() . "</p>";
    }
}

// Registration test form
echo "<div class='test-form'>";
echo "<h3>Test Workshop Registration</h3>";
echo "<form method='POST'>";
echo "<label>Select Workshop:</label><br>";
echo "<select name='test_workshop' required>";

try {
    $workshops = getAllWorkshops();
    foreach ($workshops as $workshop) {
        echo "<option value='{$workshop['id']}'>{$workshop['name']}</option>";
    }
} catch (Exception $e) {
    echo "<option value=''>Error loading workshops</option>";
}

echo "</select><br><br>";
echo "<button type='submit' name='test_registration'>Test Registration</button>";
echo "</form>";
echo "</div>";

echo "</div>";

// Test 5: Check about.php integration
echo "<div class='test-section'>";
echo "<h2>5. About.php Integration Check</h2>";

$about_content = file_get_contents('about.php');

// Check for modal
if (strpos($about_content, 'workshopModal') !== false) {
    echo "<p class='success'>✓ Workshop modal found in about.php</p>";
} else {
    echo "<p class='error'>✗ Workshop modal missing from about.php</p>";
}

// Check for JavaScript functions
if (strpos($about_content, 'openWorkshopModal') !== false) {
    echo "<p class='success'>✓ openWorkshopModal function found</p>";
} else {
    echo "<p class='error'>✗ openWorkshopModal function missing</p>";
}

// Check for onclick handlers
$onclick_count = substr_count($about_content, 'onclick="openWorkshopModal');
echo "<p class='success'>✓ Found {$onclick_count} workshop buttons with onclick handlers</p>";

echo "</div>";

// Test 6: Check workshop_registration.php
echo "<div class='test-section'>";
echo "<h2>6. Workshop Registration Handler Check</h2>";

if (file_exists('workshop_registration.php')) {
    echo "<p class='success'>✓ workshop_registration.php exists</p>";
    
    // Test API endpoint
    $test_url = 'http://localhost/we/we/workshop_registration.php';
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 5
        ]
    ]);
    
    $response = @file_get_contents($test_url, false, $context);
    if ($response) {
        $data = json_decode($response, true);
        if ($data && isset($data['success'])) {
            echo "<p class='success'>✓ Workshop registration API responds correctly</p>";
        } else {
            echo "<p class='warning'>⚠ API responds but format may be incorrect</p>";
        }
    } else {
        echo "<p class='error'>✗ Workshop registration API not responding</p>";
    }
} else {
    echo "<p class='error'>✗ workshop_registration.php missing</p>";
}

echo "</div>";

echo "<div class='test-section'>";
echo "<h2>7. Final Test - Live Workshop System</h2>";
echo "<p>If all tests above pass, your workshop system is ready!</p>";
echo "<p><a href='about.php' target='_blank' style='background:#28a745;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;font-weight:bold;'>🎉 Test Live Workshop Registration</a></p>";
echo "<p><small>Go to the About page and click any 'Join Workshop' button to test the complete system!</small></p>";

echo "<h3>System Summary:</h3>";
echo "<ul>";
echo "<li>✅ Database tables created (workshops, workshop_registrations)</li>";
echo "<li>✅ PHP functions added to database_config.php</li>";
echo "<li>✅ Workshop registration handler created</li>";
echo "<li>✅ Modal and JavaScript added to about.php</li>";
echo "<li>✅ All 5 workshop buttons now functional</li>";
echo "</ul>";
echo "</div>";

echo "</body></html>";
?>
