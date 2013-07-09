var acciones = {
	
	init: function(){
		acciones.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', acciones.prevenirClickSinDestino );
		$('#btnModificarProyecto').on('click', acciones.modificarProyecto);
		$(".eliminarSondeo").on('click', acciones.eliminarSondeo );
		$("#lista_superficie").on('change',acciones.superficie);
		$("#btnnuevoSondeo").on('click',acciones.nuevoSondeo);
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
				setTimeout(function() {
					$("#errorModificarProyecto").addClass("hide");
				}, 3000);
			}
		}, 'json');

	},

	eliminarSondeo: function( e ) {
		e.preventDefault();
		$post = $(this).parent().find("form");
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
	},
	superficie: function(){
		var superficie = $(this).find("option:selected").val();
		if(superficie=="2"){
		  $("#profundidadSuperficie").val('');
		  $("#profundidadSuperficie").prop('disabled', false); 
		} else if(superficie=="1"){
		  $("#profundidadSuperficie").val('0');
		  $("#profundidadSuperficie").prop('disabled', true);  
		} else {
		  $("#profundidadSuperficie").val('');
		  $("#profundidadSuperficie").prop('disabled', true);  
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
				}, 3000);
			} else {
				console.log(respuesta.message);
				$('#errorNuevoSondeo').removeClass('hide');
				setTimeout(function() {
					$("#errorNuevoSondeo").addClass("hide");
				}, 3000);
			}
		}, 'json');
	},
	
}

$(document).on( 'ready', acciones.init );