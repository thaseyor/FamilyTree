
<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    $logged = false;
} else {
    $logged = true;
}
require_once('config.php');
require_once('components/header.php');

$sql = "SELECT `rights` FROM `users` WHERE `username`='".$_SESSION["username"]."'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);
if($row['rights']=='editer'){
  include "components/editer.php";
  require_once('js/move.php');
  require_once('js/draw.php');
  require_once('js/addBlock.php');
}else{
  include "components/user.php";
  require_once('js/draw.php');
}
require_once('components/footer.php');

mysqli_close($link);  
?>
    