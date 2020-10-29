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
  <div class='file is-centered'>
  <label class='file-label'>
    <input class='file-input' type='file' name='resume'>
    <span class='file-cta'>
      <span class='file-icon'>
        <i class='fas fa-upload'></i>
      </span>
      <span class='file-label'>
        Изменить фото…
      </span>
    </span>
  </label>
  </div>
  </div>
  <div class='column'><br><div>
  <button id='choseClr' class=".'"'."button jscolor {valueElement:'#FFF33F', onFineChange:'setTextColor(this,$row[0],2)'}".'"'.">Выберите цвет</button>
<input type='text' oninput='setTextColor(0,$row[0],1)' id='hex' value='$row[7]' style='width:150px;' class='input'>
  </div>
  </div>
</div></div></section>
<div class='modal' id='modal'>
  <div class='modal-background'></div>
  <div class='modal-content'>
    <div class='box'>
      <div class='columns'>
        <div class='column' style='text-align: center;'>
          <p class='bd-notification is-info'>Вы уверены?</p>
          <div class='columns is-mobile'>
            <div class='column'>
              <button class='button is-danger' onclick='deleteBlock($row[0])'>Да</button>
            </div>
            <div class='column'>
              <p class='bd-notification is-info'><button class='button is-danger' onclick='closeModal()'>Нет</button></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <button class='modal-close is-large' aria-label='close'></button>
</div>";
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
          echo "
          <div class='modal' id='modal_".substr($files[$j], 0, strrpos($files[$j], "."))."'>
  <div class='modal-background'></div>
  <div class='modal-content'>
  <img src='Photos/$row[0]/gallery/$files[$j]'alt='Image'>
  </div>
  <button class='modal-close is-large' aria-label='close' ></button>
</div>
          <div class='tile is-parent is-3 ' style='position:relative;'>
            <article class='tile is-child box'>
              <figure class='image is-256x256'>
                <img src='Photos/$row[0]/gallery/$files[$j]' style='padding-bottom:30px;cursor:pointer' onclick='toggle(".substr($files[$j], 0, strrpos($files[$j], ".")).")'  alt='Placeholder image'>
              </figure>
              
              <div class='control'  style='bottom:0;position:absolute;margin-bottom:20px;width:inherit'>
              <input class='input' type='text' onChange='fileNameChange(".'"'.substr($files[$j], 0, strrpos($files[$j], ".")).'"'.")' id='filename_".substr($files[$j], 0, strrpos($files[$j], "."))."' value='".substr($files[$j], 0, strrpos($files[$j], "."))."'>
              </div>
            </article>
          </div>
          ";
        }
      }
      echo '</div>'; 
  }
  echo "</div>";
}
echo "
<div class='buttons has-addons is-centered '><button class='button is-danger' onclick='openModal()'>Удалить</button></div>
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
  function openModal(){
    document.getElementById('modal').classList.add('is-active');
  }
  function closeModal(){
    document.getElementById('modal').classList.remove('is-active');
  }
  function toggle(id){
    document.getElementById('modal_'+id).classList.add('is-active');
  }
  function fileNameChange(number){
    var newValue = document.getElementById('filename_'+number).value;
    if(newValue!=''){
    var oldValue = number;
    $.post(
      'handler.php',
     {
       id: $row[0],
       newValue:newValue,
       oldValue:oldValue
     }
   );}
  }
    </script>
 
";
    }
      mysqli_free_result($result);
  }
?>
