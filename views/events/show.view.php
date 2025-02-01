<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');


?>

<main class="container mt-5 mb-5">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
            role="alert" id="auto-dismiss-alert">
            <?= htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

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
                <p><strong>Maximum Capacity:</strong> <?= htmlspecialchars($event['capacity']); ?> people</p>
                <p><strong>Remaining Spots:</strong> <?= htmlspecialchars($event['capacity'] - $event['registration_count']); ?> </p>

                <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>

                <?php if ($isLoggedIn && $existingRegistration): ?>
                    <div class="alert alert-info">
                        You are already registered for this event. (Tickets booked: <?= htmlspecialchars($existingRegistration['tickets']); ?>)
                    </div>


                <?php elseif ($event['is_full'] == 1): ?>
                    <p class="text-danger"> Registration for this event is closed.</p>

                <?php else: ?>
                    <?php if ($_SESSION['is_admin'] == 3): ?>
                        <a class="text-decoration-none" href="<?= $eventRegisterUrl; ?>">
                            <button class="btn btn-success">Register</button>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <a href="/events">
                    <button class="btn btn-primary">Events</button></a>
            </div>
        </div>
    </div>
</main>

<?php require('views/partials/footer.view.php'); ?>