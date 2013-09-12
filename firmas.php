<?php
    session_start();
    require_once("seguridad.php");
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
    <title>Firmas - Geotecnia y Ambiente Systems</title>
    <meta name="description" content="El software de Geotecnia y Ambiente es el encargado de procesar los datos obtenidos por los laboratoristas de las muestras de los suelos">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/firmas.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>     
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/firmas.js"></script>
    <script src="assets/js/usuarios.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <link rel="stylesheet" href="assets/css/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify.bootstrap.css" />

    <script>
      $(document).ready(function()
      {

        var options = { 
          beforeSend: function() 
          {
            $("#progress").show();
            //clear everything
            $("#bar").width('0%');
            $("#message").html("");
          $("#percent").html("0%");
          },
          uploadProgress: function(event, position, total, percentComplete) 
          {
            $("#bar").width(percentComplete+'%');
            $("#percent").html(percentComplete+'%');

          },
          success: function() 
          {
              $("#bar").width('100%');
            $("#percent").html('100%');

          },
        complete: function(response) 
        {
          var respuesta= $.parseJSON(response.responseText);

          console.log(this);
         
          if(respuesta.status=="OK"){
            alertify.log("Firma y datos guardados exitosamente.");
            $("#message").html("<img src="+respuesta.ruta+" class='img-rounded' height='200px' width='200px' />");
            setTimeout(function(){
            location.reload();    
            },3000);
          } else {
            console.error(respuesta.message);
            alertify.log("Error , rectifique los datos.");
            $("#bar").width('0%');
            $("#percent").html('0%');
          }
        },
        error: function(response)
        {
          console.error("error"); 
        }
      }; 
      var options2 = { 
          beforeSend: function() 
          {
            $("#progressEditar").show();
            //clear everything
            $("#barEditar").width('0%');
            $("#messageEditar").html("");
          $("#percentEditar").html("0%");
          },
          uploadProgress: function(event, position, total, percentComplete) 
          {
            $("#barEditar").width(percentComplete+'%');
            $("#percentEditar").html(percentComplete+'%');

          },
          success: function() 
          {
              $("#barEditar").width('100%');
            $("#percentEditar").html('100%');

          },
        complete: function(response) 
        {
          var respuesta= $.parseJSON(response.responseText);

        
          if(respuesta.status=="OK"){
            alertify.log("Firma y datos actualizados exitosamente.");
            $("#messageEditar").html("<img src="+respuesta.ruta+" class='img-rounded' height='200px' width='200px' />");
            setTimeout(function(){
            
            },3000);
          } else {
            console.error(respuesta.message);
            alertify.log("Error , rectifique los datos.");
            $("#barEditar").width('0%');
            $("#percentEditar").html('0%');
          }
        },
        error: function(response)
        {
          console.error("error"); 
        }
      };
           $("#nuevaFirma").ajaxForm(options);
           $("#editarFirma").ajaxForm(options2);
      });

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
              <a href="#editar_Firma" rel='<?php echo $firmas->idFirma.",".$firmas->persona.",".$firmas->tarjetaProfesional.",".$firmas->imagenFirma; ?>' class="editarFirma" role="button" data-toggle="modal">
                <span class="badge label-inverse" ><i class="icon-pencil icon-white"></i></span>
              </a>
            </td>
            <td>
              <a class="eliminarFirma" href="#"><span class="badge label-inverse" ><i class="icon-trash icon-white "></i> </span></a>
              <form action="save.php">
                <input type="hidden" name="func" value="deleteFirma">
                <input type="hidden" name="idFirma" value="<?php echo $firmas->idFirma; ?>">
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
          <h5> Administración de firmas  </h5>
        <p> 
          La aplicación muestra una lista general de firmas registradas. </p>
       <h5> ¿ Como agregar una firma? </h5>
        <p> 
          Para agregar una firma hacer click en el boton "Nuevo firma" ubicado en la parte superior derecha de nuestra pantalla, 
          ingresamos los datos correspondiente "Nombre de persona, Tarjeta profesional". Y seleccionamos la imagen de la firma a cargar, luego hacemos click en el boton
          "Guardar firma" , Debemos tener en cuenta que la imagen a subir no supere el peso de 1.5 mb.
        </p>
        <h5> ¿ Como editar una firma ? </h5>
        <p> 
          Para editar una fima hacer click en el ícono ubicado en la columna editar correspondiente a la firma, modificamos la información corespondiente y presionamos el botón modificar firma. 
        </p>
        <h5> ¿ Como eliminar una firma ? </h5>
        <p> 
          Para eliminar una firma hacer click en el ícono ubicado en la columna eliminar nos aprecerá una ventana de confirmación en la que debemos presionar aceptar. 
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
      <form id="nuevaFirma" name='formulario' enctype="multipart/form-data" method='POST' action="save.php" class="form-vertical">
        <div class="control-group">
            
            <div class="controls inputs">
              <input  name='persona' id="persona" type='text' placeholder="Nombre persona" class="input-block-level" >
            </div>
            <div class="controls inputs">
              <input  name='tarjetaProfesional' type='text' class="input-block-level" placeholder="Tarjeta profesional" >
            </div>    
            <div class="controls inputs">
              <label for="imagen" class="title">Imagen de firma</label>
            </div>
            <div class="controls inputs">
              <input  name='imagen' id="imagen" type='file' class="input-block-level"  >
            </div>      

            <br>
            <div id="progress" class="controls">
              <div id="bar"></div>
              <div id="percent">0%</div >
              </div>
              <br>
              <div id="message"></div>
            </div> 
            <div class="controls inputs">
              <input name='func'  type="hidden"  value='addFirma' >
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="EnviarGuardarFirma"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Guardar firma</button> 
        </form>
      </div>
    </div>
    <!--  Fin nueva firma-->

    <!--  Editar firma -->
    <div id="editar_Firma" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Editar Firma</h3>
      </div>
      <div class="modal-body">
      <form id="editarFirma" name='formulario' method='post' action="save.php" class="form-vertical">
        <div class="control-group">
            <div class="controls inputs">
              <input  name='editarPersona' id="editarPersona" type='text' placeholder="Nombre persona" class="input-block-level" >
            </div>
            <div class="controls inputs">
              <input  name='editarTarjetaPro' id="editarTarjetaPro" type='text' class="input-block-level" placeholder="Tarjeta profesional" >
            </div>    
            <div class="controls inputs">
              <label for="imagen" class="title">Imagen de firma</label>
            </div>
            <div class="controls inputs">
              <input  name='imagen' id="imagen" type='file' class="input-block-level"  >
            </div>
            <br>
            <div id="progressEditar" class="controls">
              <div id="barEditar"></div>
              <div id="percentEditar">0%</div >
              </div>
              <br>
              <div id="messageEditar">
              </div> 
            </div> 
            <div class="controls inputs">
              <input name='idFirma' id="idFirma"   type="hidden" >
            </div>
            <div class="controls inputs">
              <input name='imagenActual' id="imagenActual"   type="hidden" >
            </div>   
            <div class="controls inputs">
              <input name='func'  type="hidden"  value='updateFirma' >
            </div>    
        </div>
      
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="EnviarEditarFirma"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Modificar firma</button> 
        </form>
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
    <script src="assets/js/alertify/alertify.js"></script>  
  </body>
</html>