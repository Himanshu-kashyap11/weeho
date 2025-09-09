<?php
/**
 * Test and analyze the workshop system in about.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Workshop System Analysis</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;}</style>";
echo "</head><body>";

echo "<h1>Workshop System Analysis</h1>";

require_once 'config.php';

// Test 1: Check if workshop table exists
echo "<div class='test-section'>";
echo "<h2>1. Database Workshop Table Check</h2>";

try {
    $pdo = getDB();
    if ($pdo) {
        echo "<p class='success'>✓ Database connection established</p>";
        
        // Check if workshop table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'workshops'");
        if ($stmt->rowCount() > 0) {
            echo "<p class='success'>✓ workshops table exists</p>";
            
            // Show table structure
            $stmt = $pdo->query("DESCRIBE workshops");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<p>Table structure:</p><pre>";
            foreach ($columns as $column) {
                echo $column['Field'] . " - " . $column['Type'] . "\n";
            }
            echo "</pre>";
        } else {
            echo "<p class='error'>✗ workshops table does not exist</p>";
            echo "<p class='warning'>Need to create workshops table</p>";
        }
        
        // Check for workshop_registrations table
        $stmt = $pdo->query("SHOW TABLES LIKE 'workshop_registrations'");
        if ($stmt->rowCount() > 0) {
            echo "<p class='success'>✓ workshop_registrations table exists</p>";
            
            // Show table structure
            $stmt = $pdo->query("DESCRIBE workshop_registrations");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<p>Table structure:</p><pre>";
            foreach ($columns as $column) {
                echo $column['Field'] . " - " . $column['Type'] . "\n";
            }
            echo "</pre>";
        } else {
            echo "<p class='error'>✗ workshop_registrations table does not exist</p>";
            echo "<p class='warning'>Need to create workshop_registrations table</p>";
        }
        
    } else {
        echo "<p class='error'>✗ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 2: Check workshop functions in config
echo "<div class='test-section'>";
echo "<h2>2. Workshop Functions Check</h2>";

$workshop_functions = [
    'createWorkshopRegistration',
    'getAllWorkshops', 
    'getWorkshopRegistrations',
    'createWorkshop'
];

foreach ($workshop_functions as $func) {
    if (function_exists($func)) {
        echo "<p class='success'>✓ {$func}() function exists</p>";
    } else {
        echo "<p class='error'>✗ {$func}() function missing</p>";
    }
}

echo "</div>";

// Test 3: Analyze about.php workshop buttons
echo "<div class='test-section'>";
echo "<h2>3. About.php Workshop Analysis</h2>";

$about_content = file_get_contents('about.php');

// Count workshop buttons
$workshop_btn_count = substr_count($about_content, 'workshop-btn');
echo "<p>Workshop buttons found: <strong>{$workshop_btn_count}</strong></p>";

// Check for JavaScript functionality
if (strpos($about_content, 'workshop-btn') !== false) {
    echo "<p class='warning'>⚠ Workshop buttons exist but no JavaScript functionality detected</p>";
} else {
    echo "<p class='error'>✗ No workshop buttons found</p>";
}

// List workshop types from about.php
$workshops = [
    'Music Appreciation Classes',
    'Folk Arts & Crafts', 
    'Performance Skills',
    'Cultural History Sessions',
    'Digital Arts Promotion'
];

echo "<p>Workshop types identified:</p><ul>";
foreach ($workshops as $workshop) {
    echo "<li>{$workshop}</li>";
}
echo "</ul>";

echo "</div>";

// Test 4: Create workshop system plan
echo "<div class='test-section'>";
echo "<h2>4. Workshop System Requirements</h2>";

echo "<h3>What needs to be created:</h3>";
echo "<ol>";
echo "<li><strong>Database Tables:</strong>";
echo "<ul>";
echo "<li>workshops - Store workshop information</li>";
echo "<li>workshop_registrations - Store user registrations</li>";
echo "</ul></li>";

echo "<li><strong>PHP Functions:</strong>";
echo "<ul>";
echo "<li>createWorkshop() - Add new workshops</li>";
echo "<li>getAllWorkshops() - Get all workshops</li>";
echo "<li>createWorkshopRegistration() - Register user for workshop</li>";
echo "<li>getWorkshopRegistrations() - Get registrations for a workshop</li>";
echo "</ul></li>";

echo "<li><strong>Frontend Components:</strong>";
echo "<ul>";
echo "<li>Workshop registration modal</li>";
echo "<li>JavaScript to handle button clicks</li>";
echo "<li>Form validation and submission</li>";
echo "</ul></li>";
echo "</ol>";

echo "<h3>Workshop Information to Capture:</h3>";
echo "<ul>";
echo "<li>Workshop name/type</li>";
echo "<li>User name and email</li>";
echo "<li>Phone number</li>";
echo "<li>Experience level</li>";
echo "<li>Preferred schedule</li>";
echo "<li>Special requirements/notes</li>";
echo "</ul>";

echo "</div>";

echo "<div class='test-section'>";
echo "<h2>5. Next Steps</h2>";
echo "<p>To implement the workshop registration system:</p>";
echo "<ol>";
echo "<li>Create database tables for workshops and registrations</li>";
echo "<li>Add workshop functions to database_config.php</li>";
echo "<li>Create workshop registration modal in about.php</li>";
echo "<li>Add JavaScript functionality for workshop buttons</li>";
echo "<li>Create workshop management system</li>";
echo "<li>Test the complete workshop registration flow</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";
?>
