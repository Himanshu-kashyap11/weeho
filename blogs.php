<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Event Blogs</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <a href="index.php#mission" class="nav-link">Mission</a>
                <a href="index.php#performers" class="nav-link">Performers</a>
                <a href="events.php" class="nav-link">Events</a>
                <a href="blogs.php" class="nav-link active">Blogs</a>
                <a href="spotlight.php" class="nav-link">Spotlight</a>
                <a href="index.php#contact" class="nav-link">Contact</a>
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
            <a href="index.php#mission" class="sidebar-link">Mission</a>
            <a href="index.php#performers" class="sidebar-link">Performers</a>
            <a href="events.php" class="sidebar-link">Events</a>
            <a href="blogs.php" class="sidebar-link active">Blogs</a>
            <a href="spotlight.php" class="sidebar-link">Spotlight</a>
            <a href="index.php#contact" class="sidebar-link">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Blogs Header -->
        <section class="blogs-header">
            <div class="container">
                <h1 class="blogs-title">Event Stories</h1>
                <p class="blogs-subtitle">Read about our amazing cultural events and the talented performers who made them special</p>
            </div>
        </section>

        <!-- Blogs Grid -->
        <section class="blogs-section">
            <div class="container">
                <div class="blogs-grid">
                    <!-- Anushka's Event -->
                    <article class="blog-card">
                        <div class="blog-header">
                            <div class="blog-category">Classical Dance</div>
                            <div class="blog-date">March 15, 2024</div>
                        </div>
                        <h3 class="blog-title">Anushka's Mesmerizing Bharatanatyam Performance</h3>
                        <p class="blog-excerpt">
                            Anushka captivated the audience with her graceful Bharatanatyam performance at the Chennai Cultural Festival. 
                            Her intricate mudras and expressive storytelling brought ancient tales to life, earning a standing ovation from 
                            over 500 attendees. The performance showcased traditional compositions while incorporating contemporary themes.
                        </p>
                        <div class="blog-meta">
                            <span class="blog-author">By Weeho Team</span>
                            <span class="blog-readtime">3 min read</span>
                        </div>
                        <button class="blog-btn">Read Full Story</button>
                    </article>

                    <!-- Tanisha's Event -->
                    <article class="blog-card">
                        <div class="blog-header">
                            <div class="blog-category">Vocal Music</div>
                            <div class="blog-date">April 8, 2024</div>
                        </div>
                        <h3 class="blog-title">Tanisha's Soulful Hindustani Classical Concert</h3>
                        <p class="blog-excerpt">
                            Tanisha's powerful voice resonated through the auditorium during her Hindustani classical performance in Mumbai. 
                            Her rendition of Raag Yaman and Raag Bhairav left the audience spellbound. The evening featured both traditional 
                            compositions and her own innovative interpretations, showcasing her versatility as a vocalist.
                        </p>
                        <div class="blog-meta">
                            <span class="blog-author">By Weeho Team</span>
                            <span class="blog-readtime">4 min read</span>
                        </div>
                        <button class="blog-btn">Read Full Story</button>
                    </article>

                    <!-- Aryan's Event -->
                    <article class="blog-card">
                        <div class="blog-header">
                            <div class="blog-category">Instrumental</div>
                            <div class="blog-date">May 22, 2024</div>
                        </div>
                        <h3 class="blog-title">Aryan's Masterful Sitar Recital in Delhi</h3>
                        <p class="blog-excerpt">
                            Aryan's sitar recital at the India Habitat Centre was a journey through melodic landscapes. His technical 
                            prowess combined with emotional depth created an unforgettable evening. The performance included classical 
                            ragas and fusion pieces that bridged traditional and modern musical expressions.
                        </p>
                        <div class="blog-meta">
                            <span class="blog-author">By Weeho Team</span>
                            <span class="blog-readtime">3 min read</span>
                        </div>
                        <button class="blog-btn">Read Full Story</button>
                    </article>

                    <!-- Jaivardhan's Event -->
                    <article class="blog-card">
                        <div class="blog-header">
                            <div class="blog-category">Folk Dance</div>
                            <div class="blog-date">June 10, 2024</div>
                        </div>
                        <h3 class="blog-title">Jaivardhan's Energetic Bhangra Celebration</h3>
                        <p class="blog-excerpt">
                            Jaivardhan brought the house down with his high-energy Bhangra performance at the Punjab Cultural Festival. 
                            His infectious enthusiasm and authentic moves had the entire audience dancing along. The performance celebrated 
                            harvest traditions while showcasing the vibrant spirit of Punjabi culture.
                        </p>
                        <div class="blog-meta">
                            <span class="blog-author">By Weeho Team</span>
                            <span class="blog-readtime">2 min read</span>
                        </div>
                        <button class="blog-btn">Read Full Story</button>
                    </article>

                    <!-- Sudipta's Event -->
                    <article class="blog-card">
                        <div class="blog-header">
                            <div class="blog-category">Contemporary Art</div>
                            <div class="blog-date">July 18, 2024</div>
                        </div>
                        <h3 class="blog-title">Sudipta's Innovative Dance Theatre Performance</h3>
                        <p class="blog-excerpt">
                            Sudipta's contemporary dance theatre piece "Urban Rhythms" explored modern life through movement and storytelling. 
                            Her choreography seamlessly blended classical Indian dance with contemporary techniques, creating a powerful 
                            narrative about urban youth and cultural identity in today's world.
                        </p>
                        <div class="blog-meta">
                            <span class="blog-author">By Weeho Team</span>
                            <span class="blog-readtime">4 min read</span>
                        </div>
                        <button class="blog-btn">Read Full Story</button>
                    </article>

                    <!-- Featured Event -->
                    <article class="blog-card featured">
                        <div class="blog-header">
                            <div class="blog-category">Special Feature</div>
                            <div class="blog-date">August 5, 2024</div>
                        </div>
                        <h3 class="blog-title">Weeho's Grand Cultural Festival: A Celebration of Unity</h3>
                        <p class="blog-excerpt">
                            Our annual cultural festival brought together artists from across India for a spectacular showcase of diversity. 
                            From classical performances to folk traditions, the three-day event celebrated the rich tapestry of Indian culture. 
                            Over 2000 attendees witnessed performances by 50+ artists representing different states and art forms.
                        </p>
                        <div class="blog-meta">
                            <span class="blog-author">By Weeho Editorial Team</span>
                            <span class="blog-readtime">6 min read</span>
                        </div>
                        <button class="blog-btn">Read Full Story</button>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Weeho</h3>
                    <p>Celebrating arts and culture across India through meaningful events and connections.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php#mission">Mission</a></li>
                        <li><a href="events.php">Events</a></li>
                        <li><a href="blogs.php">Blogs</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul class="footer-links">
                        <li><?php echo CONTACT_EMAIL; ?></li>
                        <li><?php echo CONTACT_PHONE; ?></li>
                        <li><?php echo CONTACT_ADDRESS; ?></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="<?php echo TWITTER_URL; ?>" class="social-link" target="_blank">Twitter</a>
                        <a href="<?php echo LINKEDIN_URL; ?>" class="social-link" target="_blank">LinkedIn</a>
                        <a href="<?php echo GITHUB_URL; ?>" class="social-link" target="_blank">GitHub</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo SITE_NAME . ' ' . CURRENT_YEAR; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
