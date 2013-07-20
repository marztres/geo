var acciones = {
	
	init: function(){
		acciones.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', acciones.prevenirClickSinDestino );
		$("#enviar_usuario").on('click', acciones.guardarUsuario );
		$(".eliminar_usuario").on('click', acciones.eliminarUsuario );
		

	},
	
	prevenirClickSinDestino: function( e ) {
		e.preventDefault();
	},
	
	guardarUsuario: function( e ) {
		e.preventDefault();
		$post = $('#datosUsuario');
		$.post($post.attr('action'), $post.serialize(), function(respuesta) {
			if (respuesta.status === 'OK') {
				$('#exito').removeClass('hide');
				setTimeout(function() {
					$("#exito").addClass("hide");
					location.reload();
				}, 3000);
				$(".limpiar").val('');
			} else {
				$('#respuesta_guardado').text(respuesta.mensaje);
				$('#error').removeClass('hide');
				setTimeout(function() {
					$("#error").addClass("hide");
				}, 3000);
			}
		}, 'json');
	},

	eliminarUsuario: function( e ) {
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
	}
	
}

$(document).on( 'ready', acciones.init );