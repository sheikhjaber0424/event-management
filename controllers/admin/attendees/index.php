<?php

// Database connection
require_once('core/Database.php');
require_once('core/functions.php');
$config = require('core/config.php');
$db = new Database($config['database']);

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Base query
$query = "SELECT users.name AS user_name, users.email AS user_email, events.name AS event_name, event_registration.tickets AS ticket_count
          FROM event_registration
          JOIN users ON event_registration.user_id = users.id
          JOIN events ON event_registration.event_id = events.id";

// Count query for pagination
$countQuery = "SELECT COUNT(*) as total FROM event_registration
               JOIN users ON event_registration.user_id = users.id
               JOIN events ON event_registration.event_id = events.id";

// Apply search filter if needed
$params = [];
if (!empty($search)) {
    $query .= " WHERE users.name LIKE :search OR users.email LIKE :search OR events.name LIKE :search";
    $countQuery .= " WHERE users.name LIKE :search OR users.email LIKE :search OR events.name LIKE :search";
    $params['search'] = "%$search%";
}

// Apply pagination
$query .= " ORDER BY users.id ASC LIMIT $limit OFFSET $offset";

// Fetch attendees
$attendeesStmt = $db->query($query, $params);
if (!$attendeesStmt) {
    dd("Query execution failed. Check error logs.");
}
$attendees = $attendeesStmt->fetchAll();

// Fetch total records for pagination
$totalStmt = $db->query($countQuery, $params);
$totalRecords = $totalStmt ? $totalStmt->fetch()['total'] : 0;
$totalPages = ceil($totalRecords / $limit);

// Load the view
require('views/admin/attendees/index.view.php');
