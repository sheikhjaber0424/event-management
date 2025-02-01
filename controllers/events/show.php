<?php
require_once('core/functions.php');
require('core/Database.php');

$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
$config = require('core/config.php');
$db = new Database($config['database']);

// Fetch event details including is_full status
$eventId = $_GET['id'] ?? null;
$event = $db->query("SELECT * FROM events WHERE id = ?", [$eventId])->fetch();

if (!$event) {
    die("Event not found.");
}

$eventRegisterUrl = $isLoggedIn ? "/events/register?id=" . $event['id'] : "/login";

// Check if the user is already registered
$existingRegistration = $isLoggedIn ? $db->query("SELECT * FROM event_registration WHERE user_id = ? AND event_id = ?", [$_SESSION['user_id'], $eventId])->fetch() : null;


require('views/events/show.view.php');
