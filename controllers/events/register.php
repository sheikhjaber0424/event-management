<?php

require_once('core/Database.php');
require_once('core/functions.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$eventId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

$config = require('core/config.php');
$db = new Database($config['database']);

// Fetch event details
$event = $db->query("SELECT name, capacity, registration_count FROM events WHERE id = ?", [$eventId])->fetch();

if (!$event) {
    die("Event not found.");
}

// Check if user is already registered
$userRegistration = $db->query("SELECT id FROM event_registration WHERE user_id = ? AND event_id = ?", [$userId, $eventId])->fetch();

if ($userRegistration) {
    // Redirect if user is already registered
    header("Location: /events?id=$eventId");
    exit();
}

require('views/events/register.view.php');
