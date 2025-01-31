<?php
require_once('core/functions.php');
require('core/Database.php');

// if (!$userId) {
//     header('Location: /admin/events');
//     exit();
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize error array
    $errors = [];

    // Get form data
    $userId = $_POST['id'];
    $userType = $_POST['is_admin']; // User type (1, 2, or 3)

    // Validate user type
    if (empty($userType) || !in_array($userType, [1, 2, 3])) {
        $errors['is_admin'] = 'Please select a valid user type.';
    }

    // If there are any validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /admin/users/edit?id=' . $userId); // Redirect to edit page with user ID
        exit();
    }

    // Database connection setup
    $config = require('core/config.php');
    $db = new Database($config['database']);

    // Prepare the SQL query to update the user
    $query = "UPDATE users SET is_admin = :is_admin WHERE id = :id";

    // Define the params array
    $params = [
        ':is_admin' => $userType,
        ':id' => $userId
    ];

    // Execute the query
    if ($db->query($query, $params)) {
        $_SESSION['message'] = 'User information updated successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to update user information';
        $_SESSION['message_type'] = 'danger';
    }


    header('Location: /admin/users');
    exit();
}

// // If the request is GET, retrieve the user data to pre-fill the form
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     // Get the user ID from the query string
//     $userId = $_GET['id'];

//     // Database connection setup
//     $config = require('core/config.php');
//     $db = new Database($config['database']);

//     // Retrieve user data from the database
//     $user = $db->query("SELECT * FROM users WHERE id = ?", [$userId])->fetch();

//     if (!$user) {
//         $_SESSION['message'] = 'User not found';
//         $_SESSION['message_type'] = 'danger';
//         header('Location: /admin/users');
//         exit();
//     }
// }
