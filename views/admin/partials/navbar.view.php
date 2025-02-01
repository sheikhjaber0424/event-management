<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a href="/" class="text-decoration-none">
            <h3 class="navbar-brand">Eventify</h3>
        </a>

        <!-- Dropdown for Logout on large screens -->
        <div class="dropdown d-none d-lg-block logout">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <?php
                echo $_SESSION['user_name'] ?>
            </a>
            <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/">Visit Site</a></li>
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>