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
}
</script>