<?php
require_once('core/functions.php');
require('core/Database.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$config = require('core/config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize error array
    $errors = [];

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $eventId = $_POST['event_id'];

    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (strlen($name) > 255) {
        $errors['name'] = 'Name cannot exceed 255 characters.';
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Validate event ID
    if (empty($eventId)) {
        $errors['event_id'] = 'Event ID is required.';
    }

    // If there are any validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: /event?id=$eventId");
        exit();
    }

    // Check event capacity
    $event = $db->query("SELECT capacity, is_full FROM events WHERE id = ?", [$eventId])->fetch();
    if ($event['is_full']) {
        $_SESSION['errors']['capacity'] = "This event is full.";
        header("Location: /event?id=$eventId");
        exit();
    }

    if ($event['capacity'] > 0) {
        // Decrease capacity
        $db->query("UPDATE events SET capacity = capacity - 1 WHERE id = ?", [$eventId]);

        // Update is_full if capacity is 0
        if ($event['capacity'] - 1 == 0) {
            $db->query("UPDATE events SET is_full = 1 WHERE id = ?", [$eventId]);
        }

        // Insert into event_register table
        $insertQuery = "INSERT INTO event_registration (user_id, event_id) VALUES (?, ?)";
        $db->query($insertQuery, [$_SESSION['user_id'], $eventId]);

        $_SESSION['message'] = 'You have successfully registered for the event.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['errors']['capacity'] = "This event is full.";
    }

    // Redirect to the event page after form submission
    header("Location: /event?id=$eventId");
    exit();
}
