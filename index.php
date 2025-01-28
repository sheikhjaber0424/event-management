<?php

require('functions.php');

$uri = $_SERVER['REQUEST_URI'];


if ($uri == '/') {
    require('index.view.php');
} elseif ($uri == '/login') {
    require('controllers/authentication/login.php');
} elseif ($uri == '/register') {
    require('controllers/authentication/register.php');
} elseif ($uri == '/dashboard') {
    require('controllers/authentication/dashboard.php');
} elseif ($uri == '/logout') {
    require('controllers/authentication/logout.php');
}
