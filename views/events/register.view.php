<?php
require('views/partials/head.view.php');
require('views/partials/navbar.view.php');
?>

<main class="container mt-5">
    <h2 class="text-center text-success" id="register-header">Register for Event</h2>

    <div id="alert-container"></div>

    <?php
    // Calculate remaining available spots
    $remaining_spots = $event['capacity'] - $event['registration_count'];
    ?>

    <div id="form-container">
        <form id="registrationForm" class="form-container">
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($eventId); ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control border-success"
                    name="name" id="name" value="<?= htmlspecialchars($_SESSION['user_name']); ?>" required disabled>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control border-success"
                    name="email" id="email" value="<?= htmlspecialchars($_SESSION['user_email']); ?>" required disabled>
            </div>

            <div class="mb-3">
                <label for="tickets" class="form-label">Number of Tickets</label>
                <input type="number" class="form-control border-success"
                    name="tickets" id="tickets" value="1" min="1" max="<?= $remaining_spots; ?>" required
                    <?= $remaining_spots == 0 ? 'disabled' : ''; ?>>
            </div>


            <?php if ($remaining_spots > 0): ?>
                <button type="submit" class="btn btn-success w-100">Confirm Registration</button>
            <?php else: ?>
                <div class="alert alert-danger text-center">This event is fully booked.</div>
            <?php endif; ?>
        </form>

        <!-- Success Message Card (Hidden by Default) -->
        <div id="successMessage" class="d-none text-center">
            <div class="card p-4">
                <h3 class="text-success">Congratulations!</h3>
                <p>Your registration was successful!</p>
                <a href="/event?id=<?= htmlspecialchars($eventId); ?>" class="btn btn-success">Back to Event</a>
            </div>
        </div>

        <!-- Error Alert Container -->
        <div id="alertContainer"></div>


    </div>


    <div class="text-center mt-3">
        <p><a href="/event?id=<?= htmlspecialchars($eventId); ?>" id="back-event" class="text-success ">Back to Event</a></p>
    </div>
</main>



<?php require('views/partials/footer.view.php'); ?>