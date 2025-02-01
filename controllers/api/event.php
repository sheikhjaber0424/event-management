<?php
require_once('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

header("Content-Type: application/json"); // Set response type to JSON

// Get event ID from request
$eventId = $_GET['id'] ?? null;

if ($eventId && !is_numeric($eventId)) {
    echo json_encode(["error" => "Invalid event ID"]);
    http_response_code(400);
    exit();
}

// If event ID is provided, fetch the specific event
if ($eventId) {
    $event = $db->query("SELECT * FROM events WHERE id = ?", [$eventId])->fetch();

    if (!$event) {
        echo json_encode(["error" => "Event not found"]);
        http_response_code(404);
        exit();
    }

    // Send JSON response for a single event
    echo json_encode([
        "id" => $event["id"],
        "name" => $event["name"],
        "date" => $event["date"],
        "location" => $event["location"],
        "description" => $event["description"],
        "image" => '/' . $event["image"],
        "is_full" => (bool)$event["is_full"],
        "capacity" => $event["capacity"],
        "registration_count" => $event["registration_count"]
    ]);
} else {
    // Fetch all events if no event ID is provided
    $events = $db->query("SELECT * FROM events")->fetchAll();

    // Send JSON response for all events
    echo json_encode($events);
}

exit();
