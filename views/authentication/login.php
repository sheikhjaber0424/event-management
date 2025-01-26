<?php
session_start();
require_once('../../core/database.php');
require('../partials/head.view.php');
require('../partials/navbar.view.php');


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

// HTML form content goes here (after processing logic)
?>

<!-- Login Form Content -->
<main class="container mt-5">
    <h2 class="text-center">Login</h2>
    <form class="form-container" method="post" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <!-- Display Messages -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger mt-3"><?= $_SESSION['error'];
                                                unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-success mt-3"><?= $_SESSION['message'];
                                                unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <div class="text-center mt-3">
        <p>Don’t have an account? <a href="register.php">Register here</a></p>
    </div>
</main>
<?php

$title = 'Login';
require('../partials/footer.view.php');
?>