<?php
session_start();
session_destroy();
// header('Location: login.php');
header('Location: ../../controllers/authentication/login.php');
exit();
