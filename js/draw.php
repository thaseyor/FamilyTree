<script type='text/javascript'>
document.documentElement.style.overflowX = "scroll";
if(typeof(localStorage.getItem('connectHandler')) != "undefined" && localStorage.getItem('connectHandler') !== null){
    document.getElementById('ico_'+localStorage.getItem('connectHandler')).style.color='Dodgerblue';
}

var canvas = document.getElementById("canvas");
<?php
$sql ="SELECT MAX( X ) as X FROM `familytree`";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array( $result );
$maxX = $row['X'];
$sql ="SELECT MAX( Y ) as Y FROM `familytree`";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array( $result );
$maxY = $row['Y'];
 $sql ="SELECT MIN( X ) as X FROM `familytree`";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array( $result );
$minX = $row['X'];
$sql ="SELECT MIN( Y ) as Y FROM `familytree`";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array( $result );
$minY = $row['Y'];
echo "
var deltaX=$minX ;
var deltaY=$minY;
 canvas.style.left = deltaX-1 + 'px';
 canvas.style.top = deltaY -1 + 'px';
 width =$maxX - $minX;
 height =$maxY - $minY;
 canvas.height = height+101;
 canvas.width  = width+303;
";
?>
 ctx = canvas.getContext('2d');
ctx.lineWidth = 4 ;

function connect(id){
if(typeof(localStorage.getItem('connectHandler')) != "undefined" && localStorage.getItem('connectHandler') !== null){
    $.post(
    "handler.php",
   {
    firstId: localStorage.getItem('connectHandler'),
    secondId: id
   }
 );
 document.getElementById('ico_'+localStorage.getItem('connectHandler')).style.removeProperty("color");
 drawLines(localStorage.getItem('connectHandler'),id);
    localStorage.clear('connectHandler');  
}
else{
    document.getElementById('ico_'+id).style.color='Dodgerblue';
    localStorage.setItem('connectHandler', id);
}
}
 
function drawLines(firstId,secondId){
 ctx.beginPath();
 x1=document.getElementById('block_'+firstId).style.left.replace('px', '') - deltaX + 300;
 y1=document.getElementById('block_'+firstId).style.top.replace('px', '')-deltaY + document.getElementById('block_'+firstId).clientHeight/2;
 x2=document.getElementById('block_'+secondId).style.left.replace('px', '') - deltaX + 300;
 y2=document.getElementById('block_'+secondId).style.top.replace('px', '') - deltaY + document.getElementById('block_'+secondId).clientHeight/2;
 ctx.moveTo( x1 , y1);
 ctx.lineTo(x2, y2);
 ctx.stroke();
}
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
function toggle(id){
  document.getElementById('modal_'+id).classList.add("is-active");
  document.documentElement.classList.add("is-clipped");
}
function remove(){
  document.documentElement.classList.remove("is-clipped");
  document.documentElement.style.overflowX = "scroll";
}
</script>