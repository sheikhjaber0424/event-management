<?php
session_start();
require_once('../../core/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
    } else {
        // Check if user exists
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];

            $_SESSION['message'] = 'Login successful! Redirecting to dashboard...';
            header('Location: dashboard.php');
            exit();
        } else {
            $_SESSION['error'] = 'Invalid email or password.';
        }
    }
}
require('../../views/authentication/login.view.php');
// HTML form content goes here (after processing logic)
