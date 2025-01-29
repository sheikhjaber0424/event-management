<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' =>  'index.view.php',
    '/login' => 'controllers/authentication/login.php',
    '/register' => 'controllers/authentication/register.php',
    '/dashboard' => 'controllers/authentication/dashboard.php',
    '/logout' => 'controllers/authentication/logout.php'
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
