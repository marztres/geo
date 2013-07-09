<?php
	session_start();
	if ( isset( $_SESSION['usuario'] ) ) {
		header("Location: ./proyectos.php");
	} else {
		header("Location: ./login.php");
	}
?>