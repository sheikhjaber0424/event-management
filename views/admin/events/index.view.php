<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');

// Database connection
require('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

// Pagination settings
$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch paginated events
$events = $db->query("SELECT * FROM events LIMIT $limit OFFSET $offset")->fetchAll();

// Get total event count
$totalEvents = $db->query("SELECT COUNT(*) as count FROM events")->fetch()['count'];
$totalPages = ceil($totalEvents / $limit);
?>

<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>
    <div class="container mt-4">
        <div class="row d-flex justify-content-center align-items-center main-content p-3">

            <a href="/admin/events/create">
                <button class="btn btn-primary">Add New</button>
            </a>

            <div class="table-responsive mt-4" style="overflow-x: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background-color: white;">
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
                                <!-- <td><?= htmlspecialchars(substr($event['description'], 0, 50)) ?>...</td> -->
                                <td><?= htmlspecialchars($event['date']) ?></td>
                                <td><?= htmlspecialchars($event['capacity']) ?></td>
                                <!-- <td><?= htmlspecialchars($event['location'] ?? 'N/A') ?></td> -->
                                <td>
                                    <?php if (!empty($event['image'])) : ?>
                                        <img src="<?= htmlspecialchars($event['image']) ?>" alt="Event Image" width="50">
                                    <?php else : ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
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
            <div class="mt-3">
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<?php require('views/admin/partials/footer.view.php'); ?>