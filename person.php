
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
if(!isset($_GET['change'])){
  include "components/person_main.php";
}
else if($row['rights']=='editer'&&$_GET['change']==true){
    include "components/person_editer.php";
    include "js/deleteBlock.php";
}
require_once('components/footer.php');

mysqli_close($link);  
?>
    </section>
</div>