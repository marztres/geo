<?php

require_once 'database.php';

class proyectos extends DataBase {

	function getDatosProyectos( $busqueda = '' ) {
		$retorno = false;
		$sql = "SELECT 
					  p.id_proyecto,
					  p.codigo_proyecto,
					  p.nombre_proyecto,
					  p.lugar,
					  p.contratista,
					  p.fecha,
					  p.fk_id_autor,
					  u.Nombres as nombres_autor,
					  u.apellidos as apellidos_autor,
					  p.fk_id_responsable,
					  r.Nombres as nombres_responsable,
					  r.apellidos as apellidos_responsable,
					  (SELECT count(*) FROM sondeos WHERE fk_idproyecto=p.id_proyecto ) AS cantidad
  				FROM
 					  proyectos p,usuarios u,usuarios r
  				where 
  				      p.fk_id_autor=u.id_usuario and p.fk_id_responsable=r.id_usuario and p.estado='1'";

		if ( $busqueda != '' ) {
			$sql .= "and concat(codigo_proyecto,'',nombre_proyecto,'',fecha) like('%".$this->real_escape_string($busqueda)."%')";
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
	
	function getProyecto( $idProyecto ) {
		$retorno = false;
		$sql = "SELECT * FROM proyectos WHERE codigo_proyecto='".$this->real_escape_string($idProyecto)."' and estado='1' limit 1";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$retorno = $respuesta->fetch_object();
			$respuesta->free();
		}
		return $retorno;
	}
	
	function addProyecto( $codigoProyecto, $nombreProyecto, $lugar, $contratista, $fecha, $autor, $responsable) {
		$retorno = false;
		$sql = "INSERT INTO proyectos (id_proyecto,codigo_proyecto,nombre_proyecto,lugar,contratista,fecha,fk_id_autor,fk_id_responsable,estado)"
					."VALUES (NULL,'".$this->real_escape_string($codigoProyecto)."','".$this->real_escape_string($nombreProyecto)
					."','".$this->real_escape_string($lugar)."','".$this->real_escape_string($contratista)
					."','".$this->real_escape_string($fecha)."','".$this->real_escape_string($autor)
					."','".$this->real_escape_string($responsable)."','1')";
		$respuesta = $this -> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

	function modificarProyecto($idProyecto, $codigo_Proyecto, $nombreProyecto, $lugar, $contratista, $fecha, $responsable) {
		$retorno = false;
		$sql = " UPDATE proyectos SET codigo_proyecto='".$this->real_escape_string($codigo_Proyecto)."',
				   nombre_proyecto='".$this->real_escape_string($nombreProyecto)."',
				   lugar='".$this->real_escape_string($lugar)."',
				   contratista='".$this->real_escape_string($contratista)."',
				   fecha='".$this->real_escape_string($fecha)."',
				   fk_id_responsable='".$this->real_escape_string($responsable)."'  WHERE id_proyecto='".$this->real_escape_string($idProyecto)."' ";
		$respuesta =$this->query($sql);
		if ($respuesta) {
			$retorno = true;
		}
		return $retorno;
	}

	

	function eliminarProyecto($id) {
		$retorno = false;
		$sql = "UPDATE proyectos SET estado='0' WHERE id_proyecto='".$this->real_escape_string($id)."' ";
		$respuesta = $this-> query($sql);
		if ( $respuesta ) {
			$retorno = true;
		}
		return $retorno;
	}

    public function getDatosProyecto( $idp ) {
        $retorno = false;
        $sql = "SELECT 
                      p.id_proyecto,
                      p.codigo_proyecto,
                      p.nombre_proyecto,
                      p.lugar,
                      p.contratista,
                      p.fecha,
                      p.fk_id_responsable,
                      r.Nombres as nombres_responsable,
                      r.apellidos as apellidos_responsable
                 FROM 
                      proyectos p,usuarios r
                 where 
                       p.fk_id_responsable=r.id_usuario and p.id_proyecto='".$this->real_escape_string($idp)."' and p.estado='1' LIMIT 1";
        $respuesta = $this -> query($sql);
        if ($respuesta) {
            $retorno = $respuesta -> fetch_object();
        }
        return $retorno;
    }

}
?>