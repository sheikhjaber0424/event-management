<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');
require_once('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

$events = $db->query("SELECT * FROM events LIMIT 6")->fetchAll();

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
    <div class="px-1  text-center mb-5">
        <h1 class="display-5 fw-bold">Welcome to Eventify</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Eventify is your go-to platform for organizing and managing events. Create, promote, and manage events effortlessly, and allow users to register and stay updated on event details. Simplify the process of event planning with our easy-to-use tools and responsive design.</p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="button" class="btn btn-primary btn-lg px-4 gap-3">Create an Event</button>
                <a href="/events" class="btn btn-outline-secondary btn-lg px-4">View Events</a>
            </div>
        </div>
    </div>

    <!-- Events Section -->
    <section class="mt-5">
        <div class="container mt-5">
            <h1 class="text-center mb-4">Upcoming Events</h1>
            <div class="row row-cols-1 row-cols-md-3 g-3">
                <?php foreach ($events as $event): ?>
                    <div class="col">
                        <a href="/event?id=<?= $event['id']; ?>" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow-sm" style="max-width: 350px; margin: auto;">
                                <img src="<?= '/' . $event['image']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" style="max-width: 100%;"><?php echo htmlspecialchars($event['name']); ?></h5>
                                    <p class="card-text"><strong>Date:</strong> <?php echo date("F d, Y", strtotime($event['date'])); ?></p>
                                    <p class="card-text text-truncate" style="max-width: 100%;"><?php echo htmlspecialchars($event['description']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- View More Button -->
        <div class="text-center mt-4">
            <a href="/events" class="btn btn-primary btn-lg">View More Events</a>
        </div>
    </section>


</main>


<?php
require('views/partials/footer.view.php');
?>