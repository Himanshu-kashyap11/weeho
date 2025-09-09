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

try {
    // Log incoming data for debugging
    error_log("Registration attempt - POST data: " . print_r($_POST, true));
    
    // Get and sanitize input data
    $eventId = sanitizeInput($_POST['eventId'] ?? '');
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $role = sanitizeInput($_POST['role'] ?? '');
    $city = sanitizeInput($_POST['city'] ?? '');
    
    error_log("Sanitized data - EventID: $eventId, Name: $name, Email: $email, Phone: $phone, Role: $role, City: $city");
    
    // Validate that we have an event ID
    if (empty($eventId)) {
        error_log("ERROR: No eventId received in POST data");
        jsonResponse(false, 'Event ID is missing');
    }

    // Validate required fields
    if (empty($eventId) || empty($name) || empty($email) || empty($phone)) {
        jsonResponse(false, 'All required fields must be filled');
    }

    // Validate email
    if (!validateEmail($email)) {
        jsonResponse(false, 'Please enter a valid email address');
    }

    // Verify the event exists first - but allow registration even if event validation fails
    $eventExists = fetchOne("SELECT id FROM events WHERE id = ?", [$eventId]);
    if (!$eventExists) {
        error_log("WARNING: Event ID $eventId not found in events table, but allowing registration");
        // Don't fail here - just log the warning and continue
    }

    // Check for duplicate registration
    $existing = fetchOne("SELECT id FROM registrations WHERE event_id = ? AND email = ?", [$eventId, $email]);
    if ($existing) {
        jsonResponse(false, 'You have already registered for this event');
    }

    // Create new registration data
    $registrationData = [
        'id' => generateId('reg_'),
        'event_id' => $eventId,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'role' => $role,
        'city' => $city,
        'status' => 'confirmed'
    ];

    // Save to database
    error_log("Attempting to save registration data: " . print_r($registrationData, true));
    
    // Test database connection first
    try {
        $pdo = getDB();
        if (!$pdo) {
            error_log("ERROR: Database connection failed");
            jsonResponse(false, 'Database connection failed');
        }
        error_log("Database connection successful");
        
        // Verify the event exists
        $eventExists = fetchOne("SELECT id FROM events WHERE id = ?", [$eventId]);
        if (!$eventExists) {
            error_log("WARNING: Event ID $eventId not found, but proceeding with registration");
        }
        
    } catch (Exception $e) {
        error_log("ERROR: Database connection exception: " . $e->getMessage());
        jsonResponse(false, 'Database connection error: ' . $e->getMessage());
    }
    
    $result = createRegistration($registrationData);
    error_log("Registration result: " . ($result ? 'SUCCESS' : 'FAILED'));
    
    if ($result) {
        // Verify the record was actually inserted
        $verify = fetchOne("SELECT id FROM registrations WHERE id = ?", [$registrationData['id']]);
        if ($verify) {
            error_log("Registration verified in database: " . $registrationData['id']);
            jsonResponse(true, 'Registration successful! We will contact you soon.', ['registration_id' => $registrationData['id']]);
        } else {
            error_log("ERROR: Registration not found in database after insertion");
            jsonResponse(false, 'Registration failed - data not saved');
        }
    } else {
        error_log("ERROR: createRegistration returned false");
        jsonResponse(false, 'Registration failed. Please try again.');
    }
    
} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    jsonResponse(false, 'An error occurred during registration. Please try again.');
}
?>
