<?php
require_once('core/Database.php');
require_once('core/functions.php');

$config = require('core/config.php');
$db = new Database($config['database']);


if (!isset($_GET['event_id']) || !is_numeric($_GET['event_id'])) {
    die("Invalid Event ID");
}

$event_id = (int)$_GET['event_id'];

// Fetch event details
$event = $db->query("SELECT name FROM events WHERE id = :event_id", ['event_id' => $event_id])->fetch();

if (!$event) {
    die("Event not found.");
}

// Fetch registered users for this event from the event_registration table
$registrations = $db->query("
    SELECT users.id, users.name, users.email, event_registration.created_at 
    FROM event_registration
    JOIN users ON event_registration.user_id = users.id 
    WHERE event_registration.event_id = :event_id
", ['event_id' => $event_id])->fetchAll();

if (empty($registrations)) {
    $_SESSION['message'] = 'No registrations found for this event.';
    $_SESSION['message_type'] = 'danger';
    header("Location: /admin/event?id=" . $event_id); // Fix the incorrect <?= syntax
    exit();
}

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="event_report_' . $event_id . '.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['User ID', 'Name', 'Email', 'Registered At']);

foreach ($registrations as $row) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['email'],
        date("Y-m-d H:i:s", strtotime($row['created_at'])) // Using 'created_at' instead of 'registered_at'
    ]);
}

fclose($output);
exit;
