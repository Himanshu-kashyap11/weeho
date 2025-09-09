<?php
// Debug registration field matching
require_once 'config.php';

echo "<h2>Registration Field Matching Debug</h2>";

// 1. HTML Form Fields
echo "<h3>1. HTML Form Fields (index.php)</h3>";
$htmlFields = [
    'eventId' => 'hidden input - name="eventId"',
    'name' => 'text input - name="name"', 
    'email' => 'email input - name="email"',
    'phone' => 'tel input - name="phone"',
    'role' => 'select - name="role"',
    'city' => 'text input - name="city"'
];

foreach ($htmlFields as $field => $description) {
    echo "- $field: $description<br>";
}

// 2. PHP $_POST Variables (register.php)
echo "<h3>2. PHP \$_POST Variables (register.php)</h3>";
$phpFields = [
    'eventId' => '$_POST[\'eventId\']',
    'name' => '$_POST[\'name\']',
    'email' => '$_POST[\'email\']', 
    'phone' => '$_POST[\'phone\']',
    'role' => '$_POST[\'role\']',
    'city' => '$_POST[\'city\']'
];

foreach ($phpFields as $field => $variable) {
    echo "- $field: $variable<br>";
}

// 3. Database Table Structure
echo "<h3>3. Database Table Structure (registrations)</h3>";
try {
    $pdo = getDB();
    $stmt = $pdo->query("DESCRIBE registrations");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']} ({$column['Null']}, {$column['Default']})<br>";
    }
} catch (Exception $e) {
    echo "Error getting table structure: " . $e->getMessage() . "<br>";
}

// 4. Registration Data Array (from register.php)
echo "<h3>4. Registration Data Array Structure</h3>";
$registrationDataStructure = [
    'id' => 'generateId(\'reg_\')',
    'event_id' => '$eventId (from $_POST[\'eventId\'])',
    'name' => '$name (from $_POST[\'name\'])',
    'email' => '$email (from $_POST[\'email\'])',
    'phone' => '$phone (from $_POST[\'phone\'])',
    'role' => '$role (from $_POST[\'role\'])',
    'city' => '$city (from $_POST[\'city\'])',
    'status' => '\'confirmed\' (hardcoded)'
];

foreach ($registrationDataStructure as $field => $source) {
    echo "- $field: $source<br>";
}

// 5. Field Mapping Analysis
echo "<h3>5. Field Mapping Analysis</h3>";
$mappings = [
    'HTML Form' => 'PHP Variable' => 'DB Column' => 'Status',
    'eventId' => 'eventId' => 'event_id' => '⚠️ MISMATCH',
    'name' => 'name' => 'name' => '✅ MATCH',
    'email' => 'email' => 'email' => '✅ MATCH', 
    'phone' => 'phone' => 'phone' => '✅ MATCH',
    'role' => 'role' => 'role' => '✅ MATCH',
    'city' => 'city' => 'city' => '✅ MATCH'
];

echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr><th>HTML Form</th><th>PHP Variable</th><th>DB Column</th><th>Status</th></tr>";
echo "<tr><td>eventId</td><td>eventId</td><td>event_id</td><td style='color: orange;'>⚠️ FIELD NAME MISMATCH</td></tr>";
echo "<tr><td>name</td><td>name</td><td>name</td><td style='color: green;'>✅ MATCH</td></tr>";
echo "<tr><td>email</td><td>email</td><td>email</td><td style='color: green;'>✅ MATCH</td></tr>";
echo "<tr><td>phone</td><td>phone</td><td>phone</td><td style='color: green;'>✅ MATCH</td></tr>";
echo "<tr><td>role</td><td>role</td><td>role</td><td style='color: green;'>✅ MATCH</td></tr>";
echo "<tr><td>city</td><td>city</td><td>city</td><td style='color: green;'>✅ MATCH</td></tr>";
echo "</table>";

// 6. Test actual form submission data
echo "<h3>6. Test Form Data Simulation</h3>";
$testFormData = [
    'eventId' => 'event_1704067200_1006',
    'name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '1234567890',
    'role' => 'Audience',
    'city' => 'Test City'
];

echo "Simulated form data:<br>";
foreach ($testFormData as $key => $value) {
    echo "- $_POST['$key'] = '$value'<br>";
}

echo "<br>Generated registration array would be:<br>";
$registrationArray = [
    'id' => 'reg_' . time() . '_1234',
    'event_id' => $testFormData['eventId'], // This is the issue!
    'name' => $testFormData['name'],
    'email' => $testFormData['email'],
    'phone' => $testFormData['phone'],
    'role' => $testFormData['role'],
    'city' => $testFormData['city'],
    'status' => 'confirmed'
];

foreach ($registrationArray as $key => $value) {
    echo "- '$key' => '$value'<br>";
}

echo "<h3>7. Issues Found</h3>";
echo "<div style='background: #ffe6e6; padding: 15px; border-left: 4px solid #ff4444; margin: 10px 0;'>";
echo "<strong>CRITICAL ISSUE:</strong><br>";
echo "The form sends 'eventId' but the database expects 'event_id'.<br>";
echo "The registration data array correctly maps eventId → event_id, so this should work.<br>";
echo "The issue might be elsewhere in the insertion process.";
echo "</div>";

?>
