<?php
session_start();
require_once('config.php');
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $logged = false;
} else {
    $logged = true;
}


require_once('components/header.php');
require_once('components/main.php');
require_once('components/footer.php');
