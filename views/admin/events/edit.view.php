<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');
?>
<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class=" container px-3">
        <div class="row d-flex justify-content-center align-items-center main-content">
            <div class="col-md-6">
                <?php
                if (isset($_SESSION['message'])):
                    $messageType = $_SESSION['message_type'] ?? 'success'; // Default to 'success' if not set
                ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show text-center" role="alert" id="auto-dismiss-alert">
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

                <h2 class="text-center mb-3">Edit Event</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/events/update?id=<?= $event['id'] ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $_POST['name'] ?? $event['name']; ?>">
                                <?php if (isset($_SESSION['errors']['name'])): ?>
                                    <div class="invalid-feedback"><?php echo $_SESSION['errors']['name']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control <?php echo isset($_SESSION['errors']['description']) ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3"><?php echo $_POST['description'] ?? $event['description']; ?></textarea>
                                <?php if (isset($_SESSION['errors']['description'])): ?>
                                    <div class="invalid-feedback"><?php echo $_SESSION['errors']['description']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control <?php echo isset($_SESSION['errors']['date']) ? 'is-invalid' : ''; ?>" id="date" name="date" value="<?php echo $_POST['date'] ?? $event['date']; ?>">
                                <?php if (isset($_SESSION['errors']['date'])): ?>
                                    <div class="invalid-feedback"><?php echo $_SESSION['errors']['date']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control <?php echo isset($_SESSION['errors']['capacity']) ? 'is-invalid' : ''; ?>" id="capacity" name="capacity" value="<?php echo $_POST['capacity'] ?? $event['capacity']; ?>">
                                <?php if (isset($_SESSION['errors']['capacity'])): ?>
                                    <div class="invalid-feedback"><?php echo $_SESSION['errors']['capacity']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo $_POST['location'] ?? $event['location']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Event Image</label>
                                <input type="file" class="form-control <?php echo isset($_SESSION['errors']['image']) ? 'is-invalid' : ''; ?>" id="image" name="image">
                                <?php if (isset($_SESSION['errors']['image'])): ?>
                                    <div class="invalid-feedback"><?php echo $_SESSION['errors']['image']; ?></div>
                                <?php endif; ?>
                                <?php if ($event['image']): ?>
                                    <div class="mt-2">
                                        <img src="/uploads/<?php echo $event['image']; ?>" alt="Event Image" class="img-fluid" width="100">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Event</button>
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

// Clear errors after displaying
unset($_SESSION['errors']);
?>