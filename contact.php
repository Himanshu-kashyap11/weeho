<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Contact Us</title>
    <link rel="stylesheet" href="styles_new.css">
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
                <a href="about.php" class="nav-link">About</a>
                <a href="events.php" class="nav-link">Events</a>
                <a href="spotlight.php" class="nav-link">Spotlight</a>
                <a href="teamFeedback.php" class="nav-link">Team Feedback</a>
                <a href="contact.php" class="nav-link active">Contact</a>
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
            <a href="about.php" class="sidebar-link">About</a>
            <a href="events.php" class="sidebar-link">Events</a>
            <a href="spotlight.php" class="sidebar-link">Spotlight</a>
            <a href="teamFeedback.php" class="sidebar-link">Team Feedback</a>
            <a href="contact.php" class="sidebar-link active">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Contact Header -->
        <section class="contact-header">
            <div class="container">
                <h1 class="contact-title">Get In Touch</h1>
                <p class="contact-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>
        </section>

      

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2>Send Us a Message</h2>
                    <form class="contact-form" id="contactForm">
                        <div class="form-group">
                            <label for="contactName">Name *</label>
                            <input type="text" id="contactName" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contactEmail">Email *</label>
                            <input type="email" id="contactEmail" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contactMessage">Message *</label>
                            <textarea id="contactMessage" name="message" rows="6" required placeholder="Tell us about your inquiry, event ideas, or how we can help you..."></textarea>
                        </div>
                        
                        <button type="submit" class="contact-btn">Send Message</button>
                    </form>
                    
                    <!-- Message Display -->
                    <div id="messageDisplay" class="message-display" style="display: none;">
                        <div id="messageContent"></div>
                    </div>
                </div>

                <!-- Contact Info & Map -->
                <div class="contact-info-container">
                    <div class="contact-info">
                        <h3>Contact Information</h3>
                        <div class="info-item">
                            <div class="info-icon">📧</div>
                            <div class="info-content">
                                <h4>Email</h4>
                                <p><?php echo CONTACT_EMAIL; ?></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">📞</div>
                            <div class="info-content">
                                <h4>Phone</h4>
                                <p><?php echo CONTACT_PHONE; ?></p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">📍</div>
                            <div class="info-content">
                                <h4>Address</h4>
                                <p><?php echo CONTACT_ADDRESS; ?></p>
                            </div>
                        </div>
                        
                        <div class="social-contact">
                            <h4>Follow Us</h4>
                            <div class="social-links">
                                <a href="<?php echo TWITTER_URL; ?>" class="social-link" target="_blank">
                                    <span class="social-icon">🐦</span> Twitter
                                </a>
                                <a href="<?php echo LINKEDIN_URL; ?>" class="social-link" target="_blank">
                                    <span class="social-icon">💼</span> LinkedIn
                                </a>
                                <a href="<?php echo GITHUB_URL; ?>" class="social-link" target="_blank">
                                    <span class="social-icon">💻</span> GitHub
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Map Placeholder -->
                    <div class="map-container ">
                        <div class="map-placeholder">
                            <div class="map-icon">🗺️</div>
                            <h4>Find Us</h4>
                            <p>Interactive map coming soon</p>
                            <div class="map-details">
                                <p><strong>Cultural Arts District</strong></p>
                                <p>Mumbai, Maharashtra</p>
                                <p>India</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <h4>How can I join as a performer?</h4>
                    <p>Send us your portfolio and performance videos through our contact form. We review all applications and get back to talented artists.</p>
                </div>
                <div class="faq-item">
                    <h4>Do you organize private events?</h4>
                    <p>Yes! We can arrange cultural performances for private events, corporate functions, and special occasions. Contact us for details.</p>
                </div>
                <div class="faq-item">
                    <h4>Are workshops really free?</h4>
                    <p>Absolutely! All our workshops and cultural programs are completely free. We believe in making arts accessible to everyone.</p>
                </div>
                <div class="faq-item">
                    <h4>How can I stay updated on events?</h4>
                    <p>Follow us on social media or check our events page regularly. You can also subscribe to our newsletter for updates.</p>
                </div>
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="contact.php">Contact</a></li>
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
<script>
    // Handle form submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('contact_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Message sent successfully!', 'success');
                this.reset();
            } else {
                showNotification(data.message || 'Error sending message', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error sending message', 'error');
        });

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    });
</script>
</body>
</html>
