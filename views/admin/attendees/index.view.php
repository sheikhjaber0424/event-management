<?php
require('views/admin/partials/head.view.php');
require('views/admin/partials/sidebar.view.php');
?>

<div class="content">
    <?php require('views/admin/partials/navbar.view.php'); ?>

    <div class="container mt-3">
        <div class="row d-flex justify-content-center align-items-start main-content p-3">

            <h2 class="text-center">Attendees List</h2>

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
                                <td colspan="3" class="text-center">No attendees found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require('views/admin/partials/footer.view.php'); ?>