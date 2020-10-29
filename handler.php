<?php 
require_once('config.php');

if(isset($_POST['y'])){
    $y = $_POST['y'];
    $x = $_POST['x'];
    $id = $_POST['id'];
    $query ="UPDATE `familytree` SET `X`='$x',`Y`='$y' WHERE id='$id'";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    mysqli_close($link);
}

if(isset($_POST['row'])){
    $data = $_POST['data'];
    $row = $_POST['row'];
    $id = $_POST['id'];

    $query ="UPDATE `familytree` SET `$row`='$data' WHERE id='$id'";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    mysqli_close($link);
}

if(isset($_POST['firstId'])){
    $firstId = $_POST['firstId'];
    $secondId = $_POST['secondId'];

    $pass=true;
    $sql = "SELECT `connections` FROM `familytree` WHERE `id`='$secondId'";
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    $connection =explode( " ",$row['connections']);
    for($i=0;$i<count($connection);$i++){
        if($connection[$i]==$firstId){
            $pass=false;
        }
    }

    $sql = "SELECT `connections` FROM `familytree` WHERE `id`='$firstId'";
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    $connection =explode( " ",$row['connections']);
    for($i=0;$i<count($connection);$i++){
        if($connection[$i]==$secondId){
            $pass=false;
        }
    }

    if($firstId==$secondId){
        $pass=false;
    }

    if($pass==true){
        if(empty($row['connections'])){
            $connections= $secondId;
        }else{
            $connections= $row['connections']." ".$secondId;
        }
        $query ="UPDATE `familytree` SET `connections`='$connections' WHERE id='$firstId'";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    }
    mysqli_close($link);
}

if(isset($_POST['picker'])){
    $picker =$_POST['picker'];
    $id= $_POST['id'];
    $query ="UPDATE `familytree` SET `color`='$picker' WHERE id=$id";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    mysqli_close($link);
}
if(isset($_POST['connection'])){
    $connectionDeleted =$_POST['connection'];
    $id= $_POST['id'];
    $sql = "SELECT `connections` FROM `familytree` WHERE `id`='$id'";
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    $connection =explode( " ",$row['connections']);
    for($i=0;$i<count($connection);$i++){
        if($connection[$i]!=$connectionDeleted){
            if($finalConnections==""){$finalConnections.=$connection[$i];}
            else{$finalConnections.=" ".$connection[$i];}
        }
    }
    $query ="UPDATE `familytree` SET `connections`='$finalConnections' WHERE id=$id";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    mysqli_close($link);
}
if(isset($_POST['create'])){
    $query ="SELECT `id` FROM `familytree` WHERE 1";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    $rows = mysqli_num_rows($result);
    $id = 1;
     for ($i = 0 ; $i < $rows ; ++$i)
   {
       $row = mysqli_fetch_row($result);
       if($id == $row[0])
       {
           $id =$id+1;
       }
       else{
           break;
       }
   }
   $query ="INSERT INTO `familytree`(`id`,`X`, `Y`) VALUES ('$id','100','100')";
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
   mysqli_close($link);
}
if(isset($_POST['delete'])){
    $id=$_POST['delete'];
    $query ="DELETE FROM `familytree` WHERE id = '$id'";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    $sql = "SELECT * FROM `familytree`";
    $result = mysqli_query($link,$sql);
    $rows = mysqli_num_rows($result);
    for ($i = 0 ; $i < $rows ; ++$i)
   {
    $finalConnections="";
       $row = mysqli_fetch_row($result);
    $connection =explode( " ",$row[8]);
    for($b=0;$b<count($connection);$b++){
        if($connection[$b]!=$id){
            if($finalConnections==""){$finalConnections.=$connection[$b];}
            else{$finalConnections.=" ".$connection[$b];}
        }
    }
    $current_id=$row[0];
    $query ="UPDATE `familytree` SET `connections`='$finalConnections' WHERE id='$current_id'";
    $result2 = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
   }
   mysqli_close($link);
}

if(isset($_POST['newValue'])){
    $id= $_POST['id'];
$newValue= $_POST['newValue'].'.png';
$oldValue=$_POST['oldValue'].'.png';
$dir    = 'Photos/'. $id. '/gallery'.'/';
if(file_exists($newValue)) 
 {  
   echo "Error While Renaming $oldValue" ; 
 } 
else
 { 
   if(rename( $dir.$oldValue, $dir.$newValue)) 
     {  
        echo "Successfully Renamed $oldValue to $newValue" ; 
     } 
     else
     { 
        echo "A File With The Same Name Already Exists" ; 
     } 
  } 
}
?>