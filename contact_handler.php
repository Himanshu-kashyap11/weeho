<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

// Get and sanitize input data
$name = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    jsonResponse(false, 'All required fields must be filled');
}

// Validate email
if (!validateEmail($email)) {
    jsonResponse(false, 'Please enter a valid email address');
}

// Create new contact message data
$contactData = [
    'id' => generateId('contact_'),
    'name' => $name,
    'email' => $email,
    'message' => $message,
    'status' => 'new'
];

// Save to database
if (createContactMessage($contactData)) {
    jsonResponse(true, 'Thank you for your message! We will get back to you soon.');
} else {
    jsonResponse(false, 'Failed to send message. Please try again.');
}
?>
