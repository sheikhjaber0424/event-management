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

        </div>
    </div>

    <!-- Events Section -->

    <section class="mt-4">
        <div class="row g-4 justify-content-center">
            <?php foreach ($events as $event): ?>
                <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                    <div class="card border-0 shadow-lg h-100 overflow-hidden" style="width: 100%; max-width: 320px;">
                        <!-- Image Section with Overlay -->
                        <div class="position-relative">
                            <img src="<?= '/' . htmlspecialchars($event['image']); ?>"
                                class="card-img-top img-fluid event-img"
                                alt="<?= htmlspecialchars($event['name']); ?>">
                            <div class="overlay"></div>
                            <span class="badge event-date position-absolute top-0 start-0 m-2 px-3 py-1">
                                <?= date("M d", strtotime($event['date'])); ?>
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($event['name']); ?></h5>
                            <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($event['location']); ?></p>
                            <p class="card-text text-muted"><?= substr(htmlspecialchars($event['description']), 0, 80); ?>...</p>
                            <div class="mt-auto">
                                <a href="/event?id=<?= $event['id']; ?>"
                                    class="btn <?= $event['is_full'] ? 'btn-secondary' : 'btn-primary'; ?> w-100">
                                    View Event
                                </a>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-users"></i> <?= $event['registration_count']; ?> Attending</small>
                            <span class="badge <?= $event['is_full'] ? 'bg-danger' : 'bg-success'; ?>">
                                <?= $event['is_full'] ? 'Closed' : 'Open'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <div class="text-center mt-4">
        <a href="/events" class="btn btn-outline-primary btn-lg">View More</a>
    </div>




</main>


<?php
require('views/partials/footer.view.php');
?>