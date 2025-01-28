<?php
session_start();
require_once('core/database.php');

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
    } else {
        // Check if user already exists
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['error'] = 'Email is already registered.';
        } else {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the user into the database
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            $_SESSION['message'] = 'Registration successful! You can now log in.';
            header('Location: /login');
            exit();
        }
    }
}
require('views/authentication/register.view.php');
