<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');
?>
<main class="container mt-5">
    <h2 class="text-center text-success">Register for Event</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type']; ?>">
            <?= htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <form class="form-container" method="post" action="/events/confirmation?event_id=<?= $eventId ?>">
        <input type="hidden" name="event_id" value="<?= htmlspecialchars($eventId); ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control border-success <?= isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" name="name" id="name" value="<?= htmlspecialchars($_SESSION['user_name']); ?>" required>
            <?php if (isset($_SESSION['errors']['name'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['name']); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control border-success <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?= htmlspecialchars($_SESSION['user_email']); ?>" required>
            <?php if (isset($_SESSION['errors']['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['email']); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="tickets" class="form-label">Number of Tickets (Available: <?= $event['capacity']; ?>)</label>
            <input type="number" class="form-control border-success <?= isset($_SESSION['errors']['tickets']) ? 'is-invalid' : ''; ?>" name="tickets" id="tickets" value="1" min="1" max="<?= $event['capacity']; ?>" required>
            <?php if (isset($_SESSION['errors']['tickets'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['tickets']); ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control border-success" value="<?= htmlspecialchars($event['name']); ?>" disabled>
        </div>

        <button type="submit" class="btn btn-success w-100">Confirm Registration</button>
    </form>

    <div class="text-center mt-3">
        <p><a href="/event?id=<?= htmlspecialchars($eventId); ?>" class="text-success">Back to Event</a></p>
    </div>
</main>

<?php require('views/partials/footer.view.php'); ?>