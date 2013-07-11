<?php
  session_start();
  require_once('includes/proyectos.php');
  require_once('includes/usuarios.php');
  $data=$_SESSION['usuario'];
  $usuariosClass = new usuarios();
  $proyectosClass = new proyectos();
  if(isset($_GET['busqueda'])){
    $proyectos = $proyectosClass->getDatosProyectos($_GET['busqueda']);
  }
  else{
    $proyectos = $proyectosClass->getDatosProyectos();
  }
  $usuarios = $usuariosClass->getUsuariosProyectos();
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
    <link rel="stylesheet" href="assets/css/proyectos.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>     
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/proyectos.js"></script>
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
          <span><i class="icon-user"></i><?php echo $data['tipo']." - ".$data['nombres']." ".$data['apellidos']; ?></span>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a href="#">
              <i class="icon-wrench"></i> Configuración de cuenta
            </a>
          </li>
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
            <a class="brand" id="listar" href="proyectos.php" data-toggle="tooltip" title="Click listar todos los proyectos">Proyectos</a>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>   
              <li>
                <a href="#Nuevoproyecto" role="button"  data-toggle="modal">
                  <i  class="icon-plus-sign"></i> Nuevo proyecto
                </a>
              </li>
            </ul>
            <form id="buscarProyecto" action="proyectos.php" class="navbar-form pull-right ">
              <div class="input-append  input-block-level">      
                <input type="text" name='busqueda' placeholder="Buscar proyecto" class="input-xxlarge" >
                <button type="submit" class="btn" >Buscar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Mensaje exito y error Generales -->
            <div id="errorGeneral" class="alert alert-error hide">                             
              <strong> 
                <small>Error al eliminar el proyecto</small>  
              </strong>
            </div>
            <div id="exitoGeneral" class="alert alert-success hide ">
              <strong>Proyecto eliminado correctamente.</strong>  
            </div>
      <!-- Fin mensaje exito y error -->

      <table id="proyectos" class="table table-hover table-striped table-bordered ">
        <thead>
          <tr>
            <th>Nombre del proyecto</th>
            <th>Codigo del proyecto</th>
            <th>Fecha</th>
            <th>Numero de Sondeos </th>
            <th>Ver proyecto</th>
            <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero'  ) : ?>  
              <th>Eliminar proyecto</th>
            <?php endif ?>
          </tr>
        </thead>
        <tbody>
          <?php if ( count( $proyectos ) ) : ?>
          <?php foreach ( $proyectos as $proyecto ) : ?>
          <tr>
            <td>
              <a  href="sondeos.php?idp=<?php echo $proyecto->id_proyecto; ?>"><span class="pull-left titulo-proyectos brand"><?php echo $proyecto->nombre_proyecto; ?></span></a>
              <br>
              <span class="muted pull-left">Autor: <?php echo $proyecto->nombres_autor.' '.$proyecto->apellidos_autor ?></span>
              <span class="muted pull-right">Responsable: <?php echo $proyecto->nombres_responsable.' '.$proyecto->apellidos_responsable ?></span>
            </td>
            <td><?php echo $proyecto->codigo_proyecto; ?></td>
            <td><?php echo $proyecto->fecha; ?></td>
            <td>
              <span class="badge"><?php echo $proyecto->cantidad; ?></span>
            </td>
            <td>
              <a href="sondeos.php?idp=<?php echo $proyecto->id_proyecto; ?>"><i class="icon-pencil"></i></a>
            </td>
            <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero'  ) : ?>
              <td>
                
                <a class="eliminarProyecto" href="#"><i class="icon-remove"></i></a>
                <form action="save.php">
                  <input type="hidden" name="func" value="eliminarProyecto">
                  <input type="hidden" name="idproyecto" value="<?php echo $proyecto->id_proyecto; ?>">
                </form>
              </td>
            <?php endif ?>  

          </tr>
          <?php endforeach; ?>
          <?php else: ?>
          <tr>
            <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero' ) : ?>  
              <td colspan="6">No hay datos que mostrar</td>
            <?php else: ?>
               <td colspan="5">No hay datos que mostrar</td>
            <?php endif ?>

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
    <!-- ayuda -->
    <div id="Nuevoproyecto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Nuevo proyecto</h3>
      </div>
      <div class="modal-body">
        <form id="datosProyecto" name='formulario' method='post' action="save.php" class="form-vertical">
          <div class="control-group">                                                              
    
            <div class="controls inputs">
              <input  name='codigoProyecto' type='text'  placeholder='Código del proyecto' class="input-block-level limpiar" required >
            </div>
            
            <div class="controls inputs">
              <input name='nombreProyecto' type='text'  placeholder='Nombre del proyecto' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input name='lugarProyecto' type='text'  placeholder='Lugar' class='input-block-level limpiar' required >
            </div>
            <div class="controls inputs">
              <input name='contratista' type='text'  placeholder='Contratista'  class="input-block-level limpiar"  required >
            </div>
            <div class="controls inputs">
              <input  name='fecha' type="text"  placeholder='fecha'   class="input-block-level datepicker limpiar" required >
            </div>
            <div class="controls inputs">
              <select name='responsable'  class="input-block-level" >
              <?php if ( count( $usuarios ) > 0 ) : ?>
              <?php foreach ( $usuarios as $usuario ) : ?>
                <option value="<?php echo $usuario->id_usuario; ?>"><?php echo $usuario->tipo; ?> <?php echo $usuario->nombres; ?> <?php echo $usuario->apellidos; ?></option>
              <?php endforeach; ?>
              <?php endif; ?>
              </select >
            </div>
            <div class="controls inputs">
              <input name='func'  type="hidden"  value='addProyecto' >
            </div>
            <div class="controls inputs">
              <input name='autor' type="hidden"  value="<?php $data=$_SESSION['usuario']; echo  $usuario=$data['id_usuario'];?>" >
            </div>                   
            
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error" class="alert alert-error hide">                             
              <strong> 
                <small>error al guardar el proyecto</small>  
              </strong>
            </div>
            <div id="exito" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>        
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="enviar"  class="btn btn-primary inputs"> 
          <i class="icon-check icon-white"></i> Guardar proyecto
        </button> 
      </div>
    </div>
    <!-- fin nuevo form -->

    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script> 
      $('.brand').tooltip('hide');
    </script>   
  
  </body>
</html>