<script type='text/javascript'>
function deleteBlock(id){
    $.post(
    "handler.php",
   {
     delete: id
   }
 );
 window.location = 'tree.php';
}
function deletePhoto(id){
    $.post(
    "handler.php",
   {
     deletePhoto: id
   }
 );
 document.getElementById('modal_deletePhoto').classList.remove('is-active');
}
function deletePhotoFromGallery(numberOfPhoto,id){
  $.post(
    "handler.php",
   {
     deletePhotoFromGallery: numberOfPhoto,
     id:id
   }
 );
 document.getElementById('tile_'+numberOfPhoto).remove();
}
</script>