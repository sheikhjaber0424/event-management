<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login'); // Redirect to login page if not logged in
    exit();
}


require('views/authentication/dashboard.view.php');
