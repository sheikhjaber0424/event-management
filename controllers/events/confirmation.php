<?php
require_once('core/Database.php');
require_once('core/functions.php');

header('Content-Type: application/json'); // Ensure JSON response

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in."]);
    exit();
}

$config = require('core/config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    $userId = $_SESSION['user_id'];
    $eventId = $_POST['event_id'] ?? null;
    $ticketNumber = (int) ($_POST['tickets'] ?? 1);

    if (empty($eventId)) {
        echo json_encode(["success" => false, "message" => "Event ID is required."]);
        exit();
    }

    if ($ticketNumber < 1) {
        echo json_encode(["success" => false, "message" => "Invalid number of tickets."]);
        exit();
    }

    // Fetch event details
    $event = $db->query("SELECT capacity, registration_count FROM events WHERE id = ?", [$eventId])->fetch();

    if (!$event) {
        echo json_encode(["success" => false, "message" => "Event not found."]);
        exit();
    }

    $remainingSpots = $event['capacity'] - $event['registration_count'];

    if ($ticketNumber > $remainingSpots) {
        echo json_encode(["success" => false, "message" => "Only $remainingSpots tickets left."]);
        exit();
    }

    // Register user
    $db->query("INSERT INTO event_registration (user_id, event_id, tickets) VALUES (?, ?, ?)", [$userId, $eventId, $ticketNumber]);

    // Update registration count
    $db->query("UPDATE events SET registration_count = registration_count + ? WHERE id = ?", [$ticketNumber, $eventId]);

    // Check if the event is now full
    $updatedEvent = $db->query("SELECT registration_count FROM events WHERE id = ?", [$eventId])->fetch();

    if ($updatedEvent['registration_count'] == $event['capacity']) {
        $db->query("UPDATE events SET is_full = 1 WHERE id = ?", [$eventId]);
    }

    echo json_encode(["success" => true, "message" => "Registration successful!"]);
    exit();
}
