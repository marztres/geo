<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login - Geotecnia y Ambiente Systems</title>
    <meta name="description" content="El software de Geotecnia y Ambiente es el encargado de procesar los datos obtenidos por los laboratoristas de las muestras de los suelos">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/vendor/usuario.js"></script>
  </head>
  <body>
    <div class="row-fluid header">
      <div class="span2">
        <figure class="logo"></figure>
      </div>
      <h4 class="span5 header-title"> Sistema de sondeo de suelos</h4>
      <a href="#Ayuda" role="button"  data-toggle="modal" class="link-header span1 offset2">
      Ayuda 
      </a>
      <a href="#legal" role="button" data-toggle="modal" class="link-header span2">
      Información legal 
      </a>
    </div>
    <div class="row-fluid cuerpo-login">
      <div class="arealogin span3 offset5">
        <form  id='datos_usuarios'  method='post' action='valida_usuario.php?controller=navegacion&amp;action=valida_Usuarios' class="form-vertical">
          <div class="control-group">
            <label for="Titulo" class="lead" title="Identificate">Identificate</label>    
            <div class="controls inputs">
              <div class="input-prepend input-block-level">
                <span class="add-on"><i class="icon-user "></i></span>
                <input type="text" id='nombre_usuario' name='usuario' placeholder="Usuario" class="input-block-level" autofocus required >
              </div>
            </div>
            <div class="controls inputs">
              <div class="input-prepend input-block-level">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input type="password" id='password' name='password' placeholder="Contraseña" class="input-block-level" required >
              </div>
            </div>
            <button id='enviar_usuario' class="btn btn-success inputs"> <i class="icon-check icon-white"></i> Ingresar</button>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <?php if(isset($_GET['error'])){
                echo " <div id='error' class='alert alert-error'>
              <strong> <small>Usuario y/o contraseñas incorrecto.</small>  </strong>
            </div>";

            } ?>
           
            <!-- Fin mensaje exito y error -->
            <div id="exito" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
          </div>
        </form>
      </div>
    </div>


    <div class="row-fluid footer">
      <footer class="span12">
        <p class="copiright span4" >Geotecnia y Ambiente S.A.S &copy; Copyright 2013</p>
        <p class="span6 offset1"><a href="#legal" role="button" data-toggle="modal" class="links-footer">Información legal</a><a href="#Ayuda" role="button" data-toggle="modal" class="links-footer">Ayuda</a>
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
        <h5>¿ Como ingresar a la aplicación de sondeos ?</h3>
        <p> R/ Para ingresar a la apliación de sondeos debes ser empleado activo de la empresa Geotecnia y Ambiente S.A.S y requerir al administrador de sistemas que registre tus datos de acuerdo a tu cargo que puede ser ingeniero o laboratorista.
        </p>
        <h5>¿ Ya tengo mi usuario y contraseña que hago ?</h3>
        <p> R/ Si ya tienes un usuario y contraseña , debe introducir cada uno en su casilla correspondiente y luego hacer click en ingresar y entraras a la aplicación, si sucede un error puede deberse a que cometiste un error al ingresar tus datos, en ese caso rectifica los datos ingresados , si olvidaste tu contraseña o continua el error contacta el administrador del sistema para ayuda.
        </p>

        <h5> Video vistaso general</h3>
        <video width="370" height="214"  id="demo1" controls style="margin: 0 auto 0 auto; display: block; ">
          <source src="assets/videos/vistasoGeneral.mp4" type="video/mp4">                   
            Tu navegador no soporta videos , actualizalo por favor.
        </video>



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
    <script src="assets/js/vendor/bootstrap.min.js"></script>

  </body>
</html>