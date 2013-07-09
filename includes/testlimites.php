<?php

require_once 'database.php';

class testlimintes extends DataBase {
	
	function addTest( $tipoMuestra, $numCapsula, $pesoCapsula, $pesoCapsulaSueloHumedo, $pesoCapsulaSueloSeco, $golpes, $idMuestra ){
		$retorno = false;
		$sql = "INSERT INTO testlimites (id_test, tipo_muestra, nom_capsula, peso_capsula, peso_capsula_suelo_humedo, peso_capsula_suelo_seco, num_golpes, fecha_ingreso, estado, fk_id_muestra ) "
				."values (NULL, '".$this->real_escape_string($tipoMuestra)
				."', '".$this->real_escape_string($numCapsula)
				."', '".$this->real_escape_string($pesoCapsula)
				."', '".$this->real_escape_string($pesoCapsulaSueloHumedo)
				."', '".$this->real_escape_string($pesoCapsulaSueloSeco)
				."', '".$this->real_escape_string($golpes)
				."', NOW(), 1, '".$this->real_escape_string($idMuestra)."')";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function modificarTest( $idTest,$nom_capsula, $peso_capsula, $peso_capsula_suelo_humedo, $peso_capsula_suelo_seco, $num_golpes){
		$retorno = false;
		echo $sql = "UPDATE testlimites  SET nom_capsula  = '".$this->real_escape_string($nom_capsula)."',
					   peso_capsula  = '".$this->real_escape_string($peso_capsula)."',
					   peso_capsula_suelo_humedo  ='".$this->real_escape_string($peso_capsula_suelo_humedo)."',
					   peso_capsula_suelo_seco  = '".$this->real_escape_string($peso_capsula_suelo_seco)."',
					   num_golpes  = '".$this->real_escape_string($num_golpes)."' 
					   WHERE id_test ='".$this->real_escape_string($idTest)."' ";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}
	
	function getLimitesMuestra( $idMuestra ) {
		$retorno = false;
		$sql = "SELECT * FROM testlimites WHERE fk_id_muestra=".$this->real_escape_string($idMuestra)." AND estado=1";
		if ( $registros = $this->query($sql) ) {
			$matriz = array();
			while ( $fila = $registros->fetch_object() ) {
				$matriz[] =  $fila;
			}
			$retorno = $matriz;
		}
		return $retorno;
	}

}

?>
