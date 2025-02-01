<?php

// Database connection
require_once('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

// Query to fetch users and their registered event names
$query = "SELECT users.name AS user_name, users.email AS user_email, events.name AS event_name, tickets AS ticket_count
          FROM event_registration
          JOIN users ON event_registration.user_id = users.id
          JOIN events ON event_registration.event_id = events.id
          ORDER BY users.id ASC";

$attendeesStmt = $db->query($query);
if (!$attendeesStmt) {
    die("Query execution failed. Check error logs.");
}
$attendees = $attendeesStmt->fetchAll();

// Load the view
require('views/admin/attendees/index.view.php');
