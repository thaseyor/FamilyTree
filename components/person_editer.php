<?php
$query ="SELECT * FROM `familytree` where id=".$_GET['id'];
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
   if($result)
{
  $rows = mysqli_num_rows($result); // количество полученных строк
  for ($i = 0 ; $i < $rows ; ++$i)
  {
      $row = mysqli_fetch_row($result);
echo "
<div style='min-height:3.25rem'></div>
<section class='section'>
    <div class='container'>
    <div class='content'>
    <div class='field is-horizontal'>
        <div class='field-label is-normal'>
          <label class='label'>ФИО</label>
        </div>
        <div class='field-body'>
          <div class='field'>
            <div class='control'>
              <input class='input' id='Name' oninput=".'"'."dataChange('Name')".'"'." value='$row[3]' type='text'>
            </div>
          </div>
        </div>
      </div>
    <div class='field is-horizontal'>
        <div class='field-label is-normal'>
          <label class='label'>Дата Рождения</label>
        </div>
        <div class='field-body'>
          <div class='field'>
            <div class='control'>
              <input class='input' id='Birthday' oninput=".'"'."dataChange('Birthday')".'"'." value='$row[4]' type='text'>
            </div>
          </div>
        </div>
    </div>      
    <div class='field is-horizontal'>
        <div class='field-label is-normal'>
          <label class='label'>Дата Смерти</label>
        </div>
        <div class='field-body'>
          <div class='field'>
            <div class='control'>
              <input class='input' id='Deathday' oninput=".'"'."dataChange('Deathday')".'"'." value='$row[6]' type='text'>
            </div>
          </div>
        </div>
    </div> <br>
    <div class='container'>
    <label class='label'>
      <strong>Дополнительная информация:</strong>
      </label> 
      <textarea class='textarea' rows='18' id='Description' oninput=".'"'."dataChange('Description')".'"'."name='comment'>$row[5]</textarea>
      </div>
    </div>
</div><br>
<div class='container'>
<div class='columns'>
  <div class='column'>
    <strong>Связи:</strong><br>
    
    <div class='select' style='margin-bottom:9px;'>
      <select id='connection' class='input'>
        ";
        if(!empty($row[8])&&$row[8]!=" "){
          $connection= explode( " ",$row[8]);
          for($i=0;$i<count($connection);$i++){
            $sql = "SELECT * FROM `familytree` WHERE `id`='$connection[$i]'";
            $result2 = mysqli_query($link,$sql);
            $row2 = mysqli_fetch_assoc($result2);
            echo "<option id='option_$connection[$i]' value='$connection[$i]'>".$row2['Name']."</option>";
          }
      }
        echo "
      </select>
    </div>
    <button class='button' onclick='deleteConnection();'>Удалить</button>
  </div>

  <div class='column'><br>
  <form action='person.php?id=$row[0]&change=true' enctype='multipart/form-data' method='post' id='formMain'>
  <div class='file is-centered'>
  <label class='file-label'>
    <input class='file-input' id='fileMain' type='file' name='file'>
    <span class='file-cta'>
      <span class='file-icon'>
        <i class='fas fa-upload'></i>
      </span>
      <span class='file-label'>
        Изменить главное фото
      </span>
    </span>
  </label>
  </div>
  </form>
  <div class='buttons has-addons is-centered ' style='margin-top:8px;'><button class='button is-danger' onclick="."'".'toggle("deletePhoto")'."'".">Удалить главное фото</button></div>
  </div>
  
  <div class='column'><br><div>
  <button id='choseClr' class=".'"'."button jscolor {valueElement:'#FFF33F', onFineChange:'setTextColor(this,$row[0],2)'}".'"'.">Выберите цвет</button>
<input type='text' oninput='setTextColor(0,$row[0],1)' id='hex' value='$row[7]' style='width:150px;' class='input'>
  </div>
  </div>
</div>

<div class='column'>
<form action='person.php?id=$row[0]&change=true' enctype='multipart/form-data' method='post' id='formGallery'>
<div class='file is-centered'>
<label class='file-label'>
  <input class='file-input' id='fileGallery' type='file' name='galleryPhoto'>
  <span class='file-cta'>
    <span class='file-icon'>
      <i class='fas fa-upload'></i>
    </span>
    <span class='file-label'>
      Добавить фото в галлерею
    </span>
  </span>
</label>
</div>
</form></div>
</div></section>

<div class='modal' id='modal_deleteAll'>
  <div class='modal-background'></div>
  <div class='modal-content'>
    <div class='box'>
      <div class='columns'>
        <div class='column' style='text-align: center;'>
          <p class='bd-notification is-info'>Вы уверены?</p>
          <div class='columns is-mobile'>
            <div class='column'>
              <button class='button is-danger' onclick='deleteBlock($row[0])'>Да, удалить</button>
            </div>
            <div class='column'>
              <p class='bd-notification is-info'><button class='button is-danger' onclick="."'".'closeModal("deleteAll")'."'".">Нет, отмена</button></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <button class='modal-close is-large' aria-label='close'></button>
</div>
<div class='modal' id='modal_deletePhoto'>
  <div class='modal-background'></div>
  <div class='modal-content'>
    <div class='box'>
      <div class='columns'>
        <div class='column' style='text-align: center;'>
          <p class='bd-notification is-info'>Вы уверены?</p>
          <div class='columns is-mobile'>
            <div class='column'>
              <button class='button is-danger' onclick='deletePhoto($row[0])'>Да, удалить</button>
            </div>
            <div class='column'>
              <p class='bd-notification is-info'><button class='button is-danger' onclick="."'".'closeModal("deletePhoto")'."'".">Нет, отмена</button></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <button class='modal-close is-large' aria-label='close'></button>
</div>
";
$dir    = 'Photos/'. $row[0]. '/gallery';
if (file_exists($dir)) {
  $files = scandir($dir);
  unset($files[0]);
  unset($files[1]);
  echo '<div class="tile is-ancestor is-vertical" style="margin-left:0.75rem;margin-right:0.75rem;">';
  $a=ceil(count($files)/4);
  for($i=1;$i<($a+1);$i++ ) {
    echo "<div class='tile'>";
      for($j=(4*$i)-2;$j<(4*$i)+2;$j++){
        if(isset($files[$j])){
          $imgName=substr($files[$j], 0, strrpos($files[$j], "."));
          $query1 ="SELECT `description` FROM `photos` WHERE img='$imgName' AND person='$row[0]'";
    $result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link)); 
    $row1= mysqli_fetch_assoc($result1);
if(!empty($row1['description'])){
    $description = $row1['description'];
  }
  else{
    $description = '';
  }
          echo "
          <div class='modal' id='modal_".$imgName."'>
  <div class='modal-background'></div>
  <div class='modal-content'>
  <img src='Photos/$row[0]/gallery/$files[$j]'alt='Image'>
  </div>
  <button class='modal-close is-large' aria-label='close' ></button>
</div>
          <div class='tile is-parent is-3 ' id='tile_$imgName' style='position:relative;'>
            <div class='tile is-child box'>
            <a class='delete ' style='position:absolute;z-index:10;right:1.5rem;margin-top:-0.5rem;background-color:hsl(348, 100%, 61%)' onClick='deletePhotoFromGallery($imgName,$row[0])' onMouseOver=".'"'."this.style.backgroundColor= 'hsl(348, 100%, 41%)'".'"'."
            onMouseOut=".'"'."this.style.backgroundColor='hsl(348, 100%, 61%)'".'"'."></a>
              <figure class='image is-256x256'>
                <img src='Photos/$row[0]/gallery/$files[$j]' style='padding-bottom:60px;cursor:pointer' onclick='toggle(".$imgName.")'  alt='Placeholder image'>
              </figure>

              <div class='control mb-4'  style='bottom:0;position:absolute;width:80%'>
              <div class='field is-horizontal'>
              <textarea  class='textarea has-fixed-size' rows='2' placeholder='Description' oninput='fileDescriptionChange(".'"'.$imgName.'"'.")' id='filename_".$imgName."'>$description</textarea>
              </div></div>
            </div>
          </div>
          ";
        }
      }
      echo '</div>'; 
  }
  echo "</div>";
}
echo "
<div class='buttons has-addons is-centered '><button class='button is-danger' onclick=".'"'."toggle('deleteAll')".'"'.">Удалить</button></div>
<script src='js/jscolor.js'></script>
<script>
function recolor(){
  document.getElementById('choseClr').style.backgroundColor = '$row[7]';
  
  var color = Math.round(((parseInt(hexToRgb('$row[7]').r ) * 299) + 
  (parseInt(hexToRgb('$row[7]').g ) * 587) + 
  (parseInt(hexToRgb('$row[7]').b ) * 114)) / 1000); 
var textColor = (color > 125) ? 'black' : 'white'; 
document.getElementById('choseClr').style.color = textColor;
}
    function dataChange(row){

      data=document.getElementById(row).value;
      $.post(
        'handler.php',
       {
         data: data,
         row:row,
         id: $row[0]
       }
     );
    }

    function setTextColor(picker, id, option) {

      if(option== 2){
      picker ='#'+picker;
      document.getElementById('hex').value =picker;
      $.post(",
      '"handler.php"',",
      {
        picker: picker,
        id:id
      }
    );}

      if(option== 1){
      picker = document.getElementById('hex').value;
      document.getElementById('choseClr').style.backgroundColor = picker;
          $.post(",
      '"handler.php"',",
      {
        picker: picker,
        id:id
      }
    );}
  }
  function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
  }
  function deleteConnection(){
   var connection=document.getElementById('connection').value;
   document.getElementById('option_'+connection).remove()
   $.post(",
      '"handler.php"',",
      {
        connection: connection,
        id:$row[0]
      }
    );
  }
  if('$row[7]'!=''){
    document.addEventListener('DOMContentLoaded', recolor);
  }
  function closeModal(id){
    document.getElementById('modal_'+id).classList.remove('is-active');
  }
  function toggle(id){
    document.getElementById('modal_'+id).classList.add('is-active');
  }
  function fileDescriptionChange(number){
    var description = document.getElementById('filename_'+number).value;
    $.post(
      'handler.php',
     {
       person: $row[0],
       description:description,
       img:number
     }
   );
  }
  document.getElementById('fileMain').onchange = function() {
    document.getElementById('formMain').submit();
  };
  document.getElementById('fileGallery').onchange = function() {
    document.getElementById('formGallery').submit();
  };
    </script>
 
";
$id = $row[0];

$ds          = DIRECTORY_SEPARATOR;  //1
$storeFolder = 'Photos/'.$id;   //2
if (!empty($_FILES)) {
  if(isset($_FILES['file'])){
    $tempFile = $_FILES['file']['tmp_name'];          //3             
    if (file_exists($storeFolder)) {
      if(file_exists($storeFolder."/main.jpg")){
        unlink($storeFolder."/main.jpg");
        move_uploaded_file($tempFile,$storeFolder."/main.jpg");
      }
      else{
        move_uploaded_file($tempFile, $storeFolder."/main.jpg");
      }
    }
    else{
    mkdir("Photos/$id");
    move_uploaded_file($tempFile, $storeFolder."/main.jpg");
    }
  }
  if(isset($_FILES['galleryPhoto'])){
    $tempFile = $_FILES['galleryPhoto']['tmp_name'];          //3 
    $NewPhotoNumber=1;            
    if (file_exists($storeFolder)) {
      if(file_exists($storeFolder."/gallery")){
        $files = scandir($dir);
        unset($files[0]);
        unset($files[1]);
        for($b=0;$b<count($files);++$b){
        foreach($files as $value){
          if ($NewPhotoNumber==$value){
            $NewPhotoNumber+=1;
          }
        }}
        move_uploaded_file($tempFile,$storeFolder."/gallery/$NewPhotoNumber.png");
      }
      else{
        mkdir("Photos/$id/gallery");
        move_uploaded_file($tempFile, $storeFolder."/gallery/$NewPhotoNumber.png");
      }
    }
    else{
    mkdir("Photos/$id");
    mkdir("Photos/$id/gallery");
    move_uploaded_file($tempFile, $storeFolder."/gallery/$NewPhotoNumber.png");
    }

    $query ="SELECT `id` FROM `photos` WHERE 1";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    $rows = mysqli_num_rows($result);
    $idNew = 1;
     for ($i = 0 ; $i < $rows ; ++$i)
   {
       $row = mysqli_fetch_row($result);
       if($idNew == $row[0])
       {
           $idNew =$idNew+1;
       }
       else{
           break;
       }
   }
   $query ="INSERT INTO `photos`(`id`,`person`, `img`) VALUES ('$idNew','$id','$NewPhotoNumber')";
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
   echo "<script> window.location = 'person.php?id=$id&change=true';</script>";
  }
}
    }
  }
?> 
