<?php

require_once('Database.php');

$config = require('config.php');
$db = new Database($config['database']);

if (isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
        header('Location: /register');
        exit();
    }

    // Validate password length
    if (strlen($password) < 8) {
        $_SESSION['error'] = 'Password must be at least 8 characters long.';
        header('Location: /register');
        exit();
    }

    // Check if user already exists
    $user = $db->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();

    if ($user) {
        $_SESSION['error'] = 'Email is already registered.';
        header('Location: /register');
        exit();
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", [
        $name,
        $email,
        $hashedPassword
    ]);

    $_SESSION['message'] = 'Registration successful! You can now log in.';
    header('Location: /login');
    exit();
}

require('views/authentication/register.view.php');
