var acciones = {
	
	init: function(){
		acciones.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', acciones.prevenirClickSinDestino );
		$("#enviar").on('click', acciones.guardarProyecto );
		$(".eliminarProyecto").on('click', acciones.eliminarProyecto );

	},
	
	prevenirClickSinDestino: function( e ) {
		e.preventDefault();
	},
	
	guardarProyecto: function( e ) {
		e.preventDefault();
		$post = $('#datosProyecto');
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
				alertify.set({ delay: 10000 });
				alertify.error(" <strong> Upss! Hubo un error. </strong> <br> Rectifica los datos y Ten en cuenta : <br> -Campos obligatorios : Codigo, nombre y Fecha. <br> -Codigo del proyecto repetido.");
				setTimeout(function() {
					$("#error").addClass("hide");
				}, 3000);
			}
		}, 'json');
	},


	eliminarProyecto: function( e ) {
		e.preventDefault();
		$post = $(this).parent().find("form");

		alertify.confirm("Esta seguro que desea eliminar este Proyecto", function (e) {
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
	}
}

$(document).on( 'ready', acciones.init );