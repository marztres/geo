var accionesFirma = {
	
	init: function(){
		accionesFirma.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', accionesFirma.prevenirClickSinDestino );
		$(".eliminarFirma").on('click', accionesFirma.eliminarFirma );
		$('.editarFirma').on('click', accionesFirma.editarFirma);	
	},
	
	prevenirClickSinDestino: function( e ) {
		e.preventDefault();
	},
	
	editarFirma: function(e){
		e.preventDefault();
        
    var datosRel = this.rel.split(',');
      idFirma = datosRel[0],
      persona = datosRel[1],
      tarjetaProfesional = datosRel[2],
      imagenFirma = datosRel[3];
    
    var mensaje =  $(this).closest('body').find('#editarFirma').find('#messageEditar');

    $('#idFirma').val(idFirma); 
    $('#editarPersona').val(persona);
    $('#editarTarjetaPro').val(tarjetaProfesional);
    $('#imagenActual').val(imagenFirma);

    mensaje.html("<img src="+imagenFirma+" class='img-rounded' height='200px' width='200px' />");


	},

	eliminarFirma: function( e ) {
		e.preventDefault();
		$post = $(this).parent().find("form");
		alertify.confirm("Esta seguro que desea eliminar este usuario", function (e) {
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

$(document).on( 'ready', accionesFirma.init );