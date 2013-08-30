var acciones = {

	iniciar : function() {
		acciones.eventos();
	},

	eventos : function() {
		$('a[href="#"]').on( 'click', acciones.prevenirClickSinDestino );
	  $('#enviarDatos').on('click', acciones.enviarDatos);
	},

	prevenirClickSinDestino: function( e ) {
		e.preventDefault();
	},

	enviarDatos :  function(e) {
		e.preventDefault();

		$.post($post.attr('action'), $post.serialize(), function(respuesta) {
			if (respuesta.status === 'OK') {
			
				
			} else {
			
				
			}
		}, 'json');
	} 
};
$(document).on('ready', acciones.iniciar);