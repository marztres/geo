<?php

require_once 'database.php';

class pesos_retenidos extends DataBase {
	
	function addPesoRetenido( $tamiz,$tamanoTamiz, $pesoRetenido, $idGranulometria) {
		$retorno = false;
		$sql = "INSERT INTO pesosretenidos (idPesoRetenido,tamiz,tamanoTamiz,pesoRetenido,fk_id_granulometria)"
					."VALUES (NULL,'".$this->real_escape_string($tamiz)."','".$this->real_escape_string($tamanoTamiz)."','".$this->real_escape_string($pesoRetenido)
					."','".$this->real_escape_string($idGranulometria)."')";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function getDatoPesosRetenidos( $idGranulometria ) {
		$retorno = false;
		$sql = "SELECT * FROM pesosretenidos WHERE fk_id_granulometria='$idGranulometria' ORDER BY tamanoTamiz DESC";
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
	
	function updatePesosRetenido($idPesoRetenido,$pesoRetenido){
		$retorno = false;
		echo $sql = "UPDATE pesosretenidos SET 
  	  pesoRetenido = '".$this->real_escape_string($pesoRetenido)."'
    	WHERE 
      idPesoRetenido = '".$this->real_escape_string($idPesoRetenido)."' ";
	  $respuesta = $this -> query($sql);
	  if ( $respuesta ) {
	    $retorno = true;
	  }
	  return $retorno;
  }
	
}
?>