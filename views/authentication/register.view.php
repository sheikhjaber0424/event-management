<?php
require('../../views/partials/head.view.php');
require('../../views/partials/navbar.view.php');

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

require('../../views/partials/footer.view.php');
?>