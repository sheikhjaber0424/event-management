<?php

require_once('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors'] = []; // Reset errors
    $_SESSION['old'] = $_POST; // Store old input for repopulating

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email
    if (empty($email)) {
        $_SESSION['errors']['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['email'] = 'Invalid email format.';
    }

    // Validate password
    if (empty($password)) {
        $_SESSION['errors']['password'] = 'Password is required.';
    }

    // If there are validation errors, redirect
    if (!empty($_SESSION['errors'])) {
        header('Location: /login');
        exit();
    }

    // Check if user exists
    $user = $db->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); // Regenerate session ID for security

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = $user['is_admin'];

        $_SESSION['message'] = 'Login successful!';
        $_SESSION['message_type'] = 'success';

        unset($_SESSION['old'], $_SESSION['errors']); // Clear old input & errors
        if (isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] === 1 || $_SESSION['is_admin'] === 2)) {
            header('Location: /admin/dashboard');
            exit(); // Prevent further execution
        } else {
            header('Location: /');
            exit();
        }

        exit();
    } else {
        $_SESSION['message'] = 'Invalid email or password!';
        $_SESSION['message_type'] = 'danger';

        header('Location: /login');
        exit();
    }
}

// Load view with errors
require('views/authentication/login.view.php');
