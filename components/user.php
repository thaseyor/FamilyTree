<?php
echo "<canvas id='canvas' style='position:absolute;'></canvas>";
   $query ="SELECT * FROM `familytree` ORDER BY `familytree`.`id` ASC";
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
   if($result)
{
  $rows = mysqli_num_rows($result); // количество полученных строк
  echo '<div>';
  for ($i = 0 ; $i < $rows ; ++$i)
  {
      $row = mysqli_fetch_row($result);
echo "<div class='box' id='block_$row[0]' style='width:600px;position:absolute; top:$row[2]px; left: $row[1]px;'>
<article class='media'>
  <div class='media-left'>
    <figure class='image is-64x64'>";
    if(file_exists("Photos/$row[0]/main.jpg")){
      echo " <img src='Photos/$row[0]/main.jpg' onclick='toggle($row[0])' alt='Image'>
      <div class='modal' id='modal_$row[0]'>
  <div class='modal-background' onclick='setTimeout(remove, 200 )'></div>
  <div class='modal-content'>
  <img src='Photos/$row[0]/main.jpg' onclick='toggle($row[0])' alt='Image'>
  </div>
  <button class='modal-close is-large' aria-label='close' onclick='setTimeout(remove, 200 )'></button>
</div>
      ";
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
    <nav class='level is-mobile'>
      <div class='level-left'>
        <a class='level-item' href='person.php?id=$row[0]' aria-label='reply'>
          <span class='icon is-small'>
            <i class='fas fa-file'></i>
          </span>
        </a>
      </div>
    </nav>
  </div>";
if(!empty($row[7])){
 echo" <div class='media-right'>
  <div style='background: $row[7];height:32px;width:32px;border-radius: 50%;border:black solid .05px;'></div>
  </div>";
}
  echo "
</article>
</div>
";
    }
    echo "</div>";
      mysqli_free_result($result);
  }
?>