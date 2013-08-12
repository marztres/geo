var accionesFirma = {
	
	init: function(){
		accionesFirma.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', accionesFirma.prevenirClickSinDestino );
		$("#enviar_usuario").on('click', accionesFirma.guardarUsuario );
		$(".eliminar_firma").on('click', accionesFirma.eliminarUsuario );
		$('.editarFirma').on('click', accionesFirma.clickEditarUsuario);	
		$("#EnviarModificarUsuario").on('click', accionesFirma.clickModificarUsuario);
		$("#Mod_Usuario").on('click', accionesFirma.clickConfigurarUsuario);
	},
	
	prevenirClickSinDestino: function( e ) {
		e.preventDefault();
	},
	
	guardarFirma: function( e ) {
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

	eliminarFirma: function( e ) {
		e.preventDefault();
		$post = $(this).parent().find("form");
		if(confirm('Estas seguro que quieres eliminar esta Firma')) {
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
	
}

$(document).on( 'ready', accionesFirma.init );