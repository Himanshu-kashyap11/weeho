<?php
/**
 * Test the fixed insertData function
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Fixed Insert Test</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;}</style>";
echo "</head><body>";

echo "<h1>Testing Fixed Insert Functions</h1>";

require_once 'config.php';

// Initialize database
initializeDatabase();

// Test 1: Registration
echo "<h2>Test 1: Registration Form</h2>";

$test_registration = [
    'id' => generateId('reg_'),
    'event_id' => 'event_1704067200_1001', // Use existing event ID
    'name' => 'Fixed Test User',
    'email' => 'fixed@test.com',
    'phone' => '+91-9876543210',
    'role' => 'Audience',
    'city' => 'Mumbai',
    'status' => 'confirmed'
];

echo "<p>Test registration data:</p>";
echo "<pre>" . print_r($test_registration, true) . "</pre>";

try {
    $result = createRegistration($test_registration);
    if ($result) {
        echo "<p class='success'>✓ Registration created successfully</p>";
        
        // Verify it was saved
        $verify = fetchOne("SELECT * FROM registrations WHERE id = ?", [$test_registration['id']]);
        if ($verify) {
            echo "<p class='success'>✓ Registration verified in database</p>";
            echo "<pre>" . print_r($verify, true) . "</pre>";
        } else {
            echo "<p class='error'>✗ Registration not found in database</p>";
        }
    } else {
        echo "<p class='error'>✗ Registration creation failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Registration error: " . $e->getMessage() . "</p>";
}

// Test 2: Feedback
echo "<h2>Test 2: Feedback Form</h2>";

$test_feedback = [
    'id' => generateId('feedback_'),
    'event_id' => 'event_1704067200_1001', // Use existing event ID
    'name' => 'Fixed Test Reviewer',
    'rating' => 5,
    'feedback' => 'This is a test feedback after the fix.',
    'status' => 'active'
];

echo "<p>Test feedback data:</p>";
echo "<pre>" . print_r($test_feedback, true) . "</pre>";

try {
    $result = createFeedback($test_feedback);
    if ($result) {
        echo "<p class='success'>✓ Feedback created successfully</p>";
        
        // Verify it was saved
        $verify = fetchOne("SELECT * FROM feedback WHERE id = ?", [$test_feedback['id']]);
        if ($verify) {
            echo "<p class='success'>✓ Feedback verified in database</p>";
            echo "<pre>" . print_r($verify, true) . "</pre>";
        } else {
            echo "<p class='error'>✗ Feedback not found in database</p>";
        }
    } else {
        echo "<p class='error'>✗ Feedback creation failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Feedback error: " . $e->getMessage() . "</p>";
}

// Test 3: Simulate actual form submission
echo "<h2>Test 3: Simulate Form POST</h2>";

// Simulate registration form POST
$_POST = [
    'eventId' => 'event_1704067200_1001',
    'name' => 'Form Test User',
    'email' => 'formtest@example.com',
    'phone' => '+91-1234567890',
    'role' => 'Audience',
    'city' => 'Delhi'
];

echo "<p>Simulating POST data:</p>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

// Test the same logic as register.php
$eventId = sanitizeInput($_POST['eventId'] ?? '');
$name = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$phone = sanitizeInput($_POST['phone'] ?? '');
$role = sanitizeInput($_POST['role'] ?? '');
$city = sanitizeInput($_POST['city'] ?? '');

if (!empty($eventId) && !empty($name) && !empty($email) && !empty($phone)) {
    $registrationData = [
        'id' => generateId('reg_'),
        'event_id' => $eventId,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'role' => $role,
        'city' => $city,
        'status' => 'confirmed'
    ];
    
    try {
        $result = createRegistration($registrationData);
        if ($result) {
            echo "<p class='success'>✓ Form simulation successful</p>";
            $verify = fetchOne("SELECT * FROM registrations WHERE id = ?", [$registrationData['id']]);
            if ($verify) {
                echo "<p class='success'>✓ Form data verified in database</p>";
            }
        } else {
            echo "<p class='error'>✗ Form simulation failed</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ Form simulation error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error'>✗ Required fields missing</p>";
}

// Show current registration count
$count = fetchOne("SELECT COUNT(*) as count FROM registrations")['count'];
echo "<h3>Current Registration Count: $count</h3>";

echo "<p><a href='index.php'>Test on actual website</a></p>";

echo "</body></html>";
?>
