<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


$routes = [
    '/' =>  'index.view.php',
    '/login' => 'controllers/authentication/login.php',
    '/register' => 'controllers/authentication/register.php',
    '/dashboard' => 'controllers/authentication/dashboard.php',
    '/logout' => 'controllers/authentication/logout.php',
    '/admin/events' => 'controllers/events/index.php',
    '/admin/event' => 'controllers/events/show.php',
    '/admin/events/create' => 'controllers/events/create.php',
    '/admin/events/store' => 'controllers/events/store.php',
    '/admin/events/delete' => 'controllers/events/delete.php',
    '/admin/events/edit' => 'controllers/events/edit.php',
    '/admin/events/update' => 'controllers/events/update.php',
    '/admin/users' => 'controllers/users/index.php',
    '/admin/users/create' => 'controllers/users/create.php',
    '/admin/users/store' => 'controllers/users/store.php',
    '/admin/users/edit' => 'controllers/users/edit.php',

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
