<?php
require_once('core/Database.php');
require_once('core/functions.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$config = require('core/config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    $userId = $_SESSION['user_id'];
    $eventId = $_POST['event_id'] ?? null;
    $ticketNumber = (int) ($_POST['tickets'] ?? 1); // Ensure integer input

    if (empty($eventId)) {
        $errors['event_id'] = "Event ID is required.";
    }

    if ($ticketNumber < 1) {
        $errors['tickets'] = "Please enter a valid number of tickets.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: /event?id=$eventId");
        exit();
    }

    // Fetch event details
    $event = $db->query("SELECT capacity, registration_count, is_full FROM events WHERE id = ?", [$eventId])->fetch();

    if (!$event) {
        $_SESSION['errors']['event'] = "Event not found.";
        header("Location: /event?id=$eventId");
        exit();
    }

    // Check if there is space available for the registration
    $remainingSpots = $event['capacity'] - $event['registration_count'];

    if ($ticketNumber > $remainingSpots) {
        $_SESSION['errors']['tickets'] = "Only $remainingSpots tickets left!";
        header("Location: /event?id=$eventId");
        exit();
    }

    // Register user for the event
    $db->query("INSERT INTO event_registration (user_id, event_id, tickets) VALUES (?, ?, ?)", [$userId, $eventId, $ticketNumber]);

    // Update registration count
    $db->query("UPDATE events SET registration_count = registration_count + ? WHERE id = ?", [$ticketNumber, $eventId]);

    // Check if the event is now full and update `is_full` accordingly
    $updatedEvent = $db->query("SELECT registration_count FROM events WHERE id = ?", [$eventId])->fetch();

    if ($updatedEvent['registration_count'] == $event['capacity']) {
        $db->query("UPDATE events SET is_full = 1 WHERE id = ?", [$eventId]);
    }

    $_SESSION['message'] = "Event registration successful";
    $_SESSION['message_type'] = "success";

    header("Location: /event?id=$eventId");
    exit();
}
