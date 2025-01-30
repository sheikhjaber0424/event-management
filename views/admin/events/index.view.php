<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');
?>
<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class="container mt-4">
        <a href="/admin/events/create">
            <button class="btn btn-primary">Add New</button>
        </a>

    </div>
</div>

<?php
require('views/admin/partials/footer.view.php');
?>