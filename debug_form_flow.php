<?php
/**
 * Debug the complete form submission flow
 * Check for ID mismatches, broken links, and data flow issues
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Form Flow Debug</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .code{background:#e8f4fd;padding:10px;border-left:4px solid #2196F3;}</style>";
echo "</head><body>";

echo "<h1>Complete Form Flow Debug</h1>";

require_once 'config.php';

// 1. Check form HTML structure in index.php
echo "<h2>1. Form HTML Structure Analysis</h2>";

$index_content = file_get_contents('index.php');

// Check registration form
echo "<h3>Registration Form:</h3>";
if (strpos($index_content, 'id="registrationForm"') !== false) {
    echo "<p class='success'>✓ Registration form found</p>";
} else {
    echo "<p class='error'>✗ Registration form not found</p>";
}

// Extract form fields
preg_match('/<form id="registrationForm".*?<\/form>/s', $index_content, $reg_form_match);
if ($reg_form_match) {
    $reg_form = $reg_form_match[0];
    
    // Check field names
    $expected_fields = ['eventId', 'name', 'email', 'phone', 'role', 'city'];
    foreach ($expected_fields as $field) {
        if (strpos($reg_form, 'name="' . $field . '"') !== false) {
            echo "<p class='success'>✓ Field '$field' found</p>";
        } else {
            echo "<p class='error'>✗ Field '$field' missing</p>";
        }
    }
    
    echo "<div class='code'><strong>Registration Form HTML:</strong><pre>" . htmlspecialchars($reg_form) . "</pre></div>";
}

// Check feedback form
echo "<h3>Feedback Form:</h3>";
if (strpos($index_content, 'id="feedbackForm"') !== false) {
    echo "<p class='success'>✓ Feedback form found</p>";
} else {
    echo "<p class='error'>✗ Feedback form not found</p>";
}

preg_match('/<form id="feedbackForm".*?<\/form>/s', $index_content, $feedback_form_match);
if ($feedback_form_match) {
    $feedback_form = $feedback_form_match[0];
    
    $expected_feedback_fields = ['eventId', 'name', 'rating', 'feedback'];
    foreach ($expected_feedback_fields as $field) {
        if (strpos($feedback_form, 'name="' . $field . '"') !== false) {
            echo "<p class='success'>✓ Field '$field' found</p>";
        } else {
            echo "<p class='error'>✗ Field '$field' missing</p>";
        }
    }
    
    echo "<div class='code'><strong>Feedback Form HTML:</strong><pre>" . htmlspecialchars($feedback_form) . "</pre></div>";
}

// 2. Check JavaScript form handlers
echo "<h2>2. JavaScript Form Handlers</h2>";

// Check for form submission handlers
if (strpos($index_content, 'registrationForm') !== false && strpos($index_content, 'addEventListener') !== false) {
    echo "<p class='success'>✓ Registration form JavaScript handler found</p>";
} else {
    echo "<p class='error'>✗ Registration form JavaScript handler missing</p>";
}

if (strpos($index_content, 'feedbackForm') !== false && strpos($index_content, 'addEventListener') !== false) {
    echo "<p class='success'>✓ Feedback form JavaScript handler found</p>";
} else {
    echo "<p class='error'>✗ Feedback form JavaScript handler missing</p>";
}

// Extract JavaScript handlers
preg_match('/document\.getElementById\(\'registrationForm\'\)\.addEventListener.*?}\);/s', $index_content, $js_reg_match);
if ($js_reg_match) {
    echo "<div class='code'><strong>Registration JS Handler:</strong><pre>" . htmlspecialchars($js_reg_match[0]) . "</pre></div>";
}

preg_match('/document\.getElementById\(\'feedbackForm\'\)\.addEventListener.*?}\);/s', $index_content, $js_feedback_match);
if ($js_feedback_match) {
    echo "<div class='code'><strong>Feedback JS Handler:</strong><pre>" . htmlspecialchars($js_feedback_match[0]) . "</pre></div>";
}

// 3. Check form submission URLs
echo "<h2>3. Form Submission URLs</h2>";

if (strpos($index_content, "fetch('register.php'") !== false) {
    echo "<p class='success'>✓ Registration form submits to register.php</p>";
} else {
    echo "<p class='error'>✗ Registration form submission URL issue</p>";
}

if (strpos($index_content, "fetch('feedback.php'") !== false) {
    echo "<p class='success'>✓ Feedback form submits to feedback.php</p>";
} else {
    echo "<p class='error'>✗ Feedback form submission URL issue</p>";
}

// 4. Check if PHP files exist and are accessible
echo "<h2>4. PHP File Accessibility</h2>";

$php_files = ['register.php', 'feedback.php', 'config.php', 'database_config.php'];
foreach ($php_files as $file) {
    if (file_exists($file)) {
        echo "<p class='success'>✓ $file exists</p>";
        
        // Check if file is readable
        if (is_readable($file)) {
            echo "<p class='success'>✓ $file is readable</p>";
        } else {
            echo "<p class='error'>✗ $file is not readable</p>";
        }
    } else {
        echo "<p class='error'>✗ $file missing</p>";
    }
}

// 5. Test actual form submission simulation
echo "<h2>5. Form Submission Simulation</h2>";

// Simulate registration POST
echo "<h3>Registration POST Simulation:</h3>";
$_POST = [
    'eventId' => 'event_1704067200_1001',
    'name' => 'Debug Flow Test',
    'email' => 'debugflow@test.com',
    'phone' => '+91-9999999999',
    'role' => 'Audience',
    'city' => 'Test City'
];

echo "<p>Simulating POST data:</p>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

// Capture output from register.php
ob_start();
$_SERVER['REQUEST_METHOD'] = 'POST';

try {
    include 'register.php';
    $register_output = ob_get_contents();
} catch (Exception $e) {
    $register_output = "Error: " . $e->getMessage();
}
ob_end_clean();

echo "<p><strong>register.php output:</strong></p>";
echo "<pre>" . htmlspecialchars($register_output) . "</pre>";

// 6. Check event IDs in database vs form usage
echo "<h2>6. Event ID Validation</h2>";

initializeDatabase();
$events = getAllEvents();

echo "<p>Available event IDs in database:</p>";
foreach ($events as $event) {
    echo "<p>• <strong>" . $event['id'] . "</strong> - " . $event['title'] . "</p>";
}

// Check if JavaScript is using correct event IDs
echo "<h3>Event ID Usage in JavaScript:</h3>";
preg_match_all('/openRegistrationModal\([\'"]([^\'"]+)[\'"]\)/', $index_content, $js_event_ids);
if ($js_event_ids[1]) {
    echo "<p>Event IDs used in JavaScript:</p>";
    foreach ($js_event_ids[1] as $js_id) {
        echo "<p>• " . $js_id . "</p>";
    }
} else {
    echo "<p class='warning'>⚠ No event IDs found in JavaScript calls</p>";
}

// 7. Check for any .htaccess or URL rewriting
echo "<h2>7. URL Rewriting Check</h2>";

if (file_exists('.htaccess')) {
    echo "<p class='warning'>⚠ .htaccess file found</p>";
    $htaccess_content = file_get_contents('.htaccess');
    echo "<pre>" . htmlspecialchars($htaccess_content) . "</pre>";
} else {
    echo "<p class='success'>✓ No .htaccess file (direct PHP access)</p>";
}

// 8. Check PHP error log
echo "<h2>8. Recent PHP Errors</h2>";

$error_log_path = ini_get('error_log');
if ($error_log_path && file_exists($error_log_path)) {
    echo "<p>Error log location: $error_log_path</p>";
    
    $log_content = file_get_contents($error_log_path);
    $recent_errors = array_slice(explode("\n", $log_content), -20); // Last 20 lines
    
    echo "<p><strong>Recent errors:</strong></p>";
    echo "<pre>" . htmlspecialchars(implode("\n", $recent_errors)) . "</pre>";
} else {
    echo "<p class='warning'>⚠ Error log not accessible</p>";
}

echo "<h2>Summary & Next Steps</h2>";
echo "<p>This debug shows the complete form flow. Check the output above for any red ✗ marks indicating issues.</p>";
echo "<p><a href='test_direct_post.php'>Test Direct POST</a> | <a href='index.php'>Back to Website</a></p>";

echo "</body></html>";
?>
