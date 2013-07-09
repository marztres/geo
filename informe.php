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

 $granulometriaClass=new granulometria();
  $pesosRetenidosClass=new pesos_retenidos();
  $granulometriaMuestra=array();
  $pesosRetenidosMuestra=array();
  $i=0;
  foreach ( $muestrasSondeo as $muestra ) {
    $granulometriaMuestra[] = $granulometriaClass->getDatoGranulometria( $muestra->id_muestra );
    $idGranulometria= $granulometriaClass->getDatoGranulometria( $muestra->id_muestra );
    $pesosRetenidosMuestra[]=$pesosRetenidosClass->getDatoPesosRetenidos($idGranulometria->id_granulometria);
  }
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
    <link rel="stylesheet" href="assets/css/baseinforme.css">
    <link rel="stylesheet" href="assets/css/informe.css">
    <link rel="stylesheet" href="assets/css/jquery.jqplot.min.css">
   


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
    
    <!--script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script-->
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    


    <script src="assets/js/jqplot/jquery.jqplot.min.js"></script>
    <script src="assets/js/jqplot/plugins/jqplot.logAxisRenderer.js"></script>
    <script src="assets/js/jqplot/plugins/jqplot.trendline.js"></script>

  </head>
  <body>
    <!-- ############# HEADER ############### -->
    <div class="row-fluid header">
      <div class="span2">
        <figure class="logo"></figure>
      </div>
      <h3 class="span4 header-title"> </h3>
      
    </div>
    <!-- ############# FIN HEADER ############### -->

    <!-- #############  CUERPO ############### --> 
    <div class="row-fluid cuerpo-proyectos">
      <!-- #############  NAVEGACION SUPERIOR ############### --> 
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" >Proyecto |</a>
            <a class="brand" > <?php echo $proyectos->nombre_proyecto; ?> |</a>
            <a class="brand" >Información de sondeo</a>
            

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
        </div>
      </div>
      <!-- ############# FIN DATOS DE SONDEO ############### -->
      <!-- #############  TAB EXTERIORES  ############### -->
        <div id="allMuestras">
      
          <h3 class="text-center">Muestras del proyecto</h3>
          <!-- ############# FIN NAVEGACION INTERIOR MUESTRAS ############### -->
          <!-- #############  TABLA MUESTRAS ############### -->
          <input type='hidden' id='idp' value="<?php echo $_GET['idp']; ?>">
          <input type='hidden' id='ids' value="<?php echo $_GET['ids']; ?>">
          <table class="table" id='muestras'>
            <thead>
              <tr>
                <th># Muestra</th>
                <th>Profundidad</th>
                <th>Numero de golpes</th>
                <th>Color</th>
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
        
        
            
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <div class="text-center" id="muestra<?php echo $i; ?>">
                <!-- #############  HUMEDAD NATURAL ############### -->
                <h3>Humedad natural muestra <?php echo $i; ?></h3>
                <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="testlimites">
                  <input type="hidden" name="muestra" value="0">
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][0]->id_test.",".$TestLimitesMuestra[$i-1][1]->id_test.",".$TestLimitesMuestra[$i-1][2]->id_test; ?>">
                  <table class="table table-condensed  humedad">
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
                        <td><?php echo $porcentajeAgua1 = round((($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][0]->peso_capsula )) * 100, 2); ?></td>
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
                        <td><?php echo round(($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][1]->peso_capsula ), 2); ?></td>
                        <td><?php echo round(($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco ), 2); ?></td>
                        <td><?php echo $porcentajeAgua2 = round((($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][1]->peso_capsula )) * 100, 2); ?></td>
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
                        <td><?php echo $porcentajeAgua3 = round((($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][2]->peso_capsula )) * 100, 2); ?></td>
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
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                <!-- ############# FIN HUMEDAD NATURAL ############### -->
                <!-- #############  LIMITE LIQUIDO ############### -->
                <h3>Limite liquido muestra <?php echo $i; ?></h3>
                <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="testlimites" />
                  <input type="hidden" name="muestra" value="1" />
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][3]->id_test.",".$TestLimitesMuestra[$i-1][4]->id_test.",".$TestLimitesMuestra[$i-1][5]->id_test; ?>">
                  <table class="table table-condensed  liquido">
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
                          <input name="liquidoGolpes[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][3]->num_golpes; ?>">
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
                        <td><?php echo round(($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][3]->peso_capsula ), 2); ?></td>
                        <td><?php echo round(($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco ), 2); ?></td>
                        <td><?php echo $porcentajeLiquido1 = round((($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][3]->peso_capsula )) * 100, 2); ?></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>
                          <input name="liquidoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->nom_capsula; ?>">
                        </td>
                        <td>
                          <input name="liquidoGolpes[]" class="input-mini limites iliquido" type="text" value="<?php echo $TestLimitesMuestra[$i-1][4]->num_golpes; ?>">
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
                        <td><?php echo $porcentajeLiquido2 = round((($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][4]->peso_capsula )) * 100, 2); ?></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>
                          <input name="liquidoNombreCapsula[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->nom_capsula; ?>">
                        </td>
                        <td>
                          <input name="liquidoGolpes[]" class="input-mini" type="text" value="<?php echo $TestLimitesMuestra[$i-1][5]->num_golpes; ?>">
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
                        <td><?php echo $porcentajeLiquido3 = round((($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][5]->peso_capsula )) * 100, 2); ?></td>
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
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </form>
            
                <div id="graficaliquido<?php echo $i;?>" class="graficas"></div>

                <script  type="text/javascript">
                $(document).ready(function graficar<?php echo $i;?>(){
                  $.jqplot.config.enablePlugins = true;
                  var line1=[[16,57.86], [26,56.11], [34,54.46]];
                  var plot1 = $.jqplot('graficaliquido<?php echo $i;?>', [line1], {
                    title:'Estimaciones de limite liquido',
                    axes:{
                        xaxis:{
                            renderer:$.jqplot.LogAxisRenderer,
                            base: 10,
                            label:'N° de golpes'
                        },
                        yaxis:{
                            label:'Contenido de humedad %'
                        }

                    },
                    series:[
                      {
                        lineWidth:4, 
                        markerOptions:{
                          style:'square'
                        }

                    }]
                    
                    
                  });
                });

                </script>
                
  
                <!-- #############  LIMITE PLASTICO ############### -->
                <h3>Limite plastico muestra <?php echo $i; ?></h3>
              
                <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="testlimites" />
                  <input type="hidden" name="muestra" value="2" />
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][6]->id_test.",".$TestLimitesMuestra[$i-1][7]->id_test.",".$TestLimitesMuestra[$i-1][8]->id_test; ?>">
                  <table class="table table-condensed plastico">
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
                        <td><?php echo $porcentajePlastico1 = round((($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][6]->peso_capsula )) * 100, 2); ?></td>
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
                        <td><?php echo $porcentajePlastico2 = round((($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][7]->peso_capsula )) * 100, 2); ?></td>
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
                        <td><?php echo $porcentajePlastico3 = round((($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_humedo - $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco ) / ($TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco - $TestLimitesMuestra[$i-1][8]->peso_capsula )) * 100, 2); ?></td>
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
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                <!-- ############# FIN LIMITE PLASTICO ############### -->
                <!-- ############# RESULTADOS ############### -->
                <h3>Resultados muestra <?php echo $i; ?></h3>
                <table class="table table-condensed resultados">
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
                          $divMayorMenor1 = $mayor / $menor;
                          if ( $divMayorMenor1 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajeAgua2, $porcentajeAgua3 ) );
                          $mayor = max( array( $porcentajeAgua2, $porcentajeAgua3 ) );
                          $divMayorMenor2 = $mayor / $menor;
                          if ( $divMayorMenor2 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajeAgua1, $porcentajeAgua3 ) );
                          $mayor = max( array( $porcentajeAgua1, $porcentajeAgua3 ) );
                          $divMayorMenor3 = $mayor / $menor;
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
                          $divMayorMenor1 = $mayor / $menor;
                          if ( $divMayorMenor1 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajeLiquido2, $porcentajeLiquido3 ) );
                          $mayor = max( array( $porcentajeLiquido2, $porcentajeLiquido3 ) );
                          $divMayorMenor2 = $mayor / $menor;
                          if ( $divMayorMenor2 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajeLiquido1, $porcentajeLiquido3 ) );
                          $mayor = max( array( $porcentajeLiquido1, $porcentajeLiquido3 ) );
                          $divMayorMenor3 = $mayor / $menor;
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
                          $menor = min( array( $porcentajePlastico1, $porcentajePlastico2 ) );
                          $mayor = max( array( $porcentajePlastico1, $porcentajePlastico2 ) );
                          $divMayorMenor1 = $mayor / $menor;
                          if ( $divMayorMenor1 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajePlastico2, $porcentajePlastico3 ) );
                          $mayor = max( array( $porcentajePlastico2, $porcentajePlastico3 ) );
                          $divMayorMenor2 = $mayor / $menor;
                          if ( $divMayorMenor2 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          $menor = min( array( $porcentajePlastico1, $porcentajePlastico3 ) );
                          $mayor = max( array( $porcentajePlastico1, $porcentajePlastico3 ) );
                          $divMayorMenor3 = $mayor / $menor;
                          if ( $divMayorMenor3 < 1.29 ) {
                            $resultado = ($mayor + $menor)/2;
                          }
                          if ( $divMayorMenor1 > 1.29 && $divMayorMenor2 > 1.29 && $divMayorMenor3 > 1.29 ) {
                            $resultado = 0;
                          }
                          echo round($resultado,2);
                          ?>
                      </td>
                      <td>62</td>
                    </tr>
                  </tbody>
                </table>
                <!-- ############# FIN RESULTADOS HUMEDAD Y LIMITE ############### -->
              </div>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
          </div>
          <!-- ############# fin tabs de muestras internas limites ############### -->
        <div  id="Compresion">
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->
          
            
            <div >
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $DatosCompresion = $datosCompresion->GetDatosCompresion( $datoMuestra->id_muestra );  ?>
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="compresion<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA ############### -->
                <h3>Medidas de la muestra muestra <?php echo $i; ?></h3>
                <form class="compresion<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <table class="table table-condensed tablacompresion ">
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
                <h3>Tabla de deformación muestra <?php echo $i; ?></h3>
                <table class="table table-condensed tabladeformacion">
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
                      <td>
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
                <img src="assets/graficas/compresion.png" alt="grafica de limite liquido">
                <!-- ############# FIN GRAFICA DE COMPRESIÓN ############### -->
                <!-- ############# RESULTADOS ############### -->
                <h3>Resultados muestra <?php echo $i; ?></h3>
                <table class="table table-condensed  resultadoscompresion">
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
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->  
              </div>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>              
            </div>
        </div>
        <div  id="Granulometria">
            <div >
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              
              <div class="tab-pane <?php echo (($i==1)?'active':''); ?> text-center" id="granulometria<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA GRANULOMETRIA############### -->
                <h3> Analisis granulometrico muestra <?php echo $i; ?> </h3>
                <form class="granulometria<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="granulometria">
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idgranulometria" value="<?php echo $granulometriaMuestra[$i-1]->id_granulometria ?>">
                <table class="table table-condensed  tablaanalisis">
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
                      <td> <input name="pesoRecipiente" class="input-mini analisis" type="text" value="<?php echo $granulometriaMuestra[$i-1]->pesoRecipiente ?>"> </td>
                      <td> <input name="pesoRecipienteMasMuestra" class="input-mini analisis" type="text" value="<?php echo $granulometriaMuestra[$i-1]->pesoRecipienteMasMuestra ?>"> </td>
                      <td>  </td>
                      <td>  </td>
                      <td>  </td>
                      <td>  </td>
                    </tr>
                  </tbody>
                </table>
                <!-- ############# FIN MEDIDAS DE LA MUESTRA GRANULOMETRIA ############### -->
                <!-- #############  TABLA DE GRANULOMETRIA ############### -->
                <h3>Tabla de granulometria muestra <?php echo $i; ?></h3>
                <table class="table table-condensed  tablapesos">
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
                    <tr>
                      <td> (2 1/2") 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][0]->idPesoRetenido ?>">
                      </td>
                      <td> 63.5</td>
                      <td>  <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][0]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> 2" 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][1]->idPesoRetenido ?>">
                      </td>
                      <td> 50.8 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][1]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> (1 1/2") 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][2]->idPesoRetenido ?>">
                      </td>
                      <td> 38.1 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][2]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> 1" 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][3]->idPesoRetenido ?>">
                      </td>
                      <td> 25.4 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][3]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> (3/4") 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][4]->idPesoRetenido ?>">
                      </td>
                      <td> 19.05 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][4]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> (1/2") 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][5]->idPesoRetenido ?>">
                      </td>
                      <td> 12.7 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][5]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> (3/8") 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][6]->idPesoRetenido ?>">
                      </td>
                      <td> 9.52 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][6]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°4 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][7]->idPesoRetenido ?>">
                      </td>
                      <td> 4.75</td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][7]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°10 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][8]->idPesoRetenido ?>">
                      </td>
                      <td> 2 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][8]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°16 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][9]->idPesoRetenido ?>">
                      </td>
                      <td> 1.19 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][9]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°30 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][10]->idPesoRetenido ?>">  
                      </td>
                      <td> 0.60 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][10]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°40 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][11]->idPesoRetenido ?>">
                      </td>
                      <td> 0.43 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][11]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°100 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][12]->idPesoRetenido ?>">
                      </td>
                      <td> 0.15 </td>
                      <td> <input name="PesosRetenido[]"  class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][12]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> N°200 
                        <input name="idPesoRetenido[]" type="hidden" class="input-mini " type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][13]->idPesoRetenido ?>">
                      </td>
                      <td> 0.08 </td>
                      <td> <input name="PesosRetenido[]" class="input-mini granulo" type="text" value="<?php echo $pesosRetenidosMuestra[$i-1][13]->pesoRetenido ?>"> </td>
                      <td>  </td>
                      <td class="retenido">  </td>
                      <td class="acumulado">  </td>
                      <td>  </td>
                    </tr>
                    <tr>
                      <td> Fondo </td>
                      <td> 0</td>
                      <td> 0</td>
                      <td> 0</td>
                      <td class="retenido"> 0</td>
                      <td class="acumulado"> 0</td>
                      <td> 0</td>
                    </tr>
                    <tr>
                      <td> Total </td>
                      <td> </td>
                      <td> 0</td>
                      <td> 0</td>
                      <td>  </td>
                      <td>  </td>
                      <td>  </td>
                    </tr>
                  </tbody>
                </table>
                </form>
                <!-- ############# TABLA DE GRANULOMETRIA ############### -->
                <!-- ############# GRAFICA DE GRANULOMETRIA ############### -->
                <img src="assets/graficas/granulometria.png" alt="grafica de limite liquido">
                <!-- ############# FIN GRAFICA DE GRANULOMETRIA ############### -->
                <!-- ############# RESULTADOS ############### -->
                <h3>Resultados muestra <?php echo $i; ?></h3>
                <table class="table table-condensed ">
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
                <table class="table table-condensed ">
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
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->
              </div>
              <?php $i++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?> 
            </div>
          
          <!-- ############# fin tabs de muestras internas GRANULOMETRIA ############### -->
        </div>
        <div  id="Informe">
          <!-- ############# tabs de muestras internas Informe de estratigrafia ############### -->
          <!-- ############# INFORME DE ESTRATIGRAFIA ############### -->
          <h3 class="text-center">Informe de estratigrafia</h3>
          <table class="table table-condensed letra-s">
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
      <div id="chart1" style="height:300px; width:650px;"></div>

<script  type="text/javascript">
$(document).ready(function(){
  $.jqplot.config.enablePlugins = true;
  var line1=[[16,57.86], [26,56.11], [34,54.46]];
  var plot1 = $.jqplot('chart1', [line1], {
    title:'Estimaciones de limite liquido',
    axes:{
        xaxis:{
            renderer:$.jqplot.LogAxisRenderer,
            base: 10,
            label:'N° de golpes'
        },
        yaxis:{
            label:'Contenido de humedad %'
        }

    },
    series:[
      {
        lineWidth:4, 
        markerOptions:{
          style:'square'
        }

    }]
    
    
  });
});

</script>



      <!-- ############# FIN CUERPO ############### --> 
    </div>
    <!-- #############  FOOTER ############### -->    
    
 




    <!--script type="text/javascript" src="assets/js/jqplot/plugins/example.js"></script-->
    <script src="assets/js/muestras.js"></script>
    <!--  
      <script>
      $(function() {
      function graficar( linea, contenedor ) {
      $.jqplot.config.enablePlugins = true;
      //var line1=[[16,57.86], [26,56.11], [34,54.46]];
      $.jqplot( contenedor, [linea], {
      title:'Estimaciones de limite liquido',
      axes:{
       xaxis:{
           renderer:$.jqplot.LogAxisRenderer,
           base: 10,
           label:'N° de golpes'
       },
       yaxis:{
           label:'Contenido de humedad %'
       }
      },
      series:[
      {
       lineWidth:4, 
       markerOptions:{
         style:'square'
       }
      
      }]
      });
      }
      
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      setTimeout(function(){
      console.log("ejecutando");
      graficar([[16,57.86], [26,56.11], [34,54.46]], 'grafica<?php echo $i; ?>' );
      },5000);
      <?php $i++; ?>
      <?php endforeach; ?>
      });
      </script>
      -->
    <script>  
      $(document).ready( function(){
      setTimeout(function(){

       graficaliquido1;   

      },5000);

    });
    </script>  

  <script>
    $('.brand').tooltip('hide');
  </script>
  
  <!-- <script src="assets/js/jqplot/plugins/example.js"></script> -->
  
  </body>
</html>