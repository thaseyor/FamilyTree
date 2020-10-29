<script type='text/javascript'>
function addBlock(){
    $.post(
    "handler.php",
   {
     create: 'true'
   }
 );
 window.location = 'tree.php';
}
</script>