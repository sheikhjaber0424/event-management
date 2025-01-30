<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');

// Display flash message if it exists

?>


<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class="px-3">
        <div class="row d-flex justify-content-center align-items-center main-content">
            <div class="col-md-6">
                <?php
                if (isset($_SESSION['message'])):
                    $messageType = $_SESSION['message_type'] ?? 'success'; // Default to 'success' if not set
                ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert" id="auto-dismiss-alert">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php
                    unset($_SESSION['message']); // Clear the message after displaying
                    unset($_SESSION['message_type']); // Clear the message type after displaying
                endif;
                ?>
                <div class="mb-1">
                    <a href="/admin/events">
                        <button class="btn btn-secondary">Back</button>
                    </a>
                </div>


                <h2 class="text-center mb-3">Create Event</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/events/store" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Event Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Create Event</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('views/admin/partials/footer.view.php');
?>