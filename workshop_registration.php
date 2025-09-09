<?php
/**
 * Workshop Registration Handler
 */

require_once 'config.php';

header('Content-Type: application/json');

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $workshop_id = trim($_POST['workshop_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $experience_level = trim($_POST['experience_level'] ?? '');
    $preferred_schedule = trim($_POST['preferred_schedule'] ?? '');
    $special_requirements = trim($_POST['special_requirements'] ?? '');
    
    // Validate required fields
    if (empty($workshop_id) || empty($name) || empty($email)) {
        $error_message = 'Workshop, name, and email are required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } else {
        // Check if workshop exists - but allow registration even if workshop validation fails
        $workshop = getWorkshopById($workshop_id);
        if (!$workshop) {
            error_log("WARNING: Workshop ID $workshop_id not found, but allowing registration");
            // Create a dummy workshop object to continue processing
            $workshop = [
                'name' => 'Workshop',
                'max_participants' => 0 // No limit if workshop not found
            ];
        } else {
            // Check if workshop is full
            $current_registrations = getWorkshopRegistrationCount($workshop_id);
            if ($workshop['max_participants'] > 0 && $current_registrations >= $workshop['max_participants']) {
                $error_message = 'Sorry, this workshop is currently full. Please try another workshop or contact us to be added to the waiting list.';
            } else {
                // Check if user already registered for this workshop
                $existing = fetchOne("SELECT * FROM workshop_registrations WHERE workshop_id = ? AND email = ? AND status != 'cancelled'", [$workshop_id, $email]);
                if ($existing) {
                    $error_message = 'You are already registered for this workshop.';
                } else {
                    // Create registration data
                    $registrationData = [
                        'workshop_id' => $workshop_id,
                        'name' => sanitizeInput($name),
                        'email' => sanitizeInput($email),
                        'phone' => sanitizeInput($phone),
                        'experience_level' => $experience_level,
                        'preferred_schedule' => sanitizeInput($preferred_schedule),
                        'special_requirements' => sanitizeInput($special_requirements),
                        'status' => 'confirmed'
                    ];
                    
                    // Save to database
                    if (createWorkshopRegistration($registrationData)) {
                        $success_message = 'Thank you for registering! You have been successfully enrolled in the ' . $workshop['name'] . ' workshop. We will contact you soon with further details.';
                    } else {
                        $error_message = 'Sorry, there was an error processing your registration. Please try again.';
                    }
                }
            }
        }
    }
    
    // Return JSON response
    echo json_encode([
        'success' => !empty($success_message),
        'message' => $success_message ?: $error_message
    ]);
    exit;
}

// If not POST request, return error
echo json_encode([
    'success' => false,
    'message' => 'Invalid request method'
]);
?>
