<?php

// Database connection
require('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

// Pagination settings
$limit = 9; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search term & status filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Base query
$query = "SELECT * FROM events WHERE 1=1";
$countQuery = "SELECT COUNT(*) as count FROM events WHERE 1=1";
$params = [];

// Search Filter
if (!empty($search)) {
    $query .= " AND (name LIKE :search OR description LIKE :search)";
    $countQuery .= " AND (name LIKE :search OR description LIKE :search)";
    $params['search'] = "%$search%";
}

// Status Filter
if ($status === 'open') {
    $query .= " AND is_full = 0";
    $countQuery .= " AND is_full = 0";
} elseif ($status === 'closed') {
    $query .= " AND is_full = 1";
    $countQuery .= " AND is_full = 1";
}

// Pagination
$query .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";

// Fetch paginated events
$events = $db->query($query, $params)->fetchAll();
$totalEvents = $db->query($countQuery, $params)->fetch()['count'];
$totalPages = ceil($totalEvents / $limit);

require('views/events/allEvents.view.php');
