
<script type='text/javascript'>
<?php 

$query ="SELECT * FROM `familytree`";
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
   if($result)
{
  $rows = mysqli_num_rows($result); // количество полученных строк
  for ($i = 0 ; $i < $rows ; ++$i)
  {
      $row = mysqli_fetch_row($result);
echo "dragElement(document.getElementById('block_$row[0]'),$row[0]);";
    }
      mysqli_free_result($result);
  }
?>
  function dragElement(elmnt,id) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    new_y=(elmnt.offsetTop - pos2);
    new_x=(elmnt.offsetLeft - pos1);
    elmnt.style.top =  new_y + "px";
    elmnt.style.left = new_x + "px";
    
 ctx.clearRect(0, 0, canvas.width, canvas.height);
 <?php
$query ="SELECT * FROM `familytree` ORDER BY `familytree`.`id` ASC";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
$rows = mysqli_num_rows($result); // количество полученных строк
for ($i = 0 ; $i < $rows ; ++$i)
{
   $row = mysqli_fetch_row($result);
   if($row){
    if(!empty($row[8])&&$row[8]!=" "){
        $connection= explode( " ",$row[8]);
        for($i=0;$i<count($connection);$i++){
            echo "drawLines($row[0],$connection[$i]);\n";
        }
    }
}
}}
?>
  }

  function closeDragElement() {
	  $.post(
    "handler.php",
   {
     y: new_y,
     x: new_x,
     id: id
   }
 );
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
</script>