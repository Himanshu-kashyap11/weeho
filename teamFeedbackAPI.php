<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

// Get and sanitize input data
$name = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$rating = (int)($_POST['rating'] ?? 0);
$message = sanitizeInput($_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    jsonResponse(false, 'All required fields must be filled');
}

// Validate email
if (!validateEmail($email)) {
    jsonResponse(false, 'Please enter a valid email address');
}

// Validate rating
if ($rating < 1 || $rating > 5) {
    jsonResponse(false, 'Rating must be between 1 and 5');
}

// Create new team feedback data
$feedbackData = [
    'id' => generateId('team_feedback_'),
    'name' => $name,
    'email' => $email,
    'rating' => $rating,
    'message' => $message,
    'status' => 'active'
];

// Save to database
if (createTeamFeedback($feedbackData)) {
    jsonResponse(true, 'Thank you for your feedback about our team!');
} else {
    jsonResponse(false, 'Failed to save feedback. Please try again.');
}
?>
