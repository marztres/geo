<?php

require_once 'database.php';

class sondeos extends DataBase {

	function getListaSondeos( $idp ) {
		$retorno = false;
		$sql = "SELECT 
  `s`.`id_sondeo`,
  `s`.`nivel_freatico`,
  `s`.`profundidad_superficie`,
  `s`.`estado`,
  `s`.`fk_id_tipo_superficie`,
  `s`.`fk_idproyecto`,
  (SELECT count(*) FROM muestras WHERE fk_idsondeo=s.id_sondeo ) AS cantidad
FROM 
  `sondeos` `s`
  where fk_idproyecto='$idp' and estado='1' ";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$matriz = array();
			while ( $fila = $respuesta->fetch_object()) {
				$matriz[] = $fila; 
			}
			$retorno = $matriz;
		}
		return $retorno;
	}

	function getDatosSondeo($ids) {
		$retorno = false;
		$sql = "SELECT 
								  `s`.`id_sondeo`,
								  `s`.`nivel_freatico`,
								  `s`.`profundidad_superficie`,
								  `s`.`estado`,
								  `s`.`fk_id_tipo_superficie`,
								   sup.`tipo_superficie`,
								  `s`.`fk_idproyecto`

						FROM 	`sondeos` `s`,`tipo_superficie` sup
 					  WHERE s.`fk_id_tipo_superficie`=sup.`id_tipo_superficie` LIMIT 1";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = $respuesta->fetch_object();
		}
		return $retorno;
	}

	function addSondeo( $nivelFreatico,$profundidadSuperficie,$tipoSuperficie,$idProyecto) {
		$retorno = false;
		$sql = "INSERT INTO sondeos (id_sondeo, nivel_freatico , profundidad_superficie , estado, fk_id_tipo_superficie , fk_idproyecto) "
					."VALUES (NULL,'".$this->real_escape_string($nivelFreatico)."', '".$this->real_escape_string($profundidadSuperficie)."', '1', '".$this->real_escape_string($tipoSuperficie)."', '".$this->real_escape_string($idProyecto)."' )";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function eliminarSondeo($idSondeo) {
		$retorno = false;
		$sql = "UPDATE sondeos SET estado='0' WHERE id_sondeo='".$this->real_escape_string($idSondeo)."' ";
		$respuesta = $this-> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function getListaSuperficie() {
		$retorno = false;
		$sql = "SELECT * FROM tipo_superficie WHERE 1=1";
		$respuesta = $this-> query($sql);
		if ( $respuesta ) {
			$matriz = array();
			while ( $fila = $respuesta->fetch_object()) {
				$matriz[] = $fila; 
			}
			$retorno = $matriz;
		}
		return $retorno;
	}




}

?>
