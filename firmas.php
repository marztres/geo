<?php
    session_start();
    require_once('includes/proyectos.php');
    require_once('includes/usuarios.php');
    require_once('includes/firmas.php');
    $data=$_SESSION['usuario'];
    $usuariosClass = new usuarios();
    $firmasClass = new firmas();
    
    if(isset($_GET['busqueda'])){
      $ListaFirmas = $firmasClass->getAllFirmas($_GET['busqueda']);
    }
    else{
      $ListaFirmas = $firmasClass->getAllFirmas();
    }
    $user = $usuariosClass->getUsuarioActual($data['id_usuario']);
  
?>
<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Proyectos - Geotecnia y Ambiente Systems</title>
    <meta name="description" content="El software de Geotecnia y Ambiente es el encargado de procesar los datos obtenidos por los laboratoristas de las muestras de los suelos">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/usuarios.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>     
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/firmas.js"></script>
    <script src="assets/js/usuarios.js"></script>
    <script >
      $(document).ready(function() {
        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' }); 
      })
    </script>
  </head>
  <body>
    <div class="row-fluid header">
      <div class="span2">
        <a href="proyectos.php">
          <figure class="logo"></figure>
        </a>
      </div>
      <h3 class="span4 header-title"> </h3>
      <div class="btn-group span3 offset2 datos-perfil ">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <span> <i class="icon-user"></i> <?php echo $user->tipo." - ".$user->nombres." ".$user->apellidos; ?></span>
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a href="#ConfiguracionCuenta" role="button"  data-toggle="modal">
              <i class="icon-wrench"></i> Configuracion cuenta
            </a>
          </li>
          <li class="divider"></li>
           <?php if ( $data['tipo']=='Administrador') : ?>
          <li>
            <a href="usuarios.php"><i class="icon-user"></i> Usuarios</a>
          </li>
          <li class="divider"></li>
          <?php endif ?>
          <li class="divider"></li>
          <li>
            <a href="#Ayuda" role="button"  data-toggle="modal">
            <i class="icon-question-sign"></i> Ayuda
            </a>
          </li>
          <li>
            <a href="#legal" role="button" data-toggle="modal" href="destruirsesion.php">
            <i class=" icon-info-sign"></i> Información legal
            </a>
          </li>
          <li class="divider"></li>
          <li>
            <a href="destruirsesion.php">
            <i class="icon-remove-sign"></i> Cerrar Sesión
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="row-fluid cuerpo-proyectos">
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" id="listar" href="firmas.php" data-toggle="tooltip" title="Click listar todas las firmas">Firmas</a>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li>
                <a href="#nueva_firma" role="button"  data-toggle="modal">
                <i  class="icon-plus-sign"></i> Nueva firma
                </a>
              </li>
            </ul>
            <form id="buscarUsuario" action="firmas.php" class="navbar-form pull-right ">
              <div class="input-append  input-block-level">      
                <input type="text" name='busqueda' placeholder="Buscar firma" class="input-xxlarge" >
                <button type="submit" class="btn" >Buscar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Mensaje exito y error Generales -->
      <div id="errorGeneral" class="alert alert-error hide">                             
        <strong> 
        <small>Error al eliminar la firma</small>  
        </strong>
      </div>
      <div id="exitoGeneral" class="alert alert-success hide ">
        <strong>Firma eliminada correctamente.</strong>  
      </div>
      <!-- Fin mensaje exito y error -->
      <table id="proyectos" class="table table-hover table-striped table-bordered ">
        <thead>
          <tr>
            <th>Texto firma</th>
            <th>Tarjeta profesional</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php if ( count( $ListaFirmas ) ) : ?>
          <?php foreach ( $ListaFirmas as $firmas ) : ?>
          <tr>
            <td>
              <span ><?php echo $firmas->persona ?></span>
            </td>
            <td>
              <span ><?php echo $firmas->tarjetaProfesional ?></span>
            </td>
            <td>
              <a href="#editar_firma" rel='<?php echo $firmas->idFirma.",".$firmas->persona.",".$firmas->tarjetaProfesional.",".$firmas->imagenFirma; ?>' class="editarFirma" role="button" id="<?php echo $firmas->id_usuario;?>" data-toggle="modal">
                    <i class="icon-pencil"></i>
                    </a>
            </td>
            <td>
              <a class="eliminar_firma" href="#"><i class="icon-remove"></i></a>
              <form action="save.php">
                <input type="hidden" name="func" value="eliminarFirma">
                <input type="hidden" name="idusuario" value="<?php echo $firmas->idFirma; ?>">
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php else: ?>
          <tr>
            <td colspan="4">No hay datos que mostrar</td> 
          </tr>
          <?php endif ?>
        </tbody>
      </table>
    </div>
    <div class="row-fluid footer ">
      <footer class="span12">
        <p class="copiright span4" >Geotecnia y Ambiente S.A.S &copy; Copyright 2013</p>
        <p class="span6 offset1">
          <a href="#legal" role="button" data-toggle="modal" class="links-footer">Información legal</a>
          <a href="#Ayuda" role="button" data-toggle="modal" class="links-footer">Ayuda</a>
        </p>
      </footer>
    </div>
    <!-- ayuda -->
    <div id="Ayuda" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Ayuda</h3>
      </div>
      <div class="modal-body">
        <p> 
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, modi, rem, fugiat dicta error accusantium possimus voluptatum distinctio pariatur perferendis corrupti libero minus iure id architecto eius neque velit est.
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate, qui, distinctio magni libero quasi molestias accusantium amet temporibus sapiente possimus eligendi quam quis perferendis rerum eos aut beatae nemo harum.
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
      </div>
    </div>
    <!-- Legal -->
    <div id="legal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Información legal</h3>
      </div>
      <div class="modal-body">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, modi, rem, fugiat dicta error accusantium possimus voluptatum distinctio pariatur perferendis corrupti libero minus iure id architecto eius neque velit est.
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate, qui, distinctio magni libero quasi molestias accusantium amet temporibus sapiente possimus eligendi quam quis perferendis rerum eos aut beatae nemo harum.
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
      </div>
    </div>
    <!-- nuevo form -->
    

    <!--  Nueva firma -->
    <div id="nueva_firma" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Nueva firma</h3>
      </div>
      <div class="modal-body">
      <form id="ModificarUsuarios" name='formulario' method='post' action="save.php" class="form-vertical">
      <div class="control-group">
            <div class="controls inputs">
              <input  name='cedula' type='text' id="cedula"  placeholder='Cédula' class="input-block-level limpiar" required >
            </div>
        
            <div class="controls inputs">
              <input name='func'  type="hidden"  value='modificar_firma' >
              <input name='id_firma'  type="hidden" id="id_firma"  >
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error_modificar_usuario" class="alert alert-error hide">                             
              <strong> 
              <small>error al modificar la firma</small>  
              </strong>
            </div>
            <div id="exito_modificar_usuario" class="alert alert-success hide ">
              <strong>Firma modificada correctamente.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
          </form>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="EnviarModificarUsuario"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Modificar Usuario</button> 
      </div>
    </div>
    <!--  Fin nueva firma-->

    <!--  Editar firma -->
    <div id="editar_firma" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Editar Firma</h3>
      </div>
      <div class="modal-body">
      <form id="ModificarUsuarios" name='formulario' method='post' action="save.php" class="form-vertical">
      <div class="control-group">
            <div class="controls inputs">
              <input  name='cedula' type='text' id="cedula"  placeholder='Cédula' class="input-block-level limpiar" required >
            </div>
        
            <div class="controls inputs">
              <input name='func'  type="hidden"  value='modificar_firma' >
              <input name='id_firma'  type="hidden" id="id_firma"  >
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error_modificar_usuario" class="alert alert-error hide">                             
              <strong> 
              <small>error al modificar el usuario</small>  
              </strong>
            </div>
            <div id="exito_modificar_usuario" class="alert alert-success hide ">
              <strong>Usuario modificado correctamente.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
          </form>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="EnviarModificarUsuario"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Modificar Usuario</button> 
      </div>
    </div>
    <!--  Fin editar firma-->

     <!-- Configuracion cuenta-->
    <div id="ConfiguracionCuenta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Configurar cuenta de usuario</h3>
      </div>
      <div class="modal-body">
      <form id="ConfigurarUsuarios" name='formulario' method='post' action="save.php" class="form-vertical">
      <div class="control-group">
            <div class="controls inputs">
              <input  name='cedula' type='text' id="cedula" value="<?php echo $user->cedula ?>"  placeholder='Cédula' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input name='nombres' type='text' id="nombres" value="<?php echo $user->nombres ?>"  placeholder='Nombres' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input name='apellidos' type='text' id="apellidos" value="<?php echo $user->apellidos ?>"  placeholder='Apellidos' class='input-block-level limpiar' required >
            </div>
            <div class="controls inputs">
              <input  name='usuario' type='text' id="nombre_usuario" value="<?php echo $user->nombre_usuario ?>" placeholder='Nombre de usuario' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input  name='clave' type='password'  placeholder='Nueva Contraseña' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input  name='confirmar_clave' type='password'  placeholder='Confirmar nueva contraseña' class="input-block-level limpiar" required >
            </div>
           
            <div class="controls inputs">
              <input name='func'  type="hidden"  value='modificar_usuario' >
              <input name='id_usuario'  type="hidden" id="id_usuario" value="<?php echo $data['id_usuario'] ?>" >
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error_configurando_cuenta" class="alert alert-error hide">                             
              <strong> 
              <small>error al modificar el usuario</small>  
              </strong>
            </div>
            <div id="exito_configurando_cuenta" class="alert alert-success hide ">
              <strong>Usuario modificado correctamente.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
          </form>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="Mod_Usuario"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Modificar Usuario</button> 
      </div>
    </div>
    <!-- Fin de configuracion cuenta -->
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script> 
      $('.brand').tooltip('hide');
    </script>   
  </body>
</html>