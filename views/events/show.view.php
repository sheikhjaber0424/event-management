<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');

$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
$config = require('core/config.php');
$db = new Database($config['database']);

// Fetch event details including is_full status
$eventId = $_GET['id'] ?? null;
$event = $db->query("SELECT * FROM events WHERE id = ?", [$eventId])->fetch();

if (!$event) {
    die("Event not found.");
}

$eventRegisterUrl = $isLoggedIn ? "/events/register?id=" . $event['id'] : "/login";

// Check if the user is already registered
$existingRegistration = $isLoggedIn ? $db->query("SELECT * FROM event_registration WHERE user_id = ? AND event_id = ?", [$_SESSION['user_id'], $eventId])->fetch() : null;
?>

<main class="container mt-5 mb-5">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center" role="alert" id="auto-dismiss-alert">
            <?= htmlspecialchars($_SESSION['message']); ?>
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
                <p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']); ?> people</p>
                <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>

                <?php if ($isLoggedIn && $existingRegistration): ?>
                    <div class="alert alert-info">
                        You are already registered for this event. (Tickets booked: <?= htmlspecialchars($existingRegistration['tickets']); ?>)
                    </div>
                    <a href="#" class="btn btn-secondary disabled">Already Registered</a>

                <?php elseif ($event['is_full'] == 1): ?>
                    <p class="text-danger"> Registration for this event is closed. The event is full.</p>

                <?php else: ?>
                    <a href="<?= $eventRegisterUrl; ?>" class="btn btn-success">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require('views/partials/footer.view.php'); ?>