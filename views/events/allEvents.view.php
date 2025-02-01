<?php require('views/partials/head.view.php'); ?>
<?php require('views/partials/navbar.view.php'); ?>

<main class="container mt-3 mb-4">
    <h1 class="text-center mb-4">All Events</h1>

    <!-- Search Bar -->
    <form method="GET" action="/events" class="d-flex justify-content-center mb-3">
        <input type="text" name="search" class="form-control w-50" placeholder="Search"
            value="<?= htmlspecialchars($search); ?>" />

        <!-- Status Filter Dropdown -->
        <select name="status" class="form-select ms-2" style="width: 150px;">
            <option value="">All</option>
            <option value="open" <?= $status === 'open' ? 'selected' : ''; ?>>Open</option>
            <option value="closed" <?= $status === 'closed' ? 'selected' : ''; ?>>Closed</option>
        </select>

        <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-search"></i></button>
    </form>

    <!-- Events Grid -->
    <section class="mt-4">
        <div class="row g-4 <?= count($events) === 1 ? 'justify-content-center' : 'row-cols-1 row-cols-md-2 row-cols-lg-3'; ?>">
            <?php if (empty($events)): ?>
                <p class="text-center">No events found.</p>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="col d-flex">
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
                                        class="btn  <?= $event['is_full'] ? 'btn-secondary' : 'btn-primary'; ?> w-100">
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
            <?php endif; ?>
        </div>
    </section>



    <!-- Pagination Controls -->
    <?php if ($totalPages > 1): ?>
        <div class="text-center mt-4">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>&search=<?= htmlspecialchars($search); ?>" class="btn btn-outline-primary">Previous</a>
            <?php endif; ?>

            <span class="mx-3">Page <?= $page; ?> of <?= $totalPages; ?></span>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1; ?>&search=<?= htmlspecialchars($search); ?>" class="btn btn-outline-primary">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php require('views/partials/footer.view.php'); ?>