<?php
// Test Database Connection and Functions
require_once 'config.php';

echo "<h2>🔧 Database Connection Test</h2>";

// Test 1: Database Connection
try {
    $db = getDB();
    if ($db) {
        echo "✅ Database connection: SUCCESS<br>";
    } else {
        echo "❌ Database connection: FAILED<br>";
        exit;
    }
} catch (Exception $e) {
    echo "❌ Database connection error: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Check if tables exist
echo "<h3>📋 Table Structure Check</h3>";
$tables = ['events', 'registrations', 'feedback', 'team_feedback', 'memories', 'contacts', 'admin_users'];
foreach ($tables as $table) {
    try {
        $result = fetchOne("SHOW TABLES LIKE '$table'");
        if ($result) {
            echo "✅ Table '$table': EXISTS<br>";
        } else {
            echo "❌ Table '$table': MISSING<br>";
        }
    } catch (Exception $e) {
        echo "❌ Table '$table': ERROR - " . $e->getMessage() . "<br>";
    }
}

// Test 3: Test database functions
echo "<h3>🧪 Function Tests</h3>";

// Test getAllEvents
try {
    $events = getAllEvents();
    echo "✅ getAllEvents(): " . count($events) . " events found<br>";
} catch (Exception $e) {
    echo "❌ getAllEvents(): ERROR - " . $e->getMessage() . "<br>";
}

// Test getAllTeamFeedback
try {
    $feedback = getAllTeamFeedback();
    echo "✅ getAllTeamFeedback(): " . count($feedback) . " feedback entries found<br>";
} catch (Exception $e) {
    echo "❌ getAllTeamFeedback(): ERROR - " . $e->getMessage() . "<br>";
}

// Test getAllMemories
try {
    $memories = getAllMemories();
    echo "✅ getAllMemories(): " . count($memories) . " memories found<br>";
} catch (Exception $e) {
    echo "❌ getAllMemories(): ERROR - " . $e->getMessage() . "<br>";
}

// Test 4: Test form submission functions
echo "<h3>📝 Form Submission Test</h3>";

// Test createTeamFeedback
try {
    $testFeedback = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'rating' => 5,
        'message' => 'This is a test feedback message',
        'status' => 'active'
    ];
    
    $result = createTeamFeedback($testFeedback);
    if ($result) {
        echo "✅ createTeamFeedback(): SUCCESS<br>";
    } else {
        echo "❌ createTeamFeedback(): FAILED<br>";
    }
} catch (Exception $e) {
    echo "❌ createTeamFeedback(): ERROR - " . $e->getMessage() . "<br>";
}

echo "<h3>🎯 Next Steps</h3>";
echo "If you see any ❌ errors above:<br>";
echo "1. Run setup_database.php to create missing tables<br>";
echo "2. Check XAMPP MySQL service is running<br>";
echo "3. Verify database 'weeho_db' exists in phpMyAdmin<br>";
echo "<br><a href='setup_database.php'>🚀 Run Database Setup</a>";
echo "<br><a href='index.php'>🏠 Go to Homepage</a>";
echo "<br><a href='teamFeedback.php'>💬 Test Team Feedback</a>";
?>
