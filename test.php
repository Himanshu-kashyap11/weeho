<?php
// Simple test script to check if PHP is working
echo "<h1>PHP Test</h1>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP version: " . phpversion() . "</p>";

// Test config file
if (file_exists('config.php')) {
    echo "<p>✅ config.php found</p>";
    require_once 'config.php';
    echo "<p>✅ Config loaded successfully</p>";
    echo "<p>Site name: " . SITE_NAME . "</p>";
} else {
    echo "<p>❌ config.php not found</p>";
}

// Test JSON files
$jsonFiles = ['events.json', 'registrations.json', 'feedback.json'];
foreach ($jsonFiles as $file) {
    if (file_exists($file)) {
        echo "<p>✅ $file found</p>";
    } else {
        echo "<p>❌ $file missing</p>";
    }
}

echo "<p><strong>If you see this page, PHP is working!</strong></p>";
?>
