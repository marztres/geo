<?php
require_once("database.php");
class valida_usuario extends DataBase {
    private $usuario;
    private $contraseña;


    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;

        return $this;
    }

    public function captura_datos(){
    	$this->setUsuario($_POST['usuario']);
    	$this->setContraseña($_POST['password']);
    }

    public function valida_user()
	{
		
		$retorno = false;
		$i=0;
		$sql = "SELECT * FROM usuarios WHERE nombre_usuario='$this->usuario' AND password='$this->contraseña'";
		$respuesta = $this->query($sql);
		if ( $respuesta ) {
			$obj_usuario = array();
			while ( $fila = $respuesta->fetch_object() ) {
				  $obj_usuario=array("id_usuario"=>$fila->id_usuario,
                    "cedula"=>$fila->cedula,
                    "nombres"=>$fila->nombres,
                    "apellidos"=>$fila->apellidos,
                    "tipo"=>$fila->tipo,
                    "nombre_usuario"=>$fila->nombre_usuario
                );
				$i++;
			}    
		}

		if($i>0){

        session_start(); 
        $_SESSION['autentificado']=1;
        $_SESSION['usuario']=$obj_usuario; 
         
            echo "
                  <script type='text/javascript'>
                  window.location='index.php';
                  </script>
                 
                 ";
		}
        else{

             echo "
                  <script type='text/javascript'>
                  window.location='login.php?error=1';
                  </script>
                 
                 ";

        }
		
	}
}

$objeto= new valida_usuario();
$objeto->captura_datos();
$objeto->valida_user();

?>