<?php

require('views/partials/head.view.php');
require('views/partials/navbar.view.php');
?>

<main class="container mt-5">
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
            role="alert" id="auto-dismiss-alert">
            <?= htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <h2 class="text-center">Login</h2>

    <!-- Show general login error -->
    <?php if (!empty($_SESSION['errors']['login'])): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['errors']['login']); ?></div>
    <?php endif; ?>

    <form class="form-container" method="post" action="/login">
        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : ''; ?>"
                name="email" id="email" placeholder="Enter your email"
                value="<?= htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>" required>
            <?php if (isset($_SESSION['errors']['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['email']); ?></div>
            <?php endif; ?>
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>"
                name="password" id="password" placeholder="Enter your password" required>
            <?php if (isset($_SESSION['errors']['password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['password']); ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <p>Don't have an account? <a href="/register">Register here</a></p>
    </div>
</main>

<?php
require('views/partials/footer.view.php');
unset($_SESSION['errors'], $_SESSION['old']); // Clear errors after displaying
?>