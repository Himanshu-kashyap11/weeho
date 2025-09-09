<?php
// Include database configuration
require_once 'database_config.php';

// Site Configuration
define('SITE_NAME', 'Weeho');
define('SITE_TAGLINE', 'Celebrating Arts & Culture Across India');
define('CURRENT_YEAR', date('Y'));

// Contact Information
define('CONTACT_EMAIL', 'info@weeho.com');
define('CONTACT_PHONE', '+91 98765 43210');
define('CONTACT_ADDRESS', 'Cultural Arts District, Mumbai, Maharashtra, India');

// Social Media Links
define('FACEBOOK_URL', 'https://facebook.com/weeho');
define('TWITTER_URL', 'https://twitter.com/weeho');
define('INSTAGRAM_URL', 'https://instagram.com/weeho');
define('LINKEDIN_URL', 'https://linkedin.com/company/weeho');
define('GITHUB_URL', 'https://github.com/weeho');

// Database-based helper functions (replacing JSON functions)
function readJsonData($type) {
    switch($type) {
        case 'events':
            return getAllEvents();
        case 'registrations':
            return fetchAll("SELECT * FROM registrations ORDER BY created_at DESC");
        case 'feedback':
            return fetchAll("SELECT * FROM feedback ORDER BY created_at DESC");
        case 'teamFeedback':
            return getAllTeamFeedback();
        case 'memories':
            return getAllMemories();
        case 'contacts':
            return getAllContactMessages();
        default:
            return [];
    }
}

function saveJsonData($type, $data) {
    // This function is deprecated - use specific database functions instead
    return true;
}

function generateId($prefix = 'id_') {
    return $prefix . uniqid() . '_' . rand(1000, 9999);
}

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function jsonResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Session management for messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function setMessage($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'];
        unset($_SESSION['message'], $_SESSION['message_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

function getStatusMessage() {
    $message = getMessage();
    if ($message) {
        $class = $message['type'] === 'error' ? 'status-error' : 'status-success';
        return [
            'message' => $message['message'],
            'class' => $class
        ];
    }
    return null;
}
?>
