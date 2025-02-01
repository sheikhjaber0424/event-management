<?php


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' =>  'index.view.php',
    '/login' => 'controllers/authentication/login.php',
    '/register' => 'controllers/authentication/register.php',
    '/admin/dashboard' => 'controllers/authentication/dashboard.php',
    '/logout' => 'controllers/authentication/logout.php',
    '/admin/events' => 'controllers/admin/events/index.php',
    '/admin/event' => 'controllers/admin/events/show.php',
    '/admin/events/create' => 'controllers/admin/events/create.php',
    '/admin/events/store' => 'controllers/admin/events/store.php',
    '/admin/events/delete' => 'controllers/admin/events/delete.php',
    '/admin/events/edit' => 'controllers/admin/events/edit.php',
    '/admin/events/update' => 'controllers/admin/events/update.php',
    '/admin/users' => 'controllers/admin/users/index.php',
    '/admin/users/create' => 'controllers/admin/users/create.php',
    '/admin/users/store' => 'controllers/admin/users/store.php',
    '/admin/users/edit' => 'controllers/admin/users/edit.php',
    '/admin/users/update' => 'controllers/admin/users/update.php',
    '/admin/users/delete' => 'controllers/admin/users/delete.php',
    '/event' => 'controllers/events/show.php',
    '/events/register' => 'controllers/events/register.php',
    '/events/confirmation' => 'controllers/events/confirmation.php',
    '/events' => 'controllers/events/allEvents.php',
    '/admin/events/generate_report' => 'controllers/events/report.php',
    '/admin/attendees' => 'controllers/admin/attendees/index.php',
    '/api/events' => 'controllers/api/events.php',

];

/**
 * Restrict access to admin routes
 */
function checkAdminAccess($uri)
{
    if (strpos($uri, '/admin') === 0) { // If route starts with "/admin"
        if (!isset($_SESSION['is_admin']) || ($_SESSION['is_admin'] !== 1 && $_SESSION['is_admin'] !== 2)) {
            header("Location: /"); // Redirect to homepage if not admin
            exit();
        }
    }
}

/**
 * Route the request to the appropriate controller or view
 */
function routeToController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

/**
 * Show a 404 page if the route is not found
 */
function abort()
{
    http_response_code(404);
    echo "Page not found!";
    exit();
}

// Apply admin check before routing
checkAdminAccess($uri);

// Route the request
routeToController($uri, $routes);
