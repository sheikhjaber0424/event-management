<?php
require_once('core/functions.php');
require('core/Database.php');



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in and has admin privileges
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1 || $_SESSION['user_id'] != 2) {
        $_SESSION['message'] = 'You do not have permission to delete users.';
        $_SESSION['message_type'] = 'danger';
        header('Location: /admin/users');
        exit();
    }

    // Get the user ID from the POST request
    $userId = $_POST['id'];

    // Database connection setup
    $config = require('core/config.php');
    $db = new Database($config['database']);

    // Check if the user exists in the database
    $user = $db->query("SELECT * FROM users WHERE id = ?", [$userId])->fetch();

    if (!$user) {
        $_SESSION['message'] = 'User not found.';
        $_SESSION['message_type'] = 'danger';
        header('Location: /admin/users');
        exit();
    }

    // Prevent deleting the admin user with ID 1
    if ($userId == 1) {
        $_SESSION['message'] = 'Cannot delete the super admin user.';
        $_SESSION['message_type'] = 'danger';
        header('Location: /admin/users');
        exit();
    }

    // Prepare the delete query
    $query = "DELETE FROM users WHERE id = ?";
    $params = [$userId];

    // Execute the query to delete the user
    if ($db->query($query, $params)) {
        $_SESSION['message'] = 'User deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to delete user.';
        $_SESSION['message_type'] = 'danger';
    }

    // Redirect back to the users list page
    header('Location: /admin/users');
    exit();
}
