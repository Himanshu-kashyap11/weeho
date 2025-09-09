<?php
// Redirect to EventsAPI.php for consistent API handling
require_once 'api/EventsAPI.php';

// Create API instance and handle the request
$api = new EventsAPI();
$api->handleRequest();
?>
