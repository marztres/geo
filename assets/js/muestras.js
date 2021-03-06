
var optimizadorGraficas=0;
var contadorLimites=0;
var acciones = {
  init: function () {
    acciones.clicks();
    acciones.allTamLocked();

  },
  clicks: function () {
    $('a[href="#"]').on('click', acciones.prevenirClickSinDestino);
    $("#enviar_muestra").on('click', acciones.clickGuardarMuestra);
    $("#EnviarModificarMuestra").on('click', acciones.clickModificarMuestra);
    $("#EnviarClonarMuestra").on('click', acciones.clickCopiarMuestra);
    $('.modalMuestra').on('click', acciones.clickEditarMuestra);
    $('.clonarMuestra').on('click', acciones.clickClonarMuestra);
    $('.eliminarMuestra').on('click', acciones.clickEliminarMuestra);
    $('.guardaLimites').on('click', acciones.updateLimites);
    $('.limites').on('keyup', acciones.calculosLimites);
    $('.noplastico').on('click', acciones.noplastico);
    $('.noliquido').on('click', acciones.noliquido);
    $('.guardarGranulometria').on('click', acciones.updateGranulometria);
    $('.GuardarCompresion').on('click', acciones.clickGuardarCompresion);
    $('.icompresion,.ideformacion').on('keyup', acciones.calculosCompresion);
    $('.analisis,.granulo').on('keyup', acciones.calculosGranulometria);
    $('.boxImpresion,.firmasBox').on('change' , acciones.Preimpresion);
    $('.btnInforme').on('click' , acciones.Preimpresion);
    $('.impresionBtn').on('click' , acciones.imprimir);
    $('.estratos').on('change',acciones.clickEstratos);
    $('.ChecksTamizes').on('click',acciones.seleccionTamizes);
    $('.selectAllTamizes').on('click',acciones.selectAllTamizes);
    $('.btnCalcularMuestraSeca').on('click',acciones.CalcularMuestraSeca);
  },

  

  clickGuardarMuestra: function (e) {
    e.preventDefault();
    $post = $('#datosMuestras');
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        $('#exito_muestra').removeClass('hide');
        setTimeout(function () {
          $("#exito_muestra").addClass("hide");
          location.reload();
        }, 3000);
        $(".limpiar").val('');
      } else {
        alertify.set({ delay: 10000 });
        alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios <br> -Descripción. <br> -Profundidad inicial y final.  <br> -Profundidad repetida ");
        $('#respuesta_guardado').text(respuesta.mensaje);
        $('#error_muestra').removeClass('hide');
        setTimeout(function () {
          $("#error_muestra").addClass("hide");
        }, 3000);
      }
    }, 'json');
  },

  clickModificarMuestra: function (e) {
    e.preventDefault();
    $post = $('#ModificarMuestras');
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        $('#exito_modificar_muestra').removeClass('hide');
        setTimeout(function () {
          $("#exito_modificar_muestra").addClass("hide");
          location.reload();
        }, 3000);
        $(".limpiar").val('');
      } else {
        $('#respuesta_guardado').text(respuesta.mensaje);

        alertify.set({ delay: 10000 });
        alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios <br> -Descripción. <br> -Profundidad inicial y final.  <br> -Profundidad repetida ");
        $('#error_modificar_muestra').removeClass('hide');
        setTimeout(function () {
          $("#error_modificar_muestra").addClass("hide");
        }, 3000);
      }
    }, 'json');
  },

  clickCopiarMuestra: function (e) {
    e.preventDefault();
    $post = $('#ClonarMuestras');
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        $('#exito_clonar_muestra').removeClass('hide');
        setTimeout(function () {
          $("#exito_clonar_muestra").addClass("hide");
          location.reload();
        }, 3000);
        $(".limpiar").val('');
      } else {
        $('#respuesta_guardado').text(respuesta.mensaje);
         alertify.set({ delay: 10000 });
        alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios <br> -Descripción. <br> -Profundidad inicial y final.  <br> -Profundidad repetida ");
        $('#error_clonar_muestra').removeClass('hide');
        setTimeout(function () {
          $("#error_clonar_muestra").addClass("hide");
        }, 3000);
      }
    }, 'json');
  },

  clickEliminarMuestra: function( e ) {
    e.preventDefault();
    $post = $(this).parent().find("form");
    alertify.confirm("Esta seguro que desea eliminar esta muestra", function (e) {
      if (e) {
        $.post($post.attr('action'), $post.serialize(), function(respuesta) {
          if (respuesta.status === 'OK') {
            console.log(respuesta.message);
              $('#exitoGeneral').removeClass('hide');
              location.reload();
          } else {
            console.log(respuesta.message);
            $('#errorGeneral').removeClass('hide');
            setTimeout(function() {
              $("#error").addClass("hide");
            }, 3000);
          }
        }, 'json');
      }
    });   

  },

   clickClonarMuestra: function (e) {
        e.preventDefault();
        var id = this.id,
        datos = this.rel;
        var box_roca =  $(this).closest('body').find('#clonarmuestra').find('.box_roca'),
        box_relleno = $(this).closest('body').find('#clonarmuestra').find('.box_relleno');
        var profundidades = this.rel.split(','),
        idm = profundidades[0],
        descripcionm = profundidades[3],
        material_de_relleno = profundidades[4],
        num_golpes = profundidades[5];
          if (material_de_relleno == 1) {
              box_relleno.attr('checked', true);
          } else {
              box_relleno.attr('checked', false);
          } if(material_de_relleno == 2){
              box_roca.attr('checked', true);
          } else {
              box_roca.attr('checked', false);
          }
        $('#descripcion_clonarm').val(descripcionm);
        $('#numero_golpes_clonar').val(num_golpes);
        $('#id_muestra_clonar').val(idm);
  },
  clickEditarMuestra: function (e) {
    e.preventDefault();
    var id = this.id,
      datos = this.rel;

    var box_roca =  $(this).closest('body').find('#editarmuestra').find('.box_roca'),
      box_relleno =  $(this).closest('body').find('#editarmuestra').find('.box_relleno');

    var profundidades = this.rel.split(','),
      idm = profundidades[0],
      pinicial = profundidades[1],
      pfinal = profundidades[2],
      descripcionm = profundidades[3],
      material_de_relleno = profundidades[4],
      num_golpes = profundidades[5];
    if (material_de_relleno == 1) {
      box_relleno.attr('checked', true);
    } else {
      box_relleno.attr('checked', false);
    } if(material_de_relleno == 2){
      box_roca.attr('checked', true);
    } else {
      box_roca.attr('checked', false);
    }
    $('#descripcion_modificarm').val(descripcionm);
    $('#profundidad_inicial_modificar').val(pinicial);
    $('#profundidad_final_modificar').val(pfinal);
    $('#numero_golpes_modificar').val(num_golpes);
    $('#id_muestra_modificar').val(idm);
  },


  clickEstratos: function(){

    var box_roca =  $(this).closest("form").find(".box_roca"),
      box_relleno = $(this).closest("form").find(".box_relleno"),
      box_clicked = $(this).attr('name');

    if(box_clicked=="box_relleno"){
      if(box_relleno.is(':checked')){ 
        box_roca.attr('checked', false);
      } 
    } else if(box_clicked=='box_roca'){
      box_relleno.attr('checked', false);
      alertify.set({ delay: 10000 });
      alertify.log(" <strong> Información importante :</strong> <br> las muestras que son de roca no se le realizaran test.");
    }
},
  
  updateLimites: function (e) {
    e.preventDefault();
    idFormularios = this.rel;
    $formularios = $('.' + idFormularios);
    $.each($formularios, function (index, formulario) {
      form = $(formulario);
      $.post(form.attr('action'), form.serialize(), function (respuesta) {
        if(contadorLimites==2){
          if (respuesta.status === 'OK') {
          console.log(respuesta.message);
          
          alertify.success(" <strong>Limites guardados exitosamente.</strong>");

          alertify.set({ delay: 10000 });
          alertify.log(" <strong>Tener en cuenta : </strong>Para que los resultados de los limites se vean reflejados en el informe final tienes que recargar la pagina.");
          } else {
          console.log(respuesta.message);
          alertify.error("<strong> opps..Hubo un error al guardar. </strong>");
          }
          contadorLimites=0;  
        } 
        contadorLimites++;
      }, 'json');
    });

  },
  calculosLimites:  function () {

    if ($(this).hasClass('iliquido')) {
      //elementos columnas finales tablas
      var trbody = $(this).parent().parent().parent(),
        trTodos = trbody.children(),
        tr1 = trTodos.eq(0),
        tr2 = trTodos.eq(1),
        tr3 = trTodos.eq(2),
        tr4 = trTodos.eq(3),
        tds1 = tr1.children(),
        tds2 = tr2.children(),
        tds3 = tr3.children(),
        tds4 = tr4.children(),
        tdFinal1 = tds1.eq(8),
        tdFinal2 = tds2.eq(8),
        tdFinal3 = tds3.eq(8),
        tdFinal4 = tds4.eq(8);

      //elementos calculos horizontales  
      var trPadre = $(this).parent().parent(),
        tdHijos = trPadre.children(),
        pesoCapsula1 = tdHijos.eq(3).find("input"),
        sueloHumedo1 = tdHijos.eq(4).find("input"),
        sueloSeco1 = tdHijos.eq(5).find("input"),
        pesoCapsula = parseFloat(pesoCapsula1.val()),
        sueloHumedo = parseFloat(sueloHumedo1.val()),
        sueloSeco = parseFloat(sueloSeco1.val());

        //calculos horizontales tabla liquido
        if( (sueloSeco!=null && sueloSeco>0 && typeof sueloSeco == 'number') && (pesoCapsula!=null && pesoCapsula>0 && typeof pesoCapsula == 'number') && (sueloHumedo!=null && sueloHumedo>0 && typeof sueloHumedo == 'number')  ){  
        
          pesoSuelo = sueloSeco - pesoCapsula,
          pesoAgua = sueloHumedo - sueloSeco;

          contenidoAgua = (pesoAgua/pesoSuelo)*100;
          contenidoAgua = isNaN(contenidoAgua) || contenidoAgua<0  ? contenidoAgua = 0 : contenidoAgua;
           
        } else {
          pesoSuelo = 0,
          pesoAgua = 0,
          contenidoAgua = 0;
        }

        //columnas de resultados horiazontales
        pesoSuelo == 0 ? tdPesoSuelo = tdHijos.eq(6).text(0) : tdPesoSuelo = tdHijos.eq(6).text(pesoSuelo.toFixed(2));

        pesoAgua == 0 ? tdPesoAgua = tdHijos.eq(7).text(0) : tdPesoAgua = tdHijos.eq(7).text(pesoAgua.toFixed(2));

        contenidoAgua == 0 || !isFinite(contenidoAgua) ? tdContenidoAgua = tdHijos.eq(8).text(0) : tdContenidoAgua = tdHijos.eq(8).text(contenidoAgua.toFixed(2));

      var total = parseFloat(tdFinal1.text()) + parseFloat(tdFinal2.text()) + parseFloat(tdFinal3.text());
      tdFinal4.text(total.toFixed(2));

    } else {
      //elementos columnas finales tablas
      var trbody = $(this).parent().parent().parent(),
        trTodos = trbody.children(),
        tr1 = trTodos.eq(0),
        tr2 = trTodos.eq(1),
        tr3 = trTodos.eq(2),
        tr4 = trTodos.eq(3),
        tds1 = tr1.children(),
        tds2 = tr2.children(),
        tds3 = tr3.children(),
        tds4 = tr4.children(),
        tdFinal1 = tds1.eq(7),
        tdFinal2 = tds2.eq(7),
        tdFinal3 = tds3.eq(7),
        tdFinal4 = tds4.eq(7);

      //elementos calculos horizontales  
      trPadre = $(this).parent().parent(), 
      tdHijos = trPadre.children(), 
      pesoCapsula1 = tdHijos.eq(2).find("input"), 
      sueloHumedo1 = tdHijos.eq(3).find("input"), 
      sueloSeco1 = tdHijos.eq(4).find("input"), 
      pesoCapsula = parseFloat(pesoCapsula1.val()),
      sueloHumedo = parseFloat(sueloHumedo1.val()),
      sueloSeco = parseFloat(sueloSeco1.val());

      //calculos horizontales tablas humedad natural y plastico
    
      if( (sueloSeco!=null && sueloSeco>0 && typeof sueloSeco == 'number') && (pesoCapsula!=null && pesoCapsula>0 && typeof pesoCapsula == 'number') && (sueloHumedo!=null && sueloHumedo>0 && typeof sueloHumedo == 'number')  ){  
        
          pesoSuelo = sueloSeco - pesoCapsula,
          pesoAgua = sueloHumedo - sueloSeco;

          contenidoAgua = (pesoAgua/pesoSuelo)*100;
          contenidoAgua = isNaN(contenidoAgua) || contenidoAgua<0  ? contenidoAgua = 0 : contenidoAgua;
           
        } else {
          pesoSuelo = 0,
          pesoAgua = 0,
          contenidoAgua = 0;
        }
    
      //columnas de resultados horiazontales
      tdPesoSuelo = tdHijos.eq(5).text(pesoSuelo.toFixed(2)),
      tdPesoAgua = tdHijos.eq(6).text(pesoAgua.toFixed(2)),
      tdContenidoAgua = tdHijos.eq(7).text(contenidoAgua.toFixed(2));



      //columnas de resultados horiazontales
      pesoSuelo == 0 ? tdPesoSuelo = tdHijos.eq(5).text(0) : tdPesoSuelo = tdHijos.eq(5).text(pesoSuelo.toFixed(2));
      pesoAgua == 0 ? tdPesoAgua = tdHijos.eq(6).text(0) : tdPesoAgua = tdHijos.eq(6).text(pesoAgua.toFixed(2));
      contenidoAgua == 0 || !isFinite(contenidoAgua) ? tdContenidoAgua = tdHijos.eq(7).text(0) : tdContenidoAgua = tdHijos.eq(7).text(contenidoAgua.toFixed(2));
      
     

    }
    //td finales de todas las tablas 
     var trFinalHumedad = $(this).closest("div").find("table.humedad").find("tbody").children(),
      trFinalLiquido = $(this).closest("div").find("table.liquido").find("tbody").children(),
      trFinalPlastico = $(this).closest("div").find("table.plastico").find("tbody").children();


      tdFinalHumedad1=trFinalHumedad.eq(0).find("td:last"),
      tdFinalHumedad2=trFinalHumedad.eq(1).find("td:last"),
      tdFinalHumedad3=trFinalHumedad.eq(2).find("td:last"),
      tdFinalHumedad4=trFinalHumedad.eq(3).find("td:last");


      tdFinalLiquido1=trFinalLiquido.eq(0).find("td:last"),
      tdFinalLiquido2=trFinalLiquido.eq(1).find("td:last"),
      tdFinalLiquido3=trFinalLiquido.eq(2).find("td:last"),
      tdFinalLiquido4=trFinalLiquido.eq(3).find("td:last");

      tdgolpes1=trFinalLiquido.eq(0).find("input.ngolpes"),
      tdgolpes2=trFinalLiquido.eq(1).find("input.ngolpes"),
      tdgolpes3=trFinalLiquido.eq(2).find("input.ngolpes");

      tdFinalPlastico1=trFinalPlastico.eq(0).find("td:last"),
      tdFinalPlastico2=trFinalPlastico.eq(1).find("td:last"),
      tdFinalPlastico3=trFinalPlastico.eq(2).find("td:last"),
      tdFinalPlastico4=trFinalPlastico.eq(3).find("td:last");


      var tdFinalHumedad1Var= parseFloat(tdFinalHumedad1.text()),
        tdFinalHumedad2Var= parseFloat(tdFinalHumedad2.text()),
        tdFinalHumedad3Var= parseFloat(tdFinalHumedad3.text()),
        tdFinalHumedad4Var= parseFloat(tdFinalHumedad4.text());

      var tdFinalLiquido1Var= parseFloat(tdFinalLiquido1.text()),
        tdFinalLiquido2Var= parseFloat(tdFinalLiquido2.text()),
        tdFinalLiquido3Var= parseFloat(tdFinalLiquido3.text()),
        tdFinalLiquido4Var= parseFloat(tdFinalLiquido4.text());

      var tdgolpes1Var=parseFloat(tdgolpes1.val()),
        tdgolpes2Var=parseFloat(tdgolpes2.val()),
        tdgolpes3Var=parseFloat(tdgolpes3.val());


      var tdFinalPlastico1Var= parseFloat(tdFinalPlastico1.text()),
        tdFinalPlastico2Var= parseFloat(tdFinalPlastico2.text()),
        tdFinalPlastico3Var= parseFloat(tdFinalPlastico3.text()),
        tdFinalPlastico4Var= parseFloat(tdFinalPlastico4.text());              

        
        // HUMEDAD NATURAL

        var HumedadNatural;
        //humedad calculando el promedio
        var menorhumedad1 = Math.min(tdFinalHumedad1Var,tdFinalHumedad2Var),
          mayorhumedad1 = Math.max(tdFinalHumedad1Var,tdFinalHumedad2Var),  
          divisionMayorMenor1H=mayorhumedad1/menorhumedad1;
          if(divisionMayorMenor1H<1.29){
            HumedadNatural = (mayorhumedad1+menorhumedad2)/2;
          }
        var menorhumedad2 = Math.min(tdFinalHumedad2Var,tdFinalHumedad3Var),
          mayorhumedad2 = Math.max(tdFinalHumedad2Var,tdFinalHumedad3Var),  
          divisionMayorMenor2H=mayorhumedad2/menorhumedad2;
          if(divisionMayorMenor2H<1.29){
            HumedadNatural= (mayorhumedad2+menorhumedad2)/2;
          }
        var menorhumedad3 = Math.min(tdFinalHumedad1Var,tdFinalHumedad3Var),
          mayorhumedad3 = Math.max(tdFinalHumedad1Var,tdFinalHumedad3Var),  
          divisionMayorMenor3H=mayorhumedad3/menorhumedad3;
          if(divisionMayorMenor3H<1.29){
            HumedadNatural= (mayorhumedad3+menorhumedad3)/2;
          }
          if(divisionMayorMenor1H>1.29 && divisionMayorMenor2H>1.29 && divisionMayorMenor3H>1.29 ){
            HumedadNatural=0;  
          }

        if(isNaN(HumedadNatural) || HumedadNatural<0){   
          tdFinalHumedad4.text(0);
        } else {
          var FinalHumedadNatural=Math.round(HumedadNatural);
          tdFinalHumedad4.text(FinalHumedadNatural.toFixed(2));
        }


        // LIMITE LIQUIDO
        var pendiente1=(tdFinalLiquido2Var-tdFinalLiquido1Var)/(tdgolpes2Var-tdgolpes1Var),
          pendiente2=(tdFinalLiquido3Var-tdFinalLiquido1Var)/(tdgolpes3Var-tdgolpes1Var),
          pendiente3=(tdFinalLiquido3Var-tdFinalLiquido2Var)/(tdgolpes3Var-tdgolpes2Var);

        var limite1=(pendiente1*25)-(pendiente1*tdgolpes1Var)+(tdFinalLiquido1Var),
          limite2=(pendiente2*25)-(pendiente2*tdgolpes3Var)+(tdFinalLiquido3Var),
          limite3=(pendiente3*25)-(pendiente3*tdgolpes2Var)+(tdFinalLiquido2Var);

        LimiteLiquido=(limite1+limite2+limite3)/3;

        if(isNaN(LimiteLiquido) || LimiteLiquido<0){   
          tdFinalLiquido4.text(0);
        } else {
          var FinalLimiteLiquido=Math.round(LimiteLiquido);
          tdFinalLiquido4.text(FinalLimiteLiquido.toFixed(2));
        }


        // LIMITE PLASTICO 
        var LimitePlastico;
        //Plastico calculando el promedio
        var menorplastico1 = Math.min(tdFinalPlastico1Var,tdFinalPlastico2Var),
          mayorplastico1 = Math.max(tdFinalPlastico1Var,tdFinalPlastico2Var),  
          divisionMayorMenor1P=mayorplastico1/menorplastico1;
          if(divisionMayorMenor1P<1.29){
            LimitePlastico= (mayorplastico1+menorplastico1)/2
          }
        var menorplastico2 = Math.min(tdFinalPlastico2Var,tdFinalPlastico3Var),
          mayorplastico2 = Math.max(tdFinalPlastico2Var,tdFinalPlastico3Var),  
          divisionMayorMenor2P=mayorplastico2/menorplastico2;
          if(divisionMayorMenor2P<1.29){
            LimitePlastico= (mayorplastico2+menorplastico2)/2
          }
        var menorplastico3 = Math.min(tdFinalPlastico1Var,tdFinalPlastico3Var),
          mayorplastico3 = Math.max(tdFinalPlastico1Var,tdFinalPlastico3Var),  
          divisionMayorMenor3P=mayorplastico3/menorplastico3;
          if(divisionMayorMenor3P<1.29){
            LimitePlastico= (mayorplastico3+menorplastico3)/2
          }
          if(divisionMayorMenor1P>1.29 && divisionMayorMenor2P>1.29 && divisionMayorMenor3P>1.29 ){
            LimitePlastico=0;  
          }

       if(isNaN(LimitePlastico) || LimitePlastico<0){   
          tdFinalPlastico4.text(0);
        } else {
          var FinalLimitePlastico=Math.round(LimitePlastico);
          tdFinalPlastico4.text(FinalLimitePlastico.toFixed(2));
        }


    //Elementos Totales de las tablas humedad plastico y liquido 
    var tdHumedad = $(this).closest("div").find("table.humedad").find("tbody").find("tr:last").find("td:last"),
      tdLiquido = $(this).closest("div").find("table.liquido").find("tbody").find("tr:last").find("td:last"),
      tdPlastico = $(this).closest("div").find("table.plastico").find("tbody").find("tr:last").find("td:last");

    //variables con valores de tablas   
    var humedadVar = parseFloat(tdHumedad.text()),
      liquidoVar = parseFloat(tdLiquido.text()),
      plasticoVar = parseFloat(tdPlastico.text());

    //Elementos tabla de resultados  
    var trResultados = $(this).closest("div").find("table.resultados").find("tbody").find("tr").children(),
      resultadoHumedad = trResultados.eq(0),
      resultadoPlastico = trResultados.eq(2),
      resultadoliquido = trResultados.eq(1),
      resultadoIndicePlasticidad = trResultados.eq(3);

    //Input hidden de resultados 
    var InputHumedadFinal = $(this).closest("div").find("form.formResultados").find("input.HumedadNaturalFinal"),
      InputLimiteLiquidoFinal= $(this).closest("div").find("form.formResultados").find("input.LimiteLiquidoFinal"),
      InputLimitePlasticoFinal= $(this).closest("div").find("form.formResultados").find("input.LimitePlasticoFinal"),
      InputIndicePlasticidad= $(this).closest("div").find("form.formResultados").find("input.IndicePlasticidadFinal");

      InputHumedadFinal.val(humedadVar.toFixed(2)),
      InputLimiteLiquidoFinal.val(liquidoVar.toFixed(2)),
      InputLimitePlasticoFinal.val(plasticoVar.toFixed(2)),
      InputIndicePlasticidad.val(liquidoVar.toFixed(2) - plasticoVar.toFixed(2));


    //resultados grafica 
    var inputGraficaLimites = $(this).closest("div").find("input.datosgraficaLimites");

    optimizadorGraficas++;
    if(optimizadorGraficas==5){
      inputGraficaLimites.val("["+parseFloat(tdgolpes1Var)+","+parseFloat(tdFinalLiquido1Var)+"]"+","+"["+parseFloat(tdgolpes2Var)+","+parseFloat(tdFinalLiquido2Var)+"]"+","+"["+parseFloat(tdgolpes3Var)+","+parseFloat(tdFinalLiquido3Var)+"]").trigger('change');
    optimizadorGraficas=0;  
    }
    if (humedadVar == null || humedadVar <= 0) {
      resultadoHumedad.text("N/A");
    } else {
      resultadoHumedad.text(humedadVar.toFixed(2));
    }

    if (plasticoVar == null) {
      resultadoPlastico.text("N/A");
    } else if (plasticoVar <= 0) {
      resultadoPlastico.text("NP");
    } else {
      resultadoPlastico.text(plasticoVar.toFixed(2));
    }

    if (liquidoVar == null) {
      resultadoliquido.text("N/A");
    } else if (liquidoVar <= 0) {
      resultadoliquido.text("NL");
    } else {
      resultadoliquido.text(liquidoVar.toFixed(2));
    }

    if (liquidoVar == null || plasticoVar == null) {
      resultadoIndicePlasticidad.text("N/A");
    } else {
      indicePlasticidad = liquidoVar.toFixed(2) - plasticoVar.toFixed(2);
      resultadoIndicePlasticidad.text(indicePlasticidad.toFixed(2));
    }
  },
  noplastico: function (e) {
    e.preventDefault();

  
    alertify.log(" <strong>Información: </strong> Suelo no plastico.");
    var inputTablaNoPlastico = $(this).closest("div").find("table.plastico").find("input"),
      trTablaNoPlastico = $(this).closest("div").find("table.plastico").find("tbody").children();
    inputTablaNoPlastico.val("0"), 
    tr1 = trTablaNoPlastico.eq(0).children(), 
    tr2 = trTablaNoPlastico.eq(1).children(), 
    tr3 = trTablaNoPlastico.eq(2).children(), 
    tr4 = trTablaNoPlastico.eq(3).children();

    tr1Td5 = tr1.eq(5).text("0"), 
    tr1Td6 = tr1.eq(6).text("0"), 
    tr1Td7 = tr1.eq(7).text("0"), 
    tr2Td5 = tr2.eq(5).text("0"), 
    tr2Td6 = tr2.eq(6).text("0"), 
    tr2Td7 = tr2.eq(7).text("0");
    tr3Td5 = tr3.eq(5).text("0"), 
    tr3Td6 = tr3.eq(6).text("0"), 
    tr3Td7 = tr3.eq(7).text("0"), 
    tr4Td7 = tr4.eq(7).text("0");

    //Elementos Totales de las tablas humedad plastico y liquido 
    var tdHumedad = $(this).closest("div").find("table.humedad").find("tbody").find("tr:last").find("td:last"),
      tdLiquido = $(this).closest("div").find("table.liquido").find("tbody").find("tr:last").find("td:last"),
      tdPlastico = $(this).closest("div").find("table.plastico").find("tbody").find("tr:last").find("td:last");

    //variables con valores de tablas   
    var humedadVar = parseFloat(tdHumedad.text()),
      liquidoVar = parseFloat(tdLiquido.text()),
      plasticoVar = parseFloat(tdPlastico.text());

    //Elementos tabla de resultados  
    var trResultados = $(this).closest("div").find("table.resultados").find("tbody").find("tr").children(),
      resultadoHumedad = trResultados.eq(0),
      resultadoPlastico = trResultados.eq(1),
      resultadoliquido = trResultados.eq(2),
      resultadoIndicePlasticidad = trResultados.eq(3);


      //Input hidden de resultados 
    var InputHumedadFinal = $(this).closest("div").find("form.formResultados").find("input.HumedadNaturalFinal"),
      InputLimiteLiquidoFinal= $(this).closest("div").find("form.formResultados").find("input.LimiteLiquidoFinal"),
      InputLimitePlasticoFinal= $(this).closest("div").find("form.formResultados").find("input.LimitePlasticoFinal"),
      InputIndicePlasticidad= $(this).closest("div").find("form.formResultados").find("input.IndicePlasticidadFinal");

      InputHumedadFinal.val(humedadVar.toFixed(2)),
      InputLimiteLiquidoFinal.val(liquidoVar.toFixed(2)),
      InputLimitePlasticoFinal.val(plasticoVar.toFixed(2)),
      InputIndicePlasticidad.val(liquidoVar.toFixed(2) - plasticoVar.toFixed(2));  

    if (humedadVar == null || humedadVar <= 0) {
      resultadoHumedad.text("N/A");
    } else {
      resultadoHumedad.text(humedadVar.toFixed(2));
    }

    if (plasticoVar == null) {
      resultadoPlastico.text("N/A");
    } else if (plasticoVar <= 0) {
      resultadoPlastico.text("NP");
    } else {
      resultadoPlastico.text(plasticoVar.toFixed(2));
    }

    if (liquidoVar == null) {
      resultadoliquido.text("N/A");
    } else if (liquidoVar <= 0) {
      resultadoliquido.text("NL");
    } else {
      resultadoliquido.text(liquidoVar.toFixed(2));
    }

    if (liquidoVar == null || plasticoVar == null) {
      resultadoIndicePlasticidad.text("N/A");
    } else {
      indicePlasticidad = liquidoVar.toFixed(2) - plasticoVar.toFixed(2);
      resultadoIndicePlasticidad.text(indicePlasticidad.toFixed(2));
    }
  },
  noliquido: function (e) {
    e.preventDefault();

    alertify.log(" <strong>Información: </strong> Suelo no liquido.");
    var inputTablaNoLiquido = $(this).closest("div").find("table.liquido").find("input"),
      trTablaNoLiquido = $(this).closest("div").find("table.liquido").find("tbody").children();
    inputTablaNoLiquido.val("0"), 
    tr1 = trTablaNoLiquido.eq(0).children(), 
    tr2 = trTablaNoLiquido.eq(1).children(), 
    tr3 = trTablaNoLiquido.eq(2).children(), 
    tr4 = trTablaNoLiquido.eq(3).children();

    tr1Td5 = tr1.eq(6).text("0"), 
    tr1Td6 = tr1.eq(7).text("0"), 
    tr1Td7 = tr1.eq(8).text("0"), 
    tr2Td5 = tr2.eq(6).text("0"), 
    tr2Td6 = tr2.eq(7).text("0"), 
    tr2Td7 = tr2.eq(8).text("0");
    tr3Td5 = tr3.eq(6).text("0"), 
    tr3Td6 = tr3.eq(7).text("0"), 
    tr3Td7 = tr3.eq(8).text("0"), 
    tr4Td7 = tr4.eq(8).text("0");

    //Elementos Totales de las tablas humedad plastico y liquido 
    var tdHumedad = $(this).closest("div").find("table.humedad").find("tbody").find("tr:last").find("td:last"),
      tdLiquido = $(this).closest("div").find("table.liquido").find("tbody").find("tr:last").find("td:last"),
      tdPlastico = $(this).closest("div").find("table.plastico").find("tbody").find("tr:last").find("td:last");

    //variables con valores de tablas   
    var humedadVar = parseFloat(tdHumedad.text()),
      liquidoVar = parseFloat(tdLiquido.text()),
      plasticoVar = parseFloat(tdPlastico.text());

    //Elementos tabla de resultados  
    var trResultados = $(this).closest("div").find("table.resultados").find("tbody").find("tr").children(),
      resultadoHumedad = trResultados.eq(0),
      resultadoPlastico = trResultados.eq(1),
      resultadoliquido = trResultados.eq(2),
      resultadoIndicePlasticidad = trResultados.eq(3);

    //modificador de graficas  
    trFinalLiquido = $(this).closest("div").find("table.liquido").find("tbody").children(); 
      tdFinalLiquido1=trFinalLiquido.eq(0).find("td:last"),
      tdFinalLiquido2=trFinalLiquido.eq(1).find("td:last"),
      tdFinalLiquido3=trFinalLiquido.eq(2).find("td:last"),
      tdFinalLiquido4=trFinalLiquido.eq(3).find("td:last");

      tdgolpes1=trFinalLiquido.eq(0).find("input.ngolpes"),
      tdgolpes2=trFinalLiquido.eq(1).find("input.ngolpes"),
      tdgolpes3=trFinalLiquido.eq(2).find("input.ngolpes");
    var tdFinalLiquido1Var= parseFloat(tdFinalLiquido1.text()),
        tdFinalLiquido2Var= parseFloat(tdFinalLiquido2.text()),
        tdFinalLiquido3Var= parseFloat(tdFinalLiquido3.text()),
        tdFinalLiquido4Var= parseFloat(tdFinalLiquido4.text());

    var tdgolpes1Var=parseFloat(tdgolpes1.val()),
      tdgolpes2Var=parseFloat(tdgolpes2.val()),
      tdgolpes3Var=parseFloat(tdgolpes3.val());

    var inputGrafica = $(this).closest("div").find("input.datosgraficaLimites");

    inputGrafica.val("[1,1],[1,1],[1,1]").trigger('change');  


    //Input hidden de resultados 
    var InputHumedadFinal = $(this).closest("div").find("form.formResultados").find("input.HumedadNaturalFinal"),
      InputLimiteLiquidoFinal= $(this).closest("div").find("form.formResultados").find("input.LimiteLiquidoFinal"),
      InputLimitePlasticoFinal= $(this).closest("div").find("form.formResultados").find("input.LimitePlasticoFinal"),
      InputIndicePlasticidad= $(this).closest("div").find("form.formResultados").find("input.IndicePlasticidadFinal");

      InputHumedadFinal.val(humedadVar.toFixed(2)),
      InputLimiteLiquidoFinal.val(liquidoVar.toFixed(2)),
      InputLimitePlasticoFinal.val(plasticoVar.toFixed(2)),
      InputIndicePlasticidad.val(liquidoVar.toFixed(2) - plasticoVar.toFixed(2));

    if (humedadVar == null || humedadVar <= 0) {
      resultadoHumedad.text("N/A");
    } else {
      resultadoHumedad.text(humedadVar.toFixed(2));
    }

    if (plasticoVar == null) {
      resultadoPlastico.text("N/A");
    } else if (plasticoVar <= 0) {
      resultadoPlastico.text("NP");
    } else {
      resultadoPlastico.text(plasticoVar.toFixed(2));
    }

    if (liquidoVar == null) {
      resultadoliquido.text("N/A");
    } else if (liquidoVar <= 0) {
      resultadoliquido.text("NL");
    } else {
      resultadoliquido.text(liquidoVar.toFixed(2));
    }
    if (liquidoVar == null || plasticoVar == null) {
      resultadoIndicePlasticidad.text("N/A");
    } else {
      indicePlasticidad = liquidoVar.toFixed(2) - plasticoVar.toFixed(2);
      resultadoIndicePlasticidad.text(indicePlasticidad.toFixed(2));
    }
  },
  updateGranulometria: function (e) {
    e.preventDefault();
    var idFormulario = this.rel;
    $post = $('.' + idFormulario);
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        console.log(respuesta.message);
        alertify.success("Datos guardados exitosamente."); 
        
        alertify.set({ delay: 10000 });
        alertify.log(" <strong>Tener en cuenta : </strong>Para que los resultados de granulometria se vean reflejados en el informe final tienes que recargar la pagina.");
      } else {
        console.log(respuesta.message);
        alertify.error("opps..Hubo un error al guardar");
      }
    }, 'json');
  },
  clickGuardarCompresion: function (e) {
    e.preventDefault();
    idFormularios = this.rel;
    $post = $('.' + idFormularios);
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        console.log(respuesta.message);
        alertify.success("Datos guardados exitosamente.");
        
        alertify.set({ delay: 10000 });
        alertify.log(" <strong>Tener en cuenta : </strong>Para que los resultados de compresión se vean reflejados en el informe final tienes que recargar la pagina.");
      } else {
        console.log(respuesta.message);
        alertify.error("opps..Hubo un error al guardar");
      }
    }, 'json');
  },
  calculosCompresion: function () {
    //Elementos y calculos Tabla de medidas 
    var tdCompresion = $(this).closest("div").find("table.tablacompresion").find("tbody").find("tr:first").children();

    var diametro = tdCompresion.eq(0).find("input.icompresion"),
      altura = tdCompresion.eq(1).find("input"),
      pesoGr = tdCompresion.eq(2).find("input"),
      tipoFalla = tdCompresion.eq(3).find("input"),
      area = tdCompresion.eq(4),
      volumen = tdCompresion.eq(5),
      cohesionVisible = tdCompresion.eq(6);

    //variables con resultados
    diametroVar = parseFloat(diametro.val());
    alturaVar = parseFloat(altura.val());
    pesoVar = parseFloat(pesoGr.val());

    //area
    areaVar = (Math.PI * (diametroVar * diametroVar)) / 4;
    areaVar = isNaN(areaVar) || areaVar<0  ? areaVar=0 : areaVar;

    volumenVar = (areaVar * alturaVar);
    volumenVar = isNaN(volumenVar) || volumenVar<0  ? volumenVar=0 : volumenVar;

    pesoUnitarioVar = (pesoVar / volumenVar) * 10;
    pesoUnitarioVar = isNaN(pesoUnitarioVar) || pesoUnitarioVar<0  ? pesoUnitarioVar=0 : pesoUnitarioVar;     

    area.text(areaVar.toFixed(2)); 
    volumen.text(volumenVar.toFixed(2));

    // elementos y calculos horizontales tabla de deformacion   
    if ($(this).hasClass("ideformacion")) {
      var calculosFila = $(this).parent().parent().children();

      var deformacion = calculosFila.eq(0),
        carga = calculosFila.eq(1).find("input"),
        deformacionTotal = calculosFila.eq(2),
        cargaKg = calculosFila.eq(3),
        areaCorregida = calculosFila.eq(4),
        esfuerzo = calculosFila.eq(5);

      if (carga.val() >= 0 && !isNaN(carga.val())) {
        var deformacionTotalVar = (parseFloat(deformacion.text()) * 2.54) / 1000;
        var cargaKgVar = carga.val() / 10;
        var areaCorregidaVar = (areaVar / (1 - (deformacionTotalVar / parseFloat(altura.val()))));      
        var esfuerzoVar = parseFloat(cargaKgVar) / areaCorregidaVar;

      } else {
        var deformacionTotalVar = 0;
        var cargaKgVar = 0;
        var areaCorregidaVar = 0;  
        var esfuerzoVar = 0;
      }


      if(!isFinite(deformacionTotalVar)) {
        deformacionTotal.text(0);
      } else {
        deformacionTotal.text(deformacionTotalVar.toPrecision(2));
      }
      if(!isFinite(cargaKgVar)) {
        cargaKg.text(0);
      } else {
        cargaKg.text(cargaKgVar.toFixed(2));
      }
      if(!isFinite(areaCorregidaVar)) {
        areaCorregida.text(0);
      } else {
        areaCorregida.text(areaCorregidaVar.toFixed(2));
      }
      if(!isFinite(esfuerzoVar)) {
        esfuerzo.text(0);
      } else {
        esfuerzo.text(esfuerzoVar.toFixed(2));
      }      
    
    }
    //todas los td esfuerzo finales de la tabla de deformacion
    var trDeformacion = $(this).closest("div").find("table.tabladeformacion").find("tbody").children();
    var tdFinal0 = trDeformacion.eq(0).find("td:last"), 
      tdFinal1 = trDeformacion.eq(1).find("td:last"), 
      tdFinal2 = trDeformacion.eq(2).find("td:last"), 
      tdFinal3 = trDeformacion.eq(3).find("td:last"), 
      tdFinal4 = trDeformacion.eq(4).find("td:last"), 
      tdFinal5 = trDeformacion.eq(5).find("td:last"), 
      tdFinal6 = trDeformacion.eq(6).find("td:last"), 
      tdFinal7 = trDeformacion.eq(7).find("td:last"), 
      tdFinal8 = trDeformacion.eq(8).find("td:last"), 
      tdFinal9 = trDeformacion.eq(9).find("td:last"), 
      tdFinal10 = trDeformacion.eq(10).find("td:last"), 
      tdFinal11 = trDeformacion.eq(11).find("td:last"), 
      tdFinal12 = trDeformacion.eq(12).find("td:last"), 
      tdFinal13 = trDeformacion.eq(13).find("td:last"), 
      tdFinal14 = trDeformacion.eq(14).find("td:last"), 
      tdFinal15 = trDeformacion.eq(15).find("td:last"), 
      tdFinal16 = trDeformacion.eq(16).find("td:last"), 
      tdFinal17 = trDeformacion.eq(17).find("td:last");

    // variables de ultimos td esfuerzo 
    var td0Var = parseFloat(tdFinal0.text()),
      td1Var = parseFloat(tdFinal1.text()),
      td2Var = parseFloat(tdFinal2.text()),
      td3Var = parseFloat(tdFinal3.text()),
      td4Var = parseFloat(tdFinal4.text()),
      td5Var = parseFloat(tdFinal5.text()),
      td6Var = parseFloat(tdFinal6.text()),
      td7Var = parseFloat(tdFinal7.text()),
      td8Var = parseFloat(tdFinal8.text()),
      td9Var = parseFloat(tdFinal9.text()),
      td10Var = parseFloat(tdFinal10.text()),
      td11Var = parseFloat(tdFinal11.text()),
      td12Var = parseFloat(tdFinal12.text()),
      td13Var = parseFloat(tdFinal13.text()),
      td14Var = parseFloat(tdFinal14.text()),
      td15Var = parseFloat(tdFinal15.text()),
      td16Var = parseFloat(tdFinal16.text()),
      td17Var = parseFloat(tdFinal17.text());


    //Todos los td columna deformacion 
    var tdDeformacion0 = trDeformacion.eq(0).find("td.gdeformacion"), 
      tdDeformacion1 = trDeformacion.eq(1).find("td.gdeformacion"), 
      tdDeformacion2 = trDeformacion.eq(2).find("td.gdeformacion"), 
      tdDeformacion3 = trDeformacion.eq(3).find("td.gdeformacion"), 
      tdDeformacion4 = trDeformacion.eq(4).find("td.gdeformacion"), 
      tdDeformacion5 = trDeformacion.eq(5).find("td.gdeformacion"), 
      tdDeformacion6 = trDeformacion.eq(6).find("td.gdeformacion"), 
      tdDeformacion7 = trDeformacion.eq(7).find("td.gdeformacion"), 
      tdDeformacion8 = trDeformacion.eq(8).find("td.gdeformacion"), 
      tdDeformacion9 = trDeformacion.eq(9).find("td.gdeformacion"), 
      tdDeformacion10 = trDeformacion.eq(10).find("td.gdeformacion"), 
      tdDeformacion11 = trDeformacion.eq(11).find("td.gdeformacion"), 
      tdDeformacion12 = trDeformacion.eq(12).find("td.gdeformacion"), 
      tdDeformacion13 = trDeformacion.eq(13).find("td.gdeformacion"), 
      tdDeformacion14 = trDeformacion.eq(14).find("td.gdeformacion"), 
      tdDeformacion15 = trDeformacion.eq(15).find("td.gdeformacion"), 
      tdDeformacion16 = trDeformacion.eq(16).find("td.gdeformacion"), 
      tdDeformacion17 = trDeformacion.eq(17).find("td.gdeformacion");

    // variables de td columna deformacion  
    var tdDeformacion0Var = parseFloat(tdDeformacion0.text()),
      tdDeformacion1Var = parseFloat(tdDeformacion1.text()),
      tdDeformacion2Var = parseFloat(tdDeformacion2.text()),
      tdDeformacion3Var = parseFloat(tdDeformacion3.text()),
      tdDeformacion4Var = parseFloat(tdDeformacion4.text()),
      tdDeformacion5Var = parseFloat(tdDeformacion5.text()),
      tdDeformacion6Var = parseFloat(tdDeformacion6.text()),
      tdDeformacion7Var = parseFloat(tdDeformacion7.text()),
      tdDeformacion8Var = parseFloat(tdDeformacion8.text()),
      tdDeformacion9Var = parseFloat(tdDeformacion9.text()),
      tdDeformacion10Var = parseFloat(tdDeformacion10.text()),
      tdDeformacion11Var = parseFloat(tdDeformacion11.text()),
      tdDeformacion12Var = parseFloat(tdDeformacion12.text()),
      tdDeformacion13Var = parseFloat(tdDeformacion13.text()),
      tdDeformacion14Var = parseFloat(tdDeformacion14.text()),
      tdDeformacion15Var = parseFloat(tdDeformacion15.text()),
      tdDeformacion16Var = parseFloat(tdDeformacion16.text()),
      tdDeformacion17Var = parseFloat(tdDeformacion17.text());


    // grafica de deformacion 
    var inputGraficaCompresion = $(this).closest("div").find("input.datosgraficaCompresion");

 
    optimizadorGraficas++;
    if(optimizadorGraficas==5){
      var datosCompresion = "["+parseFloat(tdDeformacion0Var)+","+parseFloat(td0Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion1Var)+","+parseFloat(td1Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion2Var)+","+parseFloat(td2Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion3Var)+","+parseFloat(td3Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion4Var)+","+parseFloat(td4Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion5Var)+","+parseFloat(td5Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion6Var)+","+parseFloat(td6Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion7Var)+","+parseFloat(td7Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion8Var)+","+parseFloat(td8Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion9Var)+","+parseFloat(td9Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion10Var)+","+parseFloat(td10Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion11Var)+","+parseFloat(td11Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion12Var)+","+parseFloat(td12Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion13Var)+","+parseFloat(td13Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion14Var)+","+parseFloat(td14Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion15Var)+","+parseFloat(td15Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion16Var)+","+parseFloat(td16Var)+"]"
      +","+
      "["+parseFloat(tdDeformacion17Var)+","+parseFloat(td17Var)+"]";

      var arrayCompresion = eval("["+datosCompresion+"]");
      
    var i = 0;
    var arrayCompresionFinal = new Array();
    while ( i < arrayCompresion.length ) {

      if ( 0 != arrayCompresion[i][0] && 0 != arrayCompresion[i][1] ) {
        arrayCompresionFinal.push("["+arrayCompresion[i]+"]");
      }
      i++;
    }
     inputGraficaCompresion.val(arrayCompresionFinal).trigger('change');
     optimizadorGraficas = 0;
    }

    //Calculos de cohesion   
    cohesionVar = (Math.max(td0Var, td1Var, td2Var, td3Var, td4Var, td5Var, td6Var, td7Var, td8Var, td9Var, td10Var, td11Var, td12Var, td13Var, td14Var, td15Var, td16Var, td17Var)) / 2 * 100;
    

    // Elementos y calculos tabla de resultados compresion
    var trResultados = $(this).closest("div").find("table.resultadoscompresion").find("tbody").find("tr").children();
    

    resultadoDiametro = trResultados.eq(0), 
    resultadoAltura = trResultados.eq(1), 
    resultadoPeso = trResultados.eq(2), 
    resultadoTipoFalla = trResultados.eq(3), 
    resultadoArea = trResultados.eq(4), 
    resultadoVolumen = trResultados.eq(5), 
    resultadoPesoUnitario = trResultados.eq(6), 
    resultadoCohesion = trResultados.eq(7);


    //input de resultados 
     var InputCohesionFinal = $(this).closest("div").find("form.formResultadosCompresion").find("input.cohesionFinal"),
      InputPesoUnitarioFinal= $(this).closest("div").find("form.formResultadosCompresion").find("input.pesoUnitarioFinal");


    if(isNaN(diametroVar) || diametroVar<0 ){
      resultadoDiametro.text(0);  
    } else {
      resultadoDiametro.text(diametroVar.toFixed(2));  
    }   
    
    if(isNaN(alturaVar) || alturaVar<0 ){
      resultadoAltura.text(0);
    } else {
      resultadoAltura.text(alturaVar.toFixed(2));  
    }
    
    if(isNaN(pesoVar) || pesoVar<0 ){
      resultadoPeso.text(0);
    } else {
      resultadoPeso.text(pesoVar.toFixed(2));
    }

    if(isNaN(pesoUnitarioVar) || pesoUnitarioVar<0 ){
      resultadoPesoUnitario.text(0);
    } else {
      resultadoPesoUnitario.text(pesoUnitarioVar.toFixed(2));
    }
    
    if(isNaN(cohesionVar) || cohesionVar<0 ){
      resultadoCohesion.text(0);
    } else {
      resultadoCohesion.text(cohesionVar.toFixed(2));
    }
  
    if(!tipoFalla.val()){
      resultadoTipoFalla.text('-');
    } else {
      resultadoTipoFalla.text(tipoFalla.val());
    }
    
    
    if(isNaN(areaVar) || areaVar<0 ){
      resultadoArea.text(0);
    } else {
      resultadoArea.text(areaVar.toFixed(2));
    }
    if(isNaN(volumenVar) || volumenVar<0 ){
      resultadoVolumen.text(0);
    } else {
      resultadoVolumen.text(volumenVar.toFixed(2));
    }
    if(isNaN(cohesionVar) || cohesionVar<0 ){
      resultadoCohesion.text(0);
      cohesionVisible.text(0);
    } else {
      resultadoCohesion.text(cohesionVar.toFixed(2));
      cohesionVisible.text(cohesionVar.toFixed(2))
    }
    
    //asignacion de variables a inputs resultados
    if(isNaN(cohesionVar) || cohesionVar<0 ){
      InputCohesionFinal.val(0);  
    } else {
      InputCohesionFinal.val(cohesionVar.toFixed(2));

    }
    if(isNaN(pesoUnitarioVar) || pesoUnitarioVar<0 ){
      InputPesoUnitarioFinal.val(0);
    } else {
      InputPesoUnitarioFinal.val(pesoUnitarioVar.toFixed(2));
    }
    
  },
  calculosGranulometria: function(){
    //tabla de pesos
    var trGranulometria = $(this).closest("div").find("table.tablapesos").find("tbody").children();

    // Capturando el peso del recipiente 
    var TablaPesoRecipiente = $(this).closest("div").find("table.tablaanalisis").find("tbody").find("tr:first").children();

    var _PesoRecipienteVarPura = TablaPesoRecipiente.eq(0).find("input.analisis");
    var _PesoRecipienteVar = parseFloat(_PesoRecipienteVarPura.val());


    if( _PesoRecipienteVar<=0){
      _PesoRecipienteVar = 0;
    }

      // Todos los tr    
      var tr1 = trGranulometria.eq(0).children(),
          tr2 = trGranulometria.eq(1).children(),
          tr3 = trGranulometria.eq(2).children(),
          tr4 = trGranulometria.eq(3).children(),
          tr5 = trGranulometria.eq(4).children(),
          tr6 = trGranulometria.eq(5).children(),
          tr7 = trGranulometria.eq(6).children(),
          tr8 = trGranulometria.eq(7).children(),
          tr9 = trGranulometria.eq(8).children(),
          tr10 = trGranulometria.eq(9).children(),
          tr11 = trGranulometria.eq(10).children(),
          tr12 = trGranulometria.eq(11).children(),
          tr13 = trGranulometria.eq(12).children(),
          tr14 = trGranulometria.eq(13).children(),
          tr15 = trGranulometria.eq(14).children(),
          tr16 = trGranulometria.eq(15).children(),
          tr17 = trGranulometria.eq(16).children(),
          tr18 = trGranulometria.eq(17).children(),
          tr19 = trGranulometria.eq(18).children(),
          tr20 = trGranulometria.eq(19).children();
         
      //Todos los td de la columna pesos retenidos    
      var tdReT1=tr1.eq(2).find("input"),
        tdReT2=tr2.eq(2).find("input"),
        tdReT3=tr3.eq(2).find("input"),
        tdReT4=tr4.eq(2).find("input"),
        tdReT5=tr5.eq(2).find("input"),
        tdReT6=tr6.eq(2).find("input"),
        tdReT7=tr7.eq(2).find("input"),
        tdReT8=tr8.eq(2).find("input"),
        tdReT9=tr9.eq(2).find("input"),
        tdReT10=tr10.eq(2).find("input"),
        tdReT11=tr11.eq(2).find("input"),
        tdReT12=tr12.eq(2).find("input"),
        tdReT13=tr13.eq(2).find("input"),
        tdReT14=tr14.eq(2).find("input"),
        tdReT15=tr15.eq(2).find("input"),
        tdReT16=tr16.eq(2).find("input"),
        tdReT17=tr17.eq(2).find("input"),
        tdReT18=tr18.eq(2).find("input"),
        tdReT19=tr19.eq(2),
        tdReT20=tr20.eq(2);

      // Variables de pesos retenidos   
      var pesoRet1VarPura =  parseFloat(tdReT1.val())  ,
        pesoRet2VarPura = parseFloat(tdReT2.val()),
        pesoRet3VarPura = parseFloat(tdReT3.val()),
        pesoRet4VarPura = parseFloat(tdReT4.val()),
        pesoRet5VarPura = parseFloat(tdReT5.val()),
        pesoRet6VarPura = parseFloat(tdReT6.val()),
        pesoRet7VarPura = parseFloat(tdReT7.val()),
        pesoRet8VarPura = parseFloat(tdReT8.val()),
        pesoRet9VarPura = parseFloat(tdReT9.val()),
        pesoRet10VarPura = parseFloat(tdReT10.val()),
        pesoRet11VarPura = parseFloat(tdReT11.val()),
        pesoRet12VarPura = parseFloat(tdReT12.val()),
        pesoRet13VarPura = parseFloat(tdReT13.val()),
        pesoRet14VarPura = parseFloat(tdReT14.val()),
        pesoRet15VarPura = parseFloat(tdReT15.val()),
        pesoRet16VarPura = parseFloat(tdReT16.val()),
        pesoRet17VarPura = parseFloat(tdReT17.val()),
        pesoRet18VarPura = parseFloat(tdReT18.val());


        

      // Variables de pesos retenidos   
      var pesoRet1Var = pesoRet1VarPura - _PesoRecipienteVar,
        pesoRet2Var = pesoRet2VarPura - _PesoRecipienteVar,
        pesoRet3Var = pesoRet3VarPura - _PesoRecipienteVar,
        pesoRet4Var = pesoRet4VarPura - _PesoRecipienteVar,
        pesoRet5Var = pesoRet5VarPura - _PesoRecipienteVar,
        pesoRet6Var = pesoRet6VarPura - _PesoRecipienteVar,
        pesoRet7Var = pesoRet7VarPura - _PesoRecipienteVar,
        pesoRet8Var = pesoRet8VarPura - _PesoRecipienteVar,
        pesoRet9Var = pesoRet9VarPura - _PesoRecipienteVar,
        pesoRet10Var = pesoRet10VarPura - _PesoRecipienteVar,
        pesoRet11Var = pesoRet11VarPura - _PesoRecipienteVar,
        pesoRet12Var = pesoRet12VarPura - _PesoRecipienteVar,
        pesoRet13Var = pesoRet13VarPura - _PesoRecipienteVar,
        pesoRet14Var = pesoRet14VarPura - _PesoRecipienteVar,
        pesoRet15Var = pesoRet15VarPura - _PesoRecipienteVar,
        pesoRet16Var = pesoRet16VarPura - _PesoRecipienteVar,
        pesoRet17Var = pesoRet17VarPura - _PesoRecipienteVar,
        pesoRet18Var = pesoRet18VarPura - _PesoRecipienteVar;



        //Sumatoria Pesos Retenidos
        var todosPesosRetenidos= pesoRet1Var+pesoRet2Var+pesoRet3Var+pesoRet4Var+pesoRet5Var+pesoRet6Var+pesoRet7Var+pesoRet8Var+pesoRet9Var+pesoRet10Var+pesoRet11Var+pesoRet12Var+pesoRet13Var+pesoRet14Var+pesoRet15Var+pesoRet16Var+pesoRet17Var+pesoRet18Var;

      //td fondo corregido y total corregido  
      var fondoRetenidoCorregido=tr19.eq(3),
        totalRetenidoCorregido= tr20.eq(3); 

      //td fondo RETENIDO % 
      var fondoRetenido=tr19.eq(4);

      //td fondo RETENIDO % 
      var fondoRetenidoAcumulado=tr19.eq(5);

      //td fondo pasa
      var fondoPasa=tr19.eq(6);
      
      //calculos tabla de analisis
     var tdAnalisis = $(this).closest("div").find("table.tablaanalisis").find("tbody").find("tr:first").children();

    var pesoRecipiente = tdAnalisis.eq(0).find("input.analisis"),
      pesoRecipienteMasMuestra = tdAnalisis.eq(1).find("input.analisis"),
      pesoMuestraSeca = tdAnalisis.eq(2),
      pesoRetenidoN200MasRecipiente = tdAnalisis.eq(3),
      pesoRetenidoN200 = tdAnalisis.eq(4),
      sumaPesoRetenidos = tdAnalisis.eq(5); 

    var pesoRecipienteVar= parseFloat(pesoRecipiente.val()),  
      pesoRecipienteMasMuestraVar=parseFloat(pesoRecipienteMasMuestra.val());



    if((isNaN(pesoRecipienteMasMuestraVar) || pesoRecipienteMasMuestraVar<0) || (isNaN(pesoRecipienteVar) || pesoRecipienteVar<0)) {
      pesoMuestraSecaVar=0;
    }else {
      pesoMuestraSecaVar=pesoRecipienteMasMuestraVar-pesoRecipienteVar; 
    }
    
    if((isNaN(todosPesosRetenidos) || todosPesosRetenidos<0) || (isNaN(pesoRecipienteVar) || pesoRecipienteVar<0)) {
      pesoRetenidoN200MasRecipienteVar=0;
    }else {
      pesoRetenidoN200MasRecipienteVar=todosPesosRetenidos+pesoRecipienteVar;
    }
    
    if((isNaN(pesoRetenidoN200MasRecipienteVar) || pesoRetenidoN200MasRecipienteVar<0) || (isNaN(pesoRecipienteVar) || pesoRecipienteVar<0)) {
      pesoRetenidoN200Var=pesoRetenidoN200MasRecipienteVar-pesoRecipienteVar;
    }else {
      pesoRetenidoN200Var=pesoRetenidoN200MasRecipienteVar-pesoRecipienteVar;
    }
    
    if(isNaN(todosPesosRetenidos) || todosPesosRetenidos<0) {
      sumaPesoRetenidosVar=0;
    }else {
      sumaPesoRetenidosVar=parseFloat(todosPesosRetenidos);
    }
    

      //resultados y calculos tabla analisis 
      
      pesoMuestraSeca.text(pesoMuestraSecaVar.toFixed(2)),
      pesoRetenidoN200MasRecipiente.text(pesoRetenidoN200MasRecipienteVar.toFixed(2)),
      pesoRetenidoN200.text(pesoRetenidoN200Var.toFixed(2)),
      sumaPesoRetenidos.text(sumaPesoRetenidosVar.toFixed(2)); 



      //Fondos y totales
      fondoRetVar= pesoRecipienteMasMuestraVar-pesoRetenidoN200MasRecipienteVar,
      totalRetVar= sumaPesoRetenidosVar+fondoRetVar;

      if(isNaN(fondoRetVar) || fondoRetVar<0) {
        tdReT19.text(0);
      }else {
        tdReT19.text(fondoRetVar.toFixed(2));
      }
      if(isNaN(totalRetVar) || totalRetVar<0) {
        tdReT20.text(0);
      }else {
        tdReT20.text(totalRetVar.toFixed(2));
      }
      

      //variables fondo corredigo y total Corregido 
      var  fondoRetenidoCorregidoVar= fondoRetVar-((sumaPesoRetenidosVar-pesoRetenidoN200Var )*(fondoRetVar/sumaPesoRetenidosVar)) ,
        totalRetenidoCorregidoVar= totalRetVar-((sumaPesoRetenidosVar-pesoRetenidoN200Var)*(totalRetVar/sumaPesoRetenidosVar));

      if(isNaN(fondoRetenidoCorregidoVar) || fondoRetenidoCorregidoVar<0) {
        fondoRetenidoCorregido.text(0);    
      }else {
        fondoRetenidoCorregido.text(fondoRetenidoCorregidoVar.toFixed(2));   
      }  
      if(isNaN(totalRetenidoCorregidoVar) || totalRetenidoCorregidoVar<0) {
        totalRetenidoCorregido.text(0);
      }else {
        totalRetenidoCorregido.text(totalRetenidoCorregidoVar.toFixed(2));
      }
      
      //variable fondo retenido 
      var fondoRetenidoVar=((fondoRetenidoCorregidoVar/totalRetenidoCorregidoVar)*100);
      
      if(isNaN(fondoRetenidoVar) || fondoRetenidoVar<0) {
        fondoRetenido.text(0);  
      }else {
        fondoRetenido.text(fondoRetenidoVar.toFixed(2));  
      }


      //Calculos Horizontales tabla pesos retenidos
      if ($(this).hasClass("granulo")) {
        var calculosFila = $(this).parent().parent().children();

        var pesoRetenido = calculosFila.eq(2).find("input"),
          retenidoCorregido = calculosFila.eq(3),
          retenido = calculosFila.eq(4),
          retenidoAcumulado = calculosFila.eq(5),
          pasa = calculosFila.eq(6);
        
        var pesoRetenidoVar = parseFloat(pesoRetenido.val())- _PesoRecipienteVar,
          retenidoCorregidoVar = (pesoRetenidoVar-((sumaPesoRetenidosVar-pesoRetenidoN200Var)*(pesoRetenidoVar/pesoRetenidoN200Var))),
          retenidoVar = (retenidoCorregidoVar/totalRetenidoCorregidoVar)*100;

        if(isNaN(retenidoCorregidoVar) || retenidoCorregidoVar<0) {
          retenidoCorregido.text(0);  
        }else {
          retenidoCorregido.text(retenidoCorregidoVar.toFixed(2));
        }  
        if(isNaN(retenidoVar) || retenidoVar<0) {
          retenido.text(0);
        }else {
          retenido.text(retenidoVar.toFixed(2));
        }

    // calculos acumulados
    //td  acumulado
    var tdFinal0 = trGranulometria.eq(0).find("td.acumulado"),
      tdFinal1 = trGranulometria.eq(1).find("td.acumulado"),
      tdFinal2 = trGranulometria.eq(2).find("td.acumulado"),
      tdFinal3 = trGranulometria.eq(3).find("td.acumulado"),
      tdFinal4 = trGranulometria.eq(4).find("td.acumulado"),
      tdFinal5 = trGranulometria.eq(5).find("td.acumulado"),
      tdFinal6 = trGranulometria.eq(6).find("td.acumulado"),
      tdFinal7 = trGranulometria.eq(7).find("td.acumulado"),
      tdFinal8 = trGranulometria.eq(8).find("td.acumulado"),
      tdFinal9 = trGranulometria.eq(9).find("td.acumulado"),
      tdFinal10 = trGranulometria.eq(10).find("td.acumulado"),
      tdFinal11 = trGranulometria.eq(11).find("td.acumulado"),
      tdFinal12 = trGranulometria.eq(12).find("td.acumulado"),
      tdFinal13 = trGranulometria.eq(13).find("td.acumulado"),
      tdFinal14 = trGranulometria.eq(14).find("td.acumulado"),
      tdFinal15 = trGranulometria.eq(15).find("td.acumulado"),
      tdFinal16 = trGranulometria.eq(16).find("td.acumulado"),
      tdFinal17 = trGranulometria.eq(17).find("td.acumulado"),
      tdFinal18 = trGranulometria.eq(18).find("td.acumulado");

      //Variables de todos los td Finales
      var fin0Var = parseFloat(tdFinal0.text()),
        fin1Var = parseFloat(tdFinal1.text()),
        fin2Var = parseFloat(tdFinal2.text()),
        fin3Var = parseFloat(tdFinal3.text()),
        fin4Var = parseFloat(tdFinal4.text()),
        fin5Var = parseFloat(tdFinal5.text()),
        fin6Var = parseFloat(tdFinal6.text()),
        fin7Var = parseFloat(tdFinal7.text()),
        fin8Var = parseFloat(tdFinal8.text()),
        fin9Var = parseFloat(tdFinal9.text()),
        fin10Var = parseFloat(tdFinal10.text()),
        fin11Var = parseFloat(tdFinal11.text()),
        fin12Var = parseFloat(tdFinal12.text()),
        fin13Var = parseFloat(tdFinal13.text()),
        fin14Var = parseFloat(tdFinal14.text()),
        fin15Var = parseFloat(tdFinal15.text()),
        fin16Var = parseFloat(tdFinal16.text()),
        fin17Var = parseFloat(tdFinal17.text()),
        FondoFinalVar = parseFloat(tdFinal18.text());

    //Fin grafica de granulometria  
    //td  retenido %
    var tdRetenido0 = trGranulometria.eq(0).find("td.retenido"),
      tdRetenido1 = trGranulometria.eq(1).find("td.retenido"),
      tdRetenido2 = trGranulometria.eq(2).find("td.retenido"),
      tdRetenido3 = trGranulometria.eq(3).find("td.retenido"),
      tdRetenido4 = trGranulometria.eq(4).find("td.retenido"),
      tdRetenido5 = trGranulometria.eq(5).find("td.retenido"),
      tdRetenido6 = trGranulometria.eq(6).find("td.retenido"),
      tdRetenido7 = trGranulometria.eq(7).find("td.retenido"),
      tdRetenido8 = trGranulometria.eq(8).find("td.retenido"),
      tdRetenido9 = trGranulometria.eq(9).find("td.retenido"),
      tdRetenido10 = trGranulometria.eq(10).find("td.retenido"),
      tdRetenido11 = trGranulometria.eq(11).find("td.retenido"),
      tdRetenido12 = trGranulometria.eq(12).find("td.retenido"),
      tdRetenido13 = trGranulometria.eq(13).find("td.retenido"),
      tdRetenido14 = trGranulometria.eq(14).find("td.retenido"),
      tdRetenido15 = trGranulometria.eq(15).find("td.retenido"),
      tdRetenido16 = trGranulometria.eq(16).find("td.retenido"),
      tdRetenido17 = trGranulometria.eq(17).find("td.retenido"),
      tdRetenido18 = trGranulometria.eq(18).find("td.retenido");

 

      //Variables de td retenido
      var tdRetenido0Var = parseFloat(tdRetenido0.text()),
        tdRetenido1Var = parseFloat(tdRetenido1.text()),
        tdRetenido2Var = parseFloat(tdRetenido2.text()),
        tdRetenido3Var = parseFloat(tdRetenido3.text()),
        tdRetenido4Var = parseFloat(tdRetenido4.text()),
        tdRetenido5Var = parseFloat(tdRetenido5.text()),
        tdRetenido6Var = parseFloat(tdRetenido6.text()),
        tdRetenido7Var = parseFloat(tdRetenido7.text()),
        tdRetenido8Var = parseFloat(tdRetenido8.text()),
        tdRetenido9Var = parseFloat(tdRetenido9.text()),
        tdRetenido10Var = parseFloat(tdRetenido10.text()),
        tdRetenido11Var = parseFloat(tdRetenido11.text()),
        tdRetenido12Var = parseFloat(tdRetenido12.text()),
        tdRetenido13Var = parseFloat(tdRetenido13.text()),
        tdRetenido14Var = parseFloat(tdRetenido14.text()),
        tdRetenido15Var = parseFloat(tdRetenido15.text()),
        tdRetenido16Var = parseFloat(tdRetenido16.text()),
        tdRetenido17Var = parseFloat(tdRetenido17.text()),
        tdRetenido18Var = parseFloat(tdRetenido18.text());

      //Calculo de acumulado
      acumulado0=tdRetenido0Var,
      acumulado1=tdRetenido1Var+fin0Var,
      acumulado2=tdRetenido2Var+fin1Var,
      acumulado3=tdRetenido3Var+fin2Var,
      acumulado4=tdRetenido4Var+fin3Var,
      acumulado5=tdRetenido5Var+fin4Var,
      acumulado6=tdRetenido6Var+fin5Var,
      acumulado7=tdRetenido7Var+fin6Var,
      acumulado8=tdRetenido8Var+fin7Var,
      acumulado9=tdRetenido9Var+fin8Var,
      acumulado10=tdRetenido10Var+fin9Var,
      acumulado11=tdRetenido11Var+fin10Var,
      acumulado12=tdRetenido12Var+fin11Var,
      acumulado13=tdRetenido13Var+fin12Var,
      acumulado14=tdRetenido14Var+fin13Var,
      acumulado15=tdRetenido15Var+fin14Var,
      acumulado16=tdRetenido16Var+fin15Var,
      acumulado17=tdRetenido17Var+fin16Var,
      acumulado18=tdRetenido18Var+fin17Var;


      //asignacion a la tabla



      isNaN(acumulado0) || acumulado0<0 ? tdFinal0.text(0) : tdFinal0.text(acumulado0.toFixed(2)),
      isNaN(acumulado1) || acumulado1<0 ? tdFinal1.text(0) : tdFinal1.text(acumulado1.toFixed(2)),
      isNaN(acumulado2) || acumulado2<0 ? tdFinal2.text(0) : tdFinal2.text(acumulado2.toFixed(2)),
      isNaN(acumulado3) || acumulado3<0 ? tdFinal3.text(0) : tdFinal3.text(acumulado3.toFixed(2)),
      isNaN(acumulado4) || acumulado4<0 ? tdFinal4.text(0) : tdFinal4.text(acumulado4.toFixed(2)),
      isNaN(acumulado5) || acumulado5<0 ? tdFinal5.text(0) : tdFinal5.text(acumulado5.toFixed(2)),
      isNaN(acumulado6) || acumulado6<0 ? tdFinal6.text(0) : tdFinal6.text(acumulado6.toFixed(2)),
      isNaN(acumulado7) || acumulado7<0 ? tdFinal7.text(0) : tdFinal7.text(acumulado7.toFixed(2)),
      isNaN(acumulado8) || acumulado8<0 ? tdFinal8.text(0) : tdFinal8.text(acumulado8.toFixed(2)),
      isNaN(acumulado9) || acumulado9<0 ? tdFinal9.text(0) : tdFinal9.text(acumulado9.toFixed(2)),
      isNaN(acumulado10) || acumulado10<0 ? tdFinal10.text(0) : tdFinal10.text(acumulado10.toFixed(2)),
      isNaN(acumulado11) || acumulado11<0 ? tdFinal11.text(0) : tdFinal11.text(acumulado11.toFixed(2)),
      isNaN(acumulado12) || acumulado12<0 ? tdFinal12.text(0) : tdFinal12.text(acumulado12.toFixed(2)), 
      isNaN(acumulado13) || acumulado13<0 ? tdFinal13.text(0) : tdFinal13.text(acumulado13.toFixed(2)),
      isNaN(acumulado14) || acumulado14<0 ? tdFinal14.text(0) : tdFinal14.text(acumulado14.toFixed(2)),
      isNaN(acumulado15) || acumulado15<0 ? tdFinal15.text(0) : tdFinal15.text(acumulado15.toFixed(2)),
      isNaN(acumulado16) || acumulado16<0 ? tdFinal16.text(0) : tdFinal16.text(acumulado16.toFixed(2)),
      isNaN(acumulado17) || acumulado17<0 ? tdFinal17.text(0) : tdFinal17.text(acumulado17.toFixed(2)),
      isNaN(acumulado18) || acumulado18<0 ? tdFinal18.text(0) : tdFinal18.text(acumulado18.toFixed(2));

        // Fin calculos acumulados
      
      // Calculos de pasa %  
      retenidoAcumuladoVar = parseFloat(retenidoAcumulado.text()),
      pasaVar = 100-retenidoAcumuladoVar;

      isNaN(pasaVar) || pasaVar<0 ? pasa.text(0) : pasa.text(pasaVar.toFixed(2));     
      
      
      //variable fondo retenido 
      var fondoRetenidoAcumuladoVar=parseFloat(fondoRetenidoAcumulado.text());

      //Variable  fondo pasa
      var fondoPasaVar=100-fondoRetenidoAcumuladoVar;
      
      isNaN(fondoPasaVar) || fondoPasaVar<0 ? fondoPasa.text(0) : fondoPasa.text(fondoPasaVar.toFixed(2));     



       //tds Pasa %
      var tdPasa0 = trGranulometria.eq(0).find("td.pasa"),
        tdPasa1 = trGranulometria.eq(1).find("td.pasa"),
        tdPasa2 = trGranulometria.eq(2).find("td.pasa"),
        tdPasa3 = trGranulometria.eq(3).find("td.pasa"),
        tdPasa4 = trGranulometria.eq(4).find("td.pasa"),
        tdPasa5 = trGranulometria.eq(5).find("td.pasa"),
        tdPasa6 = trGranulometria.eq(6).find("td.pasa");
        tdPasa7 = trGranulometria.eq(7).find("td.pasa");
        tdPasa8 = trGranulometria.eq(8).find("td.pasa"),
        tdPasa9 = trGranulometria.eq(9).find("td.pasa"),
        tdPasa10 = trGranulometria.eq(10).find("td.pasa"),
        tdPasa11 = trGranulometria.eq(11).find("td.pasa"),
        tdPasa12 = trGranulometria.eq(12).find("td.pasa"),
        tdPasa13 = trGranulometria.eq(13).find("td.pasa"),
        tdPasa14 = trGranulometria.eq(14).find("td.pasa"),
        tdPasa15 = trGranulometria.eq(15).find("td.pasa"),
        tdPasa16 = trGranulometria.eq(16).find("td.pasa"),
        tdPasa17 = trGranulometria.eq(17).find("td.pasa");


      //Variables de todos los td Finales
      var pasa0Var = parseFloat(tdPasa0.text()),
        pasa1Var = parseFloat(tdPasa1.text()),
        pasa2Var = parseFloat(tdPasa2.text()),
        pasa3Var = parseFloat(tdPasa3.text()),
        pasa4Var = parseFloat(tdPasa4.text()),
        pasa5Var = parseFloat(tdPasa5.text()),
        pasa6Var = parseFloat(tdPasa6.text()),
        pasa7Var = parseFloat(tdPasa7.text()),
        pasa8Var = parseFloat(tdPasa8.text()),
        pasa9Var = parseFloat(tdPasa9.text()),
        pasa10Var = parseFloat(tdPasa10.text()),
        pasa11Var = parseFloat(tdPasa11.text()),
        pasa12Var = parseFloat(tdPasa12.text()),
        pasa13Var = parseFloat(tdPasa13.text()),
        pasa14Var = parseFloat(tdPasa14.text()),
        pasa15Var = parseFloat(tdPasa15.text()),
        pasa16Var = parseFloat(tdPasa16.text()),
        pasa17Var = parseFloat(tdPasa17.text());

        
        //variables de los tamizes N4 , N200 
        Tamiz200Var = pasa17Var,
        tamiz4Var = pasa9Var,
        tamiz10Var = pasa10Var,
        tamiz40Var = pasa14Var;

        

        // td de resultados indice de grupo , tamizes 4 y 200 , clasificaciones sucs y aashto 
        var tdTamiz4 = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.tdTamiz4"),
          tdTamiz200 = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.tdTamiz200"),
          indiceGrupo = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.indiceGrupo"),
          tdLimiteLiquido = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.tdLimiteLiquido"),
          tdIndicePlasticidad = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.tdIndicePlaticidad");



        // tabla de observaciones 
        tD60 =$(this).closest("div").find("table.tablaobs").find("input.d60"), 
        tD30 =$(this).closest("div").find("table.tablaobs").find("input.d30"),  
        tD10 =$(this).closest("div").find("table.tablaobs").find("input.d10");

        var D60Var = parseFloat(tD60.val()), 
          D30Var = parseFloat(tD30.val()), 
          D10Var = parseFloat(tD10.val());

        // td tabla de clasificaciones 
        var clasSucs= $(this).closest("div").find("table.tablaClasificaciones").find("td.classSucs");
          clasAashto= $(this).closest("div").find("table.tablaClasificaciones").find("td.classAsshto");

        var LimiteLiquidoVar = parseFloat(tdLimiteLiquido.text()), 
          IndicePlasticidadVar = parseFloat(tdIndicePlasticidad.text());
          
        // asignando valores a las td de N4 y N200 

        isNaN(tamiz4Var) || tamiz4Var<0 ? tdTamiz4.text(0) : tdTamiz4.text(tamiz4Var); 
        isNaN(Tamiz200Var) || Tamiz200Var<0 ? tdTamiz200.text(0) : tdTamiz200.text(Tamiz200Var); 
        

        // input de resultados finales 
        var resultadoAashto= $(this).closest("div").find("form.resultadosGranulometria").find("input.aashto"),
          resultadoNotacionSucs= $(this).closest("div").find("form.resultadosGranulometria").find("input.notacionSucs"),
          resultadoDescripcionSucs= $(this).closest("div").find("form.resultadosGranulometria").find("input.descripcionSucs"),
          imagenPerfil = $(this).closest("div").find("form.resultadosGranulometria").find("input.imagenPerfil");


        // Ejecucion de clasificacion Sucs
        acciones.clasificacionSucs(Tamiz200Var,tamiz4Var,LimiteLiquidoVar,IndicePlasticidadVar,D60Var,D30Var,D10Var,clasSucs,resultadoNotacionSucs,resultadoDescripcionSucs,imagenPerfil);
        acciones.clasificacionAashto(tamiz10Var,tamiz40Var,Tamiz200Var,LimiteLiquidoVar,IndicePlasticidadVar,clasAashto,resultadoAashto,indiceGrupo);

        resultadoN4= $(this).closest("div").find("form.resultadosGranulometria").find("input.N4"),
        resultadoN10= $(this).closest("div").find("form.resultadosGranulometria").find("input.N10"),
        resultadoN40= $(this).closest("div").find("form.resultadosGranulometria").find("input.N40"),
        resultadoN200= $(this).closest("div").find("form.resultadosGranulometria").find("input.N200");


        resultadoN4.val(tamiz4Var),
        resultadoN10.val(tamiz10Var),
        resultadoN40.val(tamiz40Var),
        resultadoN200.val(Tamiz200Var);
        
          


        //td tamaño de tamiz en mn
        var tdTam0 = trGranulometria.eq(0).find("td.tamTamiz"),
          tdTam1 = trGranulometria.eq(1).find("td.tamTamiz"),
          tdTam2 = trGranulometria.eq(2).find("td.tamTamiz"),
          tdTam3 = trGranulometria.eq(3).find("td.tamTamiz"),
          tdTam4 = trGranulometria.eq(4).find("td.tamTamiz"),
          tdTam5 = trGranulometria.eq(5).find("td.tamTamiz"),
          tdTam6 = trGranulometria.eq(6).find("td.tamTamiz"),
          tdTam7 = trGranulometria.eq(7).find("td.tamTamiz"),
          tdTam8 = trGranulometria.eq(8).find("td.tamTamiz"),
          tdTam9 = trGranulometria.eq(9).find("td.tamTamiz"),
          tdTam10 = trGranulometria.eq(10).find("td.tamTamiz"),
          tdTam11 = trGranulometria.eq(11).find("td.tamTamiz"),
          tdTam12 = trGranulometria.eq(12).find("td.tamTamiz"),
          tdTam13 = trGranulometria.eq(13).find("td.tamTamiz"),
          tdTam14 = trGranulometria.eq(14).find("td.tamTamiz"),
          tdTam15 = trGranulometria.eq(15).find("td.tamTamiz"),
          tdTam16 = trGranulometria.eq(16).find("td.tamTamiz"),
          tdTam17 = trGranulometria.eq(17).find("td.tamTamiz");


        var tdTam0Var = parseFloat(tdTam0.text()),
          tdTam1Var = parseFloat(tdTam1.text()),
          tdTam2Var = parseFloat(tdTam2.text()),
          tdTam3Var = parseFloat(tdTam3.text()),
          tdTam4Var = parseFloat(tdTam4.text()),
          tdTam5Var = parseFloat(tdTam5.text()),
          tdTam6Var = parseFloat(tdTam6.text()),
          tdTam7Var = parseFloat(tdTam7.text()),
          tdTam8Var = parseFloat(tdTam8.text()),
          tdTam9Var = parseFloat(tdTam9.text()),
          tdTam10Var = parseFloat(tdTam10.text()),
          tdTam11Var = parseFloat(tdTam11.text()),
          tdTam12Var = parseFloat(tdTam12.text()),
          tdTam13Var = parseFloat(tdTam13.text()),
          tdTam14Var = parseFloat(tdTam14.text()),
          tdTam15Var = parseFloat(tdTam15.text()),
          tdTam16Var = parseFloat(tdTam16.text()),
          tdTam17Var = parseFloat(tdTam17.text());

        //grafica de granulometria
    // grafica de deformacion 
    var inputGraficaGranulometria = $(this).closest("div").find("input.datosgraficaGranulometria");    

    optimizadorGraficas++
    if(optimizadorGraficas==5){
      var datosGranulometria = 
      "["+parseFloat(tdTam17Var)+","+parseFloat(pasa17Var)+"]"
      +","+
      "["+parseFloat(tdTam16Var)+","+parseFloat(pasa16Var)+"]"
      +","+
      "["+parseFloat(tdTam15Var)+","+parseFloat(pasa15Var)+"]"
      +","+
      "["+parseFloat(tdTam14Var)+","+parseFloat(pasa14Var)+"]"
      +","+
      "["+parseFloat(tdTam13Var)+","+parseFloat(pasa13Var)+"]"
      +","+
      "["+parseFloat(tdTam12Var)+","+parseFloat(pasa12Var)+"]"
      +","+
      "["+parseFloat(tdTam11Var)+","+parseFloat(pasa11Var)+"]"
      +","+
      "["+parseFloat(tdTam10Var)+","+parseFloat(pasa10Var)+"]"
      +","+
      "["+parseFloat(tdTam9Var)+","+parseFloat(pasa9Var)+"]"
      +","+
      "["+parseFloat(tdTam8Var)+","+parseFloat(pasa8Var)+"]"
      +","+
      "["+parseFloat(tdTam7Var)+","+parseFloat(pasa7Var)+"]"
      +","+
      "["+parseFloat(tdTam6Var)+","+parseFloat(pasa6Var)+"]"
      +","+
      "["+parseFloat(tdTam5Var)+","+parseFloat(pasa5Var)+"]"
      +","+
      "["+parseFloat(tdTam4Var)+","+parseFloat(pasa4Var)+"]"
      +","+
      "["+parseFloat(tdTam3Var)+","+parseFloat(pasa3Var)+"]"
      +","+
      "["+parseFloat(tdTam2Var)+","+parseFloat(pasa2Var)+"]"
      +","+
      "["+parseFloat(tdTam1Var)+","+parseFloat(pasa1Var)+"]"
      +","+
      "["+parseFloat(tdTam0Var)+","+parseFloat(pasa0Var)+"]";

      var arrayGranulometria = eval("["+datosGranulometria+"]");
      
    var i = 0;
    var arrayGranulometriaFinal = new Array();
    while ( i < arrayGranulometria.length ) {

      if ( 0 != arrayGranulometria[i][0] && 0 != arrayGranulometria[i][1] ) {
        arrayGranulometriaFinal.push("["+arrayGranulometria[i]+"]");
      }
      i++;
    }


     inputGraficaGranulometria.val(arrayGranulometriaFinal).trigger('change');
     optimizadorGraficas = 0;
    } 
      
    }
  },

  clasificacionSucs: function (Tamiz200Var,tamiz4Var,LimiteLiquidoVar,IndicePlasticidadVar,D60Var,D30Var,D10Var,$clasSucs,$resultadoNotacionSucs,$resultadoDescripcionSucs,$imagenPerfil){

    

    console.log("Clasificacion de suelos SUCS");
    var notacionSucs = "N/A";
    var descSucs = " N/A";
    var imagen = "0";
    console.log(" Notacion sucs por defecto "+notacionSucs+" Descripcion Sucs por defecto "+descSucs);
    console.log("Tamiz 200 "+Tamiz200Var);
    console.log("Tamiz 4 "+tamiz4Var); 
    console.log("Limite liquido "+LimiteLiquidoVar); 
    console.log("IP "+IndicePlasticidadVar); 
    console.log("d60 "+D60Var); 
    console.log("d30 "+D30Var); 
    console.log("d10 "+D10Var); 

    if(Tamiz200Var!=undefined){

      var gravas = 100 - tamiz4Var, 
        arenas = tamiz4Var-Tamiz200Var,
        finos = Tamiz200Var;
      console.log("Porcentaje de gravas "+gravas);
      console.log("Porcentaje de arenas "+arenas);
      console.log("Porcentaje de finos "+finos);

      LineaA = (0.73*(LimiteLiquidoVar-20));
      console.log("La linea A es "+LineaA);

      var CU=0; 
      if(D60Var!=0 && D30Var!=0 && D10Var!=0){
        CU = D60Var/D10Var;
        console.log("El CU es : "+CU);
      }
      
      if(D60Var!=0 && D30Var!=0 && D10Var!=0){
        CC = (D30Var*D30Var)/(D10Var*D60Var);
        console.log("El CC es : "+CC);
      }

      var mayor = Math.max(gravas,arenas,finos);
      
      if(gravas==mayor){
        console.log("Las Gravas son mayores");
        Gravas();  
      } else if(arenas==mayor){
        console.log("Las Arenas son mayores");
        Arenas();
      } else if(finos==mayor){
        console.log("Los finos son mayores");
        Finos();
      }

    } else{
      
      $clasSucs.text("N/A");
    } 

    function Gravas(){
       console.log("Inicio de condicional de Gravas");
       notacionSucs= FinosNotacion();
       console.log("notacion finos para grava"+notacionSucs);
       if(finos<5){
         console.log("Finos menores que 5%");
         if(CU>=4 && CC>=1 && CC<=3){
           console.log("CU mayor a 4 y CC entre 1 y 3");
           notacionSucs="GW";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas>15){
             console.log("Arenas mayores que 15%");
             descSucs="Grava bien graduada";
             imagen = "gravas";
             console.log("Descripcion clasificacion Sucs : "+descSucs);

           }else if(arenas<=15){
             console.log("Arenas mayores o iguales a 15%");
             descSucs="Grava bien graduada con arena";
             imagen = "gravoso";
             console.log("Descripcion clasificacion Sucs : "+descSucs);    
           }

         } else if(CU<4 || (CC>1 && CC<3) ){
           console.log("CU menor que 4 y CC mayor que 1 y menor que 3");
           notacionSucs="GP";
           if(arenas>15){
             console.log("Arenas mayores que 15%");
             descSucs="Grava mal graduada";
             imagen = "gravas";
             console.log("Descripcion clasificacion Sucs : "+descSucs);

           }else if(arenas<=15){
             console.log("Arenas mayores o iguales a 15%");
             descSucs="Grava mal graduada con arena";
             imagen = "gravoso";
             console.log("Descripcion clasificacion Sucs : "+descSucs);    
           }
         }

       } else if(finos>=5 && finos<=12){
         console.log("Finos entre 5 y 12");  
         if(CU>=4 && CC>=1 && CC<=3){
           console.log("CU mayor a 4 y CC entre 1 y 3");
           if(notacionSucs=="MH" || notacionSucs=="ML"){
             notacionSucs="GW-GM";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava bien graduada con limo";
                imagen = "gravoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava bien graduada con limo y arena";
                imagen = "gravas";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }

           } else if (notacionSucs=="CL" || notacionSucs=="CH" || notacionSucs=="CL-ML"){
             notacionSucs="GW-GC";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava bien graduada con Arcilla (o Arcilla limosa)";
                imagen="arcillalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava bien graduada con Arcilla y Arena (o Arcilla limosa y arena)";
                imagen="arcillalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }

           } 
         } else if(CU>4 || (CC>1 && CC>3) ){
           console.log("CU menor que 4 y CC mayor que 1 y menor que 3");
           if(notacionSucs=="ML" || notacionSucs=="MH"){
             notacionSucs="GP-GM";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava mal graduada con limo";
                imagen="gravalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava mal graduada con limo y arena";
                imagen="gravalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }
           } else if(notacionSucs=="CL" || notacionSucs=="CH" || notacionSucs=="CL-ML"){
             notacionSucs="GP-GC";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava mal graduada con arcilla (o arcilla limosa)";
                imagen="arcillalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava mal graduada con arcilla y arena (o arcilla limosa con arena)";
                imagen="arcillalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }

           }

         }

       } else if(finos>12){
         console.log("Finos mayores que 12");
         if(notacionSucs=="ML" || notacionSucs=="MH"){
             notacionSucs="GM";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava limosa";
                imagen="gravalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava limosa con arena";
                imagen="gravalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }
           } else if(notacionSucs=="CL" || notacionSucs=="CH"){
             notacionSucs="GC";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava arcillosa";
                imagen="gravas";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava arcillosa con arena";
                imagen="gravoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }

           } else if(notacionSucs=="CL-ML"){
             notacionSucs="GC-GM";
             console.log("Notacion asignada "+notacionSucs);
             if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Grava limosa-arcillosa";
                imagen="gravalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Grava limosa-arcillosa con arena";
                imagen="arcillalimosa";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
             }
           } 
       }
       console.log("----Finalizacion de condicional gravas----");
       console.log("La notacion sucs es : "+notacionSucs+" y la descripcion es : "+descSucs);
       $clasSucs.text(notacionSucs+"-"+descSucs);

    }
    function Arenas(){

      console.log("Inicio de condicional de Arenas"); 
      notacionSucs= FinosNotacion();
      console.log("notacion finos para arenas"+notacionSucs);
      if(finos<5){
       console.log("Finos menores que 5%");
       if(CU>=6 && CC>=1 && CC<=3){
         console.log("CU mayor a 4 y CC entre 1 y 3");
         notacionSucs="SW";
         console.log("Notacion asignada "+notacionSucs);
         if(arenas>15){
           console.log("Arenas mayores que 15%");
           descSucs="Arena bien graduada";
           imagen="arena";
           console.log("Descripcion clasificacion Sucs : "+descSucs);

         }else if(arenas<=15){
           console.log("Arenas mayores o iguales a 15%");
           descSucs="Arena bien graduada con grava";
           imagen="arenoso";
           console.log("Descripcion clasificacion Sucs : "+descSucs);    
         }

       } else if(CU<6 || (CC>1 && CC<3) ){
         console.log("CU menor que 4 y CC mayor que 1 y menor que 3");
         notacionSucs="SP";
         if(arenas>15){
           console.log("Arenas mayores que 15%");
           descSucs="Arena mal graduada";
           imagen="arena";
           console.log("Descripcion clasificacion Sucs : "+descSucs);

         }else if(arenas<=15){
           console.log("Arenas mayores o iguales a 15%");
           descSucs="Arena mal graduada con grava";
           imagen="arenoso";
           console.log("Descripcion clasificacion Sucs : "+descSucs);    
         }
       }

      } else if(finos>=5 && finos<=12){
       console.log("Finos entre 5 y 12"); 
       if(CU>=6 && CC>=1 && CC<=3){
         console.log("CU mayor a 4 y CC entre 1 y 3");
         if(notacionSucs=="MH" || notacionSucs=="ML"){
           notacionSucs="SW-SM";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena bien graduada con limo";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena bien graduada con limo y grava";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }

         } else if (notacionSucs=="CL" || notacionSucs=="CH" || notacionSucs=="CL-ML"){
           notacionSucs="SW-SC";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena bien graduada con arcilla (o arcilla limosa)";
              imagen="arcillalimosa";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena bien graduaba con arcilla y grava (o arcilla limosa y grava)";
              imagen="arcillalimosa";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }

         } 
       } else if(CU>6 || (CC>1 && CC>3) ){
         console.log("CU menor que 4 y CC mayor que 1 y menor que 3");
         if(notacionSucs=="ML" || notacionSucs=="MH"){
           notacionSucs="SP-SM";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena mal graduada con limo";
              imagen="gravalimosa";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena mal graduada con limo y grava";
              imagen="gravalimosa";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }
         } else if(notacionSucs=="CL" || notacionSucs=="CH" || notacionSucs=="CL-ML"){
           notacionSucs="SP-SC";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena mal graduada con arcilla (o arcilla limosa)";
              imagen="arcillalimosa";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena mal grauada con arcilla y grava (o arcilla limosa y grava)";
              imagen="arcillalimosa";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }
         }
       }
      } else if(finos>12){
       console.log("Finos mayores que 12");
       if(notacionSucs=="ML" || notacionSucs=="MH"){
           notacionSucs="SM";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena limosa";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena limosa con grava";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }
         } else if(notacionSucs=="CL" || notacionSucs=="CH"){
           notacionSucs="SC";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena arcillosa";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena arcillosa con grava";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }

         } else if(notacionSucs=="CL-ML"){
           notacionSucs="SC-SM";
           console.log("Notacion asignada "+notacionSucs);
           if(arenas<15){
              console.log("arenas menores que 15");
              descSucs="Arena limosa-arcillosa";
              imagen="arenoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
            } else if(arenas>=15){
              console.log("arenas mayores o iguales a 15");
              descSucs="Arena limosa-arcillosa con grava";
              imagen="limogravoso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);
           }
         } 
      }
      console.log("----Finalizacion de condicional arenas----");
      console.log("La notacion sucs es : "+notacionSucs+" y la descripcion es : "+descSucs);
      $clasSucs.text(notacionSucs+"-"+descSucs);
      
    }
    function Finos(){

      
      console.log("Inicio de condicional de Finos");

      if(LimiteLiquidoVar<50){
        console.log("Limite liquido menor a 50");
        if(IndicePlasticidadVar>7 && IndicePlasticidadVar>=LineaA){
          console.log("IP es mayor que 7 y es mayor o igual a la linea A");
          notacionSucs="CL";
          console.log("Notacion asignada "+notacionSucs);
          if(Tamiz200Var<30){
            console.log("N200 menor a 30");
            if(Tamiz200Var<15){
              console.log("N200 menor a 15");
              descSucs="Arcilla fina";
              imagen="arcilloso";
              console.log("Descripcion clasificacion Sucs : "+descSucs);

            } else if(Tamiz200Var>15 && Tamiz200Var<29){
              console.log("N200 entre 15 y 29");
              if(arenas>=gravas){
                console.log("arenas mayores o iguales que gravas");
                descSucs="Arcilla fina con arena";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              } else if(arenas<gravas){
                console.log("arenas menores que gravas");
                descSucs="Arcilla fina con grava";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              }
            }
          }else if(Tamiz200Var>=30){
            console.log("N200 mayor o igual a 30");
            if(arenas>=gravas){
              console.log("arenas mayores o iguales que gravas");
              if(gravas<15){
                console.log("gravas menores que 15");
                descSucs="Arcilla fina arenosa";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(gravas>=15){
                console.log("gravas mayores o iguales a 15");
                descSucs="Arcilla fina arenosa con grava";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
              
            } else if(arenas<gravas){
              console.log("arenas menores que gravas");
              if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Arcilla fina gravosa";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Arcilla fina gravosa con arena";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
            }
          }

        } else if(IndicePlasticidadVar>=4 && IndicePlasticidadVar<=7 && IndicePlasticidadVar>=LineaA ){
          console.log("IP entre 4 y 7 y es mayor o igual a la linea A");
          notacionSucs="CL-ML";
          console.log("Notacion asignada "+notacionSucs);
          if(Tamiz200Var<30){
            console.log("N200 menor a 30");
            if(Tamiz200Var<15){
              console.log("N200 menor a 15");
              descSucs="Arcilla limosa";
              $imagen="arcilla";
              console.log("Descripcion clasificacion Sucs : "+descSucs);

            } else if(Tamiz200Var>15 && Tamiz200Var<29){
              console.log("N200 entre 15 y 29");
              if(arenas>=gravas){
                console.log("arenas mayores o iguales que gravas");
                descSucs="Arcilla limosa con arena";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              } else if(arenas<gravas){
                console.log("arenas menores que gravas");
                descSucs="Arcilla limosa con grava";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              }
            }
          }else if(Tamiz200Var>=30){
            console.log("N200 mayor o igual a 30");
            if(arenas>=gravas){
              console.log("arenas mayores o iguales que gravas");
              if(gravas<15){
                console.log("gravas menores que 15");
                descSucs="Arcilla areno-limosa";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(gravas>=15){
                console.log("gravas mayores o iguales a 15");
                descSucs="Arcilla areno-limosa con grava";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
              
            } else if(arenas<gravas){
              console.log("arenas menores que gravas");
              if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Arcilla gravosa limosa";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Arcilla gravosa-limosa con arena";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
            }

          }   

        } else if(IndicePlasticidadVar<4 || IndicePlasticidadVar<LineaA){
          console.log("IP menos que 4 y es menor que la linea A");
          notacionSucs="ML";
          console.log("Notacion asignada "+notacionSucs);

          if(Tamiz200Var<30){
            console.log("N200 menor a 30");
            if(Tamiz200Var<15){
              console.log("N200 menor a 15");
              descSucs="limo";
              imagen="limos";
              console.log("Descripcion clasificacion Sucs : "+descSucs);

            } else if(Tamiz200Var>15 && Tamiz200Var<29){
              console.log("N200 entre 15 y 29");
              if(arenas>=gravas){
                console.log("arenas mayores o iguales que gravas");
                descSucs="Limo con arcilla";
                imagen="limoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              } else if(arenas<gravas){
                console.log("arenas menores que gravas");
                descSucs="Limo con grava";
                imagen="limoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              }
            }
          }else if(Tamiz200Var>=30){
            console.log("N200 mayor o igual a 30");
            if(arenas>=gravas){
              console.log("arenas mayores o iguales que gravas");
              if(gravas<15){
                console.log("gravas menores que 15");
                descSucs="Limo arenoso";
                imagen="limos";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(gravas>=15){
                console.log("gravas mayores o iguales a 15");
                descSucs="Limo arenoso con grava";
                imagen="limoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
              
            } else if(arenas<gravas){
              console.log("arenas menores que gravas");
              if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Limo gravoso";
                imagen="limoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Limo gravoso con arena";
                imagen="limoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
            }

          } 
        }

      } else if(LimiteLiquidoVar>=50){
        console.log("Limite liquido mayor a 50");
        if(IndicePlasticidadVar>=LineaA){
          console.log("IP es mayor a la linea A");
          notacionSucs="CH";
          console.log("Notacion asignada "+notacionSucs);
          if(Tamiz200Var<30){
            console.log("N200 menor a 30");
            if(Tamiz200Var<15){
              console.log("N200 menor a 15");
              descSucs="Arcilla gruesa";
              imagen="arcilla";
              console.log("Descripcion clasificacion Sucs : "+descSucs);

            } else if(Tamiz200Var>15 && Tamiz200Var<29){
              console.log("N200 entre 15 y 29");
              if(arenas>=gravas){
                console.log("arenas mayores o iguales que gravas");
                descSucs="Arcilla gruesa con arena";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              } else if(arenas<gravas){
                console.log("arenas menores que gravas");
                descSucs="Arcilla gruesa con grava";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              }
            }
          }else if(Tamiz200Var>=30){
            console.log("N200 mayor o igual a 30");
            if(arenas>=gravas){
              console.log("arenas mayores o iguales que gravas");
              if(gravas<15){
                console.log("gravas menores que 15");
                descSucs="Arcilla gruesa arenosa";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(gravas>=15){
                console.log("gravas mayores o iguales a 15");
                descSucs="Arcilla gruesa arenosa con grava";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
              
            } else if(arenas<gravas){
              console.log("arenas menores que gravas");
              if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Arcilla gruesa gravosa";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Arcilla gruesa gravosa con arena";
                imagen="arcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
            }
          }

        } else if(IndicePlasticidadVar<LineaA){
          console.log("IP menor que la linea A");
          notacionSucs="MH";
          console.log("Notacion asignada "+notacionSucs);

          if(Tamiz200Var<30){
            console.log("N200 menor a 30");
            if(Tamiz200Var<15){
              console.log("N200 menor a 15");
              descSucs="Limo elástico";
              imagen="limos";
              console.log("Descripcion clasificacion Sucs : "+descSucs);

            } else if(Tamiz200Var>15 && Tamiz200Var<29){
              console.log("N200 entre 15 y 29");
              if(arenas>=gravas){
                console.log("arenas mayores o iguales que gravas");
                descSucs="Limo elástico con arena";
                imagen="limoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              } else if(arenas<gravas){
                console.log("arenas menores que gravas");
                descSucs="Limo elástico con grava";
                imagen="limogravoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);

              }
            }
          }else if(Tamiz200Var>=30){
            console.log("N200 mayor o igual a 30");
            if(arenas>=gravas){
              console.log("arenas mayores o iguales que gravas");
              if(gravas<15){
                console.log("gravas menores que 15");
                descSucs="Limo elástico arenoso";
                imagen="limoarcilloso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(gravas>=15){
                console.log("gravas mayores o iguales a 15");
                descSucs="Limo elástico arenoso con grava";
                imagen="limogravoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
              
            } else if(arenas<gravas){
              console.log("arenas menores que gravas");
              if(arenas<15){
                console.log("arenas menores que 15");
                descSucs="Limo elástico gravoso";
                imagen="limogravoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              } else if(arenas>=15){
                console.log("arenas mayores o iguales a 15");
                descSucs="Limo elástico gravoso con arena";
                imagen="limogravoso";
                console.log("Descripcion clasificacion Sucs : "+descSucs);
              }
            }

          } 
        }
      }

      console.log("----Finalizacion de condicional finos----");
      console.log("La notacion sucs es : "+notacionSucs+" y la descripcion es : "+descSucs);
      $clasSucs.text(notacionSucs+"-"+descSucs);
      $imagenPerfil.val(imagen);
      
    }
    function FinosNotacion(){

      console.log("Inicio de condicional de Finos");

      if(LimiteLiquidoVar<50){
        console.log("Limite liquido menor a 50");
        if(IndicePlasticidadVar>7 && IndicePlasticidadVar>=LineaA){
          console.log("IP es mayor que 7 y es mayor o igual a la linea A");
          notacionSucs="CL";
          console.log("Notacion asignada "+notacionSucs);

        } else if(IndicePlasticidadVar>=4 && IndicePlasticidadVar<=7 && IndicePlasticidadVar>=LineaA ){
          console.log("IP entre 4 y 7 y es mayor o igual a la linea A");
          notacionSucs="CL-ML";
          console.log("Notacion asignada "+notacionSucs);
            

        } else if(IndicePlasticidadVar<4 || IndicePlasticidadVar<LineaA){
          console.log("IP menos que 4 y es menor que la linea A");
          notacionSucs="ML";
          console.log("Notacion asignada "+notacionSucs);

           
        }

      } else if(LimiteLiquidoVar>=50){
        console.log("Limite liquido mayor a 50");
        if(IndicePlasticidadVar>=LineaA){
          console.log("IP es mayor a la linea A");
          notacionSucs="CH";
          console.log("Notacion asignada "+notacionSucs);
          

        } else if(IndicePlasticidadVar<LineaA){
          console.log("IP menos que 4 y es menor que la linea A");
          notacionSucs="MH";
          console.log("Notacion asignada "+notacionSucs);
        }
      }

      console.log("----Finalizacion de condicional  de determinacion de notacion de finos----");
      console.log("La notacion sucs es : "+notacionSucs);

      return notacionSucs;

    }
    
    // asignando resultados a cajas de resultados
    $resultadoNotacionSucs.val(notacionSucs),
    $resultadoDescripcionSucs.val(descSucs);

    

  }, clasificacionAashto: function(tamiz10Var,tamiz40Var,Tamiz200Var,LimiteLiquidoVar,IndicePlasticidadVar,$clasAashto,$resultadoAashto,$indiceGrupo){
   

    console.log("Clasificacion de suelos Aashto");
    var notacionAashto = "N/A";
    console.log(" Notacion Aashto por defecto es : "+notacionAashto);
    console.log("Tamiz 200 "+Tamiz200Var);
    console.log("Tamiz 10 "+tamiz10Var);
    console.log("Tamiz 40 "+tamiz40Var); 
    console.log("Limite liquido "+LimiteLiquidoVar);
    console.log("Indice de plasticidad : "+IndicePlasticidadVar);

    if(Tamiz200Var<=35){
      console.log("N200 es menor o igual a 35");
      if(IndicePlasticidadVar<=6 && LimiteLiquidoVar==undefined){
        if(tamiz10Var<=50 && tamiz40Var<=30 &&  Tamiz200Var<=15){
          notacionAashto="A-1a";  
          console.log("Notacion aashto asignada es : "+notacionAashto);
        } else if(tamiz40Var<=50 &&  Tamiz200Var<=25){
          notacionAashto="A-1b";  
          console.log("Notacion aashto asignada es : "+notacionAashto);
        }
      } else if(IndicePlasticidadVar==0 && LimiteLiquidoVar==undefined){
        notacionAashto="A-3";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar<=10 && LimiteLiquidoVar<=40 && Tamiz200Var<=35){
        notacionAashto="A-2-4";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar<=10 && LimiteLiquidoVar>=41 && Tamiz200Var<=35){
        notacionAashto="A-2-5";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar>=11 && LimiteLiquidoVar<=40 && Tamiz200Var<=35){
        notacionAashto="A-2-6";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar>=11 && LimiteLiquidoVar>=41 && Tamiz200Var<=35){
        notacionAashto="A-2-7";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      }
    } else if(Tamiz200Var>35){
      console.log("N200 es mayor a 35");
      if(IndicePlasticidadVar<=10 && LimiteLiquidoVar<=40 && Tamiz200Var>=36){
        notacionAashto="A-4";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar<=10 && LimiteLiquidoVar>=41 && Tamiz200Var>=36){
        notacionAashto="A-5";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar>=11 && LimiteLiquidoVar<=40 && Tamiz200Var>=36){
        notacionAashto="A-6";  
        console.log("Notacion aashto asignada es : "+notacionAashto);
      } else if(IndicePlasticidadVar>=11 && LimiteLiquidoVar>=41 && Tamiz200Var>=36){
        console.log("Notacion A-7, se define por ecuacion Ip menor o igual a Limite liquido - 30");
        if(IndicePlasticidadVar<=(LimiteLiquidoVar-30)){
          console.log("Ip menor o igual a limite liquido -30");
          notacionAashto="A-7-5";  
          console.log("Notacion aashto asignada es : "+notacionAashto);
        } else if(IndicePlasticidadVar>(LimiteLiquidoVar-30)){
          console.log("Ip mayor a limite liquido -30");
          notacionAashto="A-7-6";  
          console.log("Notacion aashto asignada es : "+notacionAashto);
        }
      }
    }

    var IndiceDeGrupo = undefined;
    if (parseFloat(IndicePlasticidadVar)<=0) {
      IndiceDeGrupo = 0; 
    } 
    else {
      if (notacionAashto=="A-2-6" || notacionAashto=="A-2-7") {
        IndiceDeGrupo = (parseFloat(Tamiz200Var)-15) * (IndicePlasticidadVar-10)*0.01;
      } else {
        IndiceDeGrupo = (parseFloat(Tamiz200Var)-35)*(0.2+0.005*(parseFloat(LimiteLiquidoVar)-40))+(parseFloat(Tamiz200Var)-15)*(parseFloat(IndicePlasticidadVar)-10)*(0.01);
      }
      if (IndiceDeGrupo<=0) {
        IndiceDeGrupo=0;
      }
    }
      
    console.log("----Finalizacion clasificación AASHTO----");
    console.log("La notacion Aashto es : "+notacionAashto);
    $clasAashto.text(notacionAashto);
    $resultadoAashto.val(notacionAashto);
    $indiceGrupo.text(IndiceDeGrupo);
    
  },

  Preimpresion: function(){
  
     var idProyectoImpresion = $("#idProyectoImpresion").val(), 
      idSondeoImpresion = $("#idSondeoImpresion").val(),
      numeroSondeo = $("#numeroSondeo").val(),
      checkLimites = $("input#checkLimites"),
      checkCompresion = $("input#checkCompresion"),
      checkGranulometria = $("input#checkGranulometria"),
      gerente = $("#gerente option:selected").val(),
      ingeniero = $("#responsable option:selected").val();

      if(checkLimites.is(':checked')){ boxLimites=1; } else{ boxLimites=0; }
      if(checkCompresion.is(':checked')){ boxCompresion=1; } else{ boxCompresion=0; }
      if(checkGranulometria.is(':checked')){ boxGranulometria=1; } else{ boxGranulometria=0; }
    var enlaceImpresion = $('a#enlaceImpresion');    

    enlaceImpresion.attr("href", "informe.php?idp="+idProyectoImpresion+"&ids="+idSondeoImpresion+"&numsondeo="+numeroSondeo+"&boxLim="+boxLimites+"&boxComp="+boxCompresion+"&boxGran="+boxGranulometria+"&Dir="+gerente+"&Ing="+ingeniero);
  },
  imprimir: function(){
    $(this).attr('target','_blank');  
  },
  seleccionTamizes: function(){
    var TamizSelected = $(this);
    var tamizRelacionado = TamizSelected.attr('rel');
    var TamizesSelected = $('.' +tamizRelacionado);

    if(TamizSelected.is(':checked')){

      TamizesSelected.attr('readonly', false);
      TamizesSelected.val('0');
    } else{
      
      TamizesSelected.attr('readonly', true);
      TamizesSelected.val('0');
    } 
  },
  selectAllTamizes: function(){
    

    var TamizSelected = $(this);

    var Alltamizes = $('.ChecksTamizes');
    var Allinput = $('.allTam');
    
    if(TamizSelected.is(':checked')){
      
      Alltamizes.attr('checked', true);
      Allinput.attr('readonly', false);

    } else{
      
      Alltamizes.attr('checked', false);
      Allinput.attr('readonly', true);
      Allinput.val('0');
      alertify.error(" <strong> Atención. </strong> Se establecerean los datos actuales a cero.");

    
    }
  },
  allTamLocked : function(){
    var Allinput = $('.allTam');  
    Allinput.attr('readonly', true);
  },
  CalcularMuestraSeca: function (){

    // Capturando el peso del recipiente 
    var TablaPesoRecipiente = $(this).closest("div").find("table.tablaanalisis").find("tbody").find("tr:first").children();
    var TextMuestraSeca = TablaPesoRecipiente.eq(1).find("input.analisis");
    
    var TxtMuestraHumeda = $(this).closest("div").find("input.calcularMuestraSeca");
    
    var TxTHumedadMuestraHumerda = $(this).closest("div").find("input.calcularMuestraSeca");
    var HumedadMuestra = TxTHumedadMuestraHumerda.attr('rel');

    // Calculo de muestra seca 
    if(isNaN(TxtMuestraHumeda.val()) || TxtMuestraHumeda.val()<0 ||  !TxtMuestraHumeda.val() || !HumedadMuestra || isNaN(HumedadMuestra) || HumedadMuestra<0 ) {
       
       alertify.set({ delay: 10000 });
       alertify.error(" <strong> Upss. </strong> No se pudo calcular, verifique si existe Humedad para esta muestra en la prueba de humedad y plasticidad natural."); 
    }else {
      //Determinando el numero de gramos de humedad 
      var GramosDeHumedad = parseFloat(TxtMuestraHumeda.val())  * parseFloat(HumedadMuestra) /100

      var ResultadoMuestraSeca = parseFloat(TxtMuestraHumeda.val()) - GramosDeHumedad

      TextMuestraSeca.val(ResultadoMuestraSeca.toFixed(2));
      TextMuestraSeca.focus();
      
      alertify.set({ delay: 10000 });
      alertify.success(" <strong> Muestra seca Calculada </strong> <br> El peso de la muestra seca + recipiente es : "+ResultadoMuestraSeca + " Gramos"); 


    } 

  }
    
}
$(document).on('ready', acciones.init);