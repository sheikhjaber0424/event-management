<?php
require_once('core/functions.php');
require('core/Database.php');

// Get the event ID from the query string
$eventId = $_GET['id'] ?? null;

if (!$eventId) {
    // Redirect to the events list if no ID is provided
    header('Location: /');
    exit();
}

// Database connection setup
$config = require('core/config.php');
$db = new Database($config['database']);

// Fetch the event data
$event = $db->query("SELECT * FROM events WHERE id = :id", [':id' => $eventId])->fetch();


require('views/events/show.view.php');
