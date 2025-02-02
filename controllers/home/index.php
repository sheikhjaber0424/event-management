<?php
require_once('core/Database.php');
$config = require('core/config.php');
$db = new Database($config['database']);

$events = $db->query("SELECT * FROM events LIMIT 6")->fetchAll();


require('views/home/index.view.php');
