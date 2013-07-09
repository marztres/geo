<?php

require_once 'database.php';

class usuarios extends DataBase {

	function getUsuariosProyectos() {
		$retorno = false;
		$sql = "SELECT * FROM usuarios where tipo='Ingeniero' ";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$matriz = array();
			while ( $fila = $respuesta->fetch_object() ) {
				$matriz[] = $fila;
			}
			$respuesta->free();
			$retorno = $matriz;
		}
		return $retorno;
	}

}
?>