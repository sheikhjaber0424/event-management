<?php
session_start();

require_once('../../core/database.php');
require('../partials/head.view.php');
require('../partials/navbar.view.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
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
            header('Location: login.php');
            exit();
        }
    }
}

// HTML form content goes here (after processing logic)
?>

<!-- Register Form Content -->
<main class="container mt-5">
    <h2 class="text-center">Register</h2>
    <form class="form-container " method="post" action="register.php">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
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
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

</main>
<?php

// Set the title dynamically
$title = 'Register';
require('../partials/footer.view.php');
?>