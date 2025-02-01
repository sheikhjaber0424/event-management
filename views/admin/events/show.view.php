<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');
?>

<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class="container px-3">

        <div class="row d-flex justify-content-center align-items-start main-content p-md-3 p-sm-1">
            <div class="col-md-8">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
                        role="alert" id="auto-dismiss-alert">
                        <?= htmlspecialchars($_SESSION['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                <?php endif; ?>


                <!-- Back Button -->
                <div class="mb-3">
                    <a href="/admin/events" class="btn btn-secondary mt-2">Back to Events</a>

                    <a href="/admin/events/generate_report?event_id=<?= $event['id']; ?>" class="btn btn-success mt-2">
                        Generate Report
                    </a>
                </div>

                <!-- Event Details Card -->
                <div class="card">
                    <!-- Event Image -->
                    <?php if (!empty($event['image'])): ?>
                        <img src="<?= '/' . $event['image']; ?>" class="card-img-top" alt="Event Image" style="height: 400px; width: 100%; object-fit: fill;">


                    <?php else: ?>
                        <div class="text-center py-5 bg-light">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <!-- Event Name -->
                        <h2 class="card-title"><?php echo htmlspecialchars($event['name']); ?></h2>

                        <!-- Event Description -->
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

                        <hr>

                        <!-- Event Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['date'])); ?></p>
                                <p><strong>Capacity:</strong> <?php echo number_format($event['capacity']); ?> attendees</p>
                            </div>
                            <div class="col-md-6">
                                <?php if (!empty($event['location'])): ?>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <div class="mt-4">
                            <a href="/admin/events/edit?id=<?php echo $event['id']; ?>" class="btn btn-primary">Edit Event</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('views/admin/partials/footer.view.php');
?>