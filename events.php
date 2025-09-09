<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Events</title>
    <link rel="stylesheet" href="main.css">
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
                <a href="events.php" class="nav-link active">Events</a>
                <a href="about.php" class="nav-link">About</a>
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
            <a href="index.php" class="sidebar-link">Home</a>
            <a href="about.php" class="sidebar-link">About</a>
            <a href="events.php" class="sidebar-link active">Events</a>
            <a href="spotlight.php" class="sidebar-link">Spotlight</a>
            <a href="teamFeedback.php" class="sidebar-link">Team Feedback</a>
            <a href="contact.php" class="sidebar-link">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Events Header -->
        <section class="events-header">
            <div class="container">
                <h1 class="events-title">Cultural Events</h1>
                <p class="events-subtitle">Discover and participate in amazing cultural events across India</p>
            </div>
        </section>

        <!-- Upcoming Events Section -->
        <section class="upcoming-events-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Upcoming Events</h2>
                    <p class="section-subtitle">Join us for these amazing cultural experiences</p>
                </div>
                
                <!-- Loading State -->
                <div id="loadingState" style="text-align: center; padding: 4rem 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⏳</div>
                    <h3>Loading Events...</h3>
                    <p>Please wait while we fetch the latest events</p>
                </div>
                
                <!-- Events Grid -->
                <div id="eventsGrid" class="events-grid" style="display: none;">
                    <!-- Events will be loaded here by JavaScript -->
                </div>
                
                <!-- No Events State -->
                <div id="noEventsState" class="no-events" style="display: none;">
                    <div class="no-events-icon">🎭</div>
                    <h3>No Events Available</h3>
                    <p>Check back soon for upcoming cultural events!</p>
                </div>
            </div>
        </section>

        <!-- Upload New Event Section -->
        <section class="upload-event-section">
    <div class="container">
        <h2 class="section-title">Upload New Event</h2>
        <div class="upload-form-container">
            <form id="uploadEventForm" class="upload-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="eventTitle">Event Title:</label>
                        <input type="text" id="eventTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Event Date:</label>
                        <input type="date" id="eventDate" name="date" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="eventPerformer">Performer:</label>
                        <input type="text" id="eventPerformer" name="performer" required>
                    </div>
                    <div class="form-group">
                        <label for="eventCity">City:</label>
                        <input type="text" id="eventCity" name="city" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="eventDescription">Description:</label>
                    <textarea id="eventDescription" name="description" rows="4" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Upload Event</button>
                    <button type="reset" class="btn btn-secondary">Clear Form</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Inline CSS -->
<style>
    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: #f4f7fb;
        margin: 0;
        padding: 20px;
    }

    .upload-event-section {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        max-width: 700px;
        width: 100%;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 6px 20px rgba(0,0,0,0.1);
    }

    .section-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 25px;
        color: #333;
    }

    .upload-form .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }

    input, textarea {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    input:focus, textarea:focus {
        border-color: #4e89ff;
        outline: none;
        box-shadow: 0 0 6px rgba(78,137,255,0.4);
    }

    textarea {
        resize: none;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 18px;
        font-size: 15px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-primary {
        background: #4e89ff;
        color: #fff;
    }

    .btn-primary:hover {
        background: #3a6fe0;
        transform: scale(1.05);
    }

    .btn-secondary {
        background: #ddd;
        color: #333;
    }

    .btn-secondary:hover {
        background: #bbb;
        transform: scale(1.05);
    }
</style>

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
                
                <!-- Event Info Display -->
                <div id="modalEventInfo" style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid var(--primary-orange);">
                    <!-- Event details will be populated here -->
                </div>
                
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
                
                <!-- Event Info Display -->
                <div id="feedbackEventInfo" style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid var(--primary-orange);">
                    <!-- Event details will be populated here -->
                </div>
                
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

    <script src="script.js"></script>
    <script src="events.js"></script>
    <script>
        // Add comprehensive CSS for professional events page
        const style = document.createElement('style');
        style.textContent = `
            /* Events Page Specific Styles */
            .events-header {
                background: linear-gradient(135deg, #ff6b35 0%, #f7931e 50%, #dc2626 100%);
                color: white;
                padding: 4rem 0;
                text-align: center;
                position: relative;
                overflow: hidden;
            }
            
            .events-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="%23fff" stop-opacity=".1"/><stop offset="100%" stop-color="%23fff" stop-opacity="0"/></radialGradient></defs><circle cx="10" cy="10" r="10" fill="url(%23a)"/><circle cx="30" cy="10" r="10" fill="url(%23a)"/><circle cx="50" cy="10" r="10" fill="url(%23a)"/><circle cx="70" cy="10" r="10" fill="url(%23a)"/><circle cx="90" cy="10" r="10" fill="url(%23a)"/></svg>') repeat;
                opacity: 0.1;
                animation: float 20s ease-in-out infinite;
            }
            
            .events-title {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                animation: slideInDown 0.8s ease-out;
            }
            
            .events-subtitle {
                font-size: 1.3rem;
                opacity: 0.9;
                max-width: 600px;
                margin: 0 auto;
                animation: slideInUp 0.8s ease-out 0.2s both;
            }
            
            /* Section Headers */
            .section-header {
                text-align: center;
                margin-bottom: 3rem;
                animation: fadeInUp 0.6s ease-out;
            }
            
            .section-title {
                font-size: 2.5rem;
                color: var(--text-dark);
                margin-bottom: 1rem;
                position: relative;
                display: inline-block;
            }
            
            .section-title::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 4px;
                background: var(--gradient-primary);
                border-radius: 2px;
            }
            
            .section-subtitle {
                font-size: 1.1rem;
                color: var(--text-light);
                max-width: 500px;
                margin: 0 auto;
            }
            
            /* Events Grid */
            .upcoming-events-section {
                padding: 5rem 0;
                background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
            }
            
            .events-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
                margin-top: 2rem;
            }
            
            .event-card {
                background: white;
                border-radius: 20px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                cursor: pointer;
            }
            
            .event-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            }
            
            .event-image-placeholder {
                height: 200px;
                background: linear-gradient(135deg, #ff6b35, #f7931e);
                position: relative;
                overflow: hidden;
            }
            
            .event-image-placeholder::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="%23fff" opacity="0.3"/><circle cx="80" cy="40" r="3" fill="%23fff" opacity="0.2"/><circle cx="40" cy="80" r="2" fill="%23fff" opacity="0.4"/></svg>') repeat;
                animation: sparkle 3s ease-in-out infinite;
            }
            
            .event-category {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: rgba(255, 255, 255, 0.9);
                color: #ff6b35;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                backdrop-filter: blur(10px);
            }
            
            .event-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .event-date {
                display: flex;
                flex-direction: column;
                align-items: center;
                background: var(--gradient-primary);
                color: white;
                padding: 1rem;
                border-radius: 12px;
                min-width: 70px;
                box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
            }
            
            .date-day {
                font-size: 1.5rem;
                font-weight: 700;
                line-height: 1;
            }
            
            .date-month {
                font-size: 0.9rem;
                opacity: 0.9;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            
            .event-location {
                color: var(--text-light);
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .event-content {
                padding: 1.5rem;
            }
            
            .event-title {
                font-size: 1.4rem;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 0.5rem;
                line-height: 1.3;
            }
            
            .event-performer {
                color: var(--primary-orange);
                font-weight: 500;
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .event-description {
                color: var(--text-light);
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }
            
            .event-actions {
                padding: 0 1.5rem 1.5rem;
                display: flex;
                gap: 1rem;
            }
            
            .event-actions .btn {
                flex: 1;
                padding: 0.8rem 1rem;
                border-radius: 10px;
                font-weight: 600;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            
            .event-actions .btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s ease;
            }
            
            .event-actions .btn:hover::before {
                left: 100%;
            }
            
            /* No Events State */
            .no-events {
                text-align: center;
                padding: 4rem 2rem;
                color: var(--text-light);
            }
            
            .no-events-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                opacity: 0.5;
            }
            
            .no-events h3 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
                color: var(--text-dark);
            }
            
            /* Upload Section */
            .upload-event-section {
                padding: 5rem 0;
                background: white;
            }
            
            .upload-form-container {
                max-width: 800px;
                margin: 0 auto;
                background: white;
                padding: 3rem;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }
            
            .form-row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            .form-group label {
                display: block;
                margin-bottom: 0.8rem;
                font-weight: 600;
                color: var(--text-dark);
                font-size: 0.95rem;
            }
            
            .form-group input,
            .form-group textarea,
            .form-control {
                width: 100%;
                padding: 1rem;
                border: 2px solid #e9ecef;
                border-radius: 12px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }
            
            .form-group input:focus,
            .form-group textarea:focus,
            .form-control:focus {
                outline: none;
                border-color: var(--primary-orange);
                background: white;
                box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
                transform: translateY(-2px);
            }
            
            .form-group textarea {
                resize: vertical;
                min-height: 120px;
            }
            
            /* Upload Form Specific Styles */
            .upload-form {
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
                padding: 2.5rem;
                border-radius: 16px;
                border: 1px solid #e9ecef;
                position: relative;
                overflow: hidden;
            }
            
            .upload-form::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: var(--gradient-primary);
            }
            
            .upload-form .form-row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
                margin-bottom: 2rem;
            }
            
            .upload-form .form-group {
                position: relative;
                margin-bottom: 2rem;
            }
            
            .upload-form .form-group label {
                display: block;
                margin-bottom: 0.8rem;
                font-weight: 600;
                color: var(--text-dark);
                font-size: 1rem;
                position: relative;
            }
            
            .upload-form .form-group label::after {
                content: '*';
                color: var(--primary-red);
                margin-left: 4px;
                font-weight: 700;
            }
            
            .upload-form input,
            .upload-form textarea {
                width: 100%;
                padding: 1.2rem 1rem;
                border: 2px solid #e9ecef;
                border-radius: 12px;
                font-size: 1rem;
                font-family: inherit;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: white;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }
            
            .upload-form input:focus,
            .upload-form textarea:focus {
                outline: none;
                border-color: var(--primary-orange);
                box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1), 0 4px 16px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }
            
            .upload-form input:valid,
            .upload-form textarea:valid {
                border-color: #10b981;
            }
            
            .upload-form textarea {
                resize: vertical;
                min-height: 140px;
                font-family: inherit;
                line-height: 1.6;
            }
            
            .upload-form input[type="date"] {
                position: relative;
                cursor: pointer;
            }
            
            .upload-form input[type="date"]::-webkit-calendar-picker-indicator {
                background: var(--gradient-primary);
                border-radius: 4px;
                cursor: pointer;
                padding: 4px;
            }
            
            /* Form Actions */
            .form-actions {
                display: flex;
                gap: 1.5rem;
                justify-content: center;
                margin-top: 2.5rem;
                padding-top: 2rem;
                border-top: 1px solid #e9ecef;
            }
            
            .form-actions .btn {
                min-width: 160px;
                padding: 1rem 2rem;
                font-size: 1.1rem;
                font-weight: 600;
                border-radius: 12px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }
            
            .form-actions .btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.6s ease;
            }
            
            .form-actions .btn:hover::before {
                left: 100%;
            }
            
            .form-actions .btn-primary {
                background: var(--gradient-primary);
                color: white;
                box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
                border: none;
            }
            
            .form-actions .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
            }
            
            .form-actions .btn-primary:active {
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            }
            
            .form-actions .btn-secondary {
                background: linear-gradient(135deg, #6c757d, #495057);
                color: white;
                box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
                border: none;
            }
            
            .form-actions .btn-secondary:hover {
                background: linear-gradient(135deg, #5a6268, #3d4043);
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(108, 117, 125, 0.4);
            }
            
            /* Upload Form Animation */
            .upload-form-container {
                animation: slideInUp 0.8s ease-out;
            }
            
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* Form Validation Styles */
            .upload-form input:invalid:not(:placeholder-shown),
            .upload-form textarea:invalid:not(:placeholder-shown) {
                border-color: var(--primary-red);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }
            
            .upload-form input:invalid:not(:placeholder-shown) + .error-message,
            .upload-form textarea:invalid:not(:placeholder-shown) + .error-message {
                display: block;
            }
            
            .error-message {
                display: none;
                color: var(--primary-red);
                font-size: 0.875rem;
                margin-top: 0.5rem;
                font-weight: 500;
            }
            
            /* Loading State */
            .upload-form .btn.loading {
                pointer-events: none;
                opacity: 0.7;
            }
            
            .upload-form .btn.loading::after {
                content: '';
                position: absolute;
                width: 16px;
                height: 16px;
                margin: auto;
                border: 2px solid transparent;
                border-top-color: currentColor;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            /* Button Styles */
            .btn {
                padding: 1rem 2rem;
                border: none;
                border-radius: 12px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                position: relative;
                overflow: hidden;
            }
            
            .btn-primary {
                background: var(--gradient-primary);
                color: white;
                box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            }
            
            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            }
            
            .btn-secondary {
                background: linear-gradient(135deg, #6c757d, #495057);
                color: white;
                box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            }
            
            .btn-secondary:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
            }
            
            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(10px);
                opacity: 0;
                transition: all 0.3s ease;
            }
            
            .modal.active {
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 1;
            }
            
            .modal.show {
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 1;
            }
            
            .modal-content {
                background: white;
                padding: 2.5rem;
                border-radius: 20px;
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
                max-width: 500px;
                width: 90%;
                max-height: 90vh;
                overflow-y: auto;
                transform: scale(0.7) translateY(50px);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .modal.active .modal-content {
                transform: scale(1) translateY(0);
            }
            
            .modal.show .modal-content {
                transform: scale(1) translateY(0);
            }
            
            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid #f0f0f0;
            }
            
            .modal-title {
                margin: 0;
                color: var(--text-dark);
                font-size: 1.6rem;
                font-weight: 600;
            }
            
            .modal-close {
                background: #f8f9fa;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: #6c757d;
                padding: 0.5rem;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: all 0.3s ease;
            }
            
            .modal-close:hover {
                background: #e9ecef;
                color: var(--primary-red);
                transform: rotate(90deg);
            }
            
            /* Notification Styles */
            .notification {
                position: fixed;
                top: 30px;
                right: 30px;
                padding: 1.2rem 1.8rem;
                border-radius: 12px;
                color: white;
                font-weight: 600;
                z-index: 10000;
                max-width: 400px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                transform: translateX(120%) scale(0.8);
                opacity: 0;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .notification.show {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
            
            .notification.success {
                background: linear-gradient(135deg, #10b981, #059669);
            }
            
            .notification.error {
                background: linear-gradient(135deg, #ef4444, #dc2626);
            }
            
            /* Animations */
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            
            @keyframes sparkle {
                0%, 100% { opacity: 0.3; }
                50% { opacity: 0.8; }
            }
            
            @keyframes slideInDown {
                from {
                    transform: translateY(-50px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideInUp {
                from {
                    transform: translateY(30px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            
            @keyframes fadeInUp {
                from {
                    transform: translateY(20px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .events-title {
                    font-size: 2.5rem;
                }
                
                .events-grid {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }
                
                .event-actions {
                    flex-direction: column;
                }
                
                .upload-form .form-row {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }
                
                .upload-form-container {
                    padding: 2rem;
                    margin: 0 1rem;
                }
                
                .upload-form {
                    padding: 2rem 1.5rem;
                }
                
                .form-actions {
                    flex-direction: column;
                    align-items: center;
                }
                
                .form-actions .btn {
                    width: 100%;
                    max-width: 280px;
                }
            }
            
            @media (max-width: 480px) {
                .events-header {
                    padding: 3rem 0;
                }
                
                .events-title {
                    font-size: 2rem;
                }
                
                .modal-content {
                    padding: 1.5rem;
                    margin: 1rem;
                }
            }
        `;
        document.head.appendChild(style);

        // Ensure modal functions are available globally
        window.openRegistrationModal = function(eventId) {
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
            
            const modal = document.getElementById('registrationModal');
            if (modal) {
                modal.classList.add('active');
                console.log('Modal should now be visible');
            } else {
                console.error('registrationModal element not found');
            }
        };

        window.openFeedbackModal = function(eventId) {
            const eventIdInput = document.getElementById('feedbackEventId');
            if (eventIdInput) {
                eventIdInput.value = eventId;
            }
            const modal = document.getElementById('feedbackModal');
            if (modal) {
                modal.classList.add('active');
            }
        };

        window.closeModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('active');
            }
        };

        // Notification system (matching index.php)
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

        // Handle registration form submission
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

        // Handle feedback form submission
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

        // Handle upload event form submission
        document.getElementById('uploadEventForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Show loading state
            submitBtn.textContent = 'Uploading...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Validate required fields
            const requiredFields = ['title', 'date', 'performer', 'city', 'description'];
            const missingFields = [];
            
            requiredFields.forEach(field => {
                if (!data[field] || data[field].trim() === '') {
                    missingFields.push(field);
                }
            });
            
            if (missingFields.length > 0) {
                showNotification(`Please fill in all required fields: ${missingFields.join(', ')}`, 'error');
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
                return;
            }
            
            try {
                // Use EventsAPI.php for creating events
                const response = await fetch('api/EventsAPI.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                console.log('Upload response status:', response.status);
                const result = await response.json();
                console.log('Upload result:', result);
                
                if (result.success) {
                    showNotification('Event uploaded successfully!', 'success');
                    this.reset();
                    // Reload events list after a short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification('Error: ' + (result.message || 'Failed to upload event'), 'error');
                }
            } catch (error) {
                console.error('Upload error:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
            }
        });
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Weeho</h4>
                    <p>Celebrating arts and culture across India through meaningful events and connections.</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo SITE_NAME . ' ' . CURRENT_YEAR; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
