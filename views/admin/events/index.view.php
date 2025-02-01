<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');

?>

<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>
    <div class="container mt-3">
        <div class="row d-flex justify-content-center align-items-start main-content p-3">

            <!-- Message Alert -->

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?? 'success'; ?> alert-dismissible fade show text-center custom-alert"
                    role="alert" id="auto-dismiss-alert">
                    <?= htmlspecialchars($_SESSION['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>


            <!-- Search and Add New Button Container -->
            <h2 class="text-center">Events List</h2>
            <div class="d-flex justify-content-between align-items-center  w-100">
                <!-- Add New Button -->
                <a href="/admin/events/create" class="ms-2">
                    <button class="btn btn-primary">Add New</button>
                </a>

                <!-- Search Form -->
                <form action="/admin/events" method="GET" class="mb-0">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or desc..">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>



            <!-- Table -->
            <div class="table-responsive " style="overflow-x: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background-color: white;min-height:60vh">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Capacity</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event) : ?>
                            <tr>
                                <td><?= htmlspecialchars($event['id']) ?></td>
                                <td><?= htmlspecialchars($event['name']) ?></td>
                                <td><?= date('F j, Y', strtotime($event['date'])) ?></td>
                                <td><?= htmlspecialchars($event['capacity']) ?></td>
                                <td>
                                    <?php if (!empty($event['image'])) : ?>
                                        <img src="<?= '/' . $event['image']; ?>" alt="Event Image" width="50">

                                    <?php else : ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/admin/event?id=<?= $event['id'] ?>" class="btn btn-sm btn-success">View</a>
                                    <a href="/admin/events/edit?id=<?= $event['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/admin/events/delete" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                        <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1) : ?>
                <div class="mt-1">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require('views/admin/partials/footer.view.php'); ?>