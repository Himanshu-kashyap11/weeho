<?php
require_once 'config.php';

echo "<h2>Setting up Workshop Database</h2>";

try {
    // Initialize database (this will create tables if they don't exist)
    if (initializeDatabase()) {
        echo "✅ Database initialized successfully<br>";
    } else {
        echo "❌ Database initialization failed<br>";
    }
    
    // Check if workshops were created
    $workshops = getAllWorkshops();
    echo "<h3>Workshops in database:</h3>";
    
    if (count($workshops) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Max Participants</th><th>Status</th></tr>";
        foreach ($workshops as $workshop) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($workshop['id']) . "</td>";
            echo "<td>" . htmlspecialchars($workshop['name']) . "</td>";
            echo "<td>" . htmlspecialchars($workshop['max_participants']) . "</td>";
            echo "<td>" . htmlspecialchars($workshop['status']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<br>✅ " . count($workshops) . " workshops found in database<br>";
    } else {
        echo "❌ No workshops found. Let me create them manually...<br>";
        
        // Create workshops manually
        $sampleWorkshops = [
            [
                'id' => 'workshop_classical_dance',
                'name' => 'Classical Dance',
                'description' => 'Learn the fundamentals of classical Indian dance forms including Bharatanatyam, Kathak, and Odissi.',
                'max_participants' => 20,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_traditional_music',
                'name' => 'Traditional Music',
                'description' => 'Explore the rich heritage of Indian classical music with instruments like sitar, tabla, and flute.',
                'max_participants' => 15,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_music_appreciation',
                'name' => 'Music Appreciation',
                'description' => 'Develop your understanding and appreciation of various musical genres and styles.',
                'max_participants' => 25,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_folk_arts',
                'name' => 'Folk Arts & Crafts',
                'description' => 'Discover traditional folk arts, crafts, and cultural practices from different regions of India.',
                'max_participants' => 18,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_cultural_history',
                'name' => 'Cultural History',
                'description' => 'Dive deep into the rich cultural history and heritage of India through interactive sessions.',
                'max_participants' => 30,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_artisan_skills',
                'name' => 'Artisan Skills',
                'description' => 'Learn traditional artisan skills and techniques from master craftsmen.',
                'max_participants' => 12,
                'status' => 'active'
            ],
            [
                'id' => 'workshop_heritage_tours',
                'name' => 'Heritage Tours',
                'description' => 'Join guided tours to explore historical sites and cultural landmarks.',
                'max_participants' => 40,
                'status' => 'active'
            ]
        ];
        
        foreach ($sampleWorkshops as $workshop) {
            if (createWorkshop($workshop)) {
                echo "✅ Created workshop: " . $workshop['name'] . "<br>";
            } else {
                echo "❌ Failed to create workshop: " . $workshop['name'] . "<br>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>
