<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');

require_once('core/Database.php');
require_once('core/functions.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$eventId = $_GET['id'] ?? null;
$config = require('core/config.php');
$db = new Database($config['database']);

$event = $db->query("SELECT name FROM events WHERE id = ?", [$eventId])->fetch();
$user = $db->query("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']])->fetch();



if (!$event) {
    die("Event not found.");
}
?>

<!-- Event Registration Form -->
<main class="container mt-5">
    <h2 class="text-center text-success">Register for Event</h2>
    <form class="form-container" method="post" action="/event/register">
        <input type="hidden" name="event_id" value="<?= htmlspecialchars($eventId); ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control border-success" name="name" id="name" value="<?= htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control border-success" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control border-success" name="event_name" id="event_name" value="<?= htmlspecialchars($event['name']); ?>" disabled>
        </div>

        <button type="submit" class="btn btn-success w-100">Confirm Registration</button>
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
        <p><a href="/event?id=<?= htmlspecialchars($eventId); ?>" class="text-success">Back to Event</a></p>
    </div>
</main>

<?php
require('views/partials/footer.view.php');
?>