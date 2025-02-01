<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');
?>

<main class="container mt-5">
    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
            role="alert" id="auto-dismiss-alert">
            <?= htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <h2 class="text-center">Register</h2>

    <form class="form-container" method="post" action="/register">
        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control <?= isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>"
                name="name" id="name" placeholder="Enter your name"
                value="<?= htmlspecialchars($_SESSION['old']['name'] ?? ''); ?>" required>
            <?php if (isset($_SESSION['errors']['name'])): ?>
                <div class="invalid-feedback"><?= $_SESSION['errors']['name']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : ''; ?>"
                name="email" id="email" placeholder="Enter your email"
                value="<?= htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>" required>
            <?php if (isset($_SESSION['errors']['email'])): ?>
                <div class="invalid-feedback"><?= $_SESSION['errors']['email']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>"
                name="password" id="password" placeholder="Enter your password" required>
            <?php if (isset($_SESSION['errors']['password'])): ?>
                <div class="invalid-feedback"><?= $_SESSION['errors']['password']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        <p>Already have an account? <a href="/login">Login here</a></p>
    </div>
</main>

<?php
require('views/partials/footer.view.php');
unset($_SESSION['errors'], $_SESSION['old']); // Clear errors after displaying
?>