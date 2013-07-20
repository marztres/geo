
var optimizadorGraficas=0;
var acciones = {
  init: function () {
    acciones.clicks();
  },
  clicks: function () {
    $('a[href="#"]').on('click', acciones.prevenirClickSinDestino);
    $("#enviar_muestra").on('click', acciones.clickGuardarMuestra);
    $("#EnviarModificarMuestra").on('click', acciones.clickModificarMuestra);
    $('.modalMuestra').on('click', acciones.clickEditarMuestra);
    $('.guardaLimites').on('click', acciones.updateLimites);
    $('.limites').on('keyup', acciones.calculosLimites);
    $('.noplastico').on('click', acciones.noplastico);
    $('.noliquido').on('click', acciones.noliquido);
    $('.guardarGranulometria').on('click', acciones.updateGranulometria);
    $('.GuardarCompresion').on('click', acciones.clickGuardarCompresion);
    $('.icompresion,.ideformacion').on('keyup', acciones.calculosCompresion);
    $('.analisis,.granulo').on('keyup', acciones.calculosGranulometria);
  },

  updateLimites: function (e) {
    e.preventDefault();
    idFormularios = this.rel;
    $formularios = $('.' + idFormularios);
    $.each($formularios, function (index, formulario) {
      form = $(formulario);
      $.post(form.attr('action'), form.serialize(), function (respuesta) {
        console.log(respuesta);
      }, 'json');
    });

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
        $('#error_modificar_muestra').removeClass('hide');
        setTimeout(function () {
          $("#error_modificar_muestra").addClass("hide");
        }, 3000);
      }
    }, 'json');
  },

  clickEditarMuestra: function (e) {
    e.preventDefault();
    var id = this.id,
      datos = this.rel;
    var profundidades = this.rel.split(','),
      idm = profundidades[0],
      pinicial = profundidades[1],
      pfinal = profundidades[2],
      descripcionm = profundidades[3],
      material_de_relleno = profundidades[4],
      num_golpes = profundidades[5];
    if (material_de_relleno == 1) {
      $('#material_de_relleno').prop('checked', true);
    } else {
      $('#material_de_relleno').prop('checked', false);
    }
    $('#descripcion_modificarm').val(descripcionm);
    $('#profundidad_inicial_modificar').val(pinicial);
    $('#profundidad_final_modificar').val(pfinal);
    $('#numero_golpes_modificar').val(num_golpes);
    $('#id_muestra_modificar').val(idm);
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
        sueloSeco = parseFloat(sueloSeco1.val()),

        //calculos horizontales tabla liquido
        pesoSuelo = sueloSeco - pesoCapsula,
        pesoAgua = sueloHumedo - sueloSeco,
        contenidoAgua = (pesoAgua/pesoSuelo)*100,
        
        //columnas de resultados horiazontales
        tdPesoSuelo = tdHijos.eq(6).text(pesoSuelo.toPrecision(4)),
        tdPesoAgua = tdHijos.eq(7).text(pesoAgua.toPrecision(4)),
        tdContenidoAgua = tdHijos.eq(8).text(contenidoAgua.toPrecision(4));

      var total = parseFloat(tdFinal1.text()) + parseFloat(tdFinal2.text()) + parseFloat(tdFinal3.text());
      tdFinal4.text(total.toPrecision(4));

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
      sueloSeco = parseFloat(sueloSeco1.val()),

      //calculos horizontales tablas humedad natural y plastico
      pesoSuelo = sueloSeco - pesoCapsula,
      pesoAgua = sueloHumedo - sueloSeco,
      contenidoAgua = (pesoAgua/pesoSuelo)*100,

      //columnas de resultados horiazontales
      tdPesoSuelo = tdHijos.eq(5).text(pesoSuelo.toPrecision(4)),
      tdPesoAgua = tdHijos.eq(6).text(pesoAgua.toPrecision(4)),
      tdContenidoAgua = tdHijos.eq(7).text(contenidoAgua.toPrecision(4));
      
     

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

        var HumedadNatural;
        //humedad calculando el promedio
        var menorhumedad1 = Math.min(tdFinalHumedad1Var,tdFinalHumedad2Var),
          mayorhumedad1 = Math.max(tdFinalHumedad1Var,tdFinalHumedad2Var),  
          divisionMayorMenor1H=mayorhumedad1/menorhumedad1;
          if(divisionMayorMenor1H<1.29){
            HumedadNatural= (mayorhumedad1+menorhumedad2)/2
          }
        var menorhumedad2 = Math.min(tdFinalHumedad2Var,tdFinalHumedad3Var),
          mayorhumedad2 = Math.max(tdFinalHumedad2Var,tdFinalHumedad3Var),  
          divisionMayorMenor2H=mayorhumedad2/menorhumedad2;
          if(divisionMayorMenor2H<1.29){
            HumedadNatural= (mayorhumedad2+menorhumedad2)/2
          }
        var menorhumedad3 = Math.min(tdFinalHumedad1Var,tdFinalHumedad3Var),
          mayorhumedad3 = Math.max(tdFinalHumedad1Var,tdFinalHumedad3Var),  
          divisionMayorMenor3H=mayorhumedad3/menorhumedad3;
          if(divisionMayorMenor3H<1.29){
            HumedadNatural= (mayorhumedad3+menorhumedad3)/2
          }
          if(divisionMayorMenor1H>1.29 && divisionMayorMenor2H>1.29 && divisionMayorMenor3H>1.29 ){
            HumedadNatural=0;  
          }

        var FinalHumedadNatural=Math.round(HumedadNatural)

        tdFinalHumedad4.text(FinalHumedadNatural.toPrecision(4));

//        liquido calculando el promedio

//               x1             y1
//        (tdgolpes1Var,tdFinalLiquido1Var)
//               x2             y2
//        (tdgolpes2Var,tdFinalLiquido2Var)
//               x3             y3
//        (tdgolpes3Var,tdFinalLiquido3Var)
        
        var pendiente1=(tdFinalLiquido2Var-tdFinalLiquido1Var)/(tdgolpes2Var-tdgolpes1Var),
          pendiente2=(tdFinalLiquido3Var-tdFinalLiquido1Var)/(tdgolpes3Var-tdgolpes1Var),
          pendiente3=(tdFinalLiquido3Var-tdFinalLiquido2Var)/(tdgolpes3Var-tdgolpes2Var);

        var limite1=(pendiente1*25)-(pendiente1*tdgolpes1Var)+(tdFinalLiquido1Var),
          limite2=(pendiente2*25)-(pendiente2*tdgolpes3Var)+(tdFinalLiquido3Var),
          limite3=(pendiente3*25)-(pendiente3*tdgolpes2Var)+(tdFinalLiquido2Var);

        LimiteLiquido=(limite1+limite2+limite3)/3;

        var FinalLimiteLiquido=Math.round(LimiteLiquido);
        tdFinalLiquido4.text(FinalLimiteLiquido.toPrecision(4));

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


        var FinalLimitePlastico=Math.round(LimitePlastico);
        

        tdFinalPlastico4.text(FinalLimitePlastico.toPrecision(4));
          
      


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

      InputHumedadFinal.val(humedadVar.toPrecision(4)),
      InputLimiteLiquidoFinal.val(liquidoVar.toPrecision(4)),
      InputLimitePlasticoFinal.val(plasticoVar.toPrecision(4)),
      InputIndicePlasticidad.val(liquidoVar.toPrecision(4) - plasticoVar.toPrecision(4));


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
      resultadoHumedad.text(humedadVar.toPrecision(4));
    }

    if (plasticoVar == null) {
      resultadoPlastico.text("N/A");
    } else if (plasticoVar <= 0) {
      resultadoPlastico.text("NP");
    } else {
      resultadoPlastico.text(plasticoVar.toPrecision(4));
    }

    if (liquidoVar == null) {
      resultadoliquido.text("N/A");
    } else if (liquidoVar <= 0) {
      resultadoliquido.text("NL");
    } else {
      resultadoliquido.text(liquidoVar.toPrecision(4));
    }

    if (liquidoVar == null || plasticoVar == null) {
      resultadoIndicePlasticidad.text("N/A");
    } else {
      indicePlasticidad = liquidoVar.toPrecision(4) - plasticoVar.toPrecision(4);
      resultadoIndicePlasticidad.text(indicePlasticidad.toPrecision(4));
    }

  },
  noplastico: function (e) {
    e.preventDefault();
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

      InputHumedadFinal.val(humedadVar.toPrecision(4)),
      InputLimiteLiquidoFinal.val(liquidoVar.toPrecision(4)),
      InputLimitePlasticoFinal.val(plasticoVar.toPrecision(4)),
      InputIndicePlasticidad.val(liquidoVar.toPrecision(4) - plasticoVar.toPrecision(4));  

    if (humedadVar == null || humedadVar <= 0) {
      resultadoHumedad.text("N/A");
    } else {
      resultadoHumedad.text(humedadVar.toPrecision(4));
    }

    if (plasticoVar == null) {
      resultadoPlastico.text("N/A");
    } else if (plasticoVar <= 0) {
      resultadoPlastico.text("NP");
    } else {
      resultadoPlastico.text(plasticoVar.toPrecision(4));
    }

    if (liquidoVar == null) {
      resultadoliquido.text("N/A");
    } else if (liquidoVar <= 0) {
      resultadoliquido.text("NL");
    } else {
      resultadoliquido.text(liquidoVar.toPrecision(4));
    }

    if (liquidoVar == null || plasticoVar == null) {
      resultadoIndicePlasticidad.text("N/A");
    } else {
      indicePlasticidad = liquidoVar.toPrecision(4) - plasticoVar.toPrecision(4);
      resultadoIndicePlasticidad.text(indicePlasticidad.toPrecision(4));
    }
  },
  noliquido: function (e) {
    e.preventDefault();
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

    inputGrafica.val("["+parseFloat(tdgolpes1Var)+","+parseFloat(tdFinalLiquido1Var)+"]"+","+"["+parseFloat(tdgolpes2Var)+","+parseFloat(tdFinalLiquido2Var)+"]"+","+"["+parseFloat(tdgolpes3Var)+","+parseFloat(tdFinalLiquido3Var)+"]").trigger('change');  


      //Input hidden de resultados 
    var InputHumedadFinal = $(this).closest("div").find("form.formResultados").find("input.HumedadNaturalFinal"),
      InputLimiteLiquidoFinal= $(this).closest("div").find("form.formResultados").find("input.LimiteLiquidoFinal"),
      InputLimitePlasticoFinal= $(this).closest("div").find("form.formResultados").find("input.LimitePlasticoFinal"),
      InputIndicePlasticidad= $(this).closest("div").find("form.formResultados").find("input.IndicePlasticidadFinal");

      InputHumedadFinal.val(humedadVar.toPrecision(4)),
      InputLimiteLiquidoFinal.val(liquidoVar.toPrecision(4)),
      InputLimitePlasticoFinal.val(plasticoVar.toPrecision(4)),
      InputIndicePlasticidad.val(liquidoVar.toPrecision(4) - plasticoVar.toPrecision(4));

    if (humedadVar == null || humedadVar <= 0) {
      resultadoHumedad.text("N/A");
    } else {
      resultadoHumedad.text(humedadVar.toPrecision(4));
    }

    if (plasticoVar == null) {
      resultadoPlastico.text("N/A");
    } else if (plasticoVar <= 0) {
      resultadoPlastico.text("NP");
    } else {
      resultadoPlastico.text(plasticoVar.toPrecision(4));
    }

    if (liquidoVar == null) {
      resultadoliquido.text("N/A");
    } else if (liquidoVar <= 0) {
      resultadoliquido.text("NL");
    } else {
      resultadoliquido.text(liquidoVar.toPrecision(4));
    }

    if (liquidoVar == null || plasticoVar == null) {
      resultadoIndicePlasticidad.text("N/A");
    } else {
      indicePlasticidad = liquidoVar.toPrecision(4) - plasticoVar.toPrecision(4);
      resultadoIndicePlasticidad.text(indicePlasticidad.toPrecision(4));
    }
  },
  updateGranulometria: function (e) {
      e.preventDefault();
      var idFormulario = this.rel;
      $post = $('.' + idFormulario);
      $.post($post.attr('action'), $post.serialize(), function (respuesta) {
        if (respuesta.status === 'OK') {

        } else {

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
      } else {
        console.log(respuesta.message);
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
      volumen = tdCompresion.eq(5);

    //variables con resultados
    diametroVar = parseFloat(diametro.val());
    alturaVar = parseFloat(altura.val());
    pesoVar = parseFloat(pesoGr.val());
    areaVar = (Math.PI * (diametroVar * diametroVar)) / 4;
    volumenVar = (areaVar * alturaVar);
    pesoUnitarioVar = (pesoVar / volumenVar) * 10;

    area.text(areaVar.toPrecision(4));
    volumen.text(volumenVar.toPrecision(4));

    // elementos y calculos horizontales tabla de deformacion   
    if ($(this).hasClass("ideformacion")) {
      var calculosFila = $(this).parent().parent().children();

      var deformacion = calculosFila.eq(0),
        carga = calculosFila.eq(1).find("input"),
        deformacionTotal = calculosFila.eq(2),
        cargaKg = calculosFila.eq(3),
        areaCorregida = calculosFila.eq(4),
        esfuerzo = calculosFila.eq(5);

      if (carga.val() > 0) {
        var deformacionTotalVar = (parseFloat(deformacion.text()) * 2.54) / 1000;
      } else {
        var deformacionTotalVar = 0;
      }
      if (carga.val() > 0) {
        var cargaKgVar = carga.val() / 10;
      } else {
        var cargaKgVar = 0;
      }
      if (carga.val() > 0) {
        var areaCorregidaVar = (areaVar / (1 - (deformacionTotalVar / parseFloat(altura.val()))));
      } else {
        var areaCorregidaVar = 0;
      }
      if (carga.val() > 0) {
        var esfuerzoVar = parseFloat(cargaKgVar) / areaCorregidaVar;
      } else {
        var esfuerzoVar = 0;
      }
      deformacionTotal.text(deformacionTotalVar.toPrecision(2));
      cargaKg.text(cargaKgVar.toPrecision(2));
      areaCorregida.text(areaCorregidaVar.toPrecision(4));
      esfuerzo.text(esfuerzoVar.toPrecision(2));
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


    resultadoDiametro.text(diametroVar.toPrecision(4));
    resultadoAltura.text(alturaVar.toPrecision(4));
    resultadoPeso.text(pesoVar.toPrecision(4));
    resultadoPesoUnitario.text(pesoUnitarioVar.toPrecision(4));
    resultadoCohesion.text(cohesionVar.toPrecision(4));
    resultadoTipoFalla.text(tipoFalla.val());
    resultadoArea.text(areaVar.toPrecision(4));
    resultadoVolumen.text(volumenVar.toPrecision(4));
    resultadoCohesion.text(cohesionVar.toPrecision(4));

    //asignacion de variables a inputs resultados
    InputCohesionFinal.val(cohesionVar.toPrecision(4)),
    InputPesoUnitarioFinal.val(pesoUnitarioVar.toPrecision(4));
  },
  calculosGranulometria: function(){
    //tabla de pesos
    var trGranulometria = $(this).closest("div").find("table.tablapesos").find("tbody").children();

   
    
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
          tr16 = trGranulometria.eq(15).children();
         
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
        tdReT15=tr15.eq(2),
        tdReT16=tr16.eq(2);

      // Variables de pesos retenidos   
      var pesoRet1Var= parseFloat(tdReT1.val()),
        pesoRet2Var= parseFloat(tdReT2.val()),
        pesoRet3Var= parseFloat(tdReT3.val()),
        pesoRet4Var= parseFloat(tdReT4.val()),
        pesoRet5Var= parseFloat(tdReT5.val()),
        pesoRet6Var= parseFloat(tdReT6.val()),
        pesoRet7Var= parseFloat(tdReT7.val()),
        pesoRet8Var= parseFloat(tdReT8.val()),
        pesoRet9Var= parseFloat(tdReT9.val()),
        pesoRet10Var= parseFloat(tdReT10.val()),
        pesoRet11Var= parseFloat(tdReT11.val()),
        pesoRet12Var= parseFloat(tdReT12.val()),
        pesoRet13Var= parseFloat(tdReT13.val()),
        pesoRet14Var= parseFloat(tdReT14.val());

        //Sumatoria Pesos Retenidos
        var todosPesosRetenidos= pesoRet1Var+pesoRet2Var+pesoRet3Var+pesoRet4Var+pesoRet5Var+pesoRet6Var+pesoRet7Var+pesoRet8Var+pesoRet9Var+pesoRet10Var+pesoRet11Var+pesoRet12Var+pesoRet13Var+pesoRet14Var;

      //td fondo corregido y total corregido  
      var fondoRetenidoCorregido=tr15.eq(3),
        totalRetenidoCorregido= tr16.eq(3); 

      //td fondo RETENIDO % 
      var fondoRetenido=tr15.eq(4);

      //td fondo RETENIDO % 
      var fondoRetenidoAcumulado=tr15.eq(5);

      //td fondo pasa
      var fondoPasa=tr15.eq(6);
      
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
    
    pesoMuestraSecaVar=pesoRecipienteMasMuestraVar-pesoRecipienteVar,
    pesoRetenidoN200MasRecipienteVar=todosPesosRetenidos+pesoRecipienteVar,
    pesoRetenidoN200Var=pesoRetenidoN200MasRecipienteVar-pesoRecipienteVar,
    sumaPesoRetenidosVar=parseFloat(todosPesosRetenidos);

      //resultados y calculos tabla analisis 
      
      pesoMuestraSeca.text(pesoMuestraSecaVar.toPrecision(4)),
      pesoRetenidoN200MasRecipiente.text(pesoRetenidoN200MasRecipienteVar.toPrecision(4)),
      pesoRetenidoN200.text(pesoRetenidoN200Var.toPrecision(4)),
      sumaPesoRetenidos.text(sumaPesoRetenidosVar.toPrecision(4)); 



      //Fondos y totales
      fondoRetVar= pesoRecipienteMasMuestraVar-pesoRetenidoN200MasRecipienteVar,
      totalRetVar= sumaPesoRetenidosVar+fondoRetVar;

      tdReT15.text(fondoRetVar.toPrecision(4)),
      tdReT16.text(totalRetVar.toPrecision(4));


      //variables fondo corredigo y total Corregido 
      var  fondoRetenidoCorregidoVar= fondoRetVar-((sumaPesoRetenidosVar-pesoRetenidoN200Var )*(fondoRetVar/sumaPesoRetenidosVar)) ,
        totalRetenidoCorregidoVar= totalRetVar-((sumaPesoRetenidosVar-pesoRetenidoN200Var)*(totalRetVar/sumaPesoRetenidosVar));


      fondoRetenidoCorregido.text(fondoRetenidoCorregidoVar.toPrecision(4));    
      totalRetenidoCorregido.text(totalRetenidoCorregidoVar.toPrecision(4));

      //variable fondo retenido 
      var fondoRetenidoVar=((fondoRetenidoCorregidoVar/totalRetenidoCorregidoVar)*100);
        fondoRetenido.text(fondoRetenidoVar.toPrecision(4));  



      //Calculos Horizontales tabla pesos retenidos
      if ($(this).hasClass("granulo")) {
        var calculosFila = $(this).parent().parent().children();

        var pesoRetenido = calculosFila.eq(2).find("input"),
          retenidoCorregido = calculosFila.eq(3),
          retenido = calculosFila.eq(4),
          retenidoAcumulado = calculosFila.eq(5),
          pasa = calculosFila.eq(6);
        
        var pesoRetenidoVar = parseFloat(pesoRetenido.val()),
          retenidoCorregidoVar = (pesoRetenidoVar-((sumaPesoRetenidosVar-pesoRetenidoN200Var)*(pesoRetenidoVar/pesoRetenidoN200Var))),
          retenidoVar = (retenidoCorregidoVar/totalRetenidoCorregidoVar)*100;
          
        retenidoCorregido.text(retenidoCorregidoVar.toPrecision(4));
        

        retenido.text(retenidoVar.toPrecision(4));
        
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
      tdFinal14 = trGranulometria.eq(14).find("td.acumulado");
 


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
        FondoFinalVar = parseFloat(tdFinal4.text());

        //tds Pasa %
        var tdPasa0 = trGranulometria.eq(0).find("td:last"),
          tdPasa1 = trGranulometria.eq(1).find("td:last"),
          tdPasa2 = trGranulometria.eq(2).find("td:last"),
          tdPasa3 = trGranulometria.eq(3).find("td:last"),
          tdPasa4 = trGranulometria.eq(4).find("td:last"),
          tdPasa5 = trGranulometria.eq(5).find("td:last"),
          tdPasa6 = trGranulometria.eq(6).find("td:last"),
          tdPasa7 = trGranulometria.eq(7).find("td:last"),
          tdPasa8 = trGranulometria.eq(8).find("td:last"),
          tdPasa9 = trGranulometria.eq(9).find("td:last"),
          tdPasa10 = trGranulometria.eq(10).find("td:last"),
          tdPasa11 = trGranulometria.eq(11).find("td:last"),
          tdPasa12 = trGranulometria.eq(12).find("td:last"),
          tdPasa13 = trGranulometria.eq(13).find("td:last");


          


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
        pasa13Var = parseFloat(tdPasa13.text());

        //variables de los tamizes N4 , N200 

       

        // td de resultados indice de grupo , tamizes 4 y 200 , clasificaciones sucs y aashto 
        var tdTamiz4 = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.tdTamiz4"),
          tdTamiz200 = $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.tdTamiz200"),
          indiceGrupo= $(this).closest("div").find("table.tablaResultadosGranulometria").find("td.indiceGrupo");

        // td tabla de clasificaciones 
        var clasSucs= $(this).closest("div").find("table.tablaClasificaciones").find("td.classSucs");
          clasAashto= $(this).closest("div").find("table.tablaClasificaciones").find("td.classAsshto");

        // asignando valores a las td de N4 y N200 
        
        tdTamiz4.text(fin7Var);
        tdTamiz200.text(fin12Var);  



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
          tdTam13 = trGranulometria.eq(13).find("td.tamTamiz");


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
          tdTam13Var = parseFloat(tdTam13.text()); 

        //grafica de granulometria
    // grafica de deformacion 
    var inputGraficaGranulometria = $(this).closest("div").find("input.datosgraficaGranulometria");    

    optimizadorGraficas++
    if(optimizadorGraficas==5){
      var datosGranulometria = 
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
      tdRetenido14 = trGranulometria.eq(14).find("td.retenido");
 

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
        tdRetenido14Var = parseFloat(tdRetenido14.text());

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
      acumulado14=tdRetenido14Var+fin13Var;

      //asignacion a la tabla
      tdFinal0.text(acumulado0.toPrecision(4)),
      tdFinal1.text(acumulado1.toPrecision(4)),
      tdFinal2.text(acumulado2.toPrecision(4)),
      tdFinal3.text(acumulado3.toPrecision(4)),
      tdFinal4.text(acumulado4.toPrecision(4)),
      tdFinal5.text(acumulado5.toPrecision(4)),
      tdFinal6.text(acumulado6.toPrecision(4)),
      tdFinal7.text(acumulado7.toPrecision(4)),
      tdFinal8.text(acumulado8.toPrecision(4)),
      tdFinal9.text(acumulado9.toPrecision(4)),
      tdFinal10.text(acumulado10.toPrecision(4)),
      tdFinal11.text(acumulado11.toPrecision(4)),
      tdFinal12.text(acumulado12.toPrecision(4)),
      tdFinal13.text(acumulado13.toPrecision(4)),
      tdFinal14.text(acumulado14.toPrecision(4));
        // Fin calculos acumulados
      
      // Calculos de pasa %  
      retenidoAcumuladoVar = parseFloat(retenidoAcumulado.text()),
      pasaVar = 100-retenidoAcumuladoVar;
      pasa.text(pasaVar.toPrecision(4));
      
      //variable fondo retenido 
      var fondoRetenidoAcumuladoVar=parseFloat(fondoRetenidoAcumulado.text());

      //Variable  fondo pasa
      var fondoPasaVar=100-fondoRetenidoAcumuladoVar;
      fondoPasa.text(fondoPasaVar.toPrecision(4));
    
      }




  },

  clasificacionAASHTO: function(){


    
  }

}
$(document).on('ready', acciones.init);