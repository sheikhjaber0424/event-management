<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


$routes = [
    '/' =>  'index.view.php',
    '/login' => 'controllers/authentication/login.php',
    '/register' => 'controllers/authentication/register.php',
    '/dashboard' => 'controllers/authentication/dashboard.php',
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

];



function routeToController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort()
{
    http_response_code(404);

    echo "Page not found!";

    die();
}

routeToController($uri, $routes);
