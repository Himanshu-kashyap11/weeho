<?php
// Database Setup Script for Weeho Cultural Events Platform
require_once 'database_config.php';

echo "<h1>Weeho Database Setup</h1>";

try {
    // Initialize the database
    if (initializeDatabase()) {
        echo "<p style='color: green;'>✅ Database setup completed successfully!</p>";
        echo "<p>Tables created and sample data inserted.</p>";
        
        // Show database statistics
        $stats = getAdminStats();
        echo "<h3>Database Statistics:</h3>";
        echo "<ul>";
        echo "<li>Events: " . $stats['total_events'] . "</li>";
        echo "<li>Registrations: " . $stats['total_registrations'] . "</li>";
        echo "<li>Feedback: " . $stats['total_feedback'] . "</li>";
        echo "<li>Team Feedback: " . $stats['total_team_feedback'] . "</li>";
        echo "<li>Contact Messages: " . $stats['total_contacts'] . "</li>";
        echo "</ul>";
        
        echo "<p><strong>Your website is now ready to use!</strong></p>";
        echo "<p><a href='index.php'>Go to Website</a> | <a href='admin/'>Admin Panel</a></p>";
        
    } else {
        echo "<p style='color: red;'>❌ Database setup failed!</p>";
        echo "<p>Please check your MySQL connection and try again.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Make sure MySQL is running and the database 'weeho_db' exists.</p>";
}
?>
