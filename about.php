<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - About Us</title>
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
                <a href="about.php" class="nav-link active">About</a>
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
            <a href="events.php" class="sidebar-link">Events</a>
            <a href="about.php" class="sidebar-link active">About</a>
            <a href="spotlight.php" class="sidebar-link">Spotlight</a>
            <a href="teamFeedback.php" class="sidebar-link">Team Feedback</a>
            <a href="contact.php" class="sidebar-link">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- About Header -->
        <section class="about-header">
            <div class="container">
                <h1 class="about-title">About Weeho</h1>
                <p class="about-subtitle">Celebrating Indian culture through art, music, and community</p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <div class="container">
                <div class="mission-content">
                    <div class="mission-text">
                        <h2>Our Mission</h2>
                        <p>Weeho is dedicated to preserving and promoting the rich cultural heritage of India through various artistic expressions. We believe in bringing communities together to celebrate the diversity and beauty of Indian traditions.</p>
                        <p>Our platform serves as a bridge connecting artists, performers, and cultural enthusiasts across the nation, fostering creativity and cultural exchange.</p>
                    </div>
                    <div class="mission-image">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=400&fit=crop" alt="Cultural Performance">
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision Section -->
        <section class="vision-section">
            <div class="container">
                <div class="vision-content">
                    <div class="vision-image">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=500&h=400&fit=crop" alt="Traditional Music">
                    </div>
                    <div class="vision-text">
                        <h2>Our Vision</h2>
                        <p>To create a vibrant ecosystem where Indian cultural arts thrive and reach new generations. We envision a future where traditional and contemporary forms of expression coexist and inspire each other.</p>
                        <p>Through our events and workshops, we aim to make cultural arts accessible to everyone, regardless of their background or experience level.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="values-section">
            <div class="container">
                <h2 class="section-title">Our Values</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">🎭</div>
                        <h3>Cultural Preservation</h3>
                        <p>Safeguarding traditional art forms for future generations</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">🤝</div>
                        <h3>Community Building</h3>
                        <p>Bringing people together through shared cultural experiences</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">🌟</div>
                        <h3>Innovation</h3>
                        <p>Blending tradition with modern approaches to art and expression</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">🎨</div>
                        <h3>Creativity</h3>
                        <p>Encouraging artistic expression and creative exploration</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <div class="container">
                <h2 class="section-title">Meet Our Team</h2>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face" alt="Team Member">
                        </div>
                        <h3>Arjun Sharma</h3>
                        <p class="member-role">Founder & Cultural Director</p>
                        <p class="member-bio">Classical dancer and cultural enthusiast with 15+ years of experience</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=300&fit=crop&crop=face" alt="Team Member">
                        </div>
                        <h3>Priya Patel</h3>
                        <p class="member-role">Event Coordinator</p>
                        <p class="member-bio">Expert in organizing cultural events and community outreach programs</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face" alt="Team Member">
                        </div>
                        <h3>Ravi Kumar</h3>
                        <p class="member-role">Music Director</p>
                        <p class="member-bio">Traditional musician specializing in Indian classical and folk music</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Workshops Section -->
        <section class="workshops-section">
            <div class="container">
                <h2 class="section-title">Our Workshops</h2>
                <div class="workshops-grid">

                    <!-- Music Appreciation Workshop -->
                    <div class="workshop-card">
                        <div class="workshop-header">
                            <div class="workshop-icon">
                                <div class="icon-bg">🎼</div>
                            </div>
                            <h3>Music Appreciation</h3>
                        </div>
                        <div class="workshop-content">
                            <p>Discover the beauty of Indian classical music, understand ragas, talas, and learn to appreciate performances.</p>
                            <div class="workshop-features">
                                <span class="feature-tag">Theory & Practice</span>
                                <span class="feature-tag">Cultural Context</span>
                        </div>
                    </div>
                        <div class="workshop-details">
                            <span class="detail-item">📅 Bi-weekly</span>
                            <span class="detail-item">⏱️ 1.5 Hours</span>
                            <span class="detail-item">👥 Max 25 Participants</span>
                        </div>
                        <button class="workshop-btn" onclick="openWorkshopModal('workshop_music_appreciation')">Join Workshop</button>
                    </div>

                    <!-- Folk Arts & Crafts Workshop -->
                    <div class="workshop-card">
                        <div class="workshop-header">
                        <div class="workshop-icon">
                            <div class="icon-bg">🎨</div>
                        </div>
                        <h3>Folk Arts & Crafts</h3>
                        </div>
                        <div class="workshop-content">
                            <p>Explore traditional folk arts, crafts, and storytelling techniques from different regions of India.</p>
                            <div class="workshop-features">
                                <span class="feature-tag">Hands-on Learning</span>
                                <span class="feature-tag">Cultural Heritage</span>
                            </div>
                        </div>
                        <div class="workshop-details">
                            <span class="detail-item">📅 Weekly</span>
                            <span class="detail-item">⏱️ 3 Hours</span>
                            <span class="detail-item">👥 Max 15 Participants</span>
                        </div>
                        <button class="workshop-btn" onclick="openWorkshopModal('workshop_folk_arts')">Join Workshop</button>
                    </div>

                    <!-- Performance Skills Workshop -->
                    <div class="workshop-card">
                        <div class="workshop-header">
                        <div class="workshop-icon">
                            <div class="icon-bg">🎭</div>
                        </div>
                        <h3>Performance Skills</h3>
                        </div>
                        <div class="workshop-content">
                            <p>Develop stage presence, overcome performance anxiety, and learn techniques for engaging with audiences.</p>
                            <div class="workshop-features">
                                <span class="feature-tag">Stage Confidence</span>
                                <span class="feature-tag">All Levels</span>
                            </div>
                        </div>
                        <div class="workshop-details">
                            <span class="detail-item">📅 Monthly</span>
                            <span class="detail-item">⏱️ 4 Hours</span>
                            <span class="detail-item">👥 Max 12 Participants</span>
                        </div>
                        <button class="workshop-btn" onclick="openWorkshopModal('workshop_performance_skills')">Join Workshop</button>
                    </div>

                    <!-- Cultural History Workshop -->
                    <div class="workshop-card">
                        <div class="workshop-header">
                        <div class="workshop-icon">
                            <div class="icon-bg">📚</div>
                        </div>
                            <h3>Cultural History</h3>
                        </div>
                        <div class="workshop-content">
                            <p>Deep dive into the history and evolution of Indian arts, understand cultural context and legendary artists.</p>
                            <div class="workshop-features">
                                <span class="feature-tag">Educational</span>
                                <span class="feature-tag">Interactive</span>
                            </div>
                        </div>
                        <div class="workshop-details">
                            <span class="detail-item">📅 Fortnightly</span>
                            <span class="detail-item">⏱️ 2 Hours</span>
                            <span class="detail-item">👥 Max 30 Participants</span>
                        </div>
                        <button class="workshop-btn" onclick="openWorkshopModal('workshop_cultural_history')">Join Workshop</button>
                    </div>

                    <!-- Digital Arts Promotion Workshop -->
                    <div class="workshop-card">
                        <div class="workshop-header">
                        <div class="workshop-icon">
                            <div class="icon-bg">🌐</div>
                        </div>
                        <h3>Digital Arts Promotion</h3>
                        </div>
                        <div class="workshop-content">
                            <p>Learn how to promote your art online, build your digital presence, and connect with audiences through social media.</p>
                            <div class="workshop-features">
                                <span class="feature-tag">Modern Approach</span>
                                <span class="feature-tag">Social Media</span>
                            </div>
                        </div>
                        <div class="workshop-details">
                            <span class="detail-item">📅 Monthly</span>
                            <span class="detail-item">⏱️ 2.5 Hours</span>
                            <span class="detail-item">👥 Max 20 Participants</span>
                        </div>
                        <button class="workshop-btn" onclick="openWorkshopModal('workshop_digital_arts')">Join Workshop</button>
                    </div>
                </div>

                <!-- Programs CTA -->
                <div class="programs-cta">
                    <h3>Ready to Start Your Cultural Journey?</h3>
                    <p>All our workshops are completely free and open to everyone. Join our community and discover the joy of Indian arts and culture.</p>
                    <div class="cta-buttons">
                        <a href="index.php#contact" class="cta-primary">Register Now</a>
                        <a href="events.php" class="cta-secondary">View Upcoming Events</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">👥</div>
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Community Members</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">🎭</div>
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Talented Artists</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">🎪</div>
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Events Organized</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">🏆</div>
                        <div class="stat-number">25+</div>
                        <div class="stat-label">Awards Won</div>
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
                        <li><a href="spotlight.php">Spotlight</a></li>
                        <li><a href="teamFeedback.php">Team Feedback</a></li>
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

    <!-- Workshop Registration Modal -->
    <div id="workshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Workshop Registration</h2>
                <button class="modal-close" onclick="closeWorkshopModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="workshopAlert"></div>
                <form id="workshopForm">
                    <input type="hidden" id="workshopId" name="workshop_id">
                    
                    <div class="form-group">
                        <label for="workshopName">Workshop:</label>
                        <input type="text" id="workshopName" readonly>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="participantName">Your Name *</label>
                            <input type="text" id="participantName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="participantEmail">Email Address *</label>
                            <input type="email" id="participantEmail" name="email" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="participantPhone">Phone Number</label>
                            <input type="tel" id="participantPhone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="experienceLevel">Experience Level</label>
                            <select id="experienceLevel" name="experience_level">
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="preferredSchedule">Preferred Schedule/Time</label>
                        <input type="text" id="preferredSchedule" name="preferred_schedule" placeholder="e.g., Weekends, Evenings, etc.">
                    </div>
                    
                    <div class="form-group">
                        <label for="specialRequirements">Special Requirements or Notes</label>
                        <textarea id="specialRequirements" name="special_requirements" rows="3" placeholder="Any special requirements, accessibility needs, or questions..."></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Register for Workshop</button>
                        <button type="button" class="btn btn-secondary" onclick="closeWorkshopModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    /* Workshop Modal Styles - Using existing modal system */
    #workshopModal {
        /* Inherits from main.css .modal styles */
        z-index: 2001 !important; /* Higher than main modal z-index */
    }
    
    #workshopModal.active {
        /* Inherits from main.css .modal.active styles */
    }
    
    #workshopModal .modal-content {
        background-color: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 12px !important;
        width: 90% !important;
        max-width: 600px !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
    }
    
    /* Custom styling for workshop modal header */
    #workshopModal .modal-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
        color: white !important;
        border-radius: 12px 12px 0 0 !important;
        border-bottom: none !important;
    }
    
    #workshopModal .modal-title {
        color: white !important;
    }
    
    #workshopModal .modal-close {
        color: rgba(255,255,255,0.8) !important;
        background: none !important;
        border: none !important;
    }
    
    #workshopModal .modal-close:hover {
        color: white !important;
        background: rgba(255,255,255,0.1) !important;
        transform: rotate(90deg) !important;
    }
    
    #workshopModal .modal-body {
        padding: 30px !important;
        background: #f8f9fa !important;
    }
    
    #workshopModal .form-row {
        display: flex !important;
        gap: 20px !important;
        margin-bottom: 20px !important;
    }
    
    #workshopModal .form-group {
        margin-bottom: 20px !important;
        flex: 1 !important;
    }
    
    #workshopModal .form-group label {
        display: block !important;
        margin-bottom: 8px !important;
        font-weight: 600 !important;
        color: #374151 !important;
        font-size: 14px !important;
    }
    
    #workshopModal .form-group input,
    #workshopModal .form-group select,
    #workshopModal .form-group textarea {
        width: 100% !important;
        padding: 12px 16px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        box-sizing: border-box !important;
        background: white !important;
        transition: all 0.3s ease !important;
        user-select: text !important;
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        pointer-events: auto !important;
        cursor: text !important;
    }
    
    #workshopModal .form-group input:focus,
    #workshopModal .form-group select:focus,
    #workshopModal .form-group textarea:focus {
        border-color: #3b82f6 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        transform: translateY(-1px) !important;
    }
    
    #workshopModal .form-actions {
        display: flex !important;
        gap: 15px !important;
        margin-top: 30px !important;
        padding-top: 20px !important;
        border-top: 1px solid #e5e7eb !important;
    }
    
    #workshopModal .btn {
        padding: 12px 24px !important;
        border: none !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        transition: all 0.3s ease !important;
        flex: 1 !important;
        position: relative !important;
        overflow: hidden !important;
    }
    
    #workshopModal .btn::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: -100% !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent) !important;
        transition: left 0.5s ease !important;
    }
    
    #workshopModal .btn:hover::before {
        left: 100% !important;
    }
    
    #workshopModal .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
    }
    
    #workshopModal .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4) !important;
    }
    
    #workshopModal .btn-secondary {
        background: linear-gradient(135deg, #e5e7eb, #d1d5db) !important;
        color: #374151 !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    #workshopModal .btn-secondary:hover {
        background: linear-gradient(135deg, #d1d5db, #9ca3af) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
    
    #workshopModal .alert {
        padding: 15px !important;
        margin-bottom: 20px !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        border: none !important;
    }
    
    #workshopModal .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
        color: #065f46 !important;
        border-left: 4px solid #10b981 !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2) !important;
    }
    
    #workshopModal .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca) !important;
        color: #991b1b !important;
        border-left: 4px solid #ef4444 !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2) !important;
    }
    
    /* Workshop Cards - Complete Redesign */
    .workshops-section {
        padding: 5rem 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }
    
    .workshops-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }
    
    .workshop-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 1px solid rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .workshop-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        border-color: rgba(59, 130, 246, 0.2);
    }
    
    .workshop-header {
        padding: 2rem 2rem 1rem;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-bottom: 1px solid #e9ecef;
        position: relative;
    }
    
    .workshop-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 2px;
    }
    
    .workshop-icon {
        margin-bottom: 1rem;
    }
    
    .workshop-icon .icon-bg {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }
    
    .workshop-card:hover .workshop-icon .icon-bg {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.35);
    }
    
    .workshop-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e40af;
        margin: 0;
        line-height: 1.3;
    }
    
    .workshop-content {
        padding: 1.5rem 2rem;
    }
    
    .workshop-content p {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }
    
    .workshop-features {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .feature-tag {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid rgba(59, 130, 246, 0.2);
        transition: all 0.2s ease;
        display: inline-block;
    }
    
    .feature-tag:hover {
        background: linear-gradient(135deg, #bfdbfe, #93c5fd);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }
    
    .workshop-details {
        padding: 1rem 2rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .detail-item {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .workshop-btn {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 0 0 16px 16px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
        z-index: 10;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    
    .workshop-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.4s ease;
        z-index: -1;
    }
    
    .workshop-btn:hover::before {
        left: 100%;
    }
    
    .workshop-btn:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
    }
    
    .workshop-btn:active {
        background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
        box-shadow: 0 3px 10px rgba(59, 130, 246, 0.3);
        transform: translateY(1px);
    }
    
    .workshop-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
    
    .workshop-btn:disabled {
        background: linear-gradient(135deg, #9ca3af, #6b7280);
        cursor: not-allowed;
        opacity: 0.7;
    }
    
    .workshop-btn:disabled:hover {
        background: linear-gradient(135deg, #9ca3af, #6b7280);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        transform: none;
    }
    
    .workshop-btn.loading {
        position: relative;
        color: transparent;
    }
    
    .workshop-btn.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    /* Success Feedback Styles */
    .alert.alert-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1rem 0;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        border-left: 4px solid #047857;
    }
    
    .success-animation {
        animation: successSlideIn 0.5s ease-out;
    }
    
    @keyframes successSlideIn {
        0% {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .success-icon {
        font-size: 2.5rem;
        color: #ffffff;
        text-align: center;
        margin-bottom: 1rem;
        animation: successBounce 0.6s ease-out;
    }
    
    @keyframes successBounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
    
    .success-content h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-align: center;
        color: #ffffff;
    }
    
    .success-content p {
        font-size: 1rem;
        margin: 0 0 1rem 0;
        text-align: center;
        opacity: 0.9;
    }
    
    .success-details {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.75rem;
        border-radius: 8px;
        margin-top: 1rem;
    }
    
    .success-tick {
        font-size: 1.2rem;
        color: #ffffff;
        font-weight: bold;
    }
    
    .success-details span:last-child {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    /* Modal Success State */
    #workshopModal.success-state .modal-content {
        border: 2px solid #10b981;
        box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
    }
    
    #workshopModal.success-state .modal-header {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    #workshopModal.success-state .modal-title {
        color: #ffffff;
    }
    
    #workshopModal.success-state .modal-close {
        color: #ffffff;
    }
    
    #workshopModal.success-state .modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    /* Error Feedback Styles */
    .alert.alert-error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1rem 0;
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        border-left: 4px solid #b91c1c;
    }
    
    .error-animation {
        animation: errorShake 0.5s ease-out;
    }
    
    @keyframes errorShake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .error-icon {
        font-size: 2rem;
        color: #ffffff;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .error-content h4 {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-align: center;
        color: #ffffff;
    }
    
    .error-content p {
        font-size: 0.95rem;
        margin: 0;
        text-align: center;
        opacity: 0.9;
    }
    </style>
    /* Responsive Design */
    @media (max-width: 768px) {
        .workshops-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .workshop-card {
            margin: 0 1rem;
        }
        
        .workshop-header {
            padding: 1.5rem 1.5rem 1rem;
        }
        
        .workshop-content {
            padding: 1rem 1.5rem;
        }
        
        .workshop-details {
            padding: 1rem 1.5rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .workshop-icon .icon-bg {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .workshop-header h3 {
            font-size: 1.3rem;
        }
        
        #workshopModal .modal-content {
            width: 95% !important;
            margin: 0 !important;
            max-height: 95vh !important;
        }
        
        #workshopModal .form-row {
            flex-direction: column !important;
            gap: 15px !important;
        }
        
        #workshopModal .modal-body {
            padding: 20px !important;
        }
        
        #workshopModal .modal-header {
            padding: 15px 20px !important;
        }
        
        #workshopModal .form-actions {
            flex-direction: column !important;
            gap: 10px !important;
        }
    }
    
    @media (max-width: 480px) {
        #workshopModal .modal-content {
            width: 98% !important;
            border-radius: 8px !important;
        }
        
        #workshopModal .modal-header h2 {
            font-size: 1.2rem !important;
        }
        
        #workshopModal .form-group input,
        #workshopModal .form-group select,
        #workshopModal .form-group textarea {
            font-size: 16px !important; /* Prevents zoom on iOS */
        }
    }
    </style>

    <script src="script.js"></script>
    <script src="ui-helpers.js"></script>
    
    <script>
    // Workshop Modal Functions
    function openWorkshopModal(workshopId) {
        console.log('openWorkshopModal called with:', workshopId);
        
        const modal = document.getElementById('workshopModal');
        const workshopIdInput = document.getElementById('workshopId');
        const workshopNameInput = document.getElementById('workshopName');
        const alertDiv = document.getElementById('workshopAlert');
        
        // Debug logging
        console.log('Modal element:', modal);
        console.log('Workshop ID input:', workshopIdInput);
        console.log('Workshop name input:', workshopNameInput);
        
        if (!modal) {
            console.error('Modal element not found!');
            alert('Error: Modal element not found!');
            return;
        }
        
        if (!workshopIdInput || !workshopNameInput) {
            console.error('Form inputs not found!');
            alert('Error: Form inputs not found!');
            return;
        }
        
        // Clear any previous alerts
        if (alertDiv) {
            alertDiv.innerHTML = '';
        }
        
        // Set workshop ID
        workshopIdInput.value = workshopId;
        
        // Set workshop name based on ID
        const workshopNames = {
            'workshop_music_appreciation': 'Music Appreciation',
            'workshop_folk_arts': 'Folk Arts & Crafts',
            'workshop_performance_skills': 'Performance Skills',
            'workshop_cultural_history': 'Cultural History',
            'workshop_digital_arts': 'Digital Arts Promotion'
        };
        
        workshopNameInput.value = workshopNames[workshopId] || 'Unknown Workshop';
        
        // Show modal with animation
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        console.log('Modal active class added');
        
        // Focus on first input
        setTimeout(() => {
            const nameInput = document.getElementById('participantName');
            if (nameInput) {
                nameInput.focus();
            }
        }, 100);
    }
    
    function closeWorkshopModal() {
        const modal = document.getElementById('workshopModal');
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
        
        // Reset form
        document.getElementById('workshopForm').reset();
        document.getElementById('workshopAlert').innerHTML = '';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('workshopModal');
        if (event.target == modal) {
            closeWorkshopModal();
        }
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('workshopModal');
            if (modal.classList.contains('active')) {
                closeWorkshopModal();
            }
        }
    });
    
    // Wait for DOM to be ready before adding event listeners
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, setting up workshop form listener');
        
        // Ensure all workshop buttons are clickable
        const workshopButtons = document.querySelectorAll('.workshop-btn');
        console.log('Found workshop buttons:', workshopButtons.length);
        
        workshopButtons.forEach((button, index) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Workshop button clicked:', index, this.onclick);
                // The onclick attribute should handle the modal opening
            });
        });
        
        const form = document.getElementById('workshopForm');
        if (!form) {
            console.error('Workshop form not found!');
            return;
        }
        
        // Debug form structure
        console.log('Form element:', form);
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        console.log('Form inputs:', form.querySelectorAll('input, select, textarea').length);
        
        form.addEventListener('submit', async function(e) {
        e.preventDefault();
        console.log('Form submission started');
        
        const alertDiv = document.getElementById('workshopAlert');
        const submitBtn = e.target.querySelector('button[type="submit"]');
        
        // Debug form data
        const formData = new FormData(this);
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        
        // Check if required fields are filled
        const name = this.querySelector('#participantName').value;
        const email = this.querySelector('#participantEmail').value;
        const workshopId = this.querySelector('#workshopId').value;
        
        console.log('Required fields check:');
        console.log('Name:', name);
        console.log('Email:', email);
        console.log('Workshop ID:', workshopId);
        
        if (!name || !email || !workshopId) {
            console.error('Missing required fields!');
            alertDiv.innerHTML = `
                <div class="alert alert-error error-animation">
                    <div class="error-icon">⚠</div>
                    <div class="error-content">
                        <h4>Missing Information</h4>
                        <p>Please fill in all required fields (Name and Email).</p>
                    </div>
                </div>
            `;
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
            submitBtn.textContent = 'Register for Workshop';
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        submitBtn.textContent = 'Registering...';
        
        try {
            console.log('Sending request to workshop_registration.php');
            
            const response = await fetch('workshop_registration.php', {
                method: 'POST',
                body: formData
            });
            
            console.log('Response received:', response.status, response.statusText);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            console.log('Response result:', result);
            
            if (result.success) {
                // Show success message with enhanced styling
                alertDiv.innerHTML = `
                    <div class="alert alert-success success-animation">
                        <div class="success-icon">✓</div>
                        <div class="success-content">
                            <h4>Registration Successful!</h4>
                            <p>${result.message}</p>
                            <div class="success-details">
                                <span class="success-tick">✓</span>
                                <span>Your workshop registration has been confirmed</span>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add success animation to the modal
                const modal = document.getElementById('workshopModal');
                modal.classList.add('success-state');
                
                // Show success feedback for 4 seconds, then close
                setTimeout(() => {
                    this.reset();
                    closeWorkshopModal();
                    modal.classList.remove('success-state');
                }, 4000);
            } else {
                alertDiv.innerHTML = `
                    <div class="alert alert-error error-animation">
                        <div class="error-icon">⚠</div>
                        <div class="error-content">
                            <h4>Registration Failed</h4>
                            <p>${result.message}</p>
                        </div>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Workshop registration error:', error);
            alertDiv.innerHTML = `
                <div class="alert alert-error error-animation">
                    <div class="error-icon">⚠</div>
                    <div class="error-content">
                        <h4>Connection Error</h4>
                        <p>Unable to connect to server. Please check your internet connection and try again.</p>
                    </div>
                </div>
            `;
        }
        
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.classList.remove('loading');
        submitBtn.textContent = 'Register for Workshop';
        });
    });
    </script>
</body>
</html>
