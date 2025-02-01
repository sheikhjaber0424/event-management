<?php

require_once('core/Database.php');
require_once('core/functions.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$eventId = $_GET['id'] ?? null;
$config = require('core/config.php');
$db = new Database($config['database']);

$event = $db->query("SELECT name, capacity FROM events WHERE id = ?", [$eventId])->fetch();

if (!$event) {
    die("Event not found.");
}


require('views/events/register.view.php');
