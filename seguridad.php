<?php SESSION_START();
if($_SESSION['autentificado']!=1){
header("Location:index.php");	
}
?>