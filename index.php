<?php require_once 'config.php'; ?>
<?php echo json_encode(['status' => 'ok']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo SITE_TAGLINE; ?></title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="styles_ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <?php 
    $statusMessage = getStatusMessage();
    if ($statusMessage): ?>
    <div class="status-message <?php echo $statusMessage['class']; ?>" id="statusMessage">
        <?php echo $statusMessage['message']; ?>
        <button class="close-status" onclick="closeStatusMessage()">&times;</button>
    </div>
    <?php endif; ?>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php">
                    <img src="logo/image.png" alt="Weeho" style="height: 40px; width: auto;">
                </a>
            </div>
            
            <div class="nav-menu">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="events.php" class="nav-link">Events</a>
                <a href="spotlight.php" class="nav-link">Spotlight</a>
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
            <a href="index.php" class="sidebar-link active">Home</a>
            <a href="about.php" class="sidebar-link">About</a>
            <a href="events.php" class="sidebar-link">Events</a>
            <a href="spotlight.php" class="sidebar-link">Spotlight</a>
            <a href="teamFeedback.php" class="sidebar-link">Team Feedback</a>
            <a href="contact.php" class="sidebar-link">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Welcome to Weeho</h1>
                    <p><?php echo SITE_TAGLINE; ?> - Connecting communities through vibrant cultural experiences and meaningful artistic expressions.</p>
                    <div class="hero-actions">
                        <a href="events.php" class="btn btn-primary">Explore Events</a>
                        <a href="about.php" class="btn btn-secondary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <!-- India Map Background with Event Markers -->
            <div class="india-map">
                <div class="map-marker" style="top: 30%; left: 25%;" data-city="Mumbai">
                    <div class="marker-pulse"></div>
                    <div class="marker-dot"></div>
                </div>
                <div class="map-marker" style="top: 20%; left: 70%;" data-city="Delhi">
                    <div class="marker-pulse"></div>
                    <div class="marker-dot"></div>
                </div>
                <div class="map-marker" style="top: 45%; left: 75%;" data-city="Kolkata">
                    <div class="marker-pulse"></div>
                    <div class="marker-dot"></div>
                </div>
                <div class="map-marker" style="top: 60%; left: 70%;" data-city="Chennai">
                    <div class="marker-pulse"></div>
                    <div class="marker-dot"></div>
                </div>
                <div class="map-marker" style="top: 50%; left: 20%;" data-city="Pune">
                    <div class="marker-pulse"></div>
                    <div class="marker-dot"></div>
                </div>
            </div>
        </section>

        <!-- Upcoming Events Section -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Upcoming Events</h2>
                    <p class="section-subtitle">Discover amazing cultural events happening across India</p>
                </div>
                <div class="events-grid" id="eventsGrid">
                    <div class="loading">
                        <div class="spinner"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">What People Say</h2>
                    <p class="section-subtitle">Hear from our community of artists and culture enthusiasts</p>
                </div>
                <div class="testimonials-slider">
                    <div class="testimonial">
                        <p class="testimonial-text">"Weeho has transformed how I connect with Indian culture. The events are authentic and beautifully organized."</p>
                        <div class="testimonial-author">Priya Sharma</div>
                        <div class="testimonial-role">Classical Dancer</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Registration Modal -->
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Register for Event</h3>
                <button class="modal-close" onclick="closeModal('registrationModal')">&times;</button>
            </div>
            <form id="registrationForm">
                <input type="hidden" id="regEventId" name="eventId">
                
                <div class="form-group">
                    <label for="regName">Full Name *</label>
                    <input type="text" id="regName" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="regEmail">Email Address *</label>
                    <input type="email" id="regEmail" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="regPhone">Phone Number *</label>
                    <input type="tel" id="regPhone" name="phone" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="regRole">Role *</label>
                    <select id="regRole" name="role" class="form-control" required>
                        <option value="">Select your role</option>
                        <option value="Performer">Performer</option>
                        <option value="Audience">Audience</option>
                        <option value="Organizer">Organizer</option>
                        <option value="Student">Student</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="regCity">City *</label>
                    <input type="text" id="regCity" name="city" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Register Now</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('registrationModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Share Your Feedback</h3>
                <button class="modal-close" onclick="closeModal('feedbackModal')">&times;</button>
            </div>
            <form id="feedbackForm">
                <input type="hidden" id="feedbackEventId" name="eventId">
                
                <div class="form-group">
                    <label for="feedbackName">Your Name *</label>
                    <input type="text" id="feedbackName" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="feedbackRating">Rating *</label>
                    <select id="feedbackRating" name="rating" class="form-control" required>
                        <option value="">Rate this event</option>
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                        <option value="4">⭐⭐⭐⭐ Very Good</option>
                        <option value="3">⭐⭐⭐ Good</option>
                        <option value="2">⭐⭐ Fair</option>
                        <option value="1">⭐ Poor</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="feedbackMessage">Your Feedback *</label>
                    <textarea id="feedbackMessage" name="feedback" class="form-control" rows="4" required placeholder="Share your experience with this event..."></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('feedbackModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Weeho</h4>
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
                        <a href="<?php echo INSTAGRAM_URL; ?>" class="social-link" target="_blank">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo SITE_NAME . ' ' . CURRENT_YEAR; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Global variables
        let events = [];

        // DOM Content Loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadEvents();
            initializeNavigation();
        });

        // Load events from database via API
        async function loadEvents() {
            try {
                const response = await fetch('api/EventsAPI.php');
                const result = await response.json();
                
                if (result.success && result.data) {
                    events = result.data;
                    displayEvents(events);
                } else {
                    // Fallback to JSON file if API fails
                    try {
                        const jsonResponse = await fetch('events.json');
                        events = await jsonResponse.json();
                        displayEvents(events);
                    } catch (jsonError) {
                        console.error('Error loading events from both API and JSON:', error, jsonError);
                        document.getElementById('eventsGrid').innerHTML = `
                            <div class="text-center">
                                <p>Unable to load events. Please try again later.</p>
                            </div>
                        `;
                    }
                }
            } catch (error) {
                console.error('Error loading events:', error);
                // Fallback to JSON file
                try {
                    const jsonResponse = await fetch('events.json');
                    events = await jsonResponse.json();
                    displayEvents(events);
                } catch (jsonError) {
                    console.error('Error loading events from both API and JSON:', error, jsonError);
                    document.getElementById('eventsGrid').innerHTML = `
                        <div class="text-center">
                            <p>Unable to load events. Please try again later.</p>
                        </div>
                    `;
                }
            }
        }

        // Display events in grid
        function displayEvents(eventsData) {
            const grid = document.getElementById('eventsGrid');
            
            if (!eventsData || eventsData.length === 0) {
                grid.innerHTML = `
                    <div class="text-center">
                        <p>No events available at the moment.</p>
                    </div>
                `;
                return;
            }

            grid.innerHTML = eventsData.map(event => `
                <div class="event-card fade-in">
                    <div class="event-header">
                        <h3 class="event-title">${event.title}</h3>
                        <div class="event-meta">
                            <span>📅 ${event.date}</span>
                            <span>🎭 ${event.performer}</span>
                            <span>📍 ${event.city}</span>
                        </div>
                    </div>
                    <div class="event-description">
                        ${event.description}
                    </div>
                    <div class="event-actions">
                        <button class="btn btn-primary btn-sm" onclick="openRegistrationModal('${event.id}')">
                            Register
                        </button>
                        <button class="btn btn-secondary btn-sm" onclick="openFeedbackModal('${event.id}')">
                            Feedback
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Modal functions
        function openRegistrationModal(eventId) {
            console.log('Opening registration modal for event:', eventId);
            
            if (!eventId) {
                console.error('No eventId provided to openRegistrationModal');
                showNotification('Error: No event selected', 'error');
                return;
            }
            
            const eventIdInput = document.getElementById('regEventId');
            if (!eventIdInput) {
                console.error('regEventId input field not found');
                showNotification('Error: Form not properly initialized', 'error');
                return;
            }
            
            eventIdInput.value = eventId;
            console.log('Set eventId in form:', eventIdInput.value);
            
            document.getElementById('registrationModal').classList.add('active');
        }

        function openFeedbackModal(eventId) {
            document.getElementById('feedbackEventId').value = eventId;
            document.getElementById('feedbackModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Form submissions
        document.getElementById('registrationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Debug: Log form data
            console.log('Form submission data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            // Validate eventId is present
            const eventId = formData.get('eventId');
            if (!eventId) {
                console.error('No eventId in form data');
                showNotification('Error: No event selected', 'error');
                return;
            }
            
            try {
                const response = await fetch('register.php', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Response data:', result);
                
                if (result.success) {
                    showNotification('Registration successful!', 'success');
                    closeModal('registrationModal');
                    this.reset();
                } else {
                    showNotification(result.message || 'Registration failed', 'error');
                }
            } catch (error) {
                console.error('Registration submission error:', error);
                showNotification('Error submitting registration', 'error');
            }
        });

        document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('feedback.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification('Feedback submitted successfully!', 'success');
                    closeModal('feedbackModal');
                    this.reset();
                } else {
                    showNotification(result.message || 'Feedback submission failed', 'error');
                }
            } catch (error) {
                showNotification('Error submitting feedback', 'error');
            }
        });

        // Navigation
        function initializeNavigation() {
            const hamburger = document.querySelector('.hamburger');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');
            const closeBtn = document.querySelector('.close-btn');

            hamburger.addEventListener('click', () => {
                sidebar.classList.add('active');
                overlay.classList.add('active');
            });

            closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // Notification system
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

        // Close modals on outside click
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('active');
            }
        });
    </script>
    <script src="ui-helperss.js"></script>
</body>
</html>
