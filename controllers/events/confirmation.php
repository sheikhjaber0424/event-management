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
    $ticketNumber = $_POST['tickets'] ?? 1; // Ensure integer input

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
    $event = $db->query("SELECT capacity FROM events WHERE id = ?", [$eventId])->fetch();

    if (!$event) {
        $_SESSION['errors']['event'] = "Event not found.";
        header("Location: /event?id=$eventId");
        exit();
    }

    // Check if enough tickets are available
    if ($event['capacity'] < $ticketNumber) {
        $_SESSION['errors']['tickets'] = "Not enough tickets available.";
        header("Location: /event?id=$eventId");
        exit();
    }

    // Register user for the event
    $db->query("INSERT INTO event_registration (user_id, event_id, tickets) VALUES (?, ?, ?)", [$userId, $eventId, $ticketNumber]);

    // Decrease event capacity
    $newCapacity = $event['capacity'] - $ticketNumber;
    $db->query("UPDATE events SET capacity = ? WHERE id = ?", [$newCapacity, $eventId]);

    // If the new capacity is 0, mark the event as full
    if ($newCapacity == 0) {
        $db->query("UPDATE events SET is_full = 1 WHERE id = ?", [$eventId]);
    }

    $_SESSION['message'] = "You have successfully registered for the event.";
    $_SESSION['message_type'] = "success";

    header("Location: /event?id=$eventId");
    exit();
}
