<?php
  require_once('seguridad.php');
  session_start();
  require_once('includes/sondeos.php');
  require_once('includes/muestras.php');
  require_once('includes/testlimites.php');
  require_once('includes/proyectos.php');
  require_once('includes/compresion.php');
  require_once('includes/granulometria.php');
  require_once('includes/pesos_retenidos.php');
  require_once('includes/resultados.php');
  require_once('includes/usuarios.php');
  require_once('includes/firmas.php');
  
  $data = $_SESSION['usuario'];
  $usuariosClass = new usuarios();
  $user = $usuariosClass->getUsuarioActual($data['id_usuario']);
  $proyectosClass = new proyectos();
  $proyectos = $proyectosClass->getDatosProyecto($_GET['idp']);
  $sondeosClass = new sondeos();
  $datos_sondeo=$sondeosClass->getDatosSondeo($_GET['ids']);
  $muestras = new muestras();
  $muestrasSondeo = $muestras->getMuestrasSondeo($_GET['ids']);
  $tipo_superficie = $sondeosClass->getListaSuperficie();
  $testLimitesClass = new testlimintes();
  $TestLimitesMuestra = array();
  $datosCompresion= new Compresion();
  foreach ( $muestrasSondeo as $muestra ) {
    //$DatosCompresion[]=$datosCompresion->GetDatosCompresion( $muestra->id_muestra );
    $TestLimitesMuestra[] = $testLimitesClass->getLimitesMuestra( $muestra->id_muestra );
  }
  $datosGranulometria= new granulometria();
  $pesosRetenidosClass= new pesos_retenidos();
  $resultadosClass= new resultados();

  $firmasClass = new firmas();
  $ListaFirmas = $firmasClass->getAllFirmas();
  
  ?>
<!DOCTYPE html>
<html lang="es" class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login - Geotecnia y Ambiente Systems</title>
    <meta name="description" content="El software de Geotecnia y Ambiente es el encargado de procesar los datos obtenidos por los laboratoristas de las muestras de los suelos">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/muestras.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>  
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/vendor/bootstrap.js"></script>
    <script src="assets/js/vendor/highcharts.js"></script>
    <script src="assets/js/vendor/regression.js"></script>
    <link rel="stylesheet" href="assets/css/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify.bootstrap.css" />
  </head>
  <body>
    <!-- ############# HEADER ############### -->
    <div class="row-fluid header">
      <div class="span2">
        <figure class="logo"></figure>
      </div>
      <h3 class="span4 header-title"> </h3>
      <div class="btn-group span3 offset2 datos-perfil ">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <span><i class="icon-user"></i> <?php echo $user->tipo." - ".$user->nombres." ".$user->apellidos; ?></span>
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
    <!-- ############# FIN HEADER ############### -->
    <!-- #############  CUERPO ############### --> 
    <div class="row-fluid cuerpo-proyectos">
      <!-- #############  NAVEGACION SUPERIOR ############### --> 
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="proyectos.php" data-toggle="tooltip" title="Click para ver todos los Proyectos">Proyectos |</a>
            <a class="brand" href="sondeos.php?idp=<?php echo $_GET['idp'] ?>" data-toggle="tooltip" title="Click para  ver los sondeos de este proyecto"> <?php echo $proyectos->nombre_proyecto; ?> |</a>
            <a class="brand" href="#" data-toggle="tooltip" title="Debajo puede ver la información del Sondeo">Información de sondeo</a>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li>
                <a href="#informe" role="button" class="btnInforme"  data-toggle="modal">
                <i  class="icon-list-alt"></i> Impresión
                </a>
              </li>
            </ul>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li>
                <a href="#">Sondeo #<?php echo $_GET['numsondeo'] ?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- ############# FIN NAVEGACION SUPERIOR ############### -->
      <!-- #############  DATOS DE SONDEO ############### -->   
      <div class="info_sondeos">
        <div class="row-fluid">
          <label for="nombre_proyecto_label" class="span2 title">Nivel freatico:</label>
          <label for="nombre_proyecto" class="span1"><?php echo $datos_sondeo->nivel_freatico; ?></label>
          <label for="codigo_proyecto_label" class="span1 title">Superficie:</label>
          <label for="codigo_proyecto" class="span2"><?php echo $datos_sondeo ->tipo_superficie; ?> </label>
          <label for="fecha_proyecto_label" class="span3 title">Profundidad superficie:</label>
          <label for="fecha_proyecto_label" class="span1"><?php echo $datos_sondeo ->profundidad_superficie; ?></label>
          <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
            <a href="#modificarsondeo" role="button" data-toggle="modal" class=" span2"> <i class="icon-edit"></i> Modificar datos</a>
          <?php endif ?>
        </div>
      </div>
      <!-- ############# FIN DATOS DE SONDEO ############### -->
      <!-- #############  TAB EXTERIORES  ############### -->
      <ul id="myTab" class="nav nav-tabs">
        <li class="active">
          <a href="#Muestras" data-toggle="tab">Muestras</a>
        </li>
        <li>
          <a href="#Limites"  data-toggle="tab">Limites de humedad y plasticidad natural</a>
        </li>
        <li>
          <a href="#Compresion" data-toggle="tab">Compresión simple</a>
        </li>
        <li>
          <a href="#Granulometria" data-toggle="tab">Analisis granulometrico</a>
        </li>
        <li>
          <a href="#Informe" data-toggle="tab">Informe de estratigrafia</a>
        </li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="Muestras">
          <!-- #############  NAVEGACION INTERIOR MUESTRAS ############### -->
          <div class="navbar">
            <div class="navbar-inner">
              <div class="container">
                <a class="brand" href="#">Muestras</a>
                <ul class="nav pull-right">
                  <li class="divider-vertical"></li>
                  <li>
                    <a href="#nuevamuestra" role="button" data-toggle="modal">
                    <i class="icon-plus-sign"></i> Nueva muestra
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- ############# FIN NAVEGACION INTERIOR MUESTRAS ############### -->
          <!-- #############  TABLA MUESTRAS ############### -->
          <input type='hidden' id='idp' value="<?php echo $_GET['idp']; ?>">
          <input type='hidden' id='ids' value="<?php echo $_GET['ids']; ?>">
          <table class="table table-hover table-striped table-bordered" id='muestras'>
            <thead>
              <tr>
                <th># Muestra</th>
                <th>Profundidad</th>
                <th>Numero de golpes</th>
                <th>Color</th>
                <th>Material de relleno</th>
                <th>Roca</th>
                <th>Editar</th>
                <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
                  <th>Clonar</th>
                  <th>Eliminar</th>
                <?php endif ?>

              </tr>
            </thead>
            <tbody>
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <tr>
                <td ><span class="titulo-proyectos"><?php echo $i; ?></span></td>
                <td>
                  <span class="badge">Desde <span> <?php echo $datoMuestra->profundidad_inicial ?> metros</span>----<span class='badge' >Hasta <?php echo $datoMuestra->profundidad_final ?> metros</span>
                </td>
                <td><?php echo $datoMuestra->numero_golpes ?></td>
                <td><?php echo $datoMuestra->descripcion ?></td>
                <td><?php if($datoMuestra->material_de_relleno==1){ echo "Si"; } else { echo "No"; } ?></td>
                <td><?php if($datoMuestra->material_de_relleno==2){ echo "Si"; } else { echo "No"; } ?></td>
                
                  <td>
                    <a rel='<?php echo $datoMuestra->id_muestra.",".$datoMuestra->profundidad_inicial.",".$datoMuestra->profundidad_final.",".$datoMuestra->descripcion.",".$datoMuestra->material_de_relleno.",".$datoMuestra->numero_golpes; ?>' id="<?php echo $datoMuestra->id_muestra ?>" class="modalMuestra" role="button" data-toggle="modal" href="#editarmuestra">
                    <i class='icon-wrench'></i>
                    </a>
                  </td>
                <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
                  <td>
                    <a rel='<?php echo $datoMuestra->id_muestra.",".$datoMuestra->profundidad_inicial.",".$datoMuestra->profundidad_final.",".$datoMuestra->descripcion.",".$datoMuestra->material_de_relleno.",".$datoMuestra->numero_golpes; ?>' id="<?php echo $datoMuestra->id_muestra ?>" class="clonarMuestra" role="button" data-toggle="modal" href="#clonarmuestra">
                    <i class='icon-wrench'></i>
                    </a>
                  </td>
                <?php endif ?>
                <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
                    <td>
                      <a class="eliminarMuestra" href="#"><i class="icon-remove"></i></a>
                      <form action="save.php">
                        <input type="hidden" name="func" value="eliminarMuestra">
                        <input type="hidden" name="idMuestra" value="<?php echo $datoMuestra->id_muestra; ?>">
                      </form>
                  </td>
                <?php endif ?>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php if ( $data['tipo']=='Administrador' || $data['tipo']=='Ingeniero') : ?>
                <td colspan="9">No hay datos que mostrar</td>
              <?php else : ?>
                <td colspan="8">No hay datos que mostrar</td>
              <?php endif ?>

              <?php endif; ?>
            </tbody>
          </table>
          <!-- #############  FIN TABLA MUESTRAS ############### -->
        </div>
        <!-- ############# tabs de muestras internas limites ############### -->
        <div class="tab-pane fade" id="Limites">
          <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; $arrLimites = array(); $arrCompresion= array(); ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              
              <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
                <li class="<?php echo (($i==1)?'active':''); ?>">
                  <a href="#muestra<?php echo $i; ?>"  data-toggle="tab">Muestra <?php echo $i; ?> </a>
                </li>
                <?php $i++; ?>
              <?php endif; ?>

              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>

              <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
                <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="muestra<?php echo $i; ?>">
                  <!-- #############  HUMEDAD NATURAL ############### -->
                  <span class="title pull-left">Muestra <?php echo $i; ?></span>
                  <h3>Humedad natural</h3>
                  <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                    <input type="hidden" name="func" value="testlimites">
                    <input type="hidden" name="muestra" value="0">
                    <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                    <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][0]->id_test.",".$TestLimitesMuestra[$i-1][1]->id_test.",".$TestLimitesMuestra[$i-1][2]->id_test; ?>">
                    <table class="table table-hover table-striped table-bordered humedad">
                      <thead>
                        <tr>
                          <th>Prueba #</th>
                          <th>Capsula #</th>
                          <th>Peso capsula gr.</th>
                          <th>Peso capsula + Suelo humedo gr.</th>
                          <th>Peso capsula + Suelo seco gr.</th>
                          <th>Peso del suelo gr.</th>
                          <th>Peso del agua gr.</th>
                          <th>Contenido agua (W) %</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>
                            <input name="humedadCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][0]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoCapsular[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][0]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoSueloHumedo[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoSueloSeco[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][0]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php 
                              if($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco!=0 ){
                                    echo $porcentajeAgua1 = round((($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][0]->peso_capsula )) * 100, 2);
                              }
                              else{
                                    echo 0;
                              }
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <input name="humedadCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][1]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoCapsular[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][1]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoSueloHumedo[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoSueloSeco[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][1]->peso_capsula!=0){
                                echo round(($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][1]->peso_capsula ), 2); 
                              } 
                              else{
                              echo 0;
                              }                          
                              ?>
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco!=0 ){
                                echo $porcentajeAgua2 = round((($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][1]->peso_capsula )) * 100, 2); 
                              }else{
                              echo 0;
                              }                
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>
                            <input name="humedadCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][2]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoCapsular[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][2]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoSueloHumedo[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="humedadPesoSueloSeco[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][2]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco!=0){
                                 echo $porcentajeAgua3 = round((($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][2]->peso_capsula )) * 100, 2); 
                              }
                               else{
                                echo 0;
                              }
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td> </td>
                          <td><strong>Total</strong></td>
                          <td>
                            <?php
                              $resultado = 0;
                              $menor = min( array( $porcentajeAgua1, $porcentajeAgua2 ) );
                              $mayor = max( array( $porcentajeAgua1, $porcentajeAgua2 ) );
                              if($mayor!=0 AND $menor!=0){
                              $divMayorMenor1 = $mayor / $menor;
                              }
                              if ( $divMayorMenor1 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              $menor = min( array( $porcentajeAgua2, $porcentajeAgua3 ) );
                              $mayor = max( array( $porcentajeAgua2, $porcentajeAgua3 ) );
                              if($mayor!=0 AND $menor!=0){
                                $divMayorMenor2 = $mayor / $menor;
                              }
                              if ( $divMayorMenor2 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              $menor = min( array( $porcentajeAgua1, $porcentajeAgua3 ) );
                              $mayor = max( array( $porcentajeAgua1, $porcentajeAgua3 ) );
                              if($mayor!=0 AND $menor!=0){
                                  $divMayorMenor3 = $mayor / $menor;
                               }
                              if ( $divMayorMenor3 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              if ( $divMayorMenor1 > 1.29 && $divMayorMenor2 > 1.29 && $divMayorMenor3 > 1.29 ) {
                                $resultado = 0;
                              }
                                echo round($resultado);
                              ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                  <!-- ############# FIN HUMEDAD NATURAL ############### -->
                  <!-- #############  LIMITE LIQUIDO ############### -->
                  <h3>Limite liquido</h3>
                  <a href="#"  class="btn btn-info pull-right title noliquido" >Pulsar si el suelo es NO LIQUIDO</a>
                  <br>
                  <br>
                  <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                    <input type="hidden" name="func" value="testlimites" />
                    <input type="hidden" name="muestra" value="1" />
                    <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                    <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][3]->id_test.",".$TestLimitesMuestra[$i-1][4]->id_test.",".$TestLimitesMuestra[$i-1][5]->id_test; ?>">
                    <table class="table table-hover table-striped table-bordered liquido">
                      <thead>
                        <tr>
                          <th>Prueba #</th>
                          <th>Capsula # </th>
                          <th>Golpes # </th>
                          <th>Peso capsula gr.</th>
                          <th>Peso capsula + Suelo humedo gr.</th>
                          <th>Peso capsula + Suelo seco gr.</th>
                          <th>Peso del suelo gr.</th>
                          <th>Peso del agua gr.</th>
                          <th>Contenido agua (W) %</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>
                            <input name="liquidoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][3]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="liquidoGolpes[]" class="input-mini limites iliquido ngolpes" type="text" value="<?php echo $TestLimitesMuestra[$i-1][3]->num_golpes; ?>">
                          </td>
                          <td>
                            <input name="liquidoPeso[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][3]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="liquidoPesoSueloHumedo[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="liquidoPesoSueloSeco[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <?php $temp = new stdClass; ?>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][3]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco!=0){
                                  $porcentajeLiquido1 = round((($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][3]->peso_capsula )) * 100, 2);
                                  echo $porcentajeLiquido1;
                              }
                              else{
                              echo 0;
                              }                            
                              ?>
                          </td>
                          <?php
                            $temp->golpes1 = $TestLimitesMuestra[$i-1][3]->num_golpes;
                            $temp->porcentaje1 = $porcentajeLiquido1;
                            ?>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <input name="liquidoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="liquidoGolpes[]" class="input-mini limites iliquido ngolpes" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->num_golpes; ?>">
                          </td>
                          <td>
                            <input name="liquidoPeso[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="liquidoPesoSueloHumedo[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="liquidoPesoSueloSeco[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][4]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco!=0){
                                 $porcentajeLiquido2 = round((($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][4]->peso_capsula )) * 100, 2); 
                                 echo $porcentajeLiquido2;
                              }
                              else{
                              echo 0;  
                              }
                              ?>
                          </td>
                        </tr>
                        <?php
                          $temp->golpes2 = $TestLimitesMuestra[$i-1][4]->num_golpes;
                          $temp->porcentaje2 = $porcentajeLiquido2;
                          ?>
                        <tr>
                          <td></td>
                          <td>
                            <input name="liquidoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="liquidoGolpes[]" class="input-mini ngolpes" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->num_golpes; ?>">
                          </td>
                          <td>
                            <input name="liquidoPeso[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="liquidoPesoSueloHumedo[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="liquidoPesoSueloSeco[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][5]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco!=0){
                                $porcentajeLiquido3 = round((($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][5]->peso_capsula )) * 100, 2); 
                                echo $porcentajeLiquido3;
                              }
                              else{
                              echo 0;
                              }
                              ?>
                          </td>
                        </tr>
                        <?php
                          $temp->golpes3 = $TestLimitesMuestra[$i-1][5]->num_golpes;
                          $temp->porcentaje3 = $porcentajeLiquido3;
                          array_push($arrLimites, $temp);
                          
                          ?>
                        <tr>
                          <td></td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td> </td>
                          <td></td>
                          <td><strong>Total</strong></td>
                          <td>
                            <?php 
                              $humedad1=$porcentajeLiquido1;
                              $humedad2=$porcentajeLiquido2;
                              $humedad3=$porcentajeLiquido3;
                              $golpes1=$TestLimitesMuestra[$i-1][3]->num_golpes;
                              $golpes2=$TestLimitesMuestra[$i-1][4]->num_golpes;
                              $golpes3=$TestLimitesMuestra[$i-1][5]->num_golpes;
                              if($golpes1!=0 && $golpes2!=0 && $golpes3!=0    ){
                                  if($humedad2!=0){
                                      $pendiente1=($humedad2-$humedad1)/($golpes2-$golpes1);
                                      $pendiente2=($humedad3-$humedad1)/($golpes3-$golpes1);
                                      $pendiente3=($humedad3-$humedad2)/($golpes3-$golpes2);
                                  }
                              }
                              $limite1=($pendiente1*25)-($pendiente1*$golpes1)+$humedad1;
                              $limite2=($pendiente2*25)-($pendiente2*$golpes3)+$humedad3;
                              $limite3=($pendiente3*25)-($pendiente3*$golpes2)+$humedad2;
                              
                              $LimiteLiquido=($limite1+$limite2+$limite3)/3;
                              if($LimiteLiquido>=0){
                                  echo round($LimiteLiquido);
                              }
                              else{
                                  echo 0;
                              }
                              
                              ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                  <input id="datosgraficaLimites<?php echo $i; ?>" class="datosgraficaLimites"  type="hidden" value="[<?php echo $arrLimites[$i-1]->golpes1?>,<?php echo $arrLimites[$i-1]->porcentaje1?>],[<?php echo $arrLimites[$i-1]->golpes2?>,<?php echo $arrLimites[$i-1]->porcentaje2?>],[<?php echo $arrLimites[$i-1]->golpes3?>,<?php echo $arrLimites[$i-1]->porcentaje3?>]">
                  <div id="graficaLimites<?php echo $i; ?>" style=" widht:100%; height: 400px; display: inline-block;"></div>
                  <!-- #############  LIMITE PLASTICO ############### -->
                  <h3>Limite plastico</h3>
                  <a href="#"  class="btn btn-info pull-right title noplastico">Pulsar si el suelo es NO PLASTICO</a>
                  <br>
                  <br>
                  <form class="muestra<?php echo $i; ?> formResultados" action="save.php" method="post" accept-charset="utf-8">
                    <input type="hidden" name="func" value="testlimites" />
                    <input type="hidden" name="muestra" value="2" />
                    <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                    <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][6]->id_test.",".$TestLimitesMuestra[$i-1][7]->id_test.",".$TestLimitesMuestra[$i-1][8]->id_test; ?>">
                    <table class="table table-hover table-striped table-bordered plastico">
                      <thead>
                        <tr>
                          <th>Prueba #</th>
                          <th>Capsula #</th>
                          <th>Peso capsula gr.</th>
                          <th>Peso capsula + Suelo humedo gr.</th>
                          <th>Peso capsula + Suelo seco gr.</th>
                          <th>Peso del suelo gr.</th>
                          <th>Peso del agua gr.</th>
                          <th>Contenido agua (W) %</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>
                            <input name="plasticoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][6]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="plasticoPeso[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][6]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="plasticoPesoSueloHumedo[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="plasticoPesoSueloSeco[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][6]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco!=0){
                                echo $porcentajePlastico1 = round((($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][6]->peso_capsula )) * 100, 2); 
                              }
                              else{
                              echo 0;
                              }
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <input name="plasticoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][7]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="plasticoPeso[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][7]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="plasticoPesoSueloHumedo[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="plasticoPesoSueloSeco[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][7]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco!=0){
                                echo $porcentajePlastico2 = round((($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][7]->peso_capsula )) * 100, 2); 
                              }  
                              else{
                              echo 0;
                              }                         
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>
                            <input name="plasticoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][8]->nom_capsula; ?>">
                          </td>
                          <td>
                            <input name="plasticoPeso[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][8]->peso_capsula; ?>">
                          </td>
                          <td>
                            <input name="plasticoPesoSueloHumedo[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_humedo; ?>">
                          </td>
                          <td>
                            <input name="plasticoPesoSueloSeco[]" class="input-mini limites" type="text" value="<?php echo $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco; ?>">
                          </td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][8]->peso_capsula ), 2); ?></td>
                          <td><?php echo round(($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco ), 2); ?></td>
                          <td>
                            <?php
                              if($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco!=0){
                                echo $porcentajePlastico3 = round((($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][8]->peso_capsula )) * 100, 2);
                              }  
                              else{
                              echo 0;
                              }             
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td> </td>
                          <td><strong>Total</strong></td>
                          <td>
                            <?php
                              $resultado = 0;
                              $menor = min( array( $porcentajePlastico1, $porcentajePlastico2 ) );
                              $mayor = max( array( $porcentajePlastico1, $porcentajePlastico2 ) );
                              if($mayor!=0 && $menor!=0){                          
                                $divMayorMenor1 = $mayor / $menor;
                              }
                              if ( $divMayorMenor1 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              $menor = min( array( $porcentajePlastico2, $porcentajePlastico3 ) );
                              $mayor = max( array( $porcentajePlastico2, $porcentajePlastico3 ) );
                              if($mayor!=0 && $menor!=0){
                                $divMayorMenor2 = $mayor / $menor;
                              }    
                              if ( $divMayorMenor2 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              $menor = min( array( $porcentajePlastico1, $porcentajePlastico3 ) );
                              $mayor = max( array( $porcentajePlastico1, $porcentajePlastico3 ) );
                              if($mayor!=0 && $menor!=0){
                                $divMayorMenor3 = $mayor / $menor;
                               } 
                              if ( $divMayorMenor3 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              if ( $divMayorMenor1 > 1.29 && $divMayorMenor2 > 1.29 && $divMayorMenor3 > 1.29 ) {
                                $resultado = 0;
                              }
                                 echo $limitePlastico=round($resultado);
                              ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- ############# FIN LIMITE PLASTICO ############### -->
                    <!-- ############# RESULTADOS ############### -->
                    <h3>Resultados</h3>
                    <table class="table table-hover table-striped table-bordered resultados">
                      <thead>
                        <tr>
                          <th>Humedad natural %</th>
                          <th>Limite liquido %</th>
                          <th>Limite plastico %</th>
                          <th>Indice de plasticidad %</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <?php
                              $resultado = 0;
                                    $menor = min( array( $porcentajeAgua1, $porcentajeAgua2 ) );
                                    $mayor = max( array( $porcentajeAgua1, $porcentajeAgua2 ) );
                                    if($mayor!=0 AND $menor!=0){
                                    $divMayorMenor1 = $mayor / $menor;
                                    }
                                    if ( $divMayorMenor1 < 1.29 ) {
                                      $resultado = ($mayor + $menor)/2;
                                    }
                                    $menor = min( array( $porcentajeAgua2, $porcentajeAgua3 ) );
                                    $mayor = max( array( $porcentajeAgua2, $porcentajeAgua3 ) );
                                    if($mayor!=0 AND $menor!=0){
                                      $divMayorMenor2 = $mayor / $menor;
                                    }
                                    if ( $divMayorMenor2 < 1.29 ) {
                                      $resultado = ($mayor + $menor)/2;
                                    }
                                    $menor = min( array( $porcentajeAgua1, $porcentajeAgua3 ) );
                                    $mayor = max( array( $porcentajeAgua1, $porcentajeAgua3 ) );
                                    if($mayor!=0 AND $menor!=0){
                                        $divMayorMenor3 = $mayor / $menor;
                                     }
                                    if ( $divMayorMenor3 < 1.29 ) {
                                      $resultado = ($mayor + $menor)/2;
                                    }
                                    if ( $divMayorMenor1 > 1.29 && $divMayorMenor2 > 1.29 && $divMayorMenor3 > 1.29 ) {
                                      $resultado = 0;
                                    }
                                      $HumedadNaturalFinal=ceil(round($resultado,2));
                                      echo $HumedadNaturalFinal;
                                      $porcentajeAgua1=0;
                                      $porcentajeAgua2=0;
                                      $porcentajeAgua3=0;
                                
                              
                              ?>
                          </td>
                          <td>
                            <?php
                              if($LimiteLiquido>=0){
                                
                                $LimiteLiquidoFinal=round($LimiteLiquido,2);  
                                echo $LimiteLiquidoFinal;
                              }  
                              else{
                                 echo 0;
                              }
                                $porcentajeLiquido1=0;
                                $porcentajeLiquido2=0;
                                $porcentajeLiquido3=0; 
                                $golpes1=0;
                                $golpes2=0;
                                $golpes3=0;                                                         
                              ?>
                          </td>
                          <td>
                            <?php
                              $resultado = 0;
                              $menor = min( array( $porcentajePlastico1, $porcentajePlastico2 ) );
                              $mayor = max( array( $porcentajePlastico1, $porcentajePlastico2 ) );
                              if($mayor!=0 AND $menor!=0){                          
                                $divMayorMenor1 = $mayor / $menor;
                              }
                              if ( $divMayorMenor1 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              $menor = min( array( $porcentajePlastico2, $porcentajePlastico3 ) );
                              $mayor = max( array( $porcentajePlastico2, $porcentajePlastico3 ) );
                              if($mayor!=0 AND $menor!=0){
                                $divMayorMenor2 = $mayor / $menor;
                              }    
                              if ( $divMayorMenor2 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              $menor = min( array( $porcentajePlastico1, $porcentajePlastico3 ) );
                              $mayor = max( array( $porcentajePlastico1, $porcentajePlastico3 ) );
                              if($mayor!=0 AND $menor!=0){
                                $divMayorMenor3 = $mayor / $menor;
                               } 
                              if ( $divMayorMenor3 < 1.29 ) {
                                $resultado = ($mayor + $menor)/2;
                              }
                              if ( $divMayorMenor1 > 1.29 && $divMayorMenor2 > 1.29 && $divMayorMenor3 > 1.29 ) {
                                $resultado = 0;
                              }
                              echo $limitePlastico=round($resultado,2);
                                 
                              ?>
                          </td>
                          <td>
                            <?php
                              if($LimiteLiquido>=0){
                                 $indicePlasticidadFinal= round($LimiteLiquido-$limitePlastico);    
                                 echo  $indicePlasticidadFinal;
                              }
                              else{
                                echo 0;
                              }
                                    $porcentajePlastico1=0;
                                    $porcentajePlastico2=0;
                                    $porcentajePlastico3=0;
                              ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <input name="humedadFinal" type="hidden" class="HumedadNaturalFinal" value="<?php echo $HumedadNaturalFinal; ?>">
                    <input name="limiteLiquidoFinal" type="hidden" class="LimiteLiquidoFinal" value="<?php echo $LimiteLiquidoFinal; ?>">          
                    <input name="limitePlasticoFinal" type="hidden" class="LimitePlasticoFinal" value="<?php echo $limitePlastico; ?>"> 
                    <input name="indicePlasticidadFinal" type="hidden" class="IndicePlasticidadFinal" value="<?php echo $indicePlasticidadFinal; ?>"> 
                  </form>
                  <!-- ############# FIN RESULTADOS HUMEDAD Y LIMITE ############### -->
                  <div class="form-actions">
                    <a href="#" rel="muestra<?php echo $i; ?>" class="guardaLimites btn btn-primary input-xlarge">Guardar información</a>
                  </div>
                </div>
                <?php $i++;?>  
              <?php endif; ?>

              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </div>
          </div>
          <!-- ############# fin tabs de muestras internas limites ############### -->
        </div>
        <div class="tab-pane fade" id="Compresion">
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->
          <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
                <li class="<?php echo (($i==1)?'active':''); ?>">
                  <a href="#compresion<?php echo $i; ?>" data-toggle="tab">Muestra <?php echo $i; ?> </a>
                </li>
                <?php $i++; ?>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              
              <?php if( $datoMuestra->material_de_relleno!=2 ): ?>

              <?php $DatosCompresion = $datosCompresion->GetDatosCompresion( $datoMuestra->id_muestra );  ?>
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="compresion<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA ############### -->
                <span class="title pull-left">Muestra <?php echo $i; ?></span>
                <h3>Medidas de la muestra</h3>
                <form class="compresion<?php echo $i; ?> formResultadosCompresion" action="save.php" method="post" accept-charset="utf-8">
                  <input name="fk_idmuestra" type="hidden" value="<?php echo $datoMuestra->id_muestra; ?>">
                  <table class="table table-hover table-striped table-bordered tablacompresion ">
                    <thead>
                      <tr>
                        <th>Diametro (cm)</th>
                        <th>Altura (cm)</th>
                        <th>Peso gr.</th>
                        <th>Tipo de falla</th>
                        <th>Area</th>
                        <th>Volumen</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <input class="input-mini " name="compresionId" value="<?php echo $DatosCompresion->id_compresion; ?>" type="hidden" >
                          <input class="input-mini icompresion" name="compresionDiametro" value="<?php echo $DatosCompresion->diametro; ?>" type="text" >
                        </td>
                        <td>
                          <input class="input-mini icompresion" name="compresionAltura" value="<?php echo $DatosCompresion->altura; ?>" type="text" >
                        </td>
                        <td>
                          <input class="input-mini icompresion" name="compresionPeso" value="<?php echo $DatosCompresion->peso; ?>" type="text" >
                        </td>
                        <td>
                          <input class="input-large icompresion" name="compresionTipofalla" value="<?php echo $DatosCompresion->tipoFalla; ?>" type="text" >
                        </td>
                        <td>
                          <?php 
                            $diametro2= $DatosCompresion->diametro* $DatosCompresion->diametro;
                            $pi=pi();
                            $area=($pi*$diametro2)/4;
                            echo round($area,2);
                            ?>
                        </td>
                        <td>
                          <?php $volumen=$area * $DatosCompresion->altura; 
                            echo round($volumen,2);
                            ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- ############# FIN MEDIDAS DE LA MUESTRA ############### -->
                  <!-- #############  TABLA DE COMPRESIÓN ############### -->
                  <h3>Tabla de deformación</h3>
                  <table class="table table-hover table-striped table-bordered tabladeformacion">
                    <thead>
                      <tr>
                        <th>Deformación(Pulg3)</th>
                        <th>Carga (N)</th>
                        <th>Deformación total</th>
                        <th>Carga (Kg)</th>
                        <th>Area corregida cm2</th>
                        <th>Esfuerzo (Kg/cm2)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $DatosDeformaciones = $datosCompresion->GetDatosDeformaciones( $DatosCompresion->id_compresion); ?>
                      <?php if ($DatosDeformaciones>0): ?>
                      <?php $k=0; $m=1;?>
                      <?php foreach ( $DatosDeformaciones as $deformaciones ):?>                    
                      <tr>
                        <td>
                          <input class="input-mini " name="compresionIdDeformacion[]" type="hidden" value="<?php echo $deformaciones ->id_deformacion ?>">
                          <input class="input-mini" name="func" type="hidden" value="UpdateCompresion">
                          <?php echo $deformaciones ->deformacion; 
                            ?>
                        </td>
                        <td>
                          <input class="input-mini ideformacion" name="compresionDeformaciones[]" type="text" value="<?php echo $deformaciones ->carga ?>">
                        </td>
                        <td class="gdeformacion">
                          <?php if($deformaciones ->carga>0) {
                            $deformacionTotal=($deformaciones ->deformacion*2.54)/1000;
                            echo round($deformacionTotal,2); 
                            $gdt[$k]=round($deformacionTotal,2);
                            } 
                            else{
                            echo 0;
                            }
                            ?>
                        </td>
                        <td>
                          <?php if($deformaciones ->carga>0) {
                            $cargakg=$deformaciones ->carga/10;
                             echo round($cargakg,2);
                            } 
                            else{
                              echo 0;
                            }
                            ?>
                        </td>
                        <td>
                          <?php if($deformaciones ->carga>0 AND $area!=0 ) {
                            $areaCorregida= $area/(1-($deformacionTotal/$DatosCompresion->altura));
                            echo round($areaCorregida,2);
                            } 
                            else{
                            echo 0;
                            }
                            ?>
                        </td>
                        <td>
                          <?php if($deformaciones ->carga>0 AND $areaCorregida!=0) {
                            $esfuerzo= $cargakg/$areaCorregida;
                            echo round($esfuerzo,2);
                            $ge[$k]=round($esfuerzo,2);
                            $mayoresfuerzo[] =$esfuerzo;
                            } 
                            else{
                            echo 0;
                            }
                            ?>
                        </td>
                      </tr>
                      <?php $k++ ?>
                      <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                  <!-- ############# TABLA DE COMPRESIÓN ############### -->
                  <!-- ############# GRAFICA DE COMPRESIÓN ############### -->
                  <?php 
                    $tamano=count($gdt);
                    $t=$tamano-1;
                    for($l=0; $l<=$t; $l++){
                       if(isset($gdt[$l]) AND isset($ge[$l])){
                          if($l<$t){
                            $datos=$datos."[".$gdt[$l].",".$ge[$l]."],";
                          }
                          else{
                            $datos=$datos."[".$gdt[$l].",".$ge[$l]."]"; 
                          }
                       }
                    }
                    ?>
                  <input id="datosgraficacompresion<?php echo $i; ?>" class="datosgraficaCompresion"  type="hidden" value="<?php echo $datos?>">
                  <div id="graficacompresion<?php echo $i; ?>" style=" widht:100%; height: 400px; display: inline-block;"></div>
                  <?php 
                    unset($gdt);
                    unset($ge);
                    unset($datos);
                    ?>
                  <!-- ############# FIN GRAFICA DE COMPRESIÓN ############### -->
                  <!-- ############# RESULTADOS ############### -->
                  <h3>Resultados</h3>
                  <table class="table table-hover table-striped table-bordered resultadoscompresion">
                    <thead>
                      <tr>
                        <th> Diametro cm</th>
                        <th> Altura cm</th>
                        <th> Peso</th>
                        <th> Tipo de falla</th>
                        <th> Area</th>
                        <th> Volumen</th>
                        <th> Peso unitario</th>
                        <th> Cohesión</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <?php echo $DatosCompresion->diametro; ?> </td>
                        <td>  <?php echo $DatosCompresion->altura; ?> </td>
                        <td> <?php echo $DatosCompresion->peso; ?></td>
                        <td> <?php echo $DatosCompresion->tipoFalla; ?> </td>
                        <td> <?php echo round($area,2); ?> </td>
                        <td> <?php echo round($volumen,2); ?> </td>
                        <td> <?php  
                          if($DatosCompresion->peso!=0){
                                $pesoUnitario=($DatosCompresion->peso/ $volumen)*10;
                                $pesoUnitarioFinal=round($pesoUnitario,2);
                                echo $pesoUnitarioFinal; 
                          }
                          ?>
                        </td>
                        <td>
                          <?php if($mayoresfuerzo!=null):?>
                          <?php sort($mayoresfuerzo);?>
                          <?php endif;?>
                          <?php
                            $posicion=count($mayoresfuerzo); 
                            if($mayoresfuerzo[$posicion-1]!=0){
                               $cohesion=($mayoresfuerzo[$posicion-1]/2)*100;                                 
                                 if($posicion==7){
                                   $cohesionFinal= round($cohesion,2);
                                   echo $cohesionFinal;  
                                   unset($mayoresfuerzo);
                                 }
                            }
                            ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <input name="pesoUnitarioFinal" class="pesoUnitarioFinal" type="hidden" value="<?php echo $pesoUnitarioFinal; ?>">
                  <input name="cohesionFinal" Class="cohesionFinal" type="hidden" value="<?php echo $cohesionFinal; ?>">
                </form>
                <!-- ############# FIN RESULTADOS compresion ############### -->
                <!-- ############# GUARDAR INFORMACION BOTON ############### -->
                <div class="form-actions">
                  <a href="#" rel="compresion<?php echo $i; ?>" class="GuardarCompresion btn btn-primary input-xlarge">Guardar información</a>
                </div>
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->  
              </div>
              <?php $i++; ?>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>              
            </div>
          </div>
          <!-- ############# fin tabs de muestras internas GRANULOMETRIA ########### -->
          <!-- ############# fin tabs de muestras internas GRANULOMETRIA ############### -->
        </div>
        <div class="tab-pane fade" id="Granulometria">
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->
          <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>

              <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
                <li class="<?php echo (($i==1)?'active':''); ?>">
                  <a href="#granulometria<?php echo $i; ?>" data-toggle="tab">Muestra <?php echo $i; ?> </a>
                </li>
                <?php $i++; ?>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
              <?php $DatosGranulometria = $datosGranulometria->getDatoGranulometria( $datoMuestra->id_muestra );  ?>
              <?php $resultado= $resultadosClass->getResultado($datoMuestra->id_muestra); ?>
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="granulometria<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA GRANULOMETRIA############### -->
                <span class="title pull-left">Muestra <?php echo $i; ?></span>
                <h3> Analisis granulometrico </h3>
                <form class="granulometria<?php echo $i; ?> resultadosGranulometria" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="granulometria">
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idgranulometria" value="<?php echo $DatosGranulometria->id_granulometria ?>">
                  <table class="table table-hover table-striped table-bordered tablaanalisis">
                    <thead>
                      <tr>
                        <th>Peso recipiente gr</th>
                        <th>Peso recipiente + muestra</th>
                        <th>Peso muestra seca</th>
                        <th>Peso retenido N°200 + recipiente</th>
                        <th>Peso retenido N°200 </th>
                        <th>Suma pesos retenidos</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <input name="pesoRecipiente" class="input-mini analisis" type="text" value="<?php echo $DatosGranulometria->pesoRecipiente?>"> </td>
                        <td> <input name="pesoRecipienteMasMuestra" class="input-mini analisis" type="text" value="<?php echo $DatosGranulometria->pesoRecipienteMasMuestra ?>"> </td>
                        <td> <?php echo $DatosGranulometria->pesoRecipienteMasMuestra- $DatosGranulometria->pesoRecipiente ?></td>
                        <td>  
                          <?php 
                            $DatosRetenidos=$pesosRetenidosClass->getDatoPesosRetenidos($DatosGranulometria->id_granulometria);
                            $j=0;
                            foreach ( $DatosRetenidos as $retenidos ):
                            $suma+=$retenidos->pesoRetenido;
                            if($j==17){
                            $pesoretenidomasrecipiente=$suma+$DatosGranulometria->pesoRecipiente;
                            $sumapesoretenidos=$suma;
                            echo $suma+$DatosGranulometria->pesoRecipiente;
                            $suma=0;
                            $j=0;
                            }
                            $j++;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $pesoretenidoN200=$pesoretenidomasrecipiente-$DatosGranulometria->pesoRecipiente ?></td>
                        <td> <?php echo $sumapesoretenidos ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- ############# FIN MEDIDAS DE LA MUESTRA GRANULOMETRIA ############### -->
                  <!-- #############  TABLA DE GRANULOMETRIA ############### -->
                  <h3>Tabla de granulometria</h3>
                  <table class="table table-hover table-striped table-bordered tablapesos">
                    <thead>
                      <tr>
                        <th>Tamiz</th>
                        <th>Tamaño(mm)</th>
                        <th>Peso retenido gr</th>
                        <th>Peso retenido corregido gr</th>
                        <th>Retenido %</th>
                        <th>Retenido acumulado %</th>
                        <th>Pasa %</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($DatosRetenidos>0): ?>
                      <?php $j = 0; $temp = array(); ?>
                      <?php foreach ( $DatosRetenidos as $retenidos ):?>
                      <tr>
                        <td><?php echo $retenidos->tamiz ?>
                          <input name="idPesoRetenido[]" class="input-mini" type="hidden" value="<?php echo $retenidos->idPesoRetenido ?>">
                        </td>
                        <td class="tamTamiz"><?php echo $tamañoTamiz[]=$retenidos->tamanoTamiz ?></td>
                        <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $retenidos->pesoRetenido ?>"> </td>
                        <?php 
                          if($retenidos->pesoRetenido>0){
                              $pr[]=$retenidos->tamanoTamiz;
                          }
                          ?>
                        <?php $fondopesoretenido=$DatosGranulometria->pesoRecipienteMasMuestra-$pesoretenidomasrecipiente;
                          $totalpesoretenido=$sumapesoretenidos+$fondopesoretenido;
                          ?>
                        <td><?php 
                          if($pesoretenidoN200!=0){
                               $pesoretenidocorregido=$retenidos->pesoRetenido-(($sumapesoretenidos-$pesoretenidoN200)*$retenidos->pesoRetenido/$pesoretenidoN200);
                              echo number_format($pesoretenidocorregido,2);
                          }
                          else{
                              echo 0;
                          }
                          ?>
                        </td>
                        <?php  
                          if($sumapesoretenidos!=0){
                               $totalpesoretenidocorregido=$totalpesoretenido-($sumapesoretenidos-$pesoretenidoN200)*$totalpesoretenido/$sumapesoretenidos;
                          }
                          ?>
                        <td class="retenido" >
                          <?php
                            if($totalpesoretenidocorregido!=0){
                                 $retenidoporcentaje = round($pesoretenidocorregido/$totalpesoretenidocorregido*100,2);
                                 echo number_format($retenidoporcentaje,2);
                            }
                            else{
                                 echo 0;
                            }
                            ?>
                        </td>
                        <?php if ( $j == 0 ) array_push($temp, ($retenidoporcentaje + 0)); else array_push($temp, $retenidoporcentaje + $temp[$j-1]); ?>
                        <td class="acumulado" ><?php echo number_format($temp[$j],2); ?></td>
                        <td class="pasa">
                          <?php $pasa= 100 - $temp[$j];
                              echo number_format($pasa,2);
                            if($retenidos->pesoRetenido>0){
                               $p[]=$pasa;
                            }
                               $tamices[]=$pasa;
                            ?>
                        </td>
                      </tr>
                      <?php $j++; ?>
                      <?php endforeach?>
                      <?php endif; ?>
                      <tr>
                        <td> Fondo </td>
                        <td> 0</td>
                        <td> <?php echo $fondopesoretenido=$DatosGranulometria->pesoRecipienteMasMuestra-$pesoretenidomasrecipiente ?></td>
                        <td> 
                          <?php
                            if($sumapesoretenidos!=0){
                               echo $fondopesocorregido=$fondopesoretenido-(($sumapesoretenidos-$trabajo-$pesoretenidoN200))*$fondopesoretenido/$sumapesoretenidos;
                            } 
                            else{
                               echo 0;
                            }
                            ?>
                        </td>
                        <td class="retenido"> 
                          <?php
                            if($totalpesoretenidocorregido!=0){
                                echo $Fondoretenido=round($fondopesoretenido/$totalpesoretenidocorregido*100,2);
                            }
                            ?>
                        </td>
                        <td class="acumulado"><?php 
                          echo $FondoRetenidoAcomulado=round($Fondoretenido+$temp[13],2);
                               $fondor=round($FondoRetenidoAcomulado);
                          ?>
                        </td>
                        <td> <?php echo 100 - $fondor ; ?></td>
                      </tr>
                      <tr>
                        <td> Total </td>
                        <td> </td>
                        <td> <?php echo $totalpesoretenido=$sumapesoretenidos+$fondopesoretenido?></td>
                        <td> <?php 
                          if($totalpesoretenido==0){
                            $totalpesoretenidocorregido=0;
                          }
                          echo $totalpesoretenidocorregido;
                          ?>
                        </td>
                        <td>  </td>
                        <td>  </td>
                        <td>  </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- ############# TABLA DE GRANULOMETRIA ############### -->
                  <!-- ############# GRAFICA DE GRANULOMETRIA ############### -->
                  <?php 
                    $tamano=count($pr);
                    if(isset($pr) && isset($p)){
                      $pr=array_reverse($pr);
                      $p=array_reverse($p);
                    }
                    
                    $t=$tamano-1;
                    for($l=0; $l<=$t; $l++){
                       if(isset($pr[$l]) AND isset($p[$l])){
                          if($l<$t){
                            $datos=$datos."[".$pr[$l].",".$p[$l]."],";
                          }
                          else{
                            $datos=$datos."[".$pr[$l].",".$p[$l]."]"; 
                          }
                       }
                    }
                    ?>
                  <input id="datosgraficagranulometria<?php echo $i; ?>" class="datosgraficaGranulometria"  type="hidden" value="<?php  echo $datos; ?>">
                  <div id="graficagranulometria<?php echo $i; ?>" style=" widht:100%; height: 400px; display: inline-block;"></div>
                  <!-- ############# FIN GRAFICA DE GRANULOMETRIA ############### -->
                  <!-- ############# RESULTADOS ############### -->
                  <?php 
                    unset($pr);
                    unset($p);
                    unset($datos); 
                    ?>
                  <h3>Observaciones de la tabla</h3>
                  <table class="table table-hover table-striped table-bordered tablaobs">
                    <thead>
                      <tr>
                        <th> D60</th>
                        <th> D30</th>
                        <th> D10</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <input name="d60" type="text" class="d60 granulo" value="<?php echo $DatosGranulometria->d60?>"> </td>
                        <td> <input name="d30" type="text" class="d30 granulo" value="<?php echo $DatosGranulometria->d30?>"> </td>
                        <td> <input name="d10" type="text" class="d10 granulo" value="<?php echo $DatosGranulometria->d10?>"> </td>
                      </tr>
                    </tbody>
                  </table>
                  <h3>Resultados</h3>
                  <table class="table table-hover table-striped table-bordered tablaResultadosGranulometria">
                    <thead>
                      <tr>
                        <th> Tamiz N°4</th>
                        <th> Tamiz N°200</th>
                        <th> Limite liquido</th>
                        <th> Indice de plasticidad</th>
                        <th> Indice de grupo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <?php
                          $d60=$DatosGranulometria->d60;
                          $d30=$DatosGranulometria->d30;
                          $d10=$DatosGranulometria->d10;
                          ?>
                        <td class="tdTamiz4">
                          <?php  echo $tamizN4=round($tamices[9],2); ?>
                        </td>
                        <td class="tdTamiz200">
                          <?php  echo $tamizN200=round($tamices[17],2);
                                 $tamizN10=round($tamices[10]);
                                 $tamizN40=round($tamices[15]);                             
                          ?> 
                        </td>
                        <td class="tdLimiteLiquido">
                            <?php  if(isset($resultado->limiteLiquido)){
                                      echo $liquido=$resultado->limiteLiquido;
                                   }
                                   else{
                                    echo $liquido=0;
                                   }
                            ?>
                         </td>
                        <?php $plastico=$resultado->limitePlastico;?>
                        <td class="tdIndicePlaticidad">
                            <?php 
                                if(isset($resultado->indicePlasticidad)){
                                   echo $indicePlasticidad=$resultado->indicePlasticidad;
                                }
                                else{
                                   echo $indicePlasticidad=0;  
                                }
                             ?>
                        </td>
                        <td class="indiceGrupo">  </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-hover table-striped table-bordered tablaClasificaciones">
                    <thead>
                      <tr>
                        <th> Clasificación Sistema unificado</th>
                        <th> Clasificación AASHTO</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="classSucs">
                          <?php 
                            $gravas=0;
                            $arenas=0;
                            $finos=0;
                            $imagenPerfil="0";
                            $lineaA=0.73*($liquido-20);
                            $gravas=100-$tamizN4;
                            $arenas=$tamizN4-$tamizN200;
                            $finos=$tamizN200;
                            if($d60!=0 && $d10!=0){
                                $cu=$d60/$d10;
                            }
                            if($d10!=0 && $d30!=0 && $d60!=0 ){
                                $cc=(($d30*$d30)/($d10*$d60));
                            }
                            if($resultado->limiteLiquido!=0 && $resultado->indicePlasticidad!=0){
                            if($gravas>$arenas && $gravas>$finos){
                                 if($finos<5){
                                    if($cu>=4 && $cc>=1 && $cc<=3){
                                        $notacion="GW";
                                        if($arenas<15){
                                          $descrsub="Grava bien graduada";
                                          echo  $notacion."-".$descrsub;
                                          $imagenPerfil="gravas";
                                        }
                                        else if($arenas>=15){
                                          $descrsub="Grava bien graduada con arena";
                                          echo  $notacion."-".$descrsub;
                                          $imagenPerfil="gravoso";
                                        }
                                    }
                                    else if($cu<4 || $cc>1 && $cc<3){
                                          $notacion="GP";
                                          if($arenas<15){
                                            $descrsub="Grava mal graduada";
                                            echo  $notacion."-".$descrsub;
                                            $imagenPerfil="gravas";
                                          }
                                          else if($arenas>=15){
                                            $descrsub="Grava mal graduada con arena";
                                            echo  $notacion."-".$descrsub;
                                            $imagenPerfil="gravoso";
                                          }
                                    }
                                 }
                                 else if($finos>5 && $finos<12){
                                      if($cu>=4 && $cc>=1 && $cc<=3){
                                          if($liquido<50){
                                              if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                                    $notacionFinos="CL";
                                              }
                                              else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                    $notacion="CL-ML";
                                              }
                                              else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                                    $notacionFinos="ML";
                                              }   
                                          }
                                          else{
                                              if($indicePlasticidad>=$lineaA){
                                                    $notacionFinos="CH";  
                                              }
                                              else{
                                                    $notacionFinos="MH";
                                              }
                                          } 
                            
                                          if($notacionFinos=="ML" || $notacionFinos=="MH"){
                                                        $notacion="GW-GM";
                                                        if($arenas<15){
                                                            $descrsub="Grava bien graduada con limo";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="gravoso";
                                                        }
                                                        else{
                                                            $descrsub="Grava bien graduada con limo y arena";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="gravas";
                                                        }
                                          }
                                          else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                              $notacion="GW-GC";
                                                              if($arenas<15){
                                                                  $descrsub="Grava bien graduada con arcilla ( o arcilla limosa)";
                                                                  echo $notacion."-".$descrsub;
                                                                  $imagenPerfil="arcillalimosa";
                                                              }
                                                              else{
                                                                  $descrsub="Grava bien graduada con arcilla y arena (o arcilla limosa y arena)";
                                                                  echo $notacion."-".$descrsub;
                                                                  $imagenPerfil="arcillalimosa";
                                                              }
                                          }
                                      }
                                      else if($cu<4 || $cc>1 && $cc<3){
                                          if($liquido<50){
                                              if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                                    $notacionFinos="CL";
                                              }
                                              else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                    $notacion="CL-ML";
                                              }
                                              else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                                    $notacionFinos="ML";
                                              }   
                                          }
                                          else{
                                              if($indicePlasticidad>=$lineaA){
                                                    $notacionFinos="CH";  
                                              }
                                              else{
                                                    $notacionFinos="MH";
                                              }
                                          }   
                                      }
                                      if($notacionFinos=="ML" || $notacionFinos=="MH"){
                                                        $notacion="GP-GM";
                                                        if($arenas<15){
                                                            $descrsub="Grava mal graduada con limo";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="gravalimosa";
                                                        }
                                                        else{
                                                            $descrsub="Grava mal graduada con limo y arena";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="gravalimosa";
                                                        }
                                          }
                                          else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                              $notacion="GP-GC";
                                                              if($arenas<15){
                                                                  $descrsub="Grava mal graduada con arcilla ( o arcilla limosa)";
                                                                  echo $notacion."-".$descrsub;
                                                                  $imagenPerfil="arcillalimosa";
                                                              }
                                                              else{
                                                                  $descrsub="Grava mal graduada con arcilla y arena (o arcilla limosa y arena)";
                                                                  echo $notacion."-".$descrsub;
                                                                  $imagenPerfil="arcillalimosa";
                                                              }
                                          }
                                 }
                                 else if($finos>12){
                                      if($liquido<50){
                                          if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                                $notacionFinos="CL";
                                          }
                                          else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                $notacion="CL-ML";
                                          }
                                          else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                                 $notacionFinos="ML";
                                          }
                                      } 
                                      else{
                                          if($indicePlasticidad>=$lineaA){
                                                  $notacionFinos="CH";  
                                          }
                                          else{
                                              $notacionFinos="MH";
                                          }
                                      }                                    
                                  }
                                  if($notacionFinos=="CL" || $notacionFinos=="CH"){
                                                    $notacion="GC";
                                                    if($arenas<15){
                                                      $descrsub="Grava Arcillosa";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="gravas";
                                                    }
                                                    else{
                                                      $descrsub="Grava Arcillosa con Arena";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="gravoso";
                                                    }
                                  }
                                  else if($notacionFinos=="ML" || $notacionFinos=="MH" ){
                                                    $notacion="GM";
                                                    if($arenas<15){
                                                      $descrsub="Grava Limosa";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="gravalimosa";
                                                    }
                                                    else{
                                                      $descrsub="Grava Limosa con Arena";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="gravalimosa";
                                                    }
                                  }
                                  else if($notacionFinos=="CL-ML"){
                                                   $notacion="GC-GM";
                                                   if($arenas<15){
                                                      $descrsub="Grava Limosa-Arcillosa";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="gravalimosa";
                                                   }
                                                   else{
                                                      $descrsub="Grava Limosa-Arcillosa con Arena";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="arcillalimosa";
                                                   }
                                  }
                            
                            }
                            else if($arenas>$gravas && $arenas>$finos){
                                    if($finos<5){
                                        if($cu>=4 && $cc>=1 && $cc<=3){
                                            $notacion="SW";
                                            if($arenas<15){
                                              $descrsub="Arena bien graduada";
                                              echo  $notacion."-".$descrsub;
                                              $imagenPerfil="arena";
                                            }
                                            else if($arenas>=15){
                                              $descrsub="Arena bien graduada con grava";
                                              echo  $notacion."-".$descrsub;
                                              $imagenPerfil="arenoso";
                                            }
                                        }
                                        else if($cu<4 || $cc>1 && $cc<3){
                                              $notacion="SP";
                                              if($arenas<15){
                                                $descrsub="Arena mal graduada";
                                                echo  $notacion."-".$descrsub;
                                                 $imagenPerfil="arena";
                                              }
                                              else if($arenas>=15){
                                                $descrsub="Arena mal graduada con grava";
                                                echo  $notacion."-".$descrsub;
                                                $imagenPerfil="arenoso";
                                              }
                                        }
                                    }
                                    else if($finos>5 && $finos<12){
                                              if($cu>=4 && $cc>=1 && $cc<=3){
                                                  if($liquido<50){
                                                        if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                                            $notacionFinos="CL";
                                                        }
                                                        else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                            $notacion="CL-ML";
                                                        }
                                                        else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                                            $notacionFinos="ML";
                                                        }   
                                                  }
                                                  else{
                                                        if($indicePlasticidad>=$lineaA){
                                                            $notacionFinos="CH";  
                                                        }
                                                        else{
                                                            $notacionFinos="MH";
                                                        }
                                                  } 
                                                        if($notacionFinos=="ML" || $notacionFinos=="MH"){
                                                            $notacion="SW-SM";
                                                            if($arenas<15){
                                                                $descrsub="Arena bien graduada con limo";
                                                                echo $notacion."-".$descrsub;
                                                                $imagenPerfil="arenoso";
                                                            }
                                                            else{
                                                                $descrsub="Arena bien graduada con limo y Grava";
                                                                echo $notacion."-".$descrsub;
                                                                $imagenPerfil="arenoso";
                                                            }
                                                        }
                                                        else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                                $notacion="SW-SC";
                                                                if($arenas<15){
                                                                    $descrsub="Arena bien graduada con arcilla ( o arcilla limosa)";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arcillalimosa";
                                                                }
                                                                else{
                                                                    $descrsub="Arena bien graduada con arcilla y arena (o arcilla limosa y grava)";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arcillalimosa";
                                                                }
                                                        }
                                              }
                                              else if($cu<4 || $cc>1 && $cc<3){
                                                      if($liquido<50){
                                                              if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                                                      $notacionFinos="CL";
                                                               }
                                                                  else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                                      $notacion="CL-ML";
                                                                  }
                                                                  else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                                                      $notacionFinos="ML";
                                                                  }   
                                                      }
                                                       else{
                                                              if($indicePlasticidad>=$lineaA){
                                                                $notacionFinos="CH";  
                                                              }
                                                              else{
                                                                $notacionFinos="MH";
                                                              }
                                                        }   
                                            }
                                                        if($notacionFinos=="ML" || $notacionFinos=="MH"){
                                                                $notacion="SP-SM";
                                                                if($arenas<15){
                                                                    $descrsub="Arena mal graduada con limo";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arenoso";
                                                                }
                                                                else{
                                                                    $descrsub="Arena mal graduada con limo y grava";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arenoso";
                                                                }
                                                        }
                                                        else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                                    $notacion="SP-SC";
                                                                    if($arenas<15){
                                                                        $descrsub="Arena mal graduada con arcilla ( o arcilla limosa)";
                                                                        echo $notacion."-".$descrsub;
                                                                        $imagenPerfil="arcillalimosa";
                                                                    }
                                                                    else{
                                                                        $descrsub="Arena mal graduada con arcilla y arena (o arcilla limosa y grava)";
                                                                        echo $notacion."-".$descrsub;
                                                                        $imagenPerfil="arcillalimosa";
                                                                    }
                                                        }
                                     }
                                     else if($finos>12){
                                              if($liquido<50){
                                                    if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                                        $notacionFinos="CL";
                                                    }
                                                    else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                        $notacion="CL-ML";
                                                    }
                                                    else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                                        $notacionFinos="ML";
                                                    }
                                              } 
                                              else{
                                                    if($indicePlasticidad>=$lineaA){
                                                        $notacionFinos="CH";  
                                                    }
                                                    else{
                                                        $notacionFinos="MH";
                                                    }
                                              }                                    
                                      }
                                                        if($notacionFinos=="CL" || $notacionFinos=="CH"){
                                                                $notacion="SC";
                                                                if($arenas<15){
                                                                        $descrsub="Arena Arcillosa";
                                                                        echo $notacion."-".$descrsub;
                                                                        $imagenPerfil="arenoso";
                                                                }
                                                                else{
                                                                        $descrsub="Arena Arcillosa con grava";
                                                                        echo $notacion."-".$descrsub;
                                                                        $imagenPerfil="arenoso";
                                                                }
                                                        }
                                                        else if($notacionFinos=="ML" || $notacionFinos=="MH" ){
                                                               $notacion="SM";
                                                               if($arenas<15){
                                                                    $descrsub="Arena Limosa";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arenoso";
                                                               }
                                                               else{
                                                                    $descrsub="Arema Limosa con Grava";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arenoso";
                                                                }
                                                        }
                                                        else if($notacionFinos=="CL-ML"){
                                                                $notacion="SC-SM";
                                                                if($arenas<15){
                                                                    $descrsub="Arena Limosa-Arcillosa";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="arenoso";
                                                                }
                                                                else{
                                                                    $descrsub="Arena Limosa-Arcillosa con Grava";
                                                                    echo $notacion."-".$descrsub;
                                                                    $imagenPerfil="limogravoso";
                                                                }
                                                        }
                            }                        
                            else if($finos>$arenas && $finos>$gravas){
                                 if($liquido<50){
                                      if($indicePlasticidad>7 && $indicePlasticidad>=$lineaA ){
                                            $notacion="CL";
                                            if($tamizN200<30){
                                               if($tamizN200<15){
                                                  $descrsub="Arcilla fina";
                                                  echo $notacion."-".$descrsub;
                                                   $imagenPerfil="arcilla";
                                               }
                                               else if($tamizN200>=15 && $tamizN200<=29){
                                                  if($arenas>=$gravas){
                                                    $descrsub="Arcilla fina con arena";
                                                    echo $notacion.$descrsub;
                                                    $imagenPerfil="arcilloso";
                                                  }
                                                  else{
                                                    $descrsub="Arcilla fina con grava";
                                                    echo $notacion.$descrsub;
                                                    $imagenPerfil="arcilloso";
                                                  }
                                               }
                                            } 
                                            else if($tamizN200>=30){
                                               if($arenas>=$gravas){
                                                  if($gravas<15){
                                                     $descrsub="Arcilla fina arenosa";
                                                     echo $notacion."-".$descrsub;
                                                     $imagenPerfil="arcilloso";
                                                  }
                                                  else{
                                                     $descrsub="Arcilla fina arenosa con grava";
                                                     echo $notacion."-".$descrsub;
                                                     $imagenPerfil="arcilloso";
                                                  }
                                               }
                                               else{
                                                    $descrsub="Arcilla fina gravosa";
                                                  if($arenas<15){
                                                     echo $notacion."-".$descrsub;
                                                     $imagenPerfil="arcilloso";
                                                  }
                                                  else{
                                                    $descrsub="Arcilla fina gravosa con arena";
                                                     echo $notacion."-".$descrsub;
                                                     $imagenPerfil="arcilloso";
                                                  }
                                               }
                                            }
                                      }
                                      else if($indicePlasticidad>=4 && $indicePlasticidad<=7 && $indicePlasticidad>=$lineaA){
                                                 $notacion="CL-ML";
                                                 if($tamizN200<30){
                                                    if($tamizN200<15){
                                                       $descrsub="Arcilla Limosa"; 
                                                       echo $notacion."-".$descrsub;
                                                       $imagenPerfil="arcilla";
                                                    }
                                                    else if($tamizN200>=15 && $tamizN200<=29){
                                                        if($arenas>=$gravas){
                                                            $descrsub="Limo con Arcilla";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="limoso";
                                                        }
                                                        else{
                                                            $descrsub="Limo con Grava";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="limoso";
                                                        }
                                                    }
                                                 }
                                                 else{
                                                    if($arenas >= $gravas){
                                                        if($gravas<15){
                                                            $descrsub="Arcilla Arenosa Limosa";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="arcilloso";
                                                        }
                                                        else{
                                                            $descrsub="Arcilla Arenosa Limosa con Grava";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="arcilloso";
                                                        }
                                                    }
                                                    else{
                                                        if($arenas<15){
                                                            $descrsub="Arcilla Gravosa Limosa";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="arcilloso";
                                                        }
                                                        else{
                                                            $descrsub="Arcilla Gravosa-Limosa con Arena";
                                                            echo $notacion."-".$descrsub;
                                                            $imagenPerfil="arcilloso";
                                                        }
                                                    }
                                                 }
                                      }
                                      else if($indicePlasticidad<4 || $indicePlasticidad<$lineaA){
                                             $notacion="ML";
                                             if($tamizN200<30){
                                                if($tamizN200<15){
                                                    $descrsub="Limo";
                                                    echo $notacion."-".$descrsub;
                                                    $imagenPerfil="limos";
                                                }
                                                else if($tamizN200>=15 && $tamizN200<=29){
                                                    if($arenas>=$gravas){
                                                      $descrsub="Limo con Arcilla";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="limoso";
                                                    }
                                                    else{
                                                      $descrsub="Limo con Grava";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="limoso";
                                                    }
                                                }
                                             }
                                             else{
                                                if($arenas>=$gravas){
                                                  if($gravas<15){
                                                    $descrsub="Limo Arenoso";
                                                    echo $notacion."-".$descrsub;
                                                    $imagenPerfil="limos";
                                                  }
                                                  else{
                                                    $descrsub="Limo Arenoso con Grava";
                                                    echo $notacion."-".$descrsub;
                                                    $imagenPerfil="limoso";
                                                  }
                                                }
                                                else{
                                                    if($arenas<15){
                                                        $descrsub="Limo Gravoso";
                                                        echo $notacion."-".$descrsub;
                                                        $imagenPerfil="limoso";  
                                                    }
                                                    else{
                                                        $descrsub="Limo Gravoso con Arena";
                                                        echo $notacion."-".$descrsub;
                                                        $imagenPerfil="limoso";  
                                                    }
                                                }
                                             }
                                      }
                                  } /* Cuando el limite liquido es mayor  o igual a 50 */
                                  else{
                                      if($indicePlasticidad>=$lineaA){
                                          $notacion="CH";
                                          if($tamizN200<30){
                                              if($tamizN200<15){
                                                  $descrsub="Arcilla gruesa";
                                                  echo $notacion."-".$descrsub;  
                                                  $imagenPerfil="arcilla";
                                              }
                                              if($tamizN200>=15 && $tamizN200<=29){
                                                  if($arenas>=$gravas){
                                                    $descrsub="Arcilla gruesa con Arena";
                                                    echo $notacion."-".$descrsub;
                                                    $imagenPerfil="arcilloso";  
                                                  }
                                                  else{
                                                    $descrsub="Arcilla gruesa con Grava";
                                                    echo $notacion."-".$descrsub;
                                                    $imagenPerfil="arcilloso";  
                                                  }
                                              }
                                          }
                                          else{
                                              if($arenas>=$gravas){
                                                    if($gravas<15){
                                                         $descrsub="Arcilla gruesa Arenosa";
                                                         echo $notacion."-".$descrsub;
                                                         $imagenPerfil="arcilloso";  
                                                    }
                                                    else{
                                                         $descrsub="Arcilla gruesa Arenosa con Grava";
                                                         echo $notacion."-".$descrsub;
                                                         $imagenPerfil="arcilloso";  
                                                    }
                                              }
                                              else{
                                                  if($arenas<15){
                                                      $descrsub="Arcilla gruesa Gravosa";
                                                      echo $notacion."-".$descrsub;  
                                                      $imagenPerfil="arcilloso";
                                                  }
                                                  else{
                                                      $descrsub="Arcilla gruesa Gravosa con Arena";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="arcilloso";  
                                                  }
                                              }
                                          }
                                      }
                                      else{
                                          $notacion="CH";
                                          if($tamizN200<30){
                                                if($tamizN200<15){
                                                    $descrsub="Limo Elástico";
                                                    echo $notacion."-".$descrsub;
                                                    $imagenPerfil="limos";
                                                }
                                                else if($tamizN200>=15 && $tamizN200<=29){
                                                        if($arenas>=$gravas){
                                                           $descrsub="Limo Elástico con Arena";
                                                           echo $notacion."-".$descrsub;
                                                           $imagenPerfil="limoarcilloso"; 
                                                        }
                                                        else{
                                                           $descrsub="Limo Elástico con Grava";
                                                           echo $notacion."-".$descrsub;
                                                           $imagenPerfil="limogravoso"; 
                                                        }
                                                }
                                          }
                                          else{
                                              if($arenas>=$gravas){
                                                  if($gravas<15){
                                                      $descrsub="Limo Elástico Arenoso";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="limoarcilloso";
                                                  }
                                                  else{
                                                      $descrsub="Limo Elástico Arenoso con Grava";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="limogravoso"; 
                                                  }
                                              }
                                              else{
                                                  if($arenas<15){
                                                      $descrsub="Limo Elástico Gravoso";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="limogravoso"; 
                                                  }
                                                  else{
                                                      $descrsub="Limo Elástico Gravoso con Arena";
                                                      echo $notacion."-".$descrsub;
                                                      $imagenPerfil="limogravoso"; 
                                                  }
                                              }
                                          }
                                      }
                                  }
                            }
                          }
                            ?>
                        </td>
                        <td class="classAsshto">
                          <?php
                            $notacionAsto=0;
                            if($resultado->limiteLiquido!=0 && $resultado->indicePlasticidad){
                            if($tamizN200<=35){   
                            if($indicePlasticidad<=6 && $liquido<=0){
                                  $grupo="A-1";
                                  if($tamizN10<=50 && $tamizN40<=40 && $tamizN200<=100){
                                        echo $notacionAsto="A-1a";
                                  }
                                  else if($tamizN40<=50 && $tamizN200<=25){
                                       echo $notacionAsto="A-1b";
                                  }
                            }
                            else if($indicePlasticidad<=0 && $liquido<=0){
                                        $grupo="A-3";
                                        if($tamizN40>=51 && $tamizN200<=10){
                                            echo $notacionAsto="A-3";
                                        }  
                                        else{
                                           echo "dos";
                                        }    
                            }
                            else if($indicePlasticidad<=10 && $liquido<=40){
                                  
                                    if($tamizN200<=35){
                                            $grupo="A-2";
                                            echo $notacionAsto="A-2-4";
                                    } 
                                    else{
                                        echo "tres";
                                    }
                            } 
                            else if($indicePlasticidad<=10 && $liquido>=41){
                                    if($tamizN200<=35){
                                            $grupo="A-2";
                                            echo $notacionAsto="A-2-5";
                                    } 
                                    else{
                                        echo "cuatro";
                                    }
                            }  
                            else if($indicePlasticidad>=11 && $liquido<=40){                                      
                                    if($tamizN200<=35){
                                            $grupo="A-2";
                                            echo $notacionAsto="A-2-6";
                                    } 
                                    else{
                                        echo "cinco";
                                    }
                            } 
                            else if($indicePlasticidad>=11 && $liquido>=41){
                                    if($tamizN200<=35){
                                            $grupo="A-2";
                                            echo $notacionAsto="A-2-7";
                                    } 
                                    else{
                                       echo "seis";
                                    }
                            } 
                            }
                            else{  
                            if($indicePlasticidad<=10 && $liquido<=40){
                                    if($tamizN200>=36){
                                            $grupo="A-4";
                                            echo $notacionAsto="A-4";
                                    } 
                                    else{
                                       echo "siete";
                                    }
                            }
                            else if($indicePlasticidad<=10 && $liquido>=41){
                                    if($tamizN200>=36){
                                            $grupo="A-5";
                                            echo $notacionAsto="A-5";
                                    } 
                                    else{
                                         echo "ocho";
                                    }
                            }
                            else if($indicePlasticidad>=11 && $liquido<=40){
                                    if($tamizN200>=36){
                                            $grupo="A-6";
                                            echo $notacionAsto="A-6";
                                    } 
                                    else{
                                       echo "nueve";
                                    }
                            }
                            else if($indicePlasticidad>=11 && $liquido>=41){
                                    if($tamizN200>=36){
                                            $grupo="A-7";
                                            if($indicePlasticidad>=$liquido-30){
                                                echo $notacionAsto="A-7-6";
                                            }
                                            else{
                                                echo $notacionAsto="A-7-5";
                                            }
                                    } 
                            }
                          }
                        }
                            ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <input name="aashto" class="aashto" type="hidden" value="<?php echo $notacionAsto; ?>">
                  <input name="notacionSucs" class="notacionSucs" type="hidden" value="<?php echo $notacion; ?>">
                  <input name="descripcionSucs" class="descripcionSucs"  type="hidden" value="<?php echo $descrsub; ?>">
                  <input name="N4" type="hidden" class="N4"  value="<?php echo $tamizN4; ?>">
                  <input name="N10" type="hidden" class="N10" value="<?php echo $tamizN10; ?>">
                  <input name="N40" type="hidden" class="N40" value="<?php echo $tamizN40; ?>">
                  <input name="N200" type="hidden" class="N200" value="<?php echo $tamizN200; ?>">
                  <input name="imagenPerfil" type="hidden" class="imagenPerfil" value="<?php echo $imagenPerfil; ?>">
                </form>
                <!-- ############# FIN RESULTADOS ############### -->
                <!-- ############# GUARDAR INFORMACION BOTON ############### -->
                <div class="form-actions">
                  <a href='#' rel="granulometria<?php echo $i;?>" class="btn btn-primary input-xlarge guardarGranulometria">Guardar información</a>
                </div>
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->
              </div>
              <?php $i++; ?>
              <?php 
                unset($tamices);
                unset($notacion);
                unset($descrsub);
                unset($temp);
                unset($retenidoporcentaje);
                unset($notacionFinos);
                ?>
              <?php endif; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?> 
            </div>
          </div>
          <!-- ############# fin tabs de muestras internas GRANULOMETRIA ############### -->
        </div>
        <div class="tab-pane fade" id="Informe">
          <!-- ############# tabs de muestras internas Informe de estratigrafia ############### -->
          <!-- ############# INFORME DE ESTRATIGRAFIA ############### -->
          <h3 class="text-center">Informe de estratigrafia</h3>
          <table class="table table-hover table-striped table-bordered letra-s">
            <thead>
              <tr>
                <th>Muestra</th>
                <th>Perfil estratigrafico</th>
                <th>Peso unitario (KN/m3)</th>
                <th>Cohesion</th>
                <th>Golpes</th>
                <th>W</th>
                <th>LL</th>
                <th>IP</th>
                <th>SUCS</th>
                <th>AASHTO</th>
                <th>Granulometria</th>
                <th>Observacion</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> - </td>
                <td>   </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> <?php echo "Superficie ".$datos_sondeo ->tipo_superficie; ?> </td>
              </tr>
              

              $nivel;
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
                <?php if( $datos_sondeo->nivel_freatico>=$datoMuestra->profundidad_inicial && $datos_sondeo->nivel_freatico<=$datoMuestra->profundidad_final ){ $nivel=$datoMuestra->profundidad_inicial; } ?>
              <?php endforeach; ?>



              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $resultado= $resultadosClass->getResultado($datoMuestra->id_muestra); ?>
              <tr>
                <td> <?php echo $i; ?> <?php if( $datoMuestra->profundidad_inicial==$nivel ){ echo"<img src='assets/img/nivelfreatico.png' alt='nivel freatico' width='30px' height='30px' style=' float:right; ' >" ;} ?> </td>
                <?php $tamano= ($datoMuestra->profundidad_final-$datoMuestra->profundidad_inicial)*100; ?> 
                <td style=" padding: 0; margin : 0;"> <img src="assets/patrones/<?php echo $resultado->imagenPerfil; ?>.jpg" alt="patron" style="border:1px solid #CCC;" >           
                </td>
                <td> <?php if($resultado->pesoUnitario<=0){echo"-";}else{ echo $resultado->pesoUnitario;} ?> </td>
                <td> <?php if($resultado->cohesion<=0){echo"-";}else{ echo $resultado->cohesion;} ?></td>
                <td> <?php echo $datoMuestra->numero_golpes; ?> </td>
                <td> <?php echo $resultado->humedad; ?> </td>
                <td> <?php echo $resultado->limiteLiquido; ?></td>
                <td> <?php echo $resultado->indicePlasticidad; ?> </td>
                <td> <?php echo $resultado->notacionSucs; ?> </td>
                <td> <?php echo $resultado->aashto; ?> </td>
                <td> 
                  <?php if ($datoMuestra->material_de_relleno!=2) : ?>

                    <span class="badge">N° 4 = <?php echo $resultado->N4; ?>% 
                    </span>
                    <span class="badge">N° 10 = <?php echo $resultado->N10; ?>% 
                    </span>
                    <span class="badge">N° 40 = <?php echo $resultado->N40; ?>% 
                    </span>
                    <span class="badge">N° 200 = <?php echo $resultado->N200; ?>% 
                    </span>
                  <?php else: ?>
                    <span>-</span>
                  <?php endif ?>
                </td>
                <td>
                  <?php  if($datoMuestra->material_de_relleno==1){echo "Material de relleno"; } else if($datoMuestra->material_de_relleno==2){ echo "Estrato de roca";} ?>  <?php if($datoMuestra->material_de_relleno!=2){ echo $resultado->descripcionSucs; } ?> 
                </td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
          <h5 > <img src="assets/img/nivelfreatico.png" alt="nivel freatico" width="30px" height="30px" > Nivel freatico:<?php echo " ".$datos_sondeo->nivel_freatico." metros"; ?></h5>
          <!-- ############# FIN INFORME DE ESTRATIGRAFIA ############### -->
  
          <!-- ############# fin tabs de muestras internas estratigrafia ############### --> 
        </div>
      </div>
      <!-- ############# FIN CUERPO ############### --> 
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
    <!-- #############  AYUDA ############### -->
    <div id="Ayuda" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Ayuda</h3>
      </div>
      <div class="modal-body">
      
        <h5> ¿ Como clonar una muestra ? </h5>
        <p> 
            Para clonar una muestra seleccionar el ícono ubicado en la columna "Clonar", escribimos los datos de la nueva muestra y luego presionamos el botón "Clonar muestra".
            Nota: Los resultados de la muestra clonada se han guardado en cero para que los resultados se actualicen debemos acceder a cada una de las pruebas de suelo y hacer click en el botón "Guardar información".
        </p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
      </div>
    </div>
    <!-- ############# FIN AYUDA ############### -->
    <!-- #############  LEGAL ############### -->
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
    <!-- #############  FIN LEGAL ############### -->
    <!-- #############  FORM MODIFICAR SONDEO ############### -->
    <div id="modificarsondeo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modificar sondeo</h3>
      </div>
      <div class="modal-body">
        <form id="ModificarSondeo" name='formulario' method='post' action="save.php" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <input type='text' name='nivel_freatico' value="<?php echo $datos_sondeo->nivel_freatico;?>" placeholder='Nivel freatico ' class="input-block-level limpiar required" autofocus >
            </div>
            <div class="row-fluid">
              <select name='tipo_superficie' id='idSuperficie' class="span8"  >
                <?php if(count($tipo_superficie) > 0): ?>
                  <?php foreach( $tipo_superficie as $tipo ): ?>
                   <?php if ( $datos_sondeo->tipo_superficie==$tipo->tipo_superficie ) : ?>   
                     <option value="<?php echo $tipo->id_tipo_superficie ?>" selected='selected'><?php echo $tipo->tipo_superficie ?></option>
                   <?php else: ?> 
                     <option value="<?php echo $tipo->id_tipo_superficie ?>"><?php echo $tipo->tipo_superficie ?></option>
                   <?php endif ?>

                  <?php endforeach; ?>
                <?php endif; ?>
              </select >
              

              <?php if ( $datos_sondeo->tipo_superficie=='Ninguna' ) : ?>
                <input type='text' name='Profundidad' id="profundidadSuperficie" value="0" readonly placeholder='Profundidad' class="span4" >
              <?php else: ?>
              <input type='text' name='Profundidad' id="profundidadSuperficie" value="<?php echo $datos_sondeo->profundidad_superficie ?>" placeholder='Profundidad' class="span4" > 
              <?php endif; ?>


              <input type='hidden' name='func' value="ModificarSondeo"  class="span4" > 
              <input type='hidden' name='id_sondeo' value="<?php echo $datos_sondeo->id_sondeo;?>"  class="span4" > 
              <input type='hidden' name='id_tipo_superficie' value="<?php echo $datos_sondeo->fk_id_tipo_superficie;?>"  class="span4" >
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error_modificar_sondeo" class="alert alert-error hide">                             
              <strong> <small>error modificando sondeo</small> </strong>
            </div>
            <div id="exito_modificar_sondeo" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
        </form>
      </div>
      <!-- fin form  nuevo sondeo-->
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="enviar_modificar_sondeo"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Guardar sondeo</button> 
      </div>
    </div>
    <!-- ############# FIN FORM MODIFICAR SONDEO ############### -->
    <!-- #############  FORM NUEVA MUESTRA ############### -->
    <div id="nuevamuestra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Nueva muestra</h3>
      </div>
      <div class="modal-body">
        <form id="datosMuestras" name='formulario' method='post' action="save.php" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <input type='text' name='descripcion_muestra' placeholder='Descripción' class="input-block-level limpiar" required autofocus >
            </div>
            <div class="row-fluid">
              <span class="span3 title tituloprofundidad">Profundidad :</span>
              <input type='text' name='profundidad_inicial' placeholder='Desde' class="span3 " >   
              <input type='text' name='profundidad_final' placeholder='Hasta' class="span3 " >   
            </div>
            <div class="controls inputs">
              <input type='text' name='numero_de_golpes' placeholder='Numero de golpes' class="input-block-level limpiar " >
            </div>
            <div class="controls inputs">
              <label class="checkbox">
              <input name="box_relleno" class="box_relleno estratos" type="checkbox" value="1">
              Es parte de la capa de relleno
              </label>
            </div>
            <div class="controls inputs">
              <label class="checkbox">
              <input name="box_roca" class="box_roca estratos" type="checkbox" value="1">
              Esta muestra esta conformada solo por roca.
              </label>
            </div>
            <input type='hidden' name='idsondeos' value="<?php echo $_GET['ids'] ?>">
            <input type='hidden' name='func' value="addMuestras">
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error_muestra" class="alert alert-error hide">                             
              <strong> <small>error al guardar el proyecto</small>  </strong>
            </div>
            <div id="exito_muestra" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
        </form>
      </div>
      <!-- fin form  nuevo sondeo-->
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="enviar_muestra"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Guardar muestra</button> 
      </div>
    </div>
    <!-- #############  FORM NUEVA MUESTRA ############### -->
    <!-- #############  FORM EDITAR MUESTRA ############### -->
    <div id="editarmuestra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Editar muestra</h3>
      </div>
      <div class="modal-body">
        <form id="ModificarMuestras" name='formulario' method='post' action="save.php" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <input id="descripcion_modificarm" name='descripcion_muestra' type='text' name='descripcion_muestra' placeholder='Descripción' class="input-block-level limpiar" required autofocus >
            </div>
            <div class="row-fluid">
              <span class="span3 title tituloprofundidad">Profundidad :</span>
              <input id="profundidad_inicial_modificar" type='text' name='profundidad_inicial' placeholder='Desde' class="span3 " >   
              <input id="profundidad_final_modificar" type='text' name='profundidad_final' placeholder='Hasta' class="span3 " >   
            </div>
            <div class="controls inputs">
              <input id="numero_golpes_modificar" type='text' name='numero_de_golpes' placeholder='Numero de golpes' class="input-block-level limpiar " >
            </div>
            <label class="checkbox">
            <input  name="box_relleno" class="box_relleno estratos" type="checkbox" value="1">
            Es parte de la capa de relleno
            </label>
            <div class="controls inputs">
              <label class="checkbox">
              <input name="box_roca" class="box_roca estratos" type="checkbox" value="1">
              Esta muestra esta conformada solo por roca.
              </label>
            </div>
            <input id="id_muestra_modificar" type='hidden' name='id_muestra' value="">
            <input type='hidden' name='idsondeos' value="<?php echo $_GET['ids'] ?>">
            <input type='hidden' name="func" value="ModificarMuestra">      
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error_modificar_muestra" class="alert alert-error hide">                             
              <strong> <small>error al guardar el proyecto</small>  </strong>
            </div>
            <div id="exito_modificar_muestra" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="EnviarModificarMuestra"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Guardar muestra</button> 
      </div>
    </div>
    <!-- #############  FIN FORM EDITAR MUESTRA ############### -->
     <!-- #############  FORM  CLONAR MUESTRA ############### -->
   <div id="clonarmuestra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         <h3 id="myModalLabel">Clonar muestra</h3>
       </div>
       <div class="modal-body">
         <form id="ClonarMuestras" name='formulario' method='post' action="save.php" class="form-vertical">
           <div class="control-group">
             <div class="controls inputs">
               <input id="descripcion_clonarm" name='descripcion_muestra' type='text' name='descripcion_muestra' placeholder='Descripción' class="input-block-level limpiar" required autofocus >
             </div>
             <div class="row-fluid">
              <span class="span3 title tituloprofundidad">Profundidad :</span>
              <input  type='text' name='profundidad_inicial' placeholder='Desde' class="span3 " >   
              <input  type='text' name='profundidad_final' placeholder='Hasta' class="span3 " >   
             </div>
            <div class="controls inputs">
               <input id="numero_golpes_clonar" type='text' name='numero_de_golpes' placeholder='Numero de golpes' class="input-block-level limpiar " >
             </div>
             <label class="checkbox">
             <input  name="box_relleno" class="box_relleno estratos" type="checkbox" value="1">
             Es parte de la capa de relleno
             </label>
             <div class="controls inputs">
               <label class="checkbox">
               <input name="box_roca" class="box_roca estratos" type="checkbox" value="1">
               Esta muestra esta conformada solo por roca.
               </label>
             </div>
             <input id="id_muestra_clonar" type='hidden' name='id_muestra' value="">
             <input type='hidden' name='idsondeos' value="<?php echo $_GET['ids'] ?>">
             <input type='hidden' name="func" value="ClonarMuestra">      
             <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
              <div id="error_clonar_muestra" class="alert alert-error hide">                             
                  <strong> <small>error al guardar el proyecto</small>  </strong>
             </div>
             <div id="exito_clonar_muestra" class="alert alert-success hide ">
               <strong>Datos correctos.</strong>  
             </div>
             <!-- Fin mensaje exito y error -->
           </div>
         </form>
       </div>
       <div class="modal-footer">
         <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
         <button type="submit" id="EnviarClonarMuestra"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Clonar muestra</button> 
       </div>
     </div>
     <!-- #############  FIN FORM ClONAR MUESTRA ############### -->
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
        <button type="submit" id="Mod_Usuario"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Modificar Usuario</button> 
      </div>
    </div>
    <!-- Fin de configuracion cuenta -->
    <!-- Impresion -->
    <div id="informe" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Impresion informe - Sondeo <?php echo $_GET['numsondeo'] ?> </h3>
      </div>
      <div class="modal-body">
        <form id="ConfigurarUsuarios" name='formulario' method='post' action="save.php" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <label class="title" for="test requeridos"> Marque las pruebas que desea imprimir :</label>
            </div>
            <label class="checkbox">
              <input id="checkLimites" class="boxImpresion" name="checkLimites" type="checkbox" checked value="1">
              Pruebas de humedad , limite liquido y limite plastico.
            </label>  
            <label class="checkbox">
              <input id="checkCompresion" class="boxImpresion" name="checkCompresion" type="checkbox" checked value="1">
              Pruebas de compresion.
            </label> 
            <label class="checkbox">
              <input id="checkGranulometria" class="boxImpresion" name="checkGranulometria" type="checkbox" checked value="1">
              Analisis granulometrico.
            </label > 


            <label for="titulo Gerente" class="title">Firma Gerente</label>
            <div class="controls inputs">
              <select   name='gerente' id='gerente' class="input-block-level firmasBox" >
                <?php if ( count( $ListaFirmas ) > 0 ) : ?>
                <?php foreach ( $ListaFirmas as $firmas ) : ?>
                  <?php if ( $firmas->idFirma=="1" ) : ?>
                    <option value="<?php echo $firmas->idFirma; ?>" selected ><?php echo $firmas->persona; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $firmas->idFirma; ?>" ><?php echo $firmas->persona; ?> </option>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
              </select >
            </div>
            <label for="titulo ingeniero" class="title">Firma Ingeniero encargado</label>
            <div class="controls inputs">
              <select  name='ingeniero' id='responsable' class="input-block-level firmasBox" >
                <?php if ( count( $ListaFirmas ) > 0 ) : ?>
                <?php foreach ( $ListaFirmas as $firmas ) : ?>
                  <?php if ( $firmas->idFirma=="2" ) : ?>
                    <option value="<?php echo $firmas->idFirma; ?>" selected ><?php echo $firmas->persona; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $firmas->idFirma; ?>" ><?php echo $firmas->persona; ?> </option>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
              </select >
            </div>

            <input id="idProyectoImpresion" type="hidden" value="<?php echo $_GET['idp'] ?>">
            <input id="idSondeoImpresion" type="hidden" value="<?php echo $_GET['ids'] ?>">
            <input id="numeroSondeo" type="hidden" value="<?php echo $_GET['numsondeo'] ?>">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <a id="enlaceImpresion" href="informe.php?idp=<?php echo $_GET['idp'] ?>&ids=<?php echo $_GET['ids'] ?>&numsondeo=<?php echo $_GET['numsondeo'] ?>&boxLim=1&boxComp=1&boxGran=1" class="btn btn-primary inputs impresionBtn"> <i class="icon-check icon-white"></i> Imprimir informe </a>
      </div>
    </div>
    <!-- Fin Impresion  -->
    <!-- #############  BOOTSTRAP JS ############### -->
    <!--script type="text/javascript" src="assets/js/jqplot/plugins/example.js"></script-->
    <script src="assets/js/muestras.js"></script>
    <script src="assets/js/usuarios.js"></script>
    <script src="assets/js/sondeos.js"></script>
    <script type="text/javascript">
      $(function graficador() {

      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
      <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
      var datosgrafica=$('#datosgraficaLimites<?php echo $i; ?>').val();

      var datosvacios ="[0,0],[0,0],[0,0]";

      if(datosgrafica==datosvacios){
        datosgrafica = "[1,1],[1,1],[1,1]";
       }

      var sourceData = eval("["+datosgrafica+"]");
      var sourceData2;
      $('#graficaLimites<?php echo $i; ?>').highcharts({
          
          chart: {
            renderTo: 'linear',
            events: {
                    load: function() {
                        
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        var series2= this.series[1];
                        $("#datosgraficaLimites<?php echo $i; ?>").change(function() {
                             // current time
                            
                            var datosgrafica2=$('#datosgraficaLimites<?php echo $i; ?>').val();
                            sourceData2 = eval("["+datosgrafica2+"]");           
                            series.update({ 
                              data: sourceData2
                              } 
                            );
      
                            series2.update({ 
                              data: (function() {
                                return fitData(sourceData2).data;
                                    })()
                              } 
                            );
                            console.log("Grafica de limites actualizada");
      
                        });
                    }
            }
          },
          
          title: {
              text: 'Grafica de Limite liquido'
          },
          credits : {
            enabled : false
          },
          
          xAxis: {
             type: 'logarithmic',
              min: 1,
              max: 100,
              minorTickInterval: 10,
              title: {
                  text: 'Numero de golpes'
              }  
          },
          yAxis: {
              min: 0.01,
              max: 100,
              minorTickInterval: 10,
              title: {
                  text: 'Contenido de humedad (%)'
              },
              labels: {
                format: '{value} %'
              } 
          },
          
          tooltip: {
              headerFormat: '<b>{series.name}</b><br />',
              pointFormat: 'x = {point.x}, y = {point.y}'
          },
          
          series: [{
              name: 'Datos',
              type: 'scatter',            
              data: sourceData,
              pointStart: 1
          },
          {
          name: 'Linea de tendencia',  
          type: 'line',
          marker: { enabled: false },
          /* function returns data for trend-line */
          data: (function() {
            return fitData(sourceData).data;
          })()
        },{
              name: '25 golpes',
              color: '#595959',
              marker: { enabled: false },
              lineWidth: 0.5,
              type: 'line',            
              pointStart: 1,
              data: [[25,0.01],[25,100]]
          }]
      });
      
      <?php $i++; ?>
      <?php endif; ?>
      <?php endforeach; ?>
      
      
      
      
      $('.brand').tooltip('hide');   
      
      //graficas compresion
      
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
      <?php if( $datoMuestra->material_de_relleno!=2 ): ?>

      var inputCompresion=$('#datosgraficacompresion<?php echo $i; ?>').val();
      var datosCompresion = eval("["+inputCompresion+"]");
      
      
      var datosCompresion2;
      $('#graficacompresion<?php echo $i; ?>').highcharts({
      
          chart: {
            renderTo: 'linear',
            events: {
                load: function() {
      
      
                        // data series
                        var series = this.series[0];
                        var series2= this.series[1];
                        $("#datosgraficacompresion<?php echo $i; ?>").change(function() {
                            
                             // update grafica
                            var inputCompresion2=$('#datosgraficacompresion<?php echo $i; ?>').val();
                            datosCompresion2 = eval("["+inputCompresion2+"]");           
                            series.update({ 
                              data: datosCompresion2
                              } 
                            );
      
                            series2.update({ 
                              data: datosCompresion2
                              } 
                            );
                            console.log("Grafica de compresion");
      
                        });
                    }
            }
            
          },
          
          title: {
              text: 'Grafica de Compresion'
          },
          credits : {
            enabled : false
          },
          
          xAxis: {
            title: {
              text: 'Deformaciones'
            }  
          },
          yAxis: {
              tickInterval: 1,
              title: {
                  text: 'Esfuerzo (Kg/cm2)'
              }
          },
          tooltip: {
              headerFormat: '<b>{series.name}</b><br />',
              pointFormat: 'x = {point.x}, y = {point.y}'
          },
          series: [{
              name: 'Datos',
              type: 'scatter',            
              data: datosCompresion,
              pointStart: 1
          },{
          name: 'Linea de tendencia',  
          type: 'line',
          lineWidth: 0.5,
          marker: { enabled: false },
          data: datosCompresion
        }]
      });
      
      <?php $i++; ?>
      <?php endif; ?>
      <?php endforeach; ?>
      
      
      
      
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>

      <?php if( $datoMuestra->material_de_relleno!=2 ): ?>
      
      var inputGranulometria=$('#datosgraficagranulometria<?php echo $i; ?>').val();
      
      var datosGranulometria = eval("["+inputGranulometria+"]");
      
      var datosGranulometria2;
      $('#graficagranulometria<?php echo $i; ?>').highcharts({
      
          chart: {
            renderTo: 'linear',
            events: {
                load: function() {
      
      
                        // data series
                        var series = this.series[0];
                        $("#datosgraficagranulometria<?php echo $i; ?>").change(function() {
                            
                             // update grafica
                            var inputGranulometria2=$('#datosgraficagranulometria<?php echo $i; ?>').val();
                            datosGranulometria2 = eval("["+inputGranulometria2+"]");           
                            series.update({ 
                              data: datosGranulometria2
                              } 
                            );
      
                            console.log("Grafica de granulometria");
      
                        });
                    }
            }
            
          },
          
          title: {
              text: 'Grafica de granulometria'
          },
          credits : {
            enabled : false
          },
          
          xAxis: {
            title: {
              text: 'Diametro de las particulas'
            },
            type: 'logarithmic',
            minorTickInterval: 10,
            reversed: true  
          },
          yAxis: {
              minorTickInterval: 10,
              title: {
                  text: 'Pasa (%)'
              },
              labels: {
                format: '{value} %'
              }
          },
          tooltip: {
              headerFormat: '<b>{series.name}</b><br />',
              pointFormat: 'x = {point.x}, y = {point.y}'
          },
          series: [{
              name: 'Datos',
              type: 'spline',            
              data: datosGranulometria,
              pointStart: 1
          },{
              name: 'D60',
              type: 'line',            
              pointStart: 1,
              data: [[0.01,60],[100,60]]
          },{
              name: 'D30',
              type: 'line',            
              pointStart: 1,
              data: [[0.01,30],[100,30]]
          },{
              name: 'D10',
              type: 'line',            
              pointStart: 1,
              data: [[0.01,10],[100,10]]
          }
          ]
      });  
      <?php $i++; ?>
      <?php endif; ?>
      <?php endforeach; ?> 
      

      });
    </script>
    <script src="assets/js/alertify/alertify.js"></script>
  </body>
</html>