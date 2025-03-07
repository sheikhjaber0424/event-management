<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand text-decoration-none" href="/">Eventify</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/events">Events</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($_SESSION['user_name']); ?> <!-- Display username -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if (isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] === 1 || $_SESSION['is_admin'] === 2)): ?>
                                <li><a class="dropdown-item text-decoration-none" href="/admin/dashboard">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endif; ?>
                            <li>
                                <form action="/logout" method="POST" class="d-inline">
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>