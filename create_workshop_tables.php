<?php
/**
 * Create workshop database tables
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Create Workshop Tables</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} pre{background:#f5f5f5;padding:10px;border:1px solid #ddd;} .test-section{border:1px solid #ddd;padding:15px;margin:10px 0;background:#f9f9f9;}</style>";
echo "</head><body>";

echo "<h1>Create Workshop Database Tables</h1>";

require_once 'config.php';

try {
    $pdo = getDB();
    if (!$pdo) {
        throw new Exception("Database connection failed");
    }
    
    echo "<div class='test-section'>";
    echo "<h2>Creating Workshop Tables</h2>";
    
    // Create workshops table
    $workshops_sql = "
    CREATE TABLE IF NOT EXISTS workshops (
        id VARCHAR(50) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        duration VARCHAR(100),
        max_participants INT DEFAULT 0,
        frequency VARCHAR(100),
        instructor VARCHAR(255),
        status ENUM('active', 'inactive', 'full') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $stmt = $pdo->prepare($workshops_sql);
    if ($stmt->execute()) {
        echo "<p class='success'>✓ workshops table created successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to create workshops table</p>";
    }
    
    // Create workshop_registrations table
    $registrations_sql = "
    CREATE TABLE IF NOT EXISTS workshop_registrations (
        id VARCHAR(50) PRIMARY KEY,
        workshop_id VARCHAR(50),
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20),
        experience_level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
        preferred_schedule VARCHAR(255),
        special_requirements TEXT,
        status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (workshop_id) REFERENCES workshops(id) ON DELETE CASCADE
    )";
    
    $stmt = $pdo->prepare($registrations_sql);
    if ($stmt->execute()) {
        echo "<p class='success'>✓ workshop_registrations table created successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to create workshop_registrations table</p>";
    }
    
    echo "</div>";
    
    // Insert sample workshop data
    echo "<div class='test-section'>";
    echo "<h2>Inserting Sample Workshop Data</h2>";
    
    $sample_workshops = [
        [
            'id' => 'workshop_music_appreciation',
            'name' => 'Music Appreciation Classes',
            'description' => 'Discover the beauty of Indian classical music, understand ragas, talas, and learn to appreciate the nuances of vocal and instrumental performances.',
            'duration' => '1.5 Hours',
            'max_participants' => 25,
            'frequency' => 'Bi-weekly',
            'instructor' => 'Ravi Kumar'
        ],
        [
            'id' => 'workshop_folk_arts',
            'name' => 'Folk Arts & Crafts',
            'description' => 'Explore traditional folk arts, crafts, and storytelling techniques from different regions of India. Learn about cultural significance and historical context.',
            'duration' => '3 Hours',
            'max_participants' => 15,
            'frequency' => 'Weekly',
            'instructor' => 'Priya Patel'
        ],
        [
            'id' => 'workshop_performance_skills',
            'name' => 'Performance Skills',
            'description' => 'Develop stage presence, overcome performance anxiety, and learn techniques for engaging with audiences. Suitable for all types of performers.',
            'duration' => '4 Hours',
            'max_participants' => 12,
            'frequency' => 'Monthly',
            'instructor' => 'Arjun Sharma'
        ],
        [
            'id' => 'workshop_cultural_history',
            'name' => 'Cultural History Sessions',
            'description' => 'Deep dive into the history and evolution of Indian arts, understand the cultural context, and learn about legendary artists and their contributions.',
            'duration' => '2 Hours',
            'max_participants' => 30,
            'frequency' => 'Fortnightly',
            'instructor' => 'Dr. Meera Singh'
        ],
        [
            'id' => 'workshop_digital_arts',
            'name' => 'Digital Arts Promotion',
            'description' => 'Learn how to promote your art online, build your digital presence, and connect with audiences through social media and digital platforms.',
            'duration' => '2.5 Hours',
            'max_participants' => 20,
            'frequency' => 'Monthly',
            'instructor' => 'Rohit Gupta'
        ]
    ];
    
    $insert_sql = "INSERT INTO workshops (id, name, description, duration, max_participants, frequency, instructor) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insert_sql);
    
    foreach ($sample_workshops as $workshop) {
        try {
            $stmt->execute([
                $workshop['id'],
                $workshop['name'],
                $workshop['description'],
                $workshop['duration'],
                $workshop['max_participants'],
                $workshop['frequency'],
                $workshop['instructor']
            ]);
            echo "<p class='success'>✓ Added workshop: {$workshop['name']}</p>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                echo "<p class='warning'>⚠ Workshop already exists: {$workshop['name']}</p>";
            } else {
                echo "<p class='error'>✗ Error adding workshop {$workshop['name']}: " . $e->getMessage() . "</p>";
            }
        }
    }
    
    echo "</div>";
    
    // Verify tables and data
    echo "<div class='test-section'>";
    echo "<h2>Verification</h2>";
    
    // Check workshops table
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM workshops");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p class='success'>✓ Workshops table has {$count['count']} records</p>";
    
    // Show workshop data
    $stmt = $pdo->query("SELECT * FROM workshops ORDER BY name");
    $workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Workshop Data:</h3>";
    foreach ($workshops as $workshop) {
        echo "<div style='border:1px solid #ddd;padding:10px;margin:5px 0;background:#fff;'>";
        echo "<strong>{$workshop['name']}</strong><br>";
        echo "<em>{$workshop['frequency']} | {$workshop['duration']} | Max: {$workshop['max_participants']} participants</em><br>";
        echo "<small>ID: {$workshop['id']} | Instructor: {$workshop['instructor']}</small>";
        echo "</div>";
    }
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";
    echo "</div>";
}

echo "<div class='test-section'>";
echo "<h2>Next Steps</h2>";
echo "<p>Workshop tables created successfully! Now we need to:</p>";
echo "<ol>";
echo "<li>Add workshop functions to database_config.php</li>";
echo "<li>Create workshop registration modal</li>";
echo "<li>Add JavaScript functionality to workshop buttons</li>";
echo "<li>Test the complete workshop registration system</li>";
echo "</ol>";
echo "</div>";

echo "</body></html>";
?>
