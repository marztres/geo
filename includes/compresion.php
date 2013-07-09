<?php

require_once 'database.php';

class Compresion extends DataBase {
	
	function addCompresion( $id_compresion,$diametro, $altura, $peso,$tipoFalla,$idMuestra ){
		$retorno = false;
		$sql = "INSERT INTO compresion (id_compresion,diametro,altura,peso,tipoFalla, fecha_ingreso,estado,fK_idmuestra) "
				."values (NULL, '".$this->real_escape_string($diametro)
				."', '".$this->real_escape_string($altura)
				."', '".$this->real_escape_string($peso)
				."', '".$this->real_escape_string($tipoFalla)
				."', NOW(), 1, '".$this->real_escape_string($idMuestra)."')";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function addDeformacion($id_compresion,$deformacion,$carga,$idCompresion ){
		$retorno = false;
		$sql = "INSERT INTO deformaciones (id_deformacion,deformacion,carga,fk_idcompresion) "
				."values (NULL, '".$this->real_escape_string($deformacion)
				."', '".$this->real_escape_string($carga)
				."', '".$this->real_escape_string($idCompresion)."')";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function modificarCompresion( $diametro,$altura,$peso,$tipoFalla,$id_compresion){
		$retorno = false;
		$sql = "UPDATE compresion SET diametro ='".$this->real_escape_string($diametro)."', altura='".$this->real_escape_string($altura)."', peso='".$this->real_escape_string($peso)."', tipoFalla='".$this->real_escape_string($tipoFalla)."'WHERE id_compresion=".$this->real_escape_string($id_compresion);  
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function modificarDeformaciones($carga,$id_deformacion){
		$retorno = false;
		$i=0;
		foreach ( $_POST['compresionIdDeformacion'] as $valor ){
				$sql = "UPDATE deformaciones SET carga='".$this->real_escape_string($carga[$i])."'WHERE id_deformacion=".$this->real_escape_string($valor);  
				$respuesta = $this->query($sql);
		$i++;		
	    }
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function GetDatosCompresion( $idMuestra ) {
		$retorno = false;
		$sql = "SELECT * FROM compresion WHERE fk_idmuestra=".$this->real_escape_string($idMuestra)." AND estado='1' LIMIT 1";
		if ( $registros = $this->query($sql) ) {
			$retorno = $registros->fetch_object();
		}
		return $retorno;
	}

	function GetDatosDeformaciones( $idCompresion ) {
		$retorno = false;
		$sql = "SELECT * FROM  `deformaciones` WHERE  `fk_idcompresion` =$this->real_escape_string($idCompresion) ORDER BY  deformacion ASC ";
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
