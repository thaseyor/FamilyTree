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
<article class='media'>
  <div class='media-left'>
    <figure class='image is-128x128'>";
    if(file_exists("Photos/$row[0]/main.jpg")){
      echo " <a href='Photos/$row[0]/main.jpg'><img src='Photos/$row[0]/main.jpg' onclick='header(Photos/$row[0]/main.jpg)' alt='Image'></a>";
    }
    else{
      echo "<img src='https://bulma.io/images/placeholders/64x64.png' alt='Image'>";
    }
    echo "</figure>
  </div>
  <div class='media-content'>
    <div class='content'>
      <p>
        <strong>$row[3]</strong>
        <br>
        Дата Рождения: $row[4]<br>";
        
        if(!empty($row[6])){
          echo "Дата Смерти: $row[6]";
      };
      echo "
      </p>
    </div>
    </div>
    </article>
    </div>
    </div>
    </section>
    <section class='section'>
    <div class='container'>
    <strong>Дополнительная информация:</strong>
      <textarea class='textarea' readonly rows='18' name='comment'  id='informChange'>$row[5]</textarea>
      </div>
    </section>
";
$dir    = 'Photos/'. $row[0]. '/gallery';
if (file_exists($dir)) {
  $files = scandir($dir);
  unset($files[0]);
  unset($files[1]);
  echo '<div class="tile is-ancestor is-vertical" style="margin-left:0.75rem;">
  ';
  $a=ceil(count($files)/4);
  for($i=1;$i<($a+1);$i++ ) {
    echo "<div class='tile'>";
      for($j=(4*$i)-2;$j<(4*$i)+2;$j++){
        if(isset($files[$j])){
          echo "
          <div class='modal' id='modal_".substr($files[$j], 0, strrpos($files[$j], "."))."'>
  <div class='modal-background' onclick='remove()'></div>
  <div class='modal-content'>
  <img src='Photos/$row[0]/gallery/$files[$j]'alt='Image'>
  </div>
  <button class='modal-close is-large' aria-label='close' onclick='remove()'></button>
</div>
          <div class='tile is-parent is-3 ' style='position:relative;'>
            <article class='tile is-child box'>
              <figure class='image is-256x256'>
                <img src='Photos/$row[0]/gallery/$files[$j]' style='padding-bottom:20px;cursor:pointer' onclick='toggle(".substr($files[$j], 0, strrpos($files[$j], ".")).")'  alt='Placeholder image'>
              </figure>
              <p class='subtitle' style='bottom:0;position:absolute;padding-bottom:20px;'>".substr($files[$j], 0, strrpos($files[$j], "."))."</p>
            </article>
          </div>";
        }
      }
      echo '</div>'; 
  }
  echo "</div>
  <script>
  function toggle(id){
    document.getElementById('modal_'+id).classList.add('is-active');
    document.documentElement.classList.add('is-clipped');
  }
  function remove(){
    document.documentElement.classList.remove('is-clipped');
  }
  </script>
  ";
}
}
      mysqli_free_result($result);
  }
?>
