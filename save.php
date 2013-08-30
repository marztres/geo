<?php

  require_once 'includes/usuarios.php';
  require_once 'includes/proyectos.php';
  require_once 'includes/muestras.php';
  require_once 'includes/sondeos.php';
  require_once 'includes/testlimites.php';
  require_once 'includes/compresion.php';
  require_once 'includes/granulometria.php';
  require_once 'includes/pesos_retenidos.php';
  require_once 'includes/resultados.php';
  require_once 'includes/firmas.php';



  if ( isset( $_POST['func'] ) ) {
    $response = array();
    switch( $_POST['func'] ) {
      case 'login' 
        
      break;

      case 'addUsuario':
        $usuariosClass = new usuarios();        
        $cedula= $_POST['cedula'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $confirmar_clave = $_POST['confirmar_clave'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $cargo = $_POST['cargo'];
        $respuesta = $usuariosClass->addUsuarios($cedula, $usuario, $clave, $confirmar_clave, $nombres, $apellidos, $cargo);
        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Usuario guardado";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error guardando el usuario";
        }
      break;

      case 'modificar_usuario':
        $usuariosClass = new usuarios();
        $cedula= $_POST['cedula'];
        $usuario = $_POST['usuario'];
        $claveAnterior = $_POST['claveAnterior'];
        $clave = $_POST['clave'];
        $confirmar_clave = $_POST['confirmar_clave'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $cargo = $_POST['cargo'];
        $id_usuario = $_POST['id_usuario'];
        $respuesta = $usuariosClass->ModificarUsuarios($id_usuario,$cedula, $usuario, $claveAnterior, $clave, $confirmar_clave, $nombres, $apellidos, $cargo);
        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Usuario modificado";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error modificando el usuario";
        } 
      break;

      

      case 'eliminarUsuario':
          $usuariosClass = new usuarios();        
          $idusuario= $_POST['idusuario'];
          $respuesta = $usuariosClass->eliminarUsuario($idusuario);
          if ( $respuesta ) {
            $response["status"] = "OK";
            $response["message"] = "Usuario eliminado correctamente";
          } else {
            $response["status"] = "ERROR";
            $response["message"] = "Error eliminado usuario";
          }
      break;

      case 'addProyecto':
        $proyectosClass = new proyectos();

        if($_POST['codigoProyecto']!=NULL && $_POST['fecha']!=NULL && $_POST['nombreProyecto']!=NULL && is_numeric($_POST['codigoProyecto'])){
          $codigoProyecto= $_POST['codigoProyecto'];
          $nombreProyecto = $_POST['nombreProyecto'];
          $lugar = $_POST['lugarProyecto'];
          $contratista = $_POST['contratista'];
          $fecha = $_POST['fecha'];
          $autor = $_POST['autor'];
          $responsable = $_POST['responsable'];
          $respuesta = $proyectosClass->addProyecto($codigoProyecto, $nombreProyecto, $lugar, $contratista, $fecha, $autor, $responsable);
        } else {
          $respuesta = false;
        }
        


        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Proyecto guardado";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error guardando el proyecto";
        }
      break;

      case 'modificarProyecto':
        $proyectosClass = new proyectos();


        if($_POST['codigo_proyecto']!=NULL && $_POST['fecha']!=NULL && $_POST['nombreProyecto']!=NULL && is_numeric($_POST['codigo_proyecto'])){
        $idProyecto = $_POST['idProyecto'];
        $codigo_proyecto= $_POST['codigo_proyecto'];
        $nombreProyecto = $_POST['nombreProyecto'];
        $lugar = $_POST['lugar'];
        $contratista = $_POST['contratista'];
        $fecha = $_POST['fecha'];
        $responsable = $_POST['responsable'];
        $respuesta = $proyectosClass->modificarProyecto($idProyecto, $codigo_proyecto, $nombreProyecto, $lugar, $contratista, $fecha, $responsable); 
        } else {
          $respuesta = false;
        }

        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Proyecto modificado";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error al modificar el proyecto proyecto";
        }
      break;

      case 'eliminarProyecto':
        $proyectosCLass = new proyectos();
        $idProyecto = $_POST['idproyecto'];
        $respuesta = $proyectosCLass->eliminarProyecto($idProyecto);
        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Proyecto eliminado correctamente";
          $response["idProyecto"] = $proyectosCLass->insert_id;
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error al eliminar el proyecto";
        }
      break;

      case 'addSondeo':
        $sondeosClass = new sondeos();

        if($_POST['tipoSuperficie']!=NULL && $_POST['profundidadSuperficie']!=NULL ){
          if(is_numeric($_POST['nivelFreatico'])){
            $nivelFreatico = $_POST['nivelFreatico'];
            $profundidadSuperficie = $_POST['profundidadSuperficie'];
            $tipoSuperficie = $_POST['tipoSuperficie'];
            $idProyecto= $_POST['idProyecto'];
            $respuesta = $sondeosClass->addSondeo($nivelFreatico,$profundidadSuperficie,$tipoSuperficie,$idProyecto); 
          }else {
            $respuesta = false;
          }
        } else {
          $respuesta = false;
        }


        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Sondeo agregado correctamente";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error al agregar el evento";
        }
      break;

      case 'ModificarSondeo':
        $sondeosClass = new sondeos();
        
        if($_POST['tipo_superficie']!=NULL && $_POST['Profundidad']!=NULL ){
          if(is_numeric($_POST['nivel_freatico'])){
            $nivel_freatico= $_POST['nivel_freatico'];
            $tipo_superficie = $_POST['tipo_superficie'];
            $Profundidad = $_POST['Profundidad'];
            $id_sondeo = $_POST['id_sondeo'];
            $id_tipo_superficie = $_POST['id_tipo_superficie'];
            $respuesta = $sondeosClass->ModificarSondeos($nivel_freatico,$tipo_superficie, $Profundidad, $id_tipo_superficie, $id_sondeo);
          } else {
            $respuesta = false;
          }
        } else {
          $respuesta = false;
        }

        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Sondeo modificado";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error modificando el sondeo";
        } 
      break;

      case 'eliminarSondeo':
        $sondeosClass = new sondeos();
        $idSondeo = $_POST['idSondeo'];
        $respuesta = $sondeosClass->eliminarSondeo($idSondeo); 
        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Sondeo eliminador correctamente $tipoSuperficie";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error al eliminar el Sondeo $tipoSuperficie";
        }
      break;

      case 'addMuestras':
            $muestrasClass = new muestras();
            $testLimitesClass = new testlimintes();
            $testCompresionClass = new Compresion();
            $granulometriaClass= new granulometria();
            $pesosRetenidoClass= new pesos_retenidos();
            $resultadosClass= new resultados();

            if($_POST['descripcion_muestra']!=NULL && $_POST['profundidad_inicial']!=NULL && $_POST['profundidad_final']!=NULL && is_numeric($_POST['profundidad_inicial']) && is_numeric($_POST['profundidad_final']) && $_POST['profundidad_inicial']!=$_POST['profundidad_final'] && $_POST['profundidad_inicial']<$_POST['profundidad_final'] && $_POST['profundidad_inicial']>0 && $_POST['profundidad_final']>0 ){

            $descripcion_muestra = $_POST['descripcion_muestra'];
            $profundidad_inicial = $_POST['profundidad_inicial'];
            $profundidad_final = $_POST['profundidad_final'];
            
            if($_POST['numero_de_golpes']==NULL){
              $numero_de_golpes= 0;
            } else {
              $numero_de_golpes= $_POST['numero_de_golpes'];
            }
            $idsondeos = $_POST['idsondeos'];

            if(isset($_POST['box_relleno'])){
              $box_relleno = $_POST['box_relleno'];           
            }
            if(isset($_POST['box_roca'])){
              $box_roca = $_POST['box_roca'];           
            }
            if($box_relleno==1){
              $box_estrato=1; 
            } else if($box_roca==1){
              $box_estrato=2; 
            } else {
              $box_estrato=0; 
            }
            
            $respuesta = $muestrasClass->addMuestras($descripcion_muestra, $profundidad_inicial, $profundidad_final, $numero_de_golpes, $box_estrato ,$idsondeos);
            $idMuestra = $muestrasClass->insert_id;
            $testLimitesClass->addTest(0, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(0, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(0, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(1, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(1, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(1, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(2, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(2, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testLimitesClass->addTest(2, NULL, NULL, NULL,NULL, NULL, $idMuestra);
            $testCompresionClass->addCompresion(0,NULL, NULL, NULL,NULL,$idMuestra);
            $idCompresion=$testCompresionClass->insert_id;
            $testCompresionClass->addDeformacion(0,10,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,30,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,50,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,75,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,100,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,150,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,200,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,250,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,300,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,350,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,400,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,450,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,500,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,550,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,600,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,650,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,700,NULL,$idCompresion);
            $testCompresionClass->addDeformacion(0,750,NULL,$idCompresion);
            
      
            $granulometriaClass->addGranulometria(NULL, NULL, $idMuestra);
            $idGranulometria= $granulometriaClass->insert_id;
            $pesosRetenidoClass->addPesoRetenido("(3\")",76.20, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(2 1/2\")",63.5, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(2\")",50.80,NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(1 1/2\")",38.10,NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(1\")",25.40, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(3/4\")",19.05, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(1/2\")",12.70,NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(3/8\")",9.52,NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("(1/4\")",6.35,NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°4",4.75, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°10",2.00, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°16",1.19, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°20",0.84, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°30",0.60, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°40",0.43, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°60",0.25, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°100",0.15, NULL, $idGranulometria);
            $pesosRetenidoClass->addPesoRetenido("N°200",0.08, NULL, $idGranulometria);


            $resultadosClass->addResultados($idMuestra);
            } else {
              $respuesta = false;
            } 


            if ( $respuesta ) {
              $response["status"] = "OK";
              $response["message"] = "Muestra guardada correctamente";
              $response["idMuestras"] = $muestrasClass->insert_id;
            } else {
              $response["status"] = "ERROR";
              $response["message"] = "Error guardando muestra";
            }
        break;

      case 'ModificarMuestra':
        $muestrasClass = new muestras();

        if($_POST['descripcion_muestra']!=NULL && $_POST['profundidad_inicial']!=NULL && $_POST['profundidad_final']!=NULL && is_numeric($_POST['profundidad_inicial']) && is_numeric($_POST['profundidad_final']) && $_POST['profundidad_inicial']!=$_POST['profundidad_final'] && $_POST['profundidad_inicial']<$_POST['profundidad_final'] && $_POST['profundidad_inicial']>0 && $_POST['profundidad_final']>0 ){


        $descripcion_muestra = $_POST['descripcion_muestra'];
        $profundidad_inicial = $_POST['profundidad_inicial'];
        $profundidad_final = $_POST['profundidad_final'];
        
        if($_POST['numero_de_golpes']==NULL){
          $numero_de_golpes= 0;
        } else {
          $numero_de_golpes= $_POST['numero_de_golpes'];
        }

        $idsondeos = $_POST['idsondeos'];
        $id_muestra = $_POST['id_muestra'];



        if(isset($_POST['box_relleno'])){
          $box_relleno = $_POST['box_relleno'];           
        }
        if(isset($_POST['box_roca'])){
          $box_roca = $_POST['box_roca'];           
        }
        if($box_relleno==1){
          $box_estrato=1; 
        } else if($box_roca==1){
          $box_estrato=2; 
        } else {
          $box_estrato=0; 
        }
        
        $respuesta = $muestrasClass->ModificarMuestras($descripcion_muestra, $profundidad_inicial, $profundidad_final, $numero_de_golpes, $box_estrato ,$idsondeos,$id_muestra);
        } else {
          $respuesta = false;
        }



        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Muestra guardada correctamente";
          $response["idMuestras"] = $muestrasClass->insert_id;
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error guardando muestra";
        }
      break;
      case 'ClonarMuestra':
            $muestrasClass = new muestras();
            $testLimitesClass = new testlimintes();
            $testCompresionClass = new Compresion();
            $granulometriaClass= new granulometria();
            $pesosRetenidoClass= new pesos_retenidos();
            $resultadosClass= new resultados();
 
            if($_POST['descripcion_muestra']!=NULL && $_POST['profundidad_inicial']!=NULL && $_POST['profundidad_final']!=NULL && is_numeric($_POST['profundidad_inicial']) && is_numeric($_POST['profundidad_final']) && $_POST['profundidad_inicial']!=$_POST['profundidad_final'] && $_POST['profundidad_inicial']<$_POST['profundidad_final'] && $_POST['profundidad_inicial']>0 && $_POST['profundidad_final']>0 ){

            $descripcion_muestra = $_POST['descripcion_muestra'];
            $profundidad_inicial = $_POST['profundidad_inicial'];
            $profundidad_final = $_POST['profundidad_final'];
            
            if($_POST['numero_de_golpes']==NULL){
              $numero_de_golpes= 0;
            } else {
              $numero_de_golpes= $_POST['numero_de_golpes'];
            }
            
            $idsondeos = $_POST['idsondeos'];
            $id_muestra = $_POST['id_muestra'];
 
            if(isset($_POST['box_relleno'])){
              $box_relleno = $_POST['box_relleno'];           
            }
            if(isset($_POST['box_roca'])){
              $box_roca = $_POST['box_roca'];           
            }
            if($box_relleno==1){
              $box_estrato=1; 
            } else if($box_roca==1){
              $box_estrato=2; 
            } else {
              $box_estrato=0; 
            }
            
            $respuesta = $muestrasClass->addMuestras($descripcion_muestra, $profundidad_inicial, $profundidad_final, $numero_de_golpes, $box_estrato ,$idsondeos);
            $idMuestra = $muestrasClass->insert_id;
            $testlimites= $testLimitesClass->getLimitesMuestra($id_muestra);
            foreach( $testlimites as $Listatest ):
              //TODOS LOS RANDOM 
                $RandomPesoCapsula=rand(0.5, 1);
                $RandomPesoCapsulaSueloHumedo=rand(0.5, 1);
                $RandomPesoCapsulaSueloSeco=rand(0.5, 1);
                $RandomNumGolpes=rand(0, 10);
              //FIN DE LOS RANDOM 
                //INCREMENTO  Y SUMA DE LOS RANDOM EN HUMEDAD
                $peso_capsula=$Listatest->peso_capsula+$RandomPesoCapsula;
                $peso_capsula_suelo_humedo=$Listatest->peso_capsula_suelo_humedo+$RandomPesoCapsulaSueloHumedo;
                $peso_capsula_suelo_seco=$Listatest->peso_capsula_suelo_seco+$RandomPesoCapsulaSueloSeco;
                $num_golpes=$Listatest->num_golpes+$RandomNumGolpes;
              // FIN INCREMENTO  Y SUMA DE LOS RANDOM 
                $testLimitesClass->addTest($Listatest->tipo_muestra, $Listatest->nom_capsula,$peso_capsula, $peso_capsula_suelo_humedo, $peso_capsula_suelo_seco, $num_golpes, $idMuestra);
            endforeach;
                
                $Compresion=$testCompresionClass->GetDatosCompresion($id_muestra);
                // RANDOM EN COMPRESION
                $RandomDiametro=rand(0.2, 1);
                $RandomAltura=rand(0.2, 1);
                $RandomPeso=rand(0.2, 1);
                $Diametro=$Compresion->diametro+$RandomDiametro;
                $Altura=$Compresion->altura+$RandomAltura;
                $Peso=$Compresion->peso+$RandomPeso;
              // FIN COMPRESION
                $testCompresionClass->addCompresion(0,$Diametro, $Altura, $Peso,$Compresion->tipoFalla,$idMuestra);
                $idCompresion=$testCompresionClass->insert_id;
                $deformaciones=$testCompresionClass->GetDatosDeformaciones($Compresion->id_compresion);
            foreach( $deformaciones as $ListaDeformaciones ):
              // RANDOM DEFORMACIONES
                $RandomCarga=rand(0.2, 1);
                if($ListaDeformaciones->carga!=0){
                  $Carga=$ListaDeformaciones->carga+$RandomCarga;
                }
                else{
                  $Carga=0;
                } 
              // FIN RANDOM DEFORMACIONES 
                $testCompresionClass->addDeformacion(0,$ListaDeformaciones->deformacion,$Carga,$idCompresion);
            endforeach;       
            $consultaGranulometria=$granulometriaClass->getDatoGranulometria($id_muestra);
              // RANDOM GRANULOMETRIA
                $RandomPesoRecipiente=rand(0.2,2);
                $RandomPesoRecipienteMasMuestra=rand(0.2,2);
                $pesoRecipiente=$consultaGranulometria->pesoRecipiente+$RandomPesoRecipiente;
                $pesoRecipienteMasMuestra=$consultaGranulometria->pesoRecipienteMasMuestra+$RandomPesoRecipienteMasMuestra;
              // FIN RANDOM GRANULOMETRIA
            $granulometriaClass->addGranulometria($pesoRecipiente, $pesoRecipienteMasMuestra, $idMuestra);
            $idGranulometria= $granulometriaClass->insert_id;
            $PesosRetenidos=$pesosRetenidoClass->getDatoPesosRetenidos( $consultaGranulometria->id_granulometria );
            foreach( $PesosRetenidos as $ListaPesosRetenidos ):
              //RANDOM PESOS RETENIDOS
                $RandompesoRetenido=rand(0.2,2);
                if($ListaPesosRetenidos->pesoRetenido!=0){
                  $pesoRetenido=$ListaPesosRetenidos->pesoRetenido+$RandompesoRetenido;
                }
                else{
                  $pesoRetenido=0;  
                }                 
              //FIN PESOS RETENIDOS
            $pesosRetenidoClass->addPesoRetenido($ListaPesosRetenidos->tamiz,$ListaPesosRetenidos->tamanoTamiz,$pesoRetenido, $idGranulometria);
            endforeach;
            $resultadosClass->addResultados($idMuestra);

            }else {
              $respuesta = false;
            }

            if ( $respuesta ) {
              $response["status"] = "OK";
              $response["message"] = "Muestra guardada correctamente";
              $response["idMuestras"] = $muestrasClass->insert_id;
            } else {
              $response["status"] = "ERROR";
              $response["message"] = "Error guardando muestra";
            }
        break;

      case 'eliminarMuestra':
        $muestrasClass = new muestras();
        $idMuestra = $_POST['idMuestra'];
        $respuesta = $muestrasClass->eliminarMuestra($idMuestra); 
        if ( $respuesta ) {
          $response["status"] = "OK";
          $response["message"] = "Muestra eliminada correctamente";
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error al eliminar la muestra";
        }
      break;

      case 'testlimites':
          $testLimitesClass = new testlimintes();
          $resultadosClass= new resultados();
          if ( $_POST['muestra'] == 0 ) {
            $humedadCapsula = array();
            $humedadPesoCapsular = array();
            $humedadPesoSueloHumedo = array();
            $humedadPesoSueloSeco = array();
            
            $allTest=$_POST['idtest'];
            $idtest= explode(',',$allTest);
            $test1= $idtest[0];
            $test2= $idtest[1];
            $test3= $idtest[2];

            foreach ( $_POST['humedadCapsula'] as $valor ) {
              $humedadCapsula[] = $valor;
            }
            foreach ( $_POST['humedadPesoCapsular'] as $valor ) {
              $humedadPesoCapsular[] = $valor;
            }
            foreach ( $_POST['humedadPesoSueloHumedo'] as $valor ) {
              $humedadPesoSueloHumedo[] = $valor;
            }
            foreach ( $_POST['humedadPesoSueloSeco'] as $valor ) {
              $humedadPesoSueloSeco[] = $valor;
            }
            $respuesta1 = $testLimitesClass->modificarTest($test1, $humedadCapsula[0], $humedadPesoCapsular[0], $humedadPesoSueloHumedo[0], $humedadPesoSueloSeco[0], 0);
            $respuesta2 = $testLimitesClass->modificarTest($test2, $humedadCapsula[1], $humedadPesoCapsular[1], $humedadPesoSueloHumedo[1], $humedadPesoSueloSeco[1], 0);
            $respuesta3 = $testLimitesClass->modificarTest($test3, $humedadCapsula[2], $humedadPesoCapsular[2], $humedadPesoSueloHumedo[2], $humedadPesoSueloSeco[2], 0);
            


          if ( $respuesta1 ) {
          $response["status"] = "OK";
          $response["message"] = "Muestra guardada correctamente";
          $response["variables"] = " $test1 , $test2 , $test3  ";
          
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error guardando muestra";
        }

          } else if ( $_POST['muestra'] == 1 ) {

            $liquidoNombreCapsula = array();
            $liquidoGolpes = array();
            $liquidoPeso = array();
            $liquidoPesoSueloHumedo = array();
            $liquidoPesoSueloSeco = array();
        
            $allTest=$_POST['idtest'];
            $idtest= explode(',',$allTest);
            $test1= $idtest[0];
            $test2= $idtest[1];
            $test3= $idtest[2];
    
            foreach ( $_POST['liquidoNombreCapsula'] as $valor ) {
              $liquidoNombreCapsula[] = $valor;
            }
            foreach ( $_POST['liquidoGolpes'] as $valor ) {
              $liquidoGolpes[] = $valor;
            }
            foreach ( $_POST['liquidoPeso'] as $valor ) {
              $liquidoPeso[] = $valor;
            }
            foreach ( $_POST['liquidoPesoSueloHumedo'] as $valor ) {
              $liquidoPesoSueloHumedo[] = $valor;
            }
            foreach ( $_POST['liquidoPesoSueloSeco'] as $valor ) {
              $liquidoPesoSueloSeco[] = $valor;
            }
            $respuesta1 = $testLimitesClass->modificarTest($test1, $liquidoNombreCapsula[0], $liquidoPeso[0], $liquidoPesoSueloHumedo[0], $liquidoPesoSueloSeco[0], $liquidoGolpes[0]);
            $respuesta2 = $testLimitesClass->modificarTest($test2, $liquidoNombreCapsula[1], $liquidoPeso[1], $liquidoPesoSueloHumedo[1], $liquidoPesoSueloSeco[1], $liquidoGolpes[1]);
            $respuesta3 = $testLimitesClass->modificarTest($test3, $liquidoNombreCapsula[2], $liquidoPeso[2], $liquidoPesoSueloHumedo[2], $liquidoPesoSueloSeco[2], $liquidoGolpes[2]);
          if ( $respuesta1 ) {
          $response["status"] = "OK";
          $response["message"] = "Muestra guardada correctamente";
          $response["variables"] = " $test1 , $test2 , $test3  ";
          
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error guardando muestra";
        }

          } else if ( $_POST['muestra'] == 2 ) {
            $plasticoNombreCapsula = array();
            $plasticoPeso = array();
            $plasticoPesoSueloHumedo = array();
            $plasticoPesoSueloSeco = array();
        
            $allTest=$_POST['idtest'];
            $idtest= explode(',',$allTest);
            $test1= $idtest[0];
            $test2= $idtest[1];
            $test3= $idtest[2];

            $humedaFinal=$_POST['humedadFinal'];
            $limiteLiquidoFinal=$_POST['limiteLiquidoFinal'];
            $limitePlasticoFinal=$_POST['limitePlasticoFinal'];
            $indicePlasticidadFinal=$_POST['indicePlasticidadFinal'];
            $fk_idMuestra=$_POST['fkMuestra'];
    
            foreach ( $_POST['plasticoNombreCapsula'] as $valor ) {
              $plasticoNombreCapsula[] = $valor;
            }
            foreach ( $_POST['plasticoPeso'] as $valor ) {
              $plasticoPeso[] = $valor;
            }
            foreach ( $_POST['plasticoPesoSueloHumedo'] as $valor ) {
              $plasticoPesoSueloHumedo[] = $valor;
            }
            foreach ( $_POST['plasticoPesoSueloSeco'] as $valor ) {
              $plasticoPesoSueloSeco[] = $valor;
            }
            $respuesta1 = $testLimitesClass->modificarTest($test1, $plasticoNombreCapsula[0], $plasticoPeso[0], $plasticoPesoSueloHumedo[0], $plasticoPesoSueloSeco[0], 0);
            $respuesta2 = $testLimitesClass->modificarTest($test2, $plasticoNombreCapsula[1], $plasticoPeso[1], $plasticoPesoSueloHumedo[1], $plasticoPesoSueloSeco[1], 0);
            $respuesta3 = $testLimitesClass->modificarTest($test3, $plasticoNombreCapsula[2], $plasticoPeso[2], $plasticoPesoSueloHumedo[2], $plasticoPesoSueloSeco[2], 0);
            
            $resultadosClass->updateResultadosLimites($humedaFinal,$limiteLiquidoFinal,$limitePlasticoFinal,$indicePlasticidadFinal,$fk_idMuestra);

          if ( $respuesta1 ) {
          $response["status"] = "OK";
          $response["message"] = "Muestra guardada correctamente";
          $response["variables"] = " $test1 , $test2 , $test3  ";
          
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error guardando muestra";
        }

          }
        break;

        case "UpdateCompresion":
            $testCompresionClass = new Compresion();
            $resultadosClass= new resultados();
            $compresionIdDeformacion = array();
            $compresionDeformaciones = array();
            $id_compresion=$_POST['compresionId'];
            $compresionDiametro=$_POST['compresionDiametro'];
            $compresionAltura=$_POST['compresionAltura'];
            $compresionPeso=$_POST['compresionPeso'];
            $compresionTipofalla=$_POST['compresionTipofalla'];
            foreach ( $_POST['compresionIdDeformacion'] as $valor ){
                  $carga=$_POST['compresionDeformaciones'];
                  $compresionIdDeformacion= $valor;
            }
            $pesoUnitarioFinal= $_POST['pesoUnitarioFinal'];
            $cohesionFinal= $_POST['cohesionFinal'];
            $fk_idMuestra= $_POST['fk_idmuestra'];

            $testCompresionClass->modificarDeformaciones($carga,$compresionIdDeformacion);
            $testCompresionClass->modificarCompresion($compresionDiametro,$compresionAltura,$compresionPeso,$compresionTipofalla,$id_compresion);
            
            $resultadosClass->updateResultadosCompresion($cohesionFinal,$pesoUnitarioFinal,$fk_idMuestra);

          if ( $testCompresionClass ) {
          $response["status"] = "OK";
          $response["message"] = "Compresion actulizada correctamente correctamente";
          
        } else {
          $response["status"] = "ERROR";
          $response["message"] = "Error actualizando compresion";
        }         
        break;

        case 'granulometria':
              $granulometriaClass=new granulometria();
                  $pesosRetenidosClass=new pesos_retenidos();
              $resultadosClass= new resultados(); 

              $idPesoRetenido = array();
              $PesosRetenido = array();
              $d60=$_POST['d60'];
              $d30=$_POST['d30'];
              $d10=$_POST['d10'];

              $id_granulometria=$_POST['idgranulometria'];
              $pesoRecipiente=$_POST['pesoRecipiente'];
              $pesoRecipienteMasMuestra=$_POST['pesoRecipienteMasMuestra'];
              $N200=$_POST['N200'];
              $N4=$_POST['N4'];
              $N10=$_POST['N10'];
              $N40=$_POST['N40'];
              $notacionSucs=$_POST['notacionSucs'];
              $descripcionSucs=$_POST['descripcionSucs'];
              $aashto=$_POST['aashto'];
              $imagenPerfil=$_POST['imagenPerfil'];
              $fk_idMuestra=$_POST['fkMuestra'];

              foreach ( $_POST['idPesoRetenido'] as $valor ) {
                $idPesoRetenido[] = $valor;
              }
              foreach ( $_POST['PesosRetenido'] as $valor ) {
                $PesosRetenido[] = $valor;
              }
                $respuesta = $granulometriaClass->updateGranulometria($id_granulometria,$pesoRecipiente,$pesoRecipienteMasMuestra,$d60,$d30,$d10);
                $respuesta1 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[0],$PesosRetenido[0]);
                $respuesta2 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[1],$PesosRetenido[1]);
                $respuesta3 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[2],$PesosRetenido[2]);
                $respuesta4 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[3],$PesosRetenido[3]);
                $respuesta5 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[4],$PesosRetenido[4]);
                $respuesta6 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[5],$PesosRetenido[5]);
                $respuesta7 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[6],$PesosRetenido[6]);
                $respuesta8 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[7],$PesosRetenido[7]);
                $respuesta9 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[8],$PesosRetenido[8]);
                $respuesta10 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[9],$PesosRetenido[9]);
                $respuesta11 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[10],$PesosRetenido[10]);
                $respuesta12 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[11],$PesosRetenido[11]);
                $respuesta13= $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[12],$PesosRetenido[12]);
                $respuesta14 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[13],$PesosRetenido[13]);
                $respuesta15 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[14],$PesosRetenido[14]);
                $respuesta16 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[15],$PesosRetenido[15]);
                $respuesta17 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[16],$PesosRetenido[16]); 
                $respuesta18 = $pesosRetenidosClass->updatePesosRetenido($idPesoRetenido[17],$PesosRetenido[17]);

                $resultadosClass->updateResultadosGranulometria($N200,$N4,$N10,$N40,$notacionSucs,$descripcionSucs,$aashto,$imagenPerfil,$fk_idMuestra);
                
            if ( $respuesta ) {
              $response["status"] = "OK";
              $response["message"] = "Granulometria Actualisada correctamente";
  
            } else {
              $response["status"] = "ERROR";
              $response["message"] = "Error al actualizar granulometria ";
            }
        break;

        case 'addFirma';
          $firmasClass=new firmas();

          if($_POST['persona']!=NULL && $_POST['tarjetaProfesional']!=NULL && isset($_FILES['imagen'])){
            $persona=$_POST['persona']; 
            $tarjetaPro=$_POST['tarjetaProfesional']; 
            $ruta = "assets/uploads/"; 

            $nombre=$_FILES['imagen']['name'];
            $max=1500000; 
            $filesize = $_FILES['imagen']['size'];
            
            if($filesize < $max){ 
              $directorio =$ruta; 
              $nombreAleatorio = strtotime(date('Y-m-d H:i:s'));
              $nombreImagen= $nombreAleatorio.".jpg";
              $nuevonombre=$directorio.$nombreImagen; 

              move_uploaded_file($_FILES['imagen']['tmp_name'],$nuevonombre); 
              $resultado= $firmasClass->addFirma($persona,$tarjetaPro,$nuevonombre);

              if($resultado){
                $respuesta =true; 
              }else {
                $respuesta =false;  
              }
            } else{
              $respuesta =false;
            }

          } else {
            $respuesta =false;
          }

          if ( $respuesta ) 
          {
              $response["status"] = "OK";
              $response["message"] = "Firma guardada correctamente";
              $response["ruta"] =$nuevonombre;
          } else 
          {
            $response["status"] = "ERROR";
            $response["message"] = "Error al guardar la firma";
          }

        break;

        case 'updateFirma';
          $firmasClass=new firmas();

          if($_POST['editarPersona']!=NULL && $_POST['editarTarjetaPro']!=NULL && $_POST['idFirma']!=NULL && $_POST['imagenActual']!=NULL){
            
            $idFirma=$_POST['idFirma'];
            $persona=$_POST['editarPersona']; 
            $tarjetaProfesional=$_POST['editarTarjetaPro'];
            $imagenActual=$_POST['imagenActual'];

            if(isset($_FILES['imagen'])){
              $ruta = "assets/uploads/"; 

              $nombre=$_FILES['imagen']['name'];
              $max=1500000; 
              $filesize = $_FILES['imagen']['size'];
              
              if($filesize < $max){ 
                $directorio =$ruta; 
                $nombreAleatorio = strtotime(date('Y-m-d H:i:s'));
                $nombreImagen= $nombreAleatorio.".jpg";
                $nuevonombre=$directorio.$nombreImagen; 

                move_uploaded_file($_FILES['imagen']['tmp_name'],$nuevonombre); 
                unlink($imagenActual);
                
                $resultado= $firmasClass->updateFirma($idFirma,$persona,$tarjetaProfesional,$nuevonombre);

                if($resultado){
                  $respuesta =true; 
                }else {
                  $respuesta =false;  
                }
              } else{
                $respuesta =false;
              }
            } else {
              $resultado= $firmasClass->updateFirma($idFirma,$persona,$tarjetaProfesional,$imagenActual);

              $nuevonombre=$imagenActual;
              if($resultado){
                $respuesta =true; 
              }else {
                $respuesta =false;  
              }
            }


            
          } else {
            $respuesta =false;
          }

          if ( $respuesta ) 
          {
              $response["status"] = "OK";
              $response["message"] = "Firma guardada correctamente";
              $response["ruta"] =$nuevonombre;
          } else 
          {
            $response["status"] = "ERROR";
            $response["message"] = "Error al guardar la firma";
          }

        break;

        case 'deleteFirma';
          $firmasClass=new firmas();

          $idFirma=$_POST['idFirma'];

          $respuesta= $firmasClass->eliminarFirma($idFirma);
          
          if ( $respuesta ) 
          {
              $response["status"] = "OK";
              $response["message"] = "Firma guardada correctamente";
              $response["ruta"] =$nuevonombre;
          } else 
          {
            $response["status"] = "ERROR";
            $response["message"] = "Error al guardar la firma";
          }

        break;
      default:
        $response["status"] = "ERROR";
        $response["message"] = "Funcion no encontrada";
        break;
    }
    echo json_encode($response);
  }

?>