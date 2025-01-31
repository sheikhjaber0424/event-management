<?php

// Database connection
require('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

// Pagination settings
$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search term
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Base query
$query = "SELECT * FROM events";
$countQuery = "SELECT COUNT(*) as count FROM events";

// Add search filter if search term is provided
if (!empty($search)) {
    $searchTerm = "%$search%";
    $query .= " WHERE name LIKE :search OR description LIKE :search";
    $countQuery .= " WHERE name LIKE :search OR description LIKE :search";
}

// Add pagination
$query .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";

// Fetch paginated events
if (!empty($search)) {
    $events = $db->query($query, ['search' => $searchTerm])->fetchAll();
    $totalEvents = $db->query($countQuery, ['search' => $searchTerm])->fetch()['count'];
} else {
    $events = $db->query($query)->fetchAll();
    $totalEvents = $db->query($countQuery)->fetch()['count'];
}

$totalPages = ceil($totalEvents / $limit);

require('views/admin/events/index.view.php');
