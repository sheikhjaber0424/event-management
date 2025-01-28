<?php
require('../../views/partials/head.view.php');
require('../../views/partials/navbar.view.php');
?>
<main class="container mt-5">
    <div class="container mt-5">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p>This is your dashboard.</p>
        <a href="../../controllers/authentication/logout.php" class="btn btn-danger">Logout</a>
    </div>
</main>


<?php
require('../../views/partials/footer.view.php');
?>