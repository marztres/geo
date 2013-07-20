<?php

require_once 'database.php';

class granulometria extends DataBase {
	
	function addGranulometria( $pesoRecipiente, $pesoRecipienteMuestra, $idMuestra ) {
		$retorno = false;
		$sql = "INSERT INTO granulometria (id_granulometria,pesoRecipiente,pesoRecipienteMasMuestra,d60,d30,d10,estado,fechaIngreso,fk_idmuestra)"
					."VALUES (NULL,'".$this->real_escape_string($pesoRecipiente)."','".$this->real_escape_string($pesoRecipienteMuestra)
					."',NULL,NULL,NULL, 1, NOW(), '".$this->real_escape_string($idMuestra)."')";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function getDatoGranulometria( $idMuestra ) {
		$retorno = false;
		$sql = "SELECT * FROM granulometria WHERE fk_idmuestra='"
				.$this->real_escape_string($idMuestra)."' and estado='1'";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = $respuesta->fetch_object();
			$respuesta->free();
		}
		return $retorno;
	}

	function updateGranulometria($id_granulometria,$pesoRecipiente,$pesoRecipienteMasMuestra,$d60,$d30,$d10){
	  $retorno = false;
		$sql = "UPDATE granulometria SET 
		  pesoRecipiente = '".$this->real_escape_string($pesoRecipiente)."',
  		pesoRecipienteMasMuestra = '".$this->real_escape_string($pesoRecipienteMasMuestra)."',
  		d60 = '".$this->real_escape_string($d60)."',
  		d30 = '".$this->real_escape_string($d30)."',
  		d10 = '".$this->real_escape_string($d10)."'

		WHERE 
      id_granulometria = '".$this->real_escape_string($id_granulometria)."' ";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}
	
}
?>