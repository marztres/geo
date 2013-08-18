var accionesSondeos = {
	
	init: function(){
		accionesSondeos.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', accionesSondeos.prevenirClickSinDestino );
		$('#btnModificarProyecto').on('click', accionesSondeos.modificarProyecto);
		$(".eliminarSondeo").on('click', accionesSondeos.eliminarSondeo );
		$("#lista_superficie").on('change',accionesSondeos.superficie);
		$('#idSuperficie').on('change',accionesSondeos.editarSuperficie);
		$("#btnnuevoSondeo").on('click',accionesSondeos.nuevoSondeo);
		$("#enviar_modificar_sondeo").on('click',accionesSondeos.modificarSondeo);
	},
	
	prevenirClickSinDestino: function( e ) {
		e.preventDefault();
	},

	modificarProyecto: function( e ){
		e.preventDefault();
		$post = $("#modificarProyecto");
		$.post($post.attr('action'), $post.serialize(), function(respuesta) {
			if (respuesta.status === 'OK') {
				console.log(respuesta.message);
				$('#exitoModificarProyecto').removeClass('hide');
				setTimeout(function() {
					$("#exitoModificarProyecto").addClass("hide");
					location.reload();
				}, 3000);
			} else {
				console.log(respuesta.message);
				$('#errorModificarProyecto').removeClass('hide');
				alertify.set({ delay: 10000 });
				alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios : Codigo, nombre y Fecha. <br> -Codigo del proyecto repetido.");
				setTimeout(function() {
					$("#errorModificarProyecto").addClass("hide");
				}, 3000);
			}
		}, 'json');
	},

	modificarSondeo: function( e ){
		e.preventDefault();
		$post = $("#ModificarSondeo");
		$.post($post.attr('action'), $post.serialize(), function(respuesta) {
			if (respuesta.status === 'OK') {
				console.log(respuesta.message);
				$('#exito_modificar_sondeo').removeClass('hide');
				setTimeout(function() {
					$("#exito_modificar_sondeo").addClass("hide");
					location.reload();
				}, 3000);
			} else {
				console.log(respuesta.message);
				alertify.set({ delay: 10000 });
				alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios : Tipo de superficie y profundidad.");
				$('#error_modificar_sondeo').removeClass('hide');
				setTimeout(function() {
					$("#error_modificar_sondeo").addClass("hide");
				}, 3000);
			}
		}, 'json');
	},

	eliminarSondeo: function( e ) {
		e.preventDefault();
		$post = $(this).parent().find("form");
		
		alertify.confirm("Esta seguro que desea eliminar este Sondeo", function (e) {
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

	superficie: function(){
		var superficie = $(this).find("option:selected").val();
		if(superficie!="1"){
		  $("#profundidadSuperficie").val('');
		  $("#profundidadSuperficie").attr('readonly', false);
		} else if(superficie=="1"){
		  $("#profundidadSuperficie").val('0');
		  $("#profundidadSuperficie").attr('readonly', true);
		} else {
		  $("#profundidadSuperficie").val('');
		  $("#profundidadSuperficie").attr('readonly', true);
		}
	},

	editarSuperficie: function(){
		var superficie = $(this).find("option:selected").val(),
			profundidad = $('#editarProfundidadSuperficie').val();
		
		if(superficie!="1"){
		  $("#profundidadSuperficie").val(profundidad);
		  $("#profundidadSuperficie").attr('readonly', false);
		} else if(superficie=="1"){
		  $("#profundidadSuperficie").val('0');
		  $("#profundidadSuperficie").attr('readonly', true);
		} 
	},
	nuevoSondeo: function( e ) {
		e.preventDefault();
		$post = $('#nuevoSondeo');
		$.post($post.attr('action'), $post.serialize(), function(respuesta) {
			if (respuesta.status === 'OK') {
				console.log(respuesta.message);
			   	$('#exitoNuevoSondeo').removeClass('hide');
				setTimeout(function() {
					$("#exitoNuevoSondeo").addClass("hide");
					location.reload();
				}, 3000);
			} else {
				console.log(respuesta.message);
				alertify.set({ delay: 10000 });
				alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios : Tipo de superficie y profundidad.");
				$('#errorNuevoSondeo').removeClass('hide');
				setTimeout(function() {
					$("#errorNuevoSondeo").addClass("hide");
				}, 3000);
			}
		}, 'json');
	},
	
}

$(document).on( 'ready', accionesSondeos.init );