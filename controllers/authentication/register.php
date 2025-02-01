<?php

require_once('core/Database.php');

$config = require('core/config.php');
$db = new Database($config['database']);

// Redirect logged-in users away from registration
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors'] = []; // Reset errors
    $_SESSION['old'] = $_POST; // Store old values for repopulating fields

    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate name
    if (empty($name)) {
        $_SESSION['errors']['name'] = 'Name cannot be empty.';
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['email'] = 'Invalid email format.';
    }

    // Validate password length
    if (strlen($password) < 8) {
        $_SESSION['errors']['password'] = 'Password must be at least 8 characters long.';
    }

    // Check if user already exists
    if (empty($_SESSION['errors'])) {
        $user = $db->query("SELECT id FROM users WHERE email = ?", [$email])->fetch();
        if ($user) {
            $_SESSION['errors']['email'] = 'Email is already registered.';
        }
    }

    // If errors exist, redirect back
    if (!empty($_SESSION['errors'])) {
        header('Location: /register');
        exit();
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $inserted = $db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", [
        $name,
        $email,
        $hashedPassword
    ]);

    if ($inserted) {
        $_SESSION['message'] = 'Registration successful! You can now log in.';
        $_SESSION['message_type'] = 'success';
        unset($_SESSION['old']); // Clear old input after success
        header('Location: /login');
    } else {
        $_SESSION['message'] = 'Something went wrong. Please try again.';
        $_SESSION['message_type'] = 'danger';
        header('Location: /register');
    }
    exit();
}

require('views/authentication/register.view.php');
