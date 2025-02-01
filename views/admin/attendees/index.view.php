<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');
?>

<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class="container mt-3">
        <div class="row d-flex justify-content-center align-items-start main-content p-3">

            <h2 class="text-center">Attendees List</h2>

            <!-- Search Form -->
            <div class="d-flex justify-content-end align-items-center w-100 mb-3">
                <form action="/admin/attendees" method="GET" class="mb-0">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name, email, or event..">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive mt-3" style="overflow-x: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background-color: white; min-height:60vh">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Event Name</th>
                            <th>Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($attendees)) : ?>
                            <?php foreach ($attendees as $attendee) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($attendee['user_name']) ?></td>
                                    <td><?= htmlspecialchars($attendee['user_email']) ?></td>
                                    <td><?= htmlspecialchars($attendee['event_name']) ?></td>
                                    <td><?= htmlspecialchars($attendee['ticket_count']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">No attendees found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1) : ?>
                <nav class="mt-3">
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
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require('views/admin/partials/footer.view.php'); ?>