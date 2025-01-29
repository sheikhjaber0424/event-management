<?php

require('functions.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


// dd($uri);
// if ($uri == '/') {
//     require('index.view.php');
// } elseif ($uri == '/login') {
//     require('controllers/authentication/login.php');
// } elseif ($uri == '/register') {
//     require('controllers/authentication/register.php');
// } elseif ($uri == '/dashboard') {
//     require('controllers/authentication/dashboard.php');
// } elseif ($uri == '/logout') {
//     require('controllers/authentication/logout.php');
// }
$routes = [
    '/' =>  'index.view.php',
    '/login' => 'controllers/authentication/login.php',
    '/register' => 'controllers/authentication/register.php',
    '/dashboard' => 'controllers/authentication/dashboard.php',
    '/logout' => 'controllers/authentication/logout.php'
];

if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
}
