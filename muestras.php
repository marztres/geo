<?php
  session_start();
  require_once('includes/sondeos.php');
  require_once('includes/muestras.php');
  require_once('includes/testlimites.php');
  require_once('includes/proyectos.php');
  require_once('includes/compresion.php');
  require_once('includes/granulometria.php');
  require_once('includes/pesos_retenidos.php');
  
  
  $data = $_SESSION['usuario'];
  $proyectosClass = new proyectos();
  $proyectos = $proyectosClass->getDatosProyecto($_GET['idp']);
  $sondeosClass = new sondeos();
  $datos_sondeo=$sondeosClass->getDatosSondeo($_GET['ids']);
  $muestras = new muestras();
  $muestrasSondeo = $muestras->getMuestrasSondeo($_GET['ids']);
  $testLimitesClass = new testlimintes();
  $TestLimitesMuestra = array();
  $datosCompresion= new Compresion();
  foreach ( $muestrasSondeo as $muestra ) {
    //$DatosCompresion[]=$datosCompresion->GetDatosCompresion( $muestra->id_muestra );
    $TestLimitesMuestra[] = $testLimitesClass->getLimitesMuestra( $muestra->id_muestra );
  }
  $datosGranulometria= new granulometria();
  $pesosRetenidosClass= new pesos_retenidos(); 
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
                <a href="#informe" role="button"  data-toggle="modal">
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
          <a href="#modificarsondeo" role="button" data-toggle="modal" class=" span2"> <i class="icon-edit"></i> Modificar datos</a>
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
                <th>Editar</th>
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
                <td>
                  <a rel='<?php echo $datoMuestra->id_muestra.",".$datoMuestra->profundidad_inicial.",".$datoMuestra->profundidad_final.",".$datoMuestra->descripcion.",".$datoMuestra->material_de_relleno.",".$datoMuestra->numero_golpes; ?>' id="<?php echo $datoMuestra->id_muestra ?>" class="modalMuestra" role="button" data-toggle="modal" href="#editarmuestra">
                  <i class='icon-wrench'></i>
                  </a>
                </td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <td colspan="7">No hay datos que mostrar</td>
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
              <li class="<?php echo (($i==1)?'active':''); ?>">
                <a href="#muestra<?php echo $i; ?>"  data-toggle="tab">Muestra <?php echo $i; ?> </a>
              </li>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="muestra<?php echo $i; ?>">
                <!-- #############  HUMEDAD NATURAL ############### -->
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
                              echo ceil(round($resultado,2));
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
                            echo $porcentajeLiquido1 = round((($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][3]->peso_capsula )) * 100, 2);
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
                             echo $porcentajeLiquido2 = round((($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][4]->peso_capsula )) * 100, 2); 
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
                        <td>3</td>
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
                              echo $porcentajeLiquido3 = round((($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][5]->peso_capsula )) * 100, 2); 
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
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                
                <input id="datosgraficaLimites<?php echo $i; ?>" class="datosgraficaLimites"  type="text" value="[<?php echo $arrLimites[$i-1]->golpes1?>,<?php echo $arrLimites[$i-1]->porcentaje1?>],[<?php echo $arrLimites[$i-1]->golpes2?>,<?php echo $arrLimites[$i-1]->porcentaje2?>],[<?php echo $arrLimites[$i-1]->golpes3?>,<?php echo $arrLimites[$i-1]->porcentaje3?>]">
                <div id="graficaLimites<?php echo $i; ?>" style=" widht:600px; height: 400px;"></div>
                
                <!-- #############  LIMITE PLASTICO ############### -->
                <h3>Limite plastico</h3>
                <a href="#"  class="btn btn-info pull-right title noplastico">Pulsar si el suelo es NO PLASTICO</a>
                <br>
                <br>
                <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
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
                      </tr>
                    </tbody>
                  </table>
                </form>
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
                            echo ceil(round($resultado,2));
                          ?>
                      </td>
                      <td>
                        <?php
                          $resultado = 0;
                          $menor = min( array( $porcentajeLiquido1, $porcentajeLiquido2 ) );
                          $mayor = max( array( $porcentajeLiquido1, $porcentajeLiquido2 ) );
                          if($mayor!=0 AND $menor!=0){
                            $divMayorMenor1 = $mayor / $menor;
                          }
                          if ( $divMayorMenor1 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajeLiquido2, $porcentajeLiquido3 ) );
                          $mayor = max( array( $porcentajeLiquido2, $porcentajeLiquido3 ) );
                          if($mayor!=0 AND $menor!=0){
                             $divMayorMenor2 = $mayor / $menor;
                           }
                          if ( $divMayorMenor2 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajeLiquido1, $porcentajeLiquido3 ) );
                          $mayor = max( array( $porcentajeLiquido1, $porcentajeLiquido3 ) );
                          if($mayor!=0 AND $menor!=0){
                            $divMayorMenor3 = $mayor / $menor;
                          }
                          if ( $divMayorMenor3 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          if ( $divMayorMenor1 > 1.29 && $divMayorMenor2 > 1.29 && $divMayorMenor3 > 1.29 ) {
                            $resultado = 0;
                          }
                          echo $limiteLiquido=ceil(round($resultado,2));
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
                      <td><?php echo $limeteLiquido-$limitePlastico?></td>
                    </tr>
                  </tbody>
                </table>
                <!-- ############# FIN RESULTADOS HUMEDAD Y LIMITE ############### -->
                <div class="form-actions">
                  <a href="#" rel="muestra<?php echo $i; ?>" class="guardaLimites btn btn-primary input-xlarge">Guardar información</a>
                </div>
              </div>
              <?php $i++; ?>
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
              <li class="<?php echo (($i==1)?'active':''); ?>">
                <a href="#compresion<?php echo $i; ?>" data-toggle="tab">Muestra <?php echo $i; ?> </a>
              </li>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $DatosCompresion = $datosCompresion->GetDatosCompresion( $datoMuestra->id_muestra );  ?>
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="compresion<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA ############### -->
                <h3>Medidas de la muestra</h3>
                <form class="compresion<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
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
                            $mayoresfuerzo[] =$esfuerzo;
                            } 
                            else{
                            echo 0;
                            }
                            ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                  <!-- ############# TABLA DE COMPRESIÓN ############### -->
                  <!-- ############# GRAFICA DE COMPRESIÓN ############### -->
                  <input id="datosgraficacompresion<?php echo $i; ?>" class="datosgraficaCompresion"  type="text" value="">
                  <div id="graficacompresion<?php echo $i; ?>" style=" widht:600px; height: 400px;"></div>

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
                                echo round($pesoUnitario,2);
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
                               echo round($cohesion,2);
                            }
                            ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                <!-- ############# FIN RESULTADOS compresion ############### -->
                <!-- ############# GUARDAR INFORMACION BOTON ############### -->
                <div class="form-actions">
                  <a href="#" rel="compresion<?php echo $i; ?>" class="GuardarCompresion btn btn-primary input-xlarge">Guardar información</a>
                </div>
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->  
              </div>
              <?php $i++; ?>
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
              <li class="<?php echo (($i==1)?'active':''); ?>">
                <a href="#granulometria<?php echo $i; ?>" data-toggle="tab">Muestra <?php echo $i; ?> </a>
              </li>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $DatosGranulometria = $datosGranulometria->getDatoGranulometria( $datoMuestra->id_muestra );  ?>
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="granulometria<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA GRANULOMETRIA############### -->
                <h3> Analisis granulometrico </h3>
                <form class="granulometria<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
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
                            if($j==13){
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
                        <td><?php echo $retenidos->tamanoTamiz ?></td>
                        <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $retenidos->pesoRetenido ?>"> </td>
                        <?php $fondopesoretenido=$DatosGranulometria->pesoRecipienteMasMuestra-$pesoretenidomasrecipiente;
                          $totalpesoretenido=$sumapesoretenidos+$fondopesoretenido;
                          ?>
                        <td><?php 
                          if($pesoretenidoN200!=0){
                              echo $pesoretenidocorregido=$retenidos->pesoRetenido-(($sumapesoretenidos-$pesoretenidoN200)*$retenidos->pesoRetenido/$pesoretenidoN200);
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
                                echo $retenidoporcentaje = round($pesoretenidocorregido/$totalpesoretenidocorregido*100,2);
                            }
                            ?>
                        </td>
                        <?php if ( $j == 0 ) array_push($temp, ($retenidoporcentaje + 0)); else array_push($temp, $retenidoporcentaje + $temp[$j-1]); ?>
                        <td class="acumulado" ><?php echo $temp[$j]; ?></td>
                        <td><?php echo 100 - $temp[$j]; ?></td>
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
                          echo $TotalRetenidoAcomulado=round($Fondoretenido+$temp[13],2);
                          ?>
                        </td>
                        <td> <?php echo 100-$TotalRetenidoAcomulado; ?></td>
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
                </form>
                <!-- ############# TABLA DE GRANULOMETRIA ############### -->

                <!-- ############# GRAFICA DE GRANULOMETRIA ############### -->
                <input id="datosgraficagranulometria<?php echo $i; ?>" class="datosgrafica"  type="text" value="">
                <div id="graficagranulometria<?php echo $i; ?>" style=" widht:600px; height: 400px;"></div>
                <!-- ############# FIN GRAFICA DE GRANULOMETRIA ############### -->
                <!-- ############# RESULTADOS ############### -->
                <h3>Resultados</h3>
                <table class="table table-hover table-striped table-bordered ">
                  <thead>
                    <tr>
                      <th> Tamiz N°4</th>
                      <th> Tamiz N°200</th>
                      <th> Limite liquido</th>
                      <th> Limite plastico</th>
                      <th> Indice de grupo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td> 45 </td>
                      <td> 51 </td>
                      <td> 23 </td>
                      <td> 62 </td>
                      <td> 45 </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-hover table-striped table-bordered ">
                  <thead>
                    <tr>
                      <th> Clasificación Sistema unificado</th>
                      <th> Clasificación AASHTO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td> MH - Arcilla de mediana plasticidad  </td>
                      <td> A-M-5 </td>
                    </tr>
                  </tbody>
                </table>
                <!-- ############# FIN RESULTADOS ############### -->
                <!-- ############# GUARDAR INFORMACION BOTON ############### -->
                <div class="form-actions">
                  <a href='#' rel="granulometria<?php echo $i;?>" class="btn btn-primary input-xlarge guardarGranulometria">Guardar información</a>
                </div>
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->
              </div>
              <?php $i++; ?>
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
                <th>Profundidad</th>
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
                <td class="tds" rowspan="13">
                  <p class="nivel_freatico"><i class="icon-ok"></i> </p>
                  <p class="centimetros">0.5 m</p>
                  <p class="centimetros">1 m</p>
                  <p class="centimetros">1.5 metros</p>
                  <p class="centimetros">2 metros</p>
                  <p class="centimetros">2.5 metros</p>
                  <p class="centimetros">3 metros</p>
                  <p class="centimetros">3.5 metros</p>
                  <p class="centimetros">4 metros</p>
                  <p class="centimetros">4.5 metros</p>
                  <p class="centimetros">5 metros</p>
                </td>
                <td> - </td>
                <td style=" height: 50px;" class="texture1">  </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> Capa vegetal </td>
              </tr>
              <tr>
                <td> 1 </td>
                <td style=" height: 50px;" class="texture">  </td>
                <td> 25 </td>
                <td> 40</td>
                <td> 23 </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 2 </td>
                <td style=" height: 35px;" class="texture1">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 3 </td>
                <td style=" height: 62px;" class="texture">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 4 </td>
                <td style=" height: 90px;" class="texture1">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 5 </td>
                <td style=" height: 55px;" class="texture">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 6 </td>
                <td style=" height: 33px;" class="texture1">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 7 </td>
                <td style=" height: 75px;" class="texture">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 8 </td>
                <td style=" height: 45px;" class="texture1">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 9 </td>
                <td style=" height: 45px;" class="texture">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 10 </td>
                <td style=" height: 45px;" class="texture1">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 11 </td>
                <td style=" height: 45px;" class="texture">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
              <tr>
                <td> 12 </td>
                <td style=" height: 45px;" class="texture1">  </td>
                <td> 25 </td>
                <td> -</td>
                <td> - </td>
                <td> 66% </td>
                <td> 55% </td>
                <td> 34% </td>
                <td> GC </td>
                <td> A-2-7 </td>
                <td> 
                  <span class="badge">N° 4 = 23% 
                  </span>
                  <span class="badge">N° 10 = 23% 
                  </span>
                  <span class="badge">N° 40 = 23% 
                  </span>
                  <span class="badge">N° 200 = 23% 
                  </span>
                </td>
                <td>
                  Material de relleno Grava areno Arcillosa 
                </td>
              </tr>
            </tbody>
          </table>
          <h5 >Nivel freatico: 1</h5>
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
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, modi, rem, fugiat dicta error accusantium possimus voluptatum distinctio pariatur perferendis corrupti libero minus iure id architecto eius neque velit est.
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate, qui, distinctio magni libero quasi molestias accusantium amet temporibus sapiente possimus eligendi quam quis perferendis rerum eos aut beatae nemo harum.
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
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, modi, rem, fugiat dicta error accusantium possimus voluptatum distinctio pariatur perferendis corrupti libero minus iure id architecto eius neque velit est.
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate, qui, distinctio magni libero quasi molestias accusantium amet temporibus sapiente possimus eligendi quam quis perferendis rerum eos aut beatae nemo harum.
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
        <form id="datosProyecto" name='formulario' method='post' action="index.php?controller=navegacion&amp;action=guardarProyectos" class="form-vertical">
          <div class="control-group">
            <div class="controls inputs">
              <input type='text' name='nivel_freatico' placeholder='Nivel freatico ' class="input-block-level limpiar required" autofocus >
            </div>
            <div class="row-fluid">
              <select name='responsable' id='lista_usuarios' class="span8"  >
                <option value="">Selecciona tipo de superficie </option>
              </select >
              <input type='text' name='Profundidad' placeholder='Profundidad' class="span4" >   
            </div>
            <!-- Mensaje exito y error , la clase hide es la que las oculta usen el Id de cada mensaje -->
            <div id="error" class="alert alert-error hide">                             
              <strong> <small>error al guardar el proyecto</small>  </strong>
            </div>
            <div id="exito" class="alert alert-success hide ">
              <strong>Datos correctos.</strong>  
            </div>
            <!-- Fin mensaje exito y error -->
          </div>
        </form>
      </div>
      <!-- fin form  nuevo sondeo-->
      <div class="modal-footer">
        <button class="btn " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button type="submit" id="enviar"  class="btn btn-primary inputs"> <i class="icon-check icon-white"></i> Guardar proyecto</button> 
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
              <input name="box_relleno" type="checkbox" value="1">
              Es parte de la capa de relleno
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
            <input id="material_de_relleno" name="box_relleno" type="checkbox" value="1">
            Es parte de la capa de relleno
            </label>
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
    <!-- #############  BOOTSTRAP JS ############### -->
    <!--script type="text/javascript" src="assets/js/jqplot/plugins/example.js"></script-->
    <script src="assets/js/muestras.js"></script>
    
    <script type="text/javascript">
      $(function graficador() {
      
        
       
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
      
      
      var datosgrafica=$('#datosgraficaLimites<?php echo $i; ?>').val();
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
              tickInterval: 1,
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
        }]
      });
      
      <?php $i++; ?>
      <?php endforeach; ?>
      
     
  

      $('.brand').tooltip('hide');   

    //graficas compresion
    
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
      //var datosgrafica=$('#datosgrafica<?php echo $i; ?>').val();
      //var sourceData = eval("["+datosgrafica+"]");  
      
      var sourceData =[
      [0.03,0.08],
      [0.08,0.29],
      [0.13,0.61],
      [0.19,0.95],
      [0.25,1.10],
      [0.38,1.23],
      [0.51,1.32]];


      $('#graficacompresion<?php echo $i; ?>').highcharts({

          chart: {
            renderTo: 'linear'
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
              data: sourceData,
              pointStart: 1
          },{
          name: 'Linea de tendencia',  
          type: 'line',
          lineWidth: 0.5,
          marker: { enabled: false },
          data: sourceData
        }]
      });
      
      <?php $i++; ?>
      <?php endforeach; ?>
        
       <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
    
    



      <?php $i++; ?>
      <?php endforeach; ?>



    });
    </script>

  </body>
</html>