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
    <section class="mt-1">
        <div class="row <?= count($events) === 1 ? 'justify-content-center' : 'row-cols-1 row-cols-md-3'; ?> g-3">
            <?php if (empty($events)): ?>
                <p class="text-center">No events found.</p>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="col <?= count($events) === 1 ? 'col-md-6 col-lg-4 d-flex justify-content-center' : ''; ?>">

                        <div style="max-width: 280px; margin: auto; min-height: 300px;">
                            <div class="card shadow-sm position-relative h-100 d-flex flex-column"
                                style="max-width: 280px; margin: auto; min-height: 300px;">

                                <!-- Image with Status Badge on Top Right -->
                                <div class="position-relative">
                                    <a href="/event?id=<?= $event['id']; ?>" class="text-decoration-none text-dark">
                                        <img src="<?= '/' . htmlspecialchars($event['image']); ?>" class="card-img-top"
                                            style="height: 140px; object-fit: cover;">
                                    </a>
                                    <span class="badge position-absolute top-0 end-0 m-2 
                                    <?= $event['is_full'] ? 'bg-danger' : 'bg-success'; ?>"
                                        style="font-size: 0.75em; padding: 6px 10px;">
                                        <?= $event['is_full'] ? 'Closed' : 'Open'; ?>
                                    </span>
                                </div>
                                <a href="/event?id=<?= $event['id']; ?>" class="text-decoration-none text-dark">
                                    <div class="card-body flex-grow-1">
                                        <h5 class="card-title text-truncate"><?= htmlspecialchars($event['name']); ?></h5>
                                        <p class="card-text"><strong>Date:</strong> <?= date("F d, Y", strtotime($event['date'])); ?></p>
                                        <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                                        <p class="card-text text-truncate"><?= htmlspecialchars($event['description']); ?></p>
                                    </div>
                                </a>
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