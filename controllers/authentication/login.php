<?php

require_once('Database.php');

$config = require('config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
        header('Location: /login');
        exit();
    }

    // Check if user exists
    $user = $db->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Regenerate session ID for security
        session_regenerate_id(true);

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];

        $_SESSION['message'] = 'Login successful! Redirecting to dashboard...';
        header('Location: /dashboard');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password.';
        header('Location: /login');
        exit();
    }
}

require('views/authentication/login.view.php');
