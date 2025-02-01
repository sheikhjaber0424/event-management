<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');

?>


<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class="container px-3">
        <div class="row d-flex justify-content-center align-items-center main-content">
            <div class="col-md-6">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
                        role="alert" id="auto-dismiss-alert">
                        <?= htmlspecialchars($_SESSION['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                <?php endif; ?>

                <div class="mb-1">
                    <a href="/admin/users">
                        <button class="btn btn-secondary">Back</button>
                    </a>
                </div>

                <h2 class="text-center mb-3">Edit User</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/users/update?id=<?= $user['id'] ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" disabled>
                            </div>

                            <!-- <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" disabled>
                            </div> -->

                            <div class="mb-3">
                                <label for="is_admin" class="form-label">User Type</label>
                                <select class="form-control <?php echo isset($_SESSION['errors']['is_admin']) ? 'is-invalid' : ''; ?>" id="is_admin" name="is_admin" required>
                                    <option value="2" <?php echo ($_POST['is_admin'] ?? $user['is_admin']) == '2' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="3" <?php echo ($_POST['is_admin'] ?? $user['is_admin']) == '3' ? 'selected' : ''; ?>>Attendee</option>
                                </select>
                                <?php if (isset($_SESSION['errors']['is_admin'])): ?>
                                    <div class="invalid-feedback"><?php echo $_SESSION['errors']['is_admin']; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update User</button>
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

// Clear errors after displaying them
unset($_SESSION['errors']);
?>