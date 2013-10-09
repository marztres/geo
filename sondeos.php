<?php
  @session_start();
  require_once('seguridad.php');
  require_once('includes/proyectos.php');
  require_once('includes/sondeos.php');
  require_once('includes/usuarios.php');
  
  $data=$_SESSION['usuario'];
  $proyectosClass = new proyectos();
  $sondeosClass = new sondeos(); 
  $usuariosClass = new usuarios();
  $proyectos = $proyectosClass->getDatosProyecto($_GET['idp']);
  $sondeos = $sondeosClass->getListaSondeos($_GET['idp']);
  $usuarios = $usuariosClass->getUsuariosProyectos();
  $tipo_superficie = $sondeosClass->getListaSuperficie();
  $user = $usuariosClass->getUsuarioActual($data['id_usuario']);

  //$datos_sondeo = $proyectosClass->datos_sondeo($_GET['ids']);
  ?>
<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sondeos - Geotecnia y Ambiente Systems</title>
    <meta name="description" content="El software de Geotecnia y Ambiente es el encargado de procesar los datos obtenidos por los laboratoristas de las muestras de los suelos">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/sondeos.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>  
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/sondeos.js"></script>
    <script src="assets/js/usuarios.js"></script>
    <link rel="stylesheet" href="assets/css/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify.bootstrap.css" />
    <script >
      $(document).ready(function() {
        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' }); 
      })
    </script>
  </head>
  <body >
    <div class="row-fluid header">
      <div class="span2">
        <a href="proyectos.php">
          <figure class="logo"></figure>
        </a>
      </div>
      <h3 class="span4 header-title"> Sistema de estudio de suelos</h3>
      <div class="btn-group span3 offset2 datos-perfil ">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <span>
        <i class="icon-user"></i> <?php echo $user->tipo." - ".$user->nombres." ".$user->apellidos; ?>
        </span>
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
             <a href="#ConfiguracionCuenta" role="button"  data-toggle="modal">
              <i class="icon-wrench"></i> Configuracion cuenta
            </a>
          </li>
           <?php if ( $data['tipo']=='Administrador') : ?>
          <li>
            <a href="usuarios.php"><i class="icon-user"></i> Usuarios</a>
          </li>
          <li class="divider"></li>
          <?php endif ?>
          <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
          <li>
            <a href="firmas.php"><i class="icon-book"></i> Firmas</a>
          </li>
          <li class="divider"></li>
          <?php endif ?>
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
            <a class="brand" id="listar" href="proyectos.php" data-toggle="tooltip" title="Click para ver todos los proyectos">Proyectos |</a>
            <a class="brand" id="listar" href="#" data-toggle="tooltip" title="Debajo puedes ver la información del proyecto">Información del proyecto :</a>
            <a class="brand" id="listar" href="#" data-toggle="tooltip" title="Nombre del proyecto actual"><?php echo $proyectos->nombre_proyecto; ?></a>
          </div>
        </div>
      </div>
      <div class="info_proyecto" id='infoproyecto'>
        <div class="row-fluid">
          <label for="nombre_proyecto_label" class="span1 title">Nombre:</label>
          <label id="lb_nombre_proyecto" for="nombre_proyecto" class="span3">
          <?php echo $proyectos->nombre_proyecto; ?>
          </label>
          <label for="codigo_proyecto_label" class="span1 title">Codigo:</label>
          <label id="lb_codigo_proyecto" for="codigo_proyecto" class="span2">
          <?php echo $proyectos->codigo_proyecto; ?>
          </label>
          <label for="fecha_proyecto_label" class="span1 title">Fecha:</label>
          <label id="lb_fecha_proyecto" for="fecha_proyecto" class="span1">
          <?php echo $proyectos->fecha; ?>
          </label>
          <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
          <a href="#modalProyecto" role="button" data-toggle="modal" class=" span2 offset1">
          <i class="icon-edit"></i> Modificar información
          </a>
          <?php endif ?>
        </div>
        <div class="row-fluid">
          <label for="nombre_proyecto_label" class="span1 title">Lugar:</label>
          <label id="lb_lugar_proyecto" for="nombre_proyecto" class="span3">
          <?php echo $proyectos->lugar; ?>
          </label>
          <label for="fecha_proyecto_label" class="span1 title">Contratista:</label>
          <label id="lb_contratista_proyecto" for="fecha_proyecto" class="span2">
          <?php echo $proyectos->contratista; ?>
          </label>
          <label for="fecha_proyecto_label" class="span1 title">Responsable:</label>
          <label id="lb_responsable" for="responsable"   class="span3 alineacionc">
          <?php echo $proyectos->nombres_responsable.' '.$proyectos->apellidos_responsable; ?>
          </label>
          <input type='hidden' id='responsable' value='<?php echo $proyectos->fk_id_responsable; ?>'>
        </div>
      </div>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" id="listar" href="#">Sondeos</a>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li>
                <a href="#nuevosondeo" role="button"  data-toggle="modal">
                <i  class="icon-plus-sign"></i> Nuevo sondeo
                </a>
              </li>
            </ul>
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
      <input id="idp" type="hidden" value="<?php echo $_GET['idp'] ?>"  >
      <table id="sondeos" class="table table-hover table-striped table-bordered ">
        <thead>
          <tr>
            <th>Número de sondeo</th>
            <th>Muestras</th>
            <th>Ver Sondeo</th>
            <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero'  ) : ?>  
              <th>Eliminar Sondeo</th>
            <?php endif ?>
          </tr>
        </thead>
        <tbody>
          
            <?php if ( count( $sondeos ) > 0 ) : ?>
            <?php $i = 1; ?>
            <?php foreach ( $sondeos as $sondeo ) : ?>
            <tr>
            <td><span class="titulo-proyectos"><?php echo $i; ?></span></td>
            <td><span class="badge"><?php echo $sondeo->cantidad; ?></span></td>
            <td><a href="muestras.php?idp=<?php echo $sondeo->fk_idproyecto; ?>&ids=<?php echo $sondeo->id_sondeo; ?>&numsondeo=<?php echo $i; ?>"><span class="badge label-inverse"><i class="icon-zoom-in icon-white"> </span></a></td>
            <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero'  ) : ?>
              <td>
                <a class="eliminarSondeo" href="#"><span class="badge label-inverse"><i class="icon-trash icon-white"></i></span></a>
                <form action="save.php">
                  <input type="hidden" name="func" value="eliminarSondeo">
                  <input type="hidden" name="idSondeo" value="<?php echo $sondeo->id_sondeo; ?>">
                </form>
              </td>
            </tr>
            <?php endif ?>  
            <?php $i++; ?>
            <?php endforeach; ?>
            
            <?php else: ?>
          <tr>
            <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero' ) : ?>  
              <td colspan="4">No hay datos que mostrar</td>
            <?php else: ?>
               <td colspan="3">No hay datos que mostrar</td>
            <?php endif ?>

          </tr>
          <?php endif ?>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- #############  FOOTER ############### -->    
    <div class="row-fluid footer ">
      <footer class="span12">
        <p class="copiright span4" >Geotecnia y Ambiente S.A.S &copy; Copyright 2013</p>
        <p class="span6 offset1"><a href="#legal" role="button" data-toggle="modal" class="links-footer">Información legal</a><a href="#Ayuda" role="button" data-toggle="modal" class="links-footer">Ayuda</a>
        </p>
      </footer>
    </div>
    <!-- ############# FIN FOOTER ############### --> 
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
        <button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Cerrar</button>
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
          El acceso y el uso de esta aplicación están sujetos a los siguientes términos y condiciones y a toda la legislación aplicable. Al acceder y utilizar este sitio, usted acepta los siguientes términos y condiciones, sin limitación ni condición alguna.
          A menos que se establezca otra cosa, el contenido de este sitio web, en especial, aunque sin que la enumeración sea exhaustiva, el texto, las imágenes y su disposición son propiedad de Geotecnia y Ambiente S.A.S. Todas las marcas comerciales utilizadas o mencionadas en este sitio web pertenecen a sus respectivos propietarios.
        </p>
        
        <p>
          Esta aplicación y sus contenidos, en especial, aunque sin que la enumeración tenga efectos limitativos, imágenes gráficas, sonidos, videos, códigos html, elementos  del sitio web  y textos, no podrán ser objeto de copia, reproducción, reedición, envío, comunicación, transmisión o distribución en modo alguno, sin contar con el consentimiento previo por escrito de Geotecnia y ambiente S.A.S, salvo los informes generados por el sistema.
        </p>

        <p>
          El software de sondeos fue licenciado a Geotecnia y Ambiente S.A.S por SYSCOMP TECNOLOGÍA.
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Cerrar</button>
      </div>
    </div>
    <!--  form  Editar proyecto-->
    <div id="modalProyecto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modificar proyecto</h3>
      </div>
      <div class="modal-body">
        <form name='formulario' id="modificarProyecto"  method='post' action="save.php" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <input name='codigo_proyecto' id="codigo_proyecto" type='text' placeholder='Código del proyecto' value="<?php echo $proyectos->codigo_proyecto; ?>" class="input-block-level limpiar required" autofocus required >
            </div>
            <div class="controls inputs">
              <input name='nombreProyecto' id="nombre_proyecto"  type='text' placeholder='Nombre del proyecto' value="<?php echo $proyectos->nombre_proyecto; ?>" class="input-block-level limpiar required" required >
            </div>
            <div class="controls inputs">
              <input name='lugar' id="lugar_proyecto" type='text' placeholder='Lugar' value="<?php echo $proyectos->lugar;?>" class="input-block-level limpiar required" required >
            </div>
            <div class="controls inputs">
              <input name='contratista' id="contratista_proyecto"  type='text'  placeholder='Contratista' value='<?php echo $proyectos->contratista; ?>'  class="input-block-level limpiar required"  required >
            </div>
            <div class="controls inputs">
              <input name='fecha' id="fecha_proyecto" type="text"  placeholder='fecha' value="<?php echo $proyectos->fecha; ?>"   class="input-block-level datepicker limpiar" required >
            </div>
            <div class="controls inputs">
              <select  name='responsable' id='responsables' class="input-block-level" >
                <?php if ( count( $usuarios ) > 0 ) : ?>
                <?php foreach ( $usuarios as $usuario ) : ?>
                  <?php if ( $usuario->id_usuario==$proyectos->fk_id_responsable ) : ?>
                    <option value="<?php echo $usuario->id_usuario; ?>" selected ><?php echo $usuario->tipo; ?> <?php echo $usuario->nombres; ?> <?php echo $usuario->apellidos; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $usuario->id_usuario; ?>" ><?php echo $usuario->tipo; ?> <?php echo $usuario->nombres; ?> <?php echo $usuario->apellidos; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
              </select >
            </div>
            <div class="controls inputs">
              <input name='func' type="hidden"   value="modificarProyecto" >
            </div>
            <div class="controls inputs">
              <input name='idProyecto' type="hidden"   value="<?php echo $proyectos->id_proyecto; ?>" >
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="errorModificarProyecto" class="alert alert-error hide">
              <strong>
              <small>Error al modificar el proyecto</small>
              </strong>
            </div>
            <div id="exitoModificarProyecto" class="alert alert-success hide">
              <strong>Proyecto modificado correctamente.</strong>
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
        </form>
      </div>
      <!-- fin form  Editar proyecto-->
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="btnModificarProyecto"  class="btn btn-success inputs"> <i class="icon-check icon-white"></i> Guardar proyecto</button> 
      </div>
    </div>
    <!-- fin modificar form -->
    
    <!--  form  nuevo sondeo-->
    <div id="nuevosondeo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Nuevo sondeo</h3>
      </div>
      <div class="modal-body">
        <form id="nuevoSondeo" name='formulario' method='post' action="save.php" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <input name='nivelFreatico' type='text' placeholder='Nivel freatico' class="input-block-level limpiar required" autofocus >
            </div>
            <div class="row-fluid">
              <select name='tipoSuperficie' id='lista_superficie' class="input-block-level">
                <option >Seleccione el tipo de superficie</option>
                <?php if(count($tipo_superficie) > 0): ?>
                <?php foreach( $tipo_superficie as $tipo ): ?>
                <option value="<?php echo $tipo->id_tipo_superficie ?>"><?php echo $tipo->tipo_superficie ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <div class="input-append">
                <input name='profundidadSuperficie' id="profundidadSuperficie" type='text'  placeholder='Profundidad de la superficie' class="input-block-level" readonly="readonly"> 
                <span class="add-on">metros</span>
              </div>

              <input name='idProyecto' type='hidden'  value="<?php echo $proyectos->id_proyecto; ?>">  
              <input name='func' type='hidden'  value="addSondeo" >
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="errorNuevoSondeo" class="alert alert-error hide">
              <strong>
              <small>error al guardar el proyecto</small>
              </strong>
            </div>
            <div id="exitoNuevoSondeo" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
        </form>
      </div>
      <!-- fin form  nuevo sondeo-->
      <div class="modal-footer">
        <button class="btn  " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button id="btnnuevoSondeo" type="submit"  class="btn btn-success inputs">
        <i class="icon-check icon-white"></i> Guardar sondeo </button> 
      </div>
    </div>
    <!-- fin nuevo sondeo form -->
    <!-- Configuracion cuenta-->
    <div id="ConfiguracionCuenta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Editar Usuario</h3>
      </div>
      <div class="modal-body">
      <form id="ConfigurarUsuarios" name='formulario' method='post' action="save.php" class="form-vertical">
      <div class="control-group">
            <div class="controls inputs">
              <input name='nombres' type='text' id="nombres" value="<?php echo $user->nombres ?>"  placeholder='Nombres' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input name='apellidos' type='text' id="apellidos" value="<?php echo $user->apellidos ?>"  placeholder='Apellidos' class='input-block-level limpiar' required >
            </div>
            <div class="controls inputs">
              <input  name='cedula' type='text' id="cedula" value="<?php echo $user->cedula ?>"  placeholder='Cédula' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input  name='usuario' type='text' id="nombre_usuario" value="<?php echo $user->nombre_usuario ?>" placeholder='Nombre de usuario' class="input-block-level limpiar" required >
            </div>
            <div class="controls inputs">
              <input  name='claveAnterior' type='password'  placeholder='Contraseña actual' class="input-block-level limpiar" required >
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
        <button type="submit" id="Mod_Usuario"  class="btn btn-success inputs"> <i class="icon-check icon-white"></i> Modificar Usuario</button> 
      </div>
    </div>
    <!-- Fin de configuracion cuenta -->
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script>
       $('.brand').tooltip('hide');
    </script>
    <script src="assets/js/alertify/alertify.js"></script>  
  </body>
</html>
