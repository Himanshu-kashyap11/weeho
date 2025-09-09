<?php
require_once 'config.php';

// Initialize database
try {
    initializeDatabase();
} catch (Exception $e) {
    error_log("Database initialization failed: " . $e->getMessage());
    jsonResponse(false, 'Database initialization failed');
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

// Get and sanitize input data
$eventId = sanitizeInput($_POST['eventId'] ?? '');
$name = sanitizeInput($_POST['name'] ?? '');
$rating = (int)($_POST['rating'] ?? 0);
$feedbackText = sanitizeInput($_POST['feedback'] ?? '');

// Validate required fields
if (empty($eventId) || empty($name) || empty($feedbackText)) {
    jsonResponse(false, 'All required fields must be filled');
}

// Validate rating
if ($rating < 1 || $rating > 5) {
    jsonResponse(false, 'Rating must be between 1 and 5');
}

// Create new feedback data
$feedbackData = [
    'id' => generateId('feedback_'),
    'event_id' => $eventId,
    'name' => $name,
    'rating' => $rating,
    'feedback' => $feedbackText,
    'status' => 'active'
];

// Save to database
try {
    // Test database connection first
    $pdo = getDB();
    if (!$pdo) {
        error_log("ERROR: Database connection failed in feedback.php");
        jsonResponse(false, 'Database connection failed');
    }
    
    // Verify the event exists - but allow registration even if event validation fails
    $eventExists = fetchOne("SELECT id FROM events WHERE id = ?", [$eventId]);
    if (!$eventExists) {
        error_log("WARNING: Event ID $eventId not found in events table, but allowing feedback submission");
        // Don't fail here - just log the warning and continue
    }
    
    error_log("Attempting to save feedback data: " . print_r($feedbackData, true));
    
    $result = createFeedback($feedbackData);
    error_log("Feedback result: " . ($result ? 'SUCCESS' : 'FAILED'));
    
    if ($result) {
        // Verify the record was actually inserted
        $verify = fetchOne("SELECT id FROM feedback WHERE id = ?", [$feedbackData['id']]);
        if ($verify) {
            error_log("Feedback verified in database: " . $feedbackData['id']);
            jsonResponse(true, 'Thank you for your feedback!', ['feedback_id' => $feedbackData['id']]);
        } else {
            error_log("ERROR: Feedback not found in database after insertion");
            jsonResponse(false, 'Feedback failed - data not saved');
        }
    } else {
        error_log("ERROR: createFeedback returned false");
        jsonResponse(false, 'Failed to save feedback. Please try again.');
    }
    
} catch (Exception $e) {
    error_log("ERROR: Feedback submission exception: " . $e->getMessage());
    jsonResponse(false, 'Database error: ' . $e->getMessage());
}
?>
