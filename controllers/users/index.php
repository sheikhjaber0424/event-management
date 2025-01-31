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
$query = "SELECT id, name, email, is_admin FROM users";
$countQuery = "SELECT COUNT(*) as count FROM users";

// Add search filter if search term is provided
if (!empty($search)) {
    $searchTerm = "%$search%";
    $query .= " WHERE name LIKE :search OR email LIKE :search";
    $countQuery .= " WHERE name LIKE :search OR email LIKE :search";
}

// Add pagination
$query .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";

// Fetch paginated users
if (!empty($search)) {
    $users = $db->query($query, ['search' => $searchTerm])->fetchAll();
    $totalUsers = $db->query($countQuery, ['search' => $searchTerm])->fetch()['count'];
} else {
    $users = $db->query($query)->fetchAll();
    $totalUsers = $db->query($countQuery)->fetch()['count'];
}

$totalPages = ceil($totalUsers / $limit);

require('views/admin/users/index.view.php');
