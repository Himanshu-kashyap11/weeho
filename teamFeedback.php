<?php 
require_once 'config.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($rating) || empty($message)) {
        $error_message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } elseif (!in_array($rating, ['1', '2', '3', '4', '5'])) {
        $error_message = 'Please select a valid rating between 1 and 5.';
    } else {
        // Create feedback data for database
        $feedbackData = [
            'name' => sanitizeInput($name),
            'email' => sanitizeInput($email),
            'rating' => (int)$rating,
            'message' => sanitizeInput($message),
            'status' => 'active'
        ];
        
        // Save to database
        if (createTeamFeedback($feedbackData)) {
            $success_message = 'Thank you for your feedback! Your message has been submitted successfully.';
            // Clear form data
            $name = $email = $rating = $message = '';
        } else {
            $error_message = 'Sorry, there was an error saving your feedback. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Team Feedback</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="styles_ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ==========================
   General Styles
========================== */
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background: #f7f8fa;
    color: #333;
    line-height: 1.6;
}

/* ==========================
   Navbar
========================== */
.navbar {
    background: #111827;
    color: #fff;
    padding: 15px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}
.nav-container {
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.nav-logo h2 {
    color: #fff;
    margin: 0;
}
.nav-menu {
    display: flex;
    gap: 20px;
}
.nav-link {
    color: #d1d5db;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}
.nav-link:hover,
.nav-link.active {
    color: #3b82f6;
}
.hamburger {
    display: none;
    cursor: pointer;
}
.bar {
    display: block;
    width: 25px;
    height: 3px;
    margin: 5px;
    background: #fff;
    transition: 0.3s;
}

/* ==========================
   Page Header
========================== */
.team-feedback-header {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: #fff;
    padding: 60px 20px;
    text-align: center;
}
.page-title {
    font-size: 2.2rem;
    margin-bottom: 10px;
}
.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* ==========================
   Alerts
========================== */
.alert {
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease-in-out;
}
.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left: 6px solid #10b981;
}
.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border-left: 6px solid #ef4444;
}

/* ==========================
   Feedback Form
========================== */
.feedback-form-container {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 50px;
}
.feedback-form .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.feedback-form .form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.feedback-form label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #374151;
}
.feedback-form input,
.feedback-form select,
.feedback-form textarea {
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}
.feedback-form input:focus,
.feedback-form select:focus,
.feedback-form textarea:focus {
    border-color: #3b82f6;
    outline: none;
}
.feedback-form textarea {
    resize: none;
}
.form-actions {
    margin-top: 20px;
    display: flex;
    gap: 15px;
}
.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: transform 0.2s ease, background 0.3s;
}
.btn-primary {
    background: #3b82f6;
    color: #fff;
}
.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
}
.btn-secondary {
    background: #e5e7eb;
    color: #111827;
}
.btn-secondary:hover {
    background: #d1d5db;
}

/* ==========================
   Feedback List
========================== */
.feedback-list-section {
    padding: 40px 20px;
}
.feedback-list {
    display: grid;
    gap: 20px;
}
.feedback-item {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: transform 0.2s ease;
}
.feedback-item:hover {
    transform: translateY(-4px);
}
.feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.feedback-author h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}
.feedback-role {
    font-size: 0.9rem;
    color: #6b7280;
}
.feedback-rating {
    font-size: 1.2rem;
    color: #f59e0b;
}
.feedback-content p {
    margin: 10px 0;
    color: #374151;
}
.feedback-date {
    text-align: right;
    font-size: 0.85rem;
    color: #6b7280;
}
.no-feedback {
    text-align: center;
    padding: 30px;
    background: #f9fafb;
    border-radius: 10px;
    color: #6b7280;
    font-style: italic;
}

/* ==========================
   Footer
========================== */
.footer {
    background: #111827;
    color: #d1d5db;
    padding: 40px 20px;
    margin-top: 50px;
}
.footer-content {
    max-width: 1200px;
    margin: auto;
}
.footer-section h4 {
    margin-bottom: 10px;
    color: #fff;
}
.footer-bottom {
    text-align: center;
    margin-top: 20px;
    font-size: 0.9rem;
    border-top: 1px solid #374151;
    padding-top: 15px;
}

/* ==========================
   Responsive
========================== */
@media (max-width: 768px) {
    .nav-menu {
        display: none;
    }
    .hamburger {
        display: block;
    }
    .feedback-form .form-row {
        flex-direction: column;
    }
}

    </style>
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
                <a href="teamFeedback.php" class="nav-link active">Team Feedback</a>
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
            <a href="events.php" class="sidebar-link">Events</a>
            <a href="spotlight.php" class="sidebar-link">Spotlight</a>
            <a href="teamFeedback.php" class="sidebar-link active">Team Feedback</a>
            <a href="contact.php" class="sidebar-link">Contact</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Team Feedback Header -->
        <section class="team-feedback-header">
            <div class="container">
                <h1 class="page-title">Team Feedback</h1>
                <p class="page-subtitle">Share your thoughts and feedback about the Weeho Team</p>
            </div>
        </section>

        <!-- Feedback Form Section -->
        <section class="team-feedback-section">
            <div class="container">
                <div class="feedback-form-container">
                    <?php if ($success_message): ?>
                        <div class="alert alert-success"><?php echo $success_message; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-error"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" class="feedback-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="rating">Overall Rating:</label>
                                <select id="rating" name="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="5" <?php echo (isset($rating) && $rating == '5') ? 'selected' : ''; ?>>5 - Excellent</option>
                                    <option value="4" <?php echo (isset($rating) && $rating == '4') ? 'selected' : ''; ?>>4 - Very Good</option>
                                    <option value="3" <?php echo (isset($rating) && $rating == '3') ? 'selected' : ''; ?>>3 - Good</option>
                                    <option value="2" <?php echo (isset($rating) && $rating == '2') ? 'selected' : ''; ?>>2 - Fair</option>
                                    <option value="1" <?php echo (isset($rating) && $rating == '1') ? 'selected' : ''; ?>>1 - Poor</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Feedback:</label>
                            <textarea id="message" name="message" rows="5" placeholder="Share your thoughts about our events, organization, or suggestions for improvement..." required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                            <button type="reset" class="btn btn-secondary">Reset Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Feedback List -->
        <section class="feedback-list-section">
            <div class="container">
                <h2 class="section-title">Community Feedback</h2>
                <div class="feedback-list" id="feedbackList">
                    <?php
                    // Load feedback from database
                    $feedbacks = getAllTeamFeedback();
                    
                    if (!empty($feedbacks)) {
                        // Sort by created_at (newest first)
                        usort($feedbacks, function($a, $b) {
                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                        });
                        
                        foreach ($feedbacks as $feedback) {
                            echo '<div class="feedback-item">';
                            echo '<div class="feedback-header">';
                            echo '<div class="feedback-author">';
                            echo '<h4>' . htmlspecialchars($feedback['name']) . '</h4>';
                            echo '<span class="feedback-role">Community Member</span>';
                            echo '</div>';
                            echo '<div class="feedback-rating">';
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $feedback['rating']) {
                                    echo '<span class="star filled">★</span>';
                                } else {
                                    echo '<span class="star">☆</span>';
                                }
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="feedback-content">';
                            echo '<p>' . htmlspecialchars($feedback['message']) . '</p>';
                            echo '</div>';
                            echo '<div class="feedback-date">';
                            echo '<span>' . date('F j, Y', strtotime($feedback['created_at'])) . '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="no-feedback">';
                        echo '<p>No feedback available yet. Be the first to share your thoughts!</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

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

    <script src="script.js"></script>
    <script src="ui-helpers.js"></script>
    <script>
        // Auto-hide success/error messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
