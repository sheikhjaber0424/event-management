<?php
require_once('core/functions.php');
require('core/Database.php');

// Check if the user ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['message'] = 'User ID is required.';
    $_SESSION['message_type'] = 'danger';
    header('Location: /admin/users');
    exit();
}

$userId = $_GET['id'];

// Fetch the user data from the database
$config = require('core/config.php');
$db = new Database($config['database']);
$user = $db->query("SELECT * FROM users WHERE id = ?", [$userId])->fetch();

if (!$user) {
    $_SESSION['message'] = 'User not found.';
    $_SESSION['message_type'] = 'danger';
    header('Location: /admin/users');
    exit();
}

// Pass the event data to the view
require('views/admin/users/edit.view.php');
