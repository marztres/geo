<?php
require_once 'database.php';
class muestras extends DataBase {

	/*Mostrar lista de las diferentes muestras */
	function getMuestrasSondeo($idSondeos) {
		$retorno = false;
		$sql = "SELECT * FROM muestras WHERE fk_idsondeo='" . $this -> real_escape_string($idSondeos) . "' AND estado='1' ORDER BY profundidad_inicial,profundidad_final DESC";
		$respuesta = $this -> query($sql);
		if ($respuesta) {
			$matriz = array();
			while ($fila = $respuesta -> fetch_object()) {
				$matriz[] = $fila;
			}
			$retorno = $matriz;
		}
		return $retorno;
	}

	/*Agregar una nueva muestra */

	function addMuestras($descripcion_muestra, $profundidad_inicial, $profundidad_final, $numero_de_golpes, $box_relleno, $idsondeos) {
		$retorno = false;
		$sql = "SELECT profundidad_inicial,profundidad_final
				FROM muestras
	  			WHERE   fk_idsondeo ='$idsondeos' ORDER BY profundidad_inicial,profundidad_final DESC";
		/* Si hay respuesta se guardan todas las profundidas iniciales y las finales en el array aux */
		if ($respuesta = $this -> query($sql)) {
			$aux = array();
			while ($fila = $respuesta -> fetch_array()) {
				array_push($aux, $fila['profundidad_inicial']);
				array_push($aux, $fila['profundidad_final']);
				//$aux[]= $fila['profundidad_inicial'];
				//$aux[]= $fila['profundidad_final'];
			}
			$posicion = count($aux);
			//if($posicion>1){
			sort($aux);
			/* Se ordena el array desde la posición menor a la mayor */
			//}
			$k = 0;
			/* Se obtiene el número de la posición y se calcula el número menor*/
			for ($i = 0; $i < $posicion; $i++) {
				if ($aux[$i] < $profundidad_inicial) {
					$numero_menor = $aux[$i];
					$k = $i + 1;
				}
			}
			/* Si la profundidad inicial es mayor al ultimo numero de la base de datos en la profundida final se agrega */
			
			
			if ($profundidad_inicial > $aux[$k]) {
				$retorno = true;
				$sql = "INSERT INTO muestras (id_muestra,profundidad_inicial,profundidad_final,descripcion,material_de_relleno,numero_golpes,estado,fk_idsondeo)" . "VALUES (NULL,'" . $this -> real_escape_string($profundidad_inicial) . "','" . $this -> real_escape_string($profundidad_final) . "','" . $this -> real_escape_string($descripcion_muestra) . "','" . $this -> real_escape_string($box_relleno) . "','" . $this -> real_escape_string($numero_de_golpes) . "','" . $this -> real_escape_string('1') . "','" . $this -> real_escape_string($idsondeos) . "')";
				$respuesta = $this -> query($sql);
			}
			/* Si k es par es decir si esta en la posición de profundidad final ingresa */
			else if ($k % 2 == 0) {
				if ($profundidad_final < $aux[$k]) {
					$retorno = true;
					$sql = "INSERT INTO muestras (id_muestra,profundidad_inicial,profundidad_final,descripcion,material_de_relleno,numero_golpes,estado,fk_idsondeo)" . "VALUES (NULL,'" . $this -> real_escape_string($profundidad_inicial) . "','" . $this -> real_escape_string($profundidad_final) . "','" . $this -> real_escape_string($descripcion_muestra) . "','" . $this -> real_escape_string($box_relleno) . "','" . $this -> real_escape_string($numero_de_golpes) . "','" . $this -> real_escape_string('1') . "','" . $this -> real_escape_string($idsondeos) . "')";
					$respuesta = $this -> query($sql);
				}
			}
		}/*Si no hay respuesta quiere decir que no existe nada en la base de datos y se puede ingresar la muestra*/
		else {
			$retorno = true;
			$sql = "INSERT INTO muestras (id_muestra,profundidad_inicial,profundidad_final,descripcion,material_de_relleno,numero_golpes,estado,fk_idsondeo)" . "VALUES (NULL,'" . $this -> real_escape_string($profundidad_inicial) . "','" . $this -> real_escape_string($profundidad_final) . "','" . $this -> real_escape_string($descripcion_muestra) . "','" . $this -> real_escape_string($box_relleno) . "','" . $this -> real_escape_string($numero_de_golpes) . "','" . $this -> real_escape_string('1') . "','" . $this -> real_escape_string($idsondeos) . "')";
			$respuesta = $this -> query($sql);
		}
		return $retorno;
	}

	/* Modificar muestras*/

	function ModificarMuestras($descripcion_muestra, $profundidad_inicial, $profundidad_final, $numero_de_golpes, $box_relleno, $idsondeos, $id_muestra) {
		$retorno = false;
		$sql = "SELECT profundidad_inicial,profundidad_final
				FROM muestras
	  			WHERE   fk_idsondeo ='$idsondeos' AND id_muestra!='$id_muestra' ORDER BY profundidad_inicial,profundidad_final DESC";
		/* Si hay respuesta se guardan todas las profundidas iniciales y las finales en el array aux */
		if ($respuesta = $this -> query($sql)) {
			$aux = array();
			while ($fila = $respuesta -> fetch_array()) {
				array_push($aux, $fila['profundidad_inicial']);
				array_push($aux, $fila['profundidad_final']);
				//$aux[]= $fila['profundidad_inicial'];
				//$aux[]= $fila['profundidad_final'];
			}
			$posicion = count($aux);
			//if($posicion>1){
			sort($aux);
			/* Se ordena el array desde la posición menor a la mayor */
			//}
			$k = 0;
			/* Se obtiene el número de la posición y se calcula el número menor*/
			for ($i = 0; $i < $posicion; $i++) {
				if ($aux[$i] < $profundidad_inicial) {
					$numero_menor = $aux[$i];
					$k = $i + 1;
				}
			}
			/* Si la profundidad inicial es mayor al ultimo numero de la base de datos en la profundida final se agrega */
			
			
			if ($profundidad_inicial > $aux[$k]) {
				$retorno = true;
					$sql = "UPDATE muestras SET profundidad_inicial='$profundidad_inicial', profundidad_final='$profundidad_final', descripcion='$descripcion_muestra',material_de_relleno='$box_relleno', numero_golpes='$numero_de_golpes'  WHERE id_muestra='$id_muestra'";
					$respuesta = $this->query($sql);
			}
			/* Si k es par es decir si esta en la posición de profundidad final ingresa */
			else if ($k % 2 == 0) {
				if ($profundidad_final < $aux[$k]) {
					$retorno = true;
					$sql = "UPDATE muestras SET profundidad_inicial='$profundidad_inicial', profundidad_final='$profundidad_final', descripcion='$descripcion_muestra',material_de_relleno='$box_relleno', numero_golpes='$numero_de_golpes'  WHERE id_muestra='$id_muestra'";
					$respuesta = $this->query($sql);
				}
			}
		}/*Si no hay respuesta quiere decir que no existe nada en la base de datos y se puede ingresar la muestra*/
		else {
			$retorno = true;
					$sql = "UPDATE muestras SET profundidad_inicial='$profundidad_inicial', profundidad_final='$profundidad_final', descripcion='$descripcion_muestra',material_de_relleno='$box_relleno', numero_golpes='$numero_de_golpes'  WHERE id_muestra='$id_muestra'";
					$respuesta = $this->query($sql);
		}
		return $retorno;
	}

}
?>