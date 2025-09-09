<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Spotlight</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="styles_ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php">
                <img src="logo/image.png" alt="Weeho" style="height: 40px; width: auto;">

                </a>
            </div>
            
            <div class="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="events.php" class="nav-link">Events</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="spotlight.php" class="nav-link active">Spotlight</a>
                <a href="teamFeedback.php" class="nav-link">Team Feedback</a>
                <a href="contact.php" class="nav-link">Contact</a>
            </div>
            
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Weeho</h3>
            <button class="close-btn">&times;</button>
        </div>
        <div class="sidebar-menu">
            <a href="index.php" class="sidebar-link">Home</a>
            <a href="events.php" class="sidebar-link">Events</a>
            <a href="about.php" class="sidebar-link">About</a>
            <a href="spotlight.php" class="sidebar-link active">Spotlight</a>
            <a href="teamFeedback.php" class="sidebar-link">Team Feedback</a>
            <a href="contact.php" class="sidebar-link">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Spotlight Header -->
        <section class="spotlight-header">
            <div class="container">
                <h1 class="spotlight-title">Spotlight</h1>
                <p class="spotlight-subtitle">Capturing beautiful moments from our cultural events</p>
            </div>
        </section>

        <!-- Memories Gallery -->
        <section class="memories-section">
            <div class="container">
                <h2 class="section-title">Event Memories</h2>
                <div class="memories-grid" id="memoriesGrid">
                    <?php
                    // Load memories from database
                    $memories = getAllMemories();
                    
                    // Display all memories
                    foreach ($memories as $memory) {
                        echo '<div class="memory-card" onclick="openMemoryModal(\'' . htmlspecialchars($memory['image']) . '\', \'' . htmlspecialchars($memory['caption']) . '\')">';
                        echo '<div class="memory-image">';
                        echo '<img src="' . htmlspecialchars($memory['image']) . '" alt="' . htmlspecialchars($memory['caption']) . '" loading="lazy">';
                        echo '<div class="memory-overlay">';
                        echo '<div class="memory-overlay-content">';
                        echo '<span class="overlay-icon">🔍</span>';
                        echo '<p>View Full Size</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="memory-caption">';
                        echo '<p>' . htmlspecialchars($memory['caption']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    if (empty($memories)) {
                        echo '<div class="no-memories">';
                        echo '<p>No memories available at the moment. Check back soon for beautiful moments from our events!</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Featured Performances Section -->
        <section class="featured-section">
            <div class="container">
                <h2 class="section-title">Featured Performances</h2>
                <div class="featured-grid">
                    <div class="featured-card">
                        <div class="featured-image">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop" alt="Classical Dance Performance">
                        </div>
                        <div class="featured-content">
                            <h3>Bharatanatyam Excellence</h3>
                            <p class="featured-artist">By Meera Krishnan</p>
                            <p class="featured-description">A mesmerizing performance showcasing the grace and precision of classical Bharatanatyam dance form.</p>
                            <div class="featured-stats">
                                <span class="stat-item">📅 December 2024</span>
                                <span class="stat-item">📍 Chennai</span>
                                <span class="stat-item">👥 500+ Audience</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="featured-card">
                        <div class="featured-image">
                            <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=600&h=400&fit=crop" alt="Sitar Performance">
                        </div>
                        <div class="featured-content">
                            <h3>Sitar Maestro Concert</h3>
                            <p class="featured-artist">By Pandit Ravi Shankar Jr.</p>
                            <p class="featured-description">An enchanting evening of classical Indian music featuring intricate ragas and soulful melodies.</p>
                            <div class="featured-stats">
                                <span class="stat-item">📅 November 2024</span>
                                <span class="stat-item">📍 Mumbai</span>
                                <span class="stat-item">👥 300+ Audience</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="featured-card">
                        <div class="featured-image">
                            <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&h=400&fit=crop" alt="Folk Art Workshop">
                        </div>
                        <div class="featured-content">
                            <h3>Rajasthani Folk Festival</h3>
                            <p class="featured-artist">By Kalbelia Dance Troupe</p>
                            <p class="featured-description">Vibrant folk performances celebrating the rich cultural heritage of Rajasthan.</p>
                            <div class="featured-stats">
                                <span class="stat-item">📅 October 2024</span>
                                <span class="stat-item">📍 Jaipur</span>
                                <span class="stat-item">👥 800+ Audience</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Memory Modal -->
    <div class="modal" id="memoryModal">
        <div class="modal-content memory-modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="closeMemoryModal()">&times;</button>
            </div>
            <div class="modal-body memory-modal-body">
                <img id="modalMemoryImage" src="" alt="">
                <p id="modalMemoryCaption"></p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="ui-helpers.js"></script>
    <script>
        // Memory modal functions
        function openMemoryModal(imageUrl, caption) {
            document.getElementById('modalMemoryImage').src = imageUrl;
            document.getElementById('modalMemoryCaption').textContent = caption;
            document.getElementById('memoryModal').style.display = 'flex';
        }

        function closeMemoryModal() {
            document.getElementById('memoryModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('memoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMemoryModal();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMemoryModal();
            }
        });

        // Add hover effects and animations
        document.addEventListener('DOMContentLoaded', function() {
            const memoryCards = document.querySelectorAll('.memory-card');
            
            memoryCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
