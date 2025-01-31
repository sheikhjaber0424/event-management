<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');
$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
$eventRegisterUrl = $isLoggedIn ? "/event/register?id=" . $event['id'] : "/login";
?>


<main class="container mt-5 mb-5">
    <div class="card shadow-lg p-4">
        <div class="row g-4">
            <!-- Event Image -->
            <div class="col-md-6">
                <img src="<?= '/' . htmlspecialchars($event['image']); ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($event['name']); ?>">
            </div>

            <!-- Event Details -->
            <div class="col-md-6">
                <h1 class="fw-bold"> <?= htmlspecialchars($event['name']); ?> </h1>
                <p class="text-muted"><strong>Date:</strong> <?= date("F d, Y", strtotime($event['date'])); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                <p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']); ?> people</p>
                <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>

                <!-- Back to Events Button -->

                <a href="<?= $eventRegisterUrl; ?>" class="btn btn-success">Register</a>
            </div>
        </div>
    </div>
</main>

<?php
require('views/partials/footer.view.php');
?>