<?php
	class resultados extends Database {

		
		function addResultados( $idMuestra ) {
		$retorno = false;
		$sql = "INSERT INTO resultados (id_resultados,humedad,limiteLiquido,limitePlastico,indicePlasticidad,cohesion,pesoUnitario,N200,N4,N10,N40,notacionSucs,descripcionSucs,aashto,fechaIngreso,estado,fk_idMuestra)"
					."VALUES (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NOW(),1, '".$this->real_escape_string($idMuestra)."')";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
		}

		function updateResultados($id_resultados,$humedad,$limiteLiquido,$limitePlastico,$indicePlasticidad,$cohesion,$pesoUnitario,$N200,$N4,$N10,$N40,$notacionSucs,$descripcionSucs,$aashto,$fk_idMuestra){
	  	$retorno = false;

			$sql0="	SELECT id_resultados FROM resultados where fk_idMuestra='".$this->real_escape_string($fk_idMuestra)."' limit 1 ";
			$respuesta0 = $this -> query($sql0);

				if ( $respuesta0 ) {
			$idResult = $respuesta0->fetch_object();
			$respuesta0->free();
			}	

			$sql = "UPDATE resultados SET 
		 	humedad = '".$this->real_escape_string($humedad)."',
			limiteLiquido = '".$this->real_escape_string($limiteLiquido)."',
			limitePlastico = '".$this->real_escape_string($limitePlastico)."',
			indicePlasticidad = '".$this->real_escape_string($indicePlasticidad)."',
			cohesion = '".$this->real_escape_string($cohesion)."',
			pesoUnitario = '".$this->real_escape_string($pesoUnitario)."',
			N200 = '".$this->real_escape_string($N200)."',
			N4 = '".$this->real_escape_string($N4)."',
			N10 = '".$this->real_escape_string($N10)."',
			N40 = '".$this->real_escape_string($N40)."',
			notacionSucs = '".$this->real_escape_string($notacionSucs)."',
			descripcionSucs = '".$this->real_escape_string($descripcionSucs)."',
			aashto = '".$this->real_escape_string($aashto)."' 
			WHERE id_resultados = '".$this->real_escape_string($idResult->id_resultados)."' ";
			
			$respuesta = $this -> query($sql);
			if ( $respuesta ) {
				$retorno = true;
			}
			return $retorno;
		}

		function updateResultadosGranulometria($N200,$N4,$N10,$N40,$notacionSucs,$descripcionSucs,$aashto,$fk_idMuestra){
	  	$retorno = false;

			$sql0="	SELECT id_resultados FROM resultados where fk_idMuestra='".$this->real_escape_string($fk_idMuestra)."' limit 1 ";
			$respuesta0 = $this -> query($sql0);

				if ( $respuesta0 ) {
			$idResult = $respuesta0->fetch_object();
			$respuesta0->free();
			}	

			$sql = "UPDATE resultados SET 
		 	N200 = '".$this->real_escape_string($N200)."',
			N4 = '".$this->real_escape_string($N4)."',
			N10 = '".$this->real_escape_string($N10)."',
			N40 = '".$this->real_escape_string($N40)."',
			notacionSucs = '".$this->real_escape_string($notacionSucs)."',
			descripcionSucs = '".$this->real_escape_string($descripcionSucs)."',
			aashto = '".$this->real_escape_string($aashto)."' 
			WHERE id_resultados = '".$this->real_escape_string($idResult->id_resultados)."' ";
			
			$respuesta = $this -> query($sql);
			if ( $respuesta ) {
				$retorno = true;
			}
			return $retorno;
		}

		function updateResultadosLimites($humedad,$limiteLiquido,$limitePlastico,$indicePlasticidad,$fk_idMuestra){
	  	$retorno = false;

			$sql0="	SELECT id_resultados FROM resultados where fk_idMuestra='".$this->real_escape_string($fk_idMuestra)."' limit 1 ";
			$respuesta0 = $this -> query($sql0);

				if ( $respuesta0 ) {
			$idResult = $respuesta0->fetch_object();
			$respuesta0->free();
			}	

			$sql = "UPDATE resultados SET 
		 	humedad = '".$this->real_escape_string($humedad)."',
			limiteLiquido = '".$this->real_escape_string($limiteLiquido)."',
			limitePlastico = '".$this->real_escape_string($limitePlastico)."',
			indicePlasticidad = '".$this->real_escape_string($indicePlasticidad)."'
			WHERE id_resultados = '".$this->real_escape_string($idResult->id_resultados)."' ";
			
			$respuesta = $this -> query($sql);
			if ( $respuesta ) {
				$retorno = true;
			}
			return $retorno;
		}


		function updateResultadosCompresion($cohesion,$pesoUnitario,$fk_idMuestra){
	  	$retorno = false;

			$sql0="	SELECT id_resultados FROM resultados where fk_idMuestra='".$this->real_escape_string($fk_idMuestra)."' limit 1 ";
			$respuesta0 = $this -> query($sql0);

				if ( $respuesta0 ) {
			$idResult = $respuesta0->fetch_object();
			$respuesta0->free();
			}	

			$sql = "UPDATE resultados SET 
		 	cohesion = '".$this->real_escape_string($cohesion)."',
			pesoUnitario = '".$this->real_escape_string($pesoUnitario)."'
			WHERE id_resultados = '".$this->real_escape_string($idResult->id_resultados)."' ";
			
			$respuesta = $this -> query($sql);
			if ( $respuesta ) {
				$retorno = true;
			}
			return $retorno;
		}


		function getResultado( $idMuestra ) {
			$retorno = false;
			$sql = "SELECT * FROM resultados WHERE fk_idMuestra='".$this->real_escape_string($idMuestra)."' and estado='1' limit 1";
			$respuesta = $this->query($sql);
			if ( $respuesta ) {
				$retorno = $respuesta->fetch_object();
				$respuesta->free();
			}
			return $retorno;
		}

	}


?>