<?php
session_start();
require_once('config.php');
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $logged = false;
} else {
    $logged = true;
}

require_once('components/header.php');
$username54=$_SESSION['username'];
$sql = "SELECT * FROM users WHERE `username`='$username54'";
$data = mysqli_query($link, $sql);
$row = mysqli_fetch_array($data);
mysqli_close($link);  
require_once('components/footer.php');