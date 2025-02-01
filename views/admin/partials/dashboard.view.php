<?php
require('head.view.php');
require('sidebar.view.php');
?>

<div class="content">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
            role="alert" id="auto-dismiss-alert">
            <?= htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>


    <?php
    require('navbar.view.php');
    ?>
    <h3 class="text-center">Welcome to Dashboard!</h3>


</div>

<?php
require('footer.view.php');
?>