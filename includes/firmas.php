<?php
require_once 'database.php';
class firmas extends DataBase {

	
	
	function getAllFirmas($busqueda=''){
		$retorno = false;
		$sql = "SELECT * FROM firmas WHERE estado='1' ";
		if($busqueda!=''){
			$sql .= "and concat(persona,'',tarjetaProfesional) like('%".$this->real_escape_string($busqueda)."%')";
		}
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

	function addFirma($persona,$tarjetaProfesional,$imagenFirma) {
		$retorno = false;

				
			$sql = "INSERT INTO firmas (idFirma,persona,tarjetaProfesional,imagenFirma,estado)"
							."VALUES (NULL,'".$this->real_escape_string($persona)."','"
							.$this->real_escape_string($tarjetaProfesional)."','"
							.$this->real_escape_string($imagenFirma)."','1')";

				$respuesta = $this -> query($sql);

		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function updateFirma($idFirma,$persona,$tarjetaProfesional,$imagenFirma){
	  $retorno = false;
		 $sql = "UPDATE firmas SET 
		  persona = '".$this->real_escape_string($persona)."',
  		tarjetaProfesional = '".$this->real_escape_string($tarjetaProfesional)."',
  		imagenFirma = '".$this->real_escape_string($imagenFirma)."'

		WHERE 
      idFirma = '".$this->real_escape_string($idFirma)."' ";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function eliminarFirma($idFirma) {
		$retorno = false;
		$sql = "UPDATE firmas SET estado='0' WHERE idFirma='".$this->real_escape_string($idFirma)."' ";
		$respuesta = $this-> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

}
?>