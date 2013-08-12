<?php
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
  
  $data = $_SESSION['usuario'];
  $usuariosClass = new usuarios();
  $user = $usuariosClass->getUsuarioActual($data['id_usuario']);
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
  $resultadosClass= new resultados();
  $pagina = 1;  
  ?>
<!DOCTYPE html>
<html lang="es" class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Informe de suelos - Sondeo <?php echo $_GET['numsondeo'] ?> - <?php echo $proyectos->fecha; ?> - Geotecnia y Ambiente S.A.S</title>
    <meta name="description" content="El software de Geotecnia y Ambiente es el encargado de procesar los datos obtenidos por los laboratoristas de las muestras de los suelos">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/baseinforme.css">
    <link rel="stylesheet" href="assets/css/informe.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>  
    <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="assets/js/vendor/bootstrap.js"></script>
    <script src="assets/js/vendor/highcharts.js"></script>
    <script src="assets/js/vendor/regression.js"></script>
    <link rel="stylesheet" href="assets/css/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify.default.css" />
  </head>
  <body>
    <!-- #############  CUERPO ############### --> 
    <div class="row-fluid cuerpo-proyectos">
      
      <!-- #############  DATOS DE SONDEO ############### -->   
      <div class="encabezados">
        <div class="row-fluid">
          <div class="span1 "> 
            <img src="assets/img/logoinforme.png" class="logo"  alt="Logo impresion">
          </div>
          <div class="span11 div-separador">
            <div class="row-fluid"> 
              <h4 class="header-title text-center"> 
                Informe de suelos - Sondeo <?php echo $_GET['numsondeo'] ?> 
              </h4>
            </div>
            <div class="row-fluid datosinforme">
              <label for="nombre_proyecto_label" class="span2 title">Proyecto:</label>
              <label id="lb_nombre_proyecto" for="nombre_proyecto" class="span3">
              <?php echo $proyectos->nombre_proyecto; ?>
              </label>
              <label for="fecha_proyecto_label" class="span1 title">Fecha:</label>
              <label id="lb_fecha_proyecto" for="fecha_proyecto" class="span2">
              <?php echo $proyectos->fecha; ?>
              </label>
            </div>
            <div class="row-fluid datosinforme">
              <label for="codigo_proyecto_label" class="span2 title">Codigo:</label>
              <label id="lb_codigo_proyecto" for="codigo_proyecto" class="span3">
              <?php echo $proyectos->codigo_proyecto; ?>
              </label>
              <label for="nombre_proyecto_label" class="span1 title">Lugar:</label>
              <label id="lb_lugar_proyecto" for="nombre_proyecto" class="span3">
              <?php echo $proyectos->lugar; ?>
              </label>
            </div>
          </div>
        </div>
      </div>
    
        
        <div class="text-center"  id="Muestras">
          <p>Muestras</p>  
          <!-- #############  TABLA MUESTRAS ############### -->
          <input type='hidden' id='idp' value="<?php echo $_GET['idp']; ?>">
          <input type='hidden' id='ids' value="<?php echo $_GET['ids']; ?>">
          <table class="table " id='muestras'>
            <thead>
              <tr>
                <th># Muestra</th>
                <th>Profundidad</th>
                <th>Numero de golpes</th>
                <th>Color  </th>
              </tr>
            </thead>
            <tbody>
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <tr>
                <td ><span class="titulo-proyectos"><?php echo $i; ?></span></td>
                <td>
                  Desde <?php echo $datoMuestra->profundidad_inicial ?> metros --- Hasta <?php echo $datoMuestra->profundidad_final ?> metros
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
        
        <span class="pull-right paginadorMuestras">Pagina <?php echo $pagina; ?></span>
        </div>
        <?php $pagina++; ?>
        <!-- ############# tabs de muestras internas limites ############### -->
        

        <?php if ( $_GET['boxLim']==1) : ?>
        <div  id="Limites">
                 

              
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; $arrLimites = array(); $arrCompresion= array(); ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <div class="encabezados">
                  <div class="row-fluid">
                    <div class="span1 "> 
                      <img src="assets/img/logoinforme.png" class="logo"  alt="Logo impresion">
                    </div>
                    <div class="span11 div-separador">
                      <div class="row-fluid"> 
                        <h4 class="header-title text-center"> 
                          Informe de suelos - Sondeo <?php echo $_GET['numsondeo'] ?> 
                        </h4>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="nombre_proyecto_label" class="span2 title">Proyecto:</label>
                        <label id="lb_nombre_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->nombre_proyecto; ?>
                        </label>
                        <label for="fecha_proyecto_label" class="span1 title">Fecha:</label>
                        <label id="lb_fecha_proyecto" for="fecha_proyecto" class="span2">
                        <?php echo $proyectos->fecha; ?>
                        </label>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="codigo_proyecto_label" class="span2 title">Codigo:</label>
                        <label id="lb_codigo_proyecto" for="codigo_proyecto" class="span3">
                        <?php echo $proyectos->codigo_proyecto; ?>
                        </label>
                        <label for="nombre_proyecto_label" class="span1 title">Lugar:</label>
                        <label id="lb_lugar_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->lugar; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>  
              <div class="text-center divLimites"  id="muestra<?php echo $i; ?>">
                <!-- #############  HUMEDAD NATURAL ############### -->
                <p >Humedad natural - Muestra <?php echo $i; ?> </p>
                <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="testlimites">
                  <input type="hidden" name="muestra" value="0">
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][0]->id_test.",".$TestLimitesMuestra[$i-1][1]->id_test.",".$TestLimitesMuestra[$i-1][2]->id_test; ?>">
                  <table class="table  humedad">
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
                      <tr >
                        <td>1</td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][0]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][0]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][0]->peso_capsula_suelo_seco; ?>
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
                          <?php echo $TestLimitesMuestra[$i-1][1]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][1]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][1]->peso_capsula_suelo_seco; ?>
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
                          <?php echo $TestLimitesMuestra[$i-1][2]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][2]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][2]->peso_capsula_suelo_seco; ?>
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
                <p>Limite liquido - Muestra <?php echo $i; ?></p>
                <form class="muestra<?php echo $i; ?>" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="testlimites" />
                  <input type="hidden" name="muestra" value="1" />
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][3]->id_test.",".$TestLimitesMuestra[$i-1][4]->id_test.",".$TestLimitesMuestra[$i-1][5]->id_test; ?>">
                  <table class="table  liquido">
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
                          <?php echo $TestLimitesMuestra[$i-1][3]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][3]->num_golpes; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][3]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][3]->peso_capsula_suelo_seco; ?>
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
                          <?php echo $TestLimitesMuestra[$i-1][4]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][4]->num_golpes; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][4]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][4]->peso_capsula_suelo_seco; ?>
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
                          <?php echo $TestLimitesMuestra[$i-1][5]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][5]->num_golpes; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][5]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][5]->peso_capsula_suelo_seco; ?>
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
                            if($golpes1!=0 AND $golpes2!=0 AND $golpes3!=0    ){
                                $pendiente1=($humedad2-$humedad1)/($golpes2-$golpes1);
                                $pendiente2=($humedad3-$humedad1)/($golpes3-$golpes1);
                                $pendiente3=($humedad3-$humedad2)/($golpes3-$golpes2);
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
                <div id="graficaLimites<?php echo $i; ?>" style=" widht:600px; height: 400px;"></div>
                <!-- #############  LIMITE PLASTICO ############### -->
                <p>Limite plastico - Muestra <?php echo $i; ?></p>
                <form class="muestra<?php echo $i; ?> formResultados" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="testlimites" />
                  <input type="hidden" name="muestra" value="2" />
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idtest" value="<?php echo $TestLimitesMuestra[$i-1][6]->id_test.",".$TestLimitesMuestra[$i-1][7]->id_test.",".$TestLimitesMuestra[$i-1][8]->id_test; ?>">
                  <table class="table  plastico">
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
                          <?php echo $TestLimitesMuestra[$i-1][6]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][6]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][6]->peso_capsula_suelo_seco; ?>
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
                          <?php echo $TestLimitesMuestra[$i-1][7]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][7]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][7]->peso_capsula_suelo_seco; ?>
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
                          <?php echo $TestLimitesMuestra[$i-1][8]->nom_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][8]->peso_capsula; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_humedo; ?>
                        </td>
                        <td>
                          <?php echo $TestLimitesMuestra[$i-1][8]->peso_capsula_suelo_seco; ?>
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
                  <p>Resultados</p>
                  <table class="table  resultados">
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
                  
       
                </form>
                <!-- ############# FIN RESULTADOS HUMEDAD Y LIMITE ############### -->
              <span class="paginadorLimites">Pagina <?php echo $pagina; ?></span>
              </div>
              <?php $i++;?>
              <?php $pagina++;?>   
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>
          
          <!-- ############# fin limites ############### -->

        </div>
        <?php endif ?>
        
        <?php if ( $_GET['boxComp']==1) : ?>
        <div  id="Compresion">
          <!-- ############# COMPRESION ############### -->
         
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $DatosCompresion = $datosCompresion->GetDatosCompresion( $datoMuestra->id_muestra );  ?>
              <div class="encabezados">
                  <div class="row-fluid">
                    <div class="span1 "> 
                      <img src="assets/img/logoinforme.png" class="logo"  alt="Logo impresion">
                    </div>
                    <div class="span11 div-separador">
                      <div class="row-fluid"> 
                        <h4 class="header-title text-center"> 
                          Informe de suelos - Sondeo <?php echo $_GET['numsondeo'] ?> 
                        </h4>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="nombre_proyecto_label" class="span2 title">Proyecto:</label>
                        <label id="lb_nombre_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->nombre_proyecto; ?>
                        </label>
                        <label for="fecha_proyecto_label" class="span1 title">Fecha:</label>
                        <label id="lb_fecha_proyecto" for="fecha_proyecto" class="span2">
                        <?php echo $proyectos->fecha; ?>
                        </label>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="codigo_proyecto_label" class="span2 title">Codigo:</label>
                        <label id="lb_codigo_proyecto" for="codigo_proyecto" class="span3">
                        <?php echo $proyectos->codigo_proyecto; ?>
                        </label>
                        <label for="nombre_proyecto_label" class="span1 title">Lugar:</label>
                        <label id="lb_lugar_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->lugar; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>  
              <div class="text-center divCompresion" id="compresion<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA ############### -->
                <p>Compresión - Medidas de la muestra - Muestra <?php echo $i; ?></p>
                <form class="compresion<?php echo $i; ?> formResultadosCompresion" action="save.php" method="post" accept-charset="utf-8">
                  <input name="fk_idmuestra" type="hidden" value="<?php echo $datoMuestra->id_muestra; ?>">
                  <table class="table  tablacompresion ">
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
                          <?php echo $DatosCompresion->diametro; ?>
                        </td>
                        <td>
                          <?php echo $DatosCompresion->altura; ?>
                        </td>
                        <td>
                          <?php echo $DatosCompresion->peso; ?>
                        </td>
                        <td>
                          <?php echo $DatosCompresion->tipoFalla; ?>
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
                  <p>Tabla de deformación - Muestra <?php echo $i; ?></p>
                  <table class="table  tabladeformacion">
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
                          <?php echo $deformaciones ->carga ?>
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
                  <div id="graficacompresion<?php echo $i; ?>" style=" widht:600px; height: 400px;"></div>
                  <?php 
                    unset($gdt);
                    unset($ge);
                    unset($datos);
                    ?>
                  <!-- ############# FIN GRAFICA DE COMPRESIÓN ############### -->
                  <!-- ############# RESULTADOS ############### -->
                  <p>Resultados</p>
                  <table class="table  resultadoscompresion">
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
                                 
                                 if($posicion==9){
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
                <!-- ############# FIN GUARDAR INFORMACION BOTON ############### -->  
              <span class="paginadorCompresion">Pagina <?php echo $pagina; ?></span>
              </div>
              <?php $i++; ?>
              <?php $pagina++; ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?>              
          
             <!-- ############# fin Compresion ############### -->
        </div>
        <?php endif ?>

        <?php if ( $_GET['boxGran']==1) : ?>
        <div  id="Granulometria">
          <!-- ############# tabs de muestras internas GRANULOMETRIA ############### -->  
              <?php if( count($muestrasSondeo) > 0 ): ?>
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $DatosGranulometria = $datosGranulometria->getDatoGranulometria( $datoMuestra->id_muestra );  ?>
              <?php $resultado= $resultadosClass->getResultado($datoMuestra->id_muestra); ?>
              <div class="encabezados">
                  <div class="row-fluid">
                    <div class="span1 "> 
                      <img src="assets/img/logoinforme.png" class="logo"  alt="Logo impresion">
                    </div>
                    <div class="span11 div-separador">
                      <div class="row-fluid"> 
                        <h4 class="header-title text-center"> 
                          Informe de suelos - Sondeo <?php echo $_GET['numsondeo'] ?> 
                        </h4>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="nombre_proyecto_label" class="span2 title">Proyecto:</label>
                        <label id="lb_nombre_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->nombre_proyecto; ?>
                        </label>
                        <label for="fecha_proyecto_label" class="span1 title">Fecha:</label>
                        <label id="lb_fecha_proyecto" for="fecha_proyecto" class="span2">
                        <?php echo $proyectos->fecha; ?>
                        </label>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="codigo_proyecto_label" class="span2 title">Codigo:</label>
                        <label id="lb_codigo_proyecto" for="codigo_proyecto" class="span3">
                        <?php echo $proyectos->codigo_proyecto; ?>
                        </label>
                        <label for="nombre_proyecto_label" class="span1 title">Lugar:</label>
                        <label id="lb_lugar_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->lugar; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>  
              <div class="text-center divGranulometria" id="granulometria<?php echo $i; ?>">
                <!-- #############  MEDIDAS DE LA MUESTRA GRANULOMETRIA############### -->
                <p> Analisis granulometrico - Muestra <?php echo $i; ?></p>
                <form class="granulometria<?php echo $i; ?> resultadosGranulometria" action="save.php" method="post" accept-charset="utf-8">
                  <input type="hidden" name="func" value="granulometria">
                  <input type="hidden" name="fkMuestra" value="<?php echo $datoMuestra->id_muestra ?>">
                  <input type="hidden" name="idgranulometria" value="<?php echo $DatosGranulometria->id_granulometria ?>">
                  <table class="table  tablaanalisis">
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
                        <td> <?php echo $DatosGranulometria->pesoRecipiente?> </td>
                        <td> <?php echo $DatosGranulometria->pesoRecipienteMasMuestra ?> </td>
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
                  <p>Tabla de granulometria - Muestra <?php echo $i; ?></p>
                  <table class="table  tablapesos">
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
                        <?php if ($retenidos->pesoRetenido>0): ?>  
                          <tr>
                            <td><?php echo $retenidos->tamiz ?>
                              <input name="idPesoRetenido[]" class="input-mini" type="hidden" value="<?php echo $retenidos->idPesoRetenido ?>">
                            </td>
                            <td class="tamTamiz"><?php echo $tamañoTamiz[]=$retenidos->tamanoTamiz ?></td>
                            <td> <?php echo $retenidos->pesoRetenido ?> </td>
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
                            <td class="pasa">
                              <?php echo $pasa= 100 - $temp[$j];
                                if($retenidos->pesoRetenido>0){
                                   $p[]=$pasa;
                                }
                                   $tamices[]=$pasa;
                                ?>
                            </td>
                          </tr>
                        
                      <?php $j++; ?>
                      <?php endif; ?>
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
                  <div id="graficagranulometria<?php echo $i; ?>" style=" widht:600px; height: 400px;"></div>
                  <!-- ############# FIN GRAFICA DE GRANULOMETRIA ############### -->
                  <!-- ############# RESULTADOS ############### -->
                  <?php 
                    unset($pr);
                    unset($p);
                    unset($datos); 
                    ?>
                  
                  <p>Resultados</p>
                  <table class="table  tablaResultadosGranulometria">
                    <thead>
                      <tr>
                        <th> Tamiz N°4</th>
                        <th> Tamiz N°200</th>
                        <th> Limite liquido</th>
                        <th> Indice de plasticidad</th>
                        <th> Indice de grupo</th>
                        <th> Clasificación Sistema unificado</th>
                        <th> Clasificación AASHTO</th>
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
                          <?php
                            if($resultado->indicePlasticidad==0){
                               $tamizN4=0;
                            }
                            else{
                                 echo $tamizN4=round($tamices[7],2);
                            }
                            ?>
                        </td>
                        <td class="tdTamiz200">
                          <?php ; 
                            if($resultado->indicePlasticidad==0){
                                  $tamizN200=0;
                            }
                            else{
                                echo $tamizN200=round($tamices[13],2);
                            }
                                $tamizN10=round($tamices[8]);
                                $tamizN40=round($tamices[11]);                             
                            ?> 
                        </td>
                        <td class="tdLimiteLiquido"><?php echo $liquido=$resultado->limiteLiquido; ?> </td>
                        <?php $plastico=$resultado->limitePlastico;?>
                        <td class="tdIndicePlaticidad"><?php echo $indicePlasticidad=$resultado->indicePlasticidad; ?></td>
                        <td class="indiceGrupo">  </td>
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
                                        }
                                    }
                                    else if($cu<4 || $cc>1 && $cc<3){
                                          $notacion="GP";
                                          if($arenas<15){
                                            $descrsub="Grava mal graduada";
                                            echo  $notacion."-".$descrsub;
                                          }
                                          else if($arenas>=15){
                                            $descrsub="Grava mal graduada con arena";
                                            echo  $notacion."-".$descrsub;
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
                                                        }
                                                        else{
                                                            $descrsub="Grava bien graduada con limo y arena";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                          }
                                          else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                              $notacion="GW-GC";
                                                              if($arenas<15){
                                                                  $descrsub="Grava bien graduada con arcilla ( o arcilla limosa)";
                                                                  echo $notacion."-".$descrsub;
                                                              }
                                                              else{
                                                                  $descrsub="Grava bien graduada con arcilla y arena (o arcilla limosa y arena)";
                                                                  echo $notacion."-".$descrsub;
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
                                                        }
                                                        else{
                                                            $descrsub="Grava mal graduada con limo y arena";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                          }
                                          else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                              $notacion="GP-GC";
                                                              if($arenas<15){
                                                                  $descrsub="Grava mal graduada con arcilla ( o arcilla limosa)";
                                                                  echo $notacion."-".$descrsub;
                                                              }
                                                              else{
                                                                  $descrsub="Grava mal graduada con arcilla y arena (o arcilla limosa y arena)";
                                                                  echo $notacion."-".$descrsub;
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
                                                    }
                                                    else{
                                                      $descrsub="Grava Arcillosa con Arena";
                                                      echo $notacion."-".$descrsub;
                                                    }
                                  }
                                  else if($notacionFinos=="ML" || $notacionFinos=="MH" ){
                                                    $notacion="GM";
                                                    if($arenas<15){
                                                      $descrsub="Grava Limosa";
                                                      echo $notacion."-".$descrsub;
                                                    }
                                                    else{
                                                      $descrsub="Grava Limosa con Arena";
                                                      echo $notacion."-".$descrsub;
                                                    }
                                  }
                                  else if($notacionFinos=="CL-ML"){
                                                   $notacion="GC-GM";
                                                   if($arenas<15){
                                                      $descrsub="Grava Limosa-Arcillosa";
                                                      echo $notacion."-".$descrsub;
                                                   }
                                                   else{
                                                      $descrsub="Grava Limosa-Arcillosa con Arena";
                                                      echo $notacion."-".$descrsub;
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
                                            }
                                            else if($arenas>=15){
                                              $descrsub="Arena bien graduada con grava";
                                              echo  $notacion."-".$descrsub;
                                            }
                                        }
                                        else if($cu<4 || $cc>1 && $cc<3){
                                              $notacion="SP";
                                              if($arenas<15){
                                                $descrsub="Arena mal graduada";
                                                echo  $notacion."-".$descrsub;
                                              }
                                              else if($arenas>=15){
                                                $descrsub="Arena mal graduada con grava";
                                                echo  $notacion."-".$descrsub;
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
                                                            }
                                                            else{
                                                                $descrsub="Arena bien graduada con limo y Grava";
                                                                echo $notacion."-".$descrsub;
                                                            }
                                                        }
                                                        else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                                $notacion="SW-SC";
                                                                if($arenas<15){
                                                                    $descrsub="Arena bien graduada con arcilla ( o arcilla limosa)";
                                                                    echo $notacion."-".$descrsub;
                                                                }
                                                                else{
                                                                    $descrsub="Arena bien graduada con arcilla y arena (o arcilla limosa y grava)";
                                                                    echo $notacion."-".$descrsub;
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
                                                                }
                                                                else{
                                                                    $descrsub="Arena mal graduada con limo y grava";
                                                                    echo $notacion."-".$descrsub;
                                                                }
                                                        }
                                                        else if($notacionFinos=="CL" || $notacionFinos=="CH" || $notacionFinos=="CL-ML"){
                                                                    $notacion="SP-SC";
                                                                    if($arenas<15){
                                                                        $descrsub="Arena mal graduada con arcilla ( o arcilla limosa)";
                                                                        echo $notacion."-".$descrsub;
                                                                    }
                                                                    else{
                                                                        $descrsub="Arena mal graduada con arcilla y arena (o arcilla limosa y grava)";
                                                                        echo $notacion."-".$descrsub;
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
                                                                }
                                                                else{
                                                                        $descrsub="Arena Arcillosa con grava";
                                                                        echo $notacion."-".$descrsub;
                                                                }
                                                        }
                                                        else if($notacionFinos=="ML" || $notacionFinos=="MH" ){
                                                               $notacion="SM";
                                                               if($arenas<15){
                                                                    $descrsub="Arena Limosa";
                                                                    echo $notacion."-".$descrsub;
                                                               }
                                                               else{
                                                                    $descrsub="Arema Limosa con Grava";
                                                                    echo $notacion."-".$descrsub;
                                                                }
                                                        }
                                                        else if($notacionFinos=="CL-ML"){
                                                                $notacion="SC-SM";
                                                                if($arenas<15){
                                                                    $descrsub="Arena Limosa-Arcillosa";
                                                                    echo $notacion."-".$descrsub;
                                                                }
                                                                else{
                                                                    $descrsub="Arena Limosa-Arcillosa con Grava";
                                                                    echo $notacion."-".$descrsub;
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
                                               }
                                               else if($tamizN200>=15 && $tamizN200<=29){
                                                  if($arenas>=$gravas){
                                                    $descrsub="Arcilla fina con arena";
                                                    echo $notacion.$descrsub;
                                                  }
                                                  else{
                                                    $descrsub="Arcilla fina con grava";
                                                    echo $notacion.$descrsub;
                                                  }
                                               }
                                            } 
                                            else if($tamizN200>=30){
                                               if($arenas>=$gravas){
                                                  if($gravas<15){
                                                     $descrsub="Arcilla fina arenosa";
                                                     echo $notacion."-".$descrsub;
                                                  }
                                                  else{
                                                     $descrsub="Arcilla fina arenosa con grava";
                                                     echo $notacion."-".$descrsub;
                                                  }
                                               }
                                               else{
                                                    $descrsub="Arcilla fina gravosa";
                                                  if($arenas<15){
                                                     echo $notacion."-".$descrsub;
                                                  }
                                                  else{
                                                    $descrsub="Arcilla fina gravosa con arena";
                                                     echo $notacion."-".$descrsub;
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
                                                    }
                                                    else if($tamizN200>=15 && $tamizN200<=29){
                                                        if($arenas>=$gravas){
                                                            $descrsub="Limo con Arcilla";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                                        else{
                                                            $descrsub="Limo con Grava";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                                    }
                                                 }
                                                 else{
                                                    if($arenas >= $gravas){
                                                        if($gravas<15){
                                                            $descrsub="Arcilla Arenosa Limosa";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                                        else{
                                                            $descrsub="Arcilla Arenosa Limosa con Grava";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                                    }
                                                    else{
                                                        if($arenas<15){
                                                            $descrsub="Arcilla Gravosa Limosa";
                                                            echo $notacion."-".$descrsub;
                                                        }
                                                        else{
                                                            $descrsub="Arcilla Gravosa-Limosa con Arena";
                                                            echo $notacion."-".$descrsub;
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
                                                }
                                                else if($tamizN200>=15 && $tamizN200<=29){
                                                    if($arenas>=$gravas){
                                                      $descrsub="Limo con Arcilla";
                                                      echo $notacion."-".$descrsub;
                                                    }
                                                    else{
                                                      $descrsub="Limo con Grava";
                                                      echo $notacion."-".$descrsub;
                                                    }
                                                }
                                             }
                                             else{
                                                if($arenas>=$gravas){
                                                  if($gravas<15){
                                                    $descrsub="Limo Arenoso";
                                                    echo $notacion."-".$descrsub;
                                                  }
                                                  else{
                                                    $descrsub="Limo Arenoso con Grava";
                                                    echo $notacion."-".$descrsub;
                                                  }
                                                }
                                                else{
                                                    if($arenas<15){
                                                        $descrsub="Limo Gravoso";
                                                        echo $notacion."-".$descrsub;  
                                                    }
                                                    else{
                                                        $descrsub="Limo Gravoso con Arena";
                                                        echo $notacion."-".$descrsub;  
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
                                              }
                                              if($tamizN200>=15 && $tamizN200<=29){
                                                  if($arenas>=$gravas){
                                                    $descrsub="Arcilla gruesa con Arena";
                                                    echo $notacion."-".$descrsub;  
                                                  }
                                                  else{
                                                    $descrsub="Arcilla gruesa con Grava";
                                                    echo $notacion."-".$descrsub;  
                                                  }
                                              }
                                          }
                                          else{
                                              if($arenas>=$gravas){
                                                    if($gravas<15){
                                                         $descrsub="Arcilla gruesa Arenosa";
                                                         echo $notacion."-".$descrsub;  
                                                    }
                                                    else{
                                                         $descrsub="Arcilla gruesa Arenosa con Grava";
                                                         echo $notacion."-".$descrsub;  
                                                    }
                                              }
                                              else{
                                                  if($arenas<15){
                                                      $descrsub="Arcilla gruesa Gravosa";
                                                      echo $notacion."-".$descrsub;  
                                                  }
                                                  else{
                                                      $descrsub="Arcilla gruesa Gravosa con Arena";
                                                      echo $notacion."-".$descrsub;  
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
                                                }
                                                else if($tamizN200>=15 && $tamizN200<=29){
                                                        if($arenas>=$gravas){
                                                           $descrsub="Limo Elástico con Arena";
                                                           echo $notacion."-".$descrsub; 
                                                        }
                                                        else{
                                                           $descrsub="Limo Elástico con Grava";
                                                           echo $notacion."-".$descrsub; 
                                                        }
                                                }
                                          }
                                          else{
                                              if($arenas>=$gravas){
                                                  if($gravas<15){
                                                      $descrsub="Limo Elástico Arenoso";
                                                      echo $notacion."-".$descrsub;
                                                  }
                                                  else{
                                                      $descrsub="Limo Elástico Arenoso con Grava";
                                                      echo $notacion."-".$descrsub;
                                                  }
                                              }
                                              else{
                                                  if($arenas<15){
                                                      $descrsub="Limo Elástico Gravoso";
                                                      echo $notacion."-".$descrsub;
                                                  }
                                                  else{
                                                      $descrsub="Limo Elástico Gravoso con Arena";
                                                      echo $notacion."-".$descrsub;
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
              <span class="paginadorGranulometria">Pagina <?php echo $pagina; ?></span>
              </div>
              <?php $i++; ?>
              <?php $pagina++; ?>
              <?php 
                unset($tamices);
                unset($notacion);
                unset($descrsub);
                unset($temp);
                unset($retenidoporcentaje);
                unset($notacionFinos);
                ?>
              <?php endforeach; ?>
              <?php else: ?>
              <?php endif; ?> 
          <!-- ############# fin GRANULOMETRIA ############### -->
        </div>
        <?php endif; ?> 
        
        <!-- ############# INFORME DE ESTRATIGRAFIA ############### -->
        <div  id="Informe" class="divInforme">
          
          <div class="encabezados">
                  <div class="row-fluid">
                    <div class="span1 "> 
                      <img src="assets/img/logoinforme.png" class="logo"  alt="Logo impresion">
                    </div>
                    <div class="span11 div-separador">
                      <div class="row-fluid"> 
                        <h4 class="header-title text-center"> 
                          Informe de suelos - Sondeo <?php echo $_GET['numsondeo'] ?> 
                        </h4>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="nombre_proyecto_label" class="span2 title">Proyecto:</label>
                        <label id="lb_nombre_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->nombre_proyecto; ?>
                        </label>
                        <label for="fecha_proyecto_label" class="span1 title">Fecha:</label>
                        <label id="lb_fecha_proyecto" for="fecha_proyecto" class="span2">
                        <?php echo $proyectos->fecha; ?>
                        </label>
                      </div>
                      <div class="row-fluid datosinforme">
                        <label for="codigo_proyecto_label" class="span2 title">Codigo:</label>
                        <label id="lb_codigo_proyecto" for="codigo_proyecto" class="span3">
                        <?php echo $proyectos->codigo_proyecto; ?>
                        </label>
                        <label for="nombre_proyecto_label" class="span1 title">Lugar:</label>
                        <label id="lb_lugar_proyecto" for="nombre_proyecto" class="span3">
                        <?php echo $proyectos->lugar; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>  
          <p class="text-center">Informe de estratigrafia</p>
          <table class="table  letra-s">
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
              <?php $i = 1; ?>
              <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
              <?php $resultado= $resultadosClass->getResultado($datoMuestra->id_muestra); ?>
              <tr>
                <td> <?php echo $i; ?> </td>
                <?php $tamano= ($datoMuestra->profundidad_final-$datoMuestra->profundidad_inicial)*100; ?> 
                <td style=" padding: 0; margin : 0;"> <img src="assets/patrones/<?php echo $i; ?>.png" alt="patron" style="border:1px solid #CCC;" > </td>
                <td> <?php if($resultado->pesoUnitario<=0){echo"-";}else{ echo $resultado->pesoUnitario;} ?> </td>
                <td> <?php if($resultado->cohesion<=0){echo"-";}else{ echo $resultado->cohesion;} ?></td>
                <td> <?php echo $datoMuestra->numero_golpes; ?> </td>
                <td> <?php echo $resultado->humedad; ?> </td>
                <td> <?php echo $resultado->limiteLiquido; ?></td>
                <td> <?php echo $resultado->indicePlasticidad; ?> </td>
                <td> <?php echo $resultado->notacionSucs; ?> </td>
                <td> <?php echo $resultado->aashto; ?> </td>
                <td> 
                  <span class="ninguna">N° 4 = <?php echo $resultado->N4; ?>% 
                  </span>
                  <span class="ninguna">N° 10 = <?php echo $resultado->N10; ?>% 
                  </span>
                  <span class="ninguna">N° 40 = <?php echo $resultado->N40; ?>% 
                  </span>
                  <span class="ninguna">N° 200 = <?php echo $resultado->N200; ?>% 
                  </span>
                </td>
                <td>
                  <?php  if($datoMuestra->material_de_relleno==1){echo "Material de relleno"; } ?>  <?php echo $resultado->descripcionSucs; ?> 
                </td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
          <h5 >Nivel freatico:<?php echo " ".$datos_sondeo->nivel_freatico." metros"; ?></h5>
          <!-- ############# FIN INFORME DE ESTRATIGRAFIA ############### -->

          <!-- ############# fin tabs de muestras internas estratigrafia ############### --> 
          <table class="table firmas">
            <tr>
                <td> 
                 <img src="assets/firmas/ing_natalia.jpg" alt="firma ingeniero"> 
                 <br>
                 <span class="lineafirma"></span>
                 <br>
                 <span>Ing. Civil NATHALIA HERNANDEZ R</span>
                 <br>
                 <span class="title">M.P. 22202166765COR</span>
                </td>
                <td>
                 <img src="assets/firmas/IngPabloCastilla.jpg" alt="Firma gerente">  
                 <br>
                 <span class="lineafirma"></span> 
                 <br>
                 <span>Ing. Geotecnista  PABLO CASTILLA NEGRETE</span>
                 <br>
                 <span class="title">M.P. 1320251172BLV</span>
                </td>
            </tr>  

          </table>
          <span class="paginadorInforme">Pagina <?php echo $pagina; ?></span>
        </div>
      
      <!-- ############# FIN CUERPO ############### --> 
    </div>



    <!-- #############  BOOTSTRAP JS ############### -->
    <!--script type="text/javascript" src="assets/js/jqplot/plugins/example.js"></script-->
    <script src="assets/js/muestras.js"></script>
    <script src="assets/js/usuarios.js"></script>
    <script type="text/javascript">
      $(function graficador() {
      

      <?php if ( $_GET['boxLim']==1) : ?>
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
              lineWidth: 0.2,
              type: 'line',            
              pointStart: 1,
              data: [[25,0.01],[25,100]]
          }]
      });
      
      <?php $i++; ?>
      <?php endforeach; ?>
      <?php endif ?>
      
      
      
        
      
      //graficas compresion
      
      <?php if ( $_GET['boxComp']==1) : ?>
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
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
      <?php endforeach; ?>
      <?php endif ?>
      
      
      <?php if ( $_GET['boxGran']==1) : ?>
      <?php $i = 1; ?>
      <?php foreach( $muestrasSondeo as $datoMuestra ): ?>
      
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
      <?php endforeach; ?> 
      <?php endif ?>
      });
    </script>
    <script src="assets/js/alertify/alertify.js"></script>
  </body>
</html>