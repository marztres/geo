var acciones = {
	
	init: function(){
		acciones.clicks();
	},
	
	clicks: function(){
		$('a[href="#"]').on( 'click', acciones.prevenirClickSinDestino );
		$("#enviar_usuario").on('click', acciones.guardarUsuario );
		$(".eliminar_usuario").on('click', acciones.eliminarUsuario );
		$('.editarUsuario').on('click', acciones.clickEditarUsuario);	
		$("#EnviarModificarUsuario").on('click', acciones.clickModificarUsuario);
		$("#Mod_Usuario").on('click', acciones.clickConfigurarUsuario);
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

	clickEditarUsuario: function (e) {
    e.preventDefault();
    var id = this.id,
        datos = this.rel;
    var datosusuarios = this.rel.split(',');
      idu = datosusuarios[0],
      cedula = datosusuarios[1],
      nombres = datosusuarios[2],
      apellidos = datosusuarios[3],
      cargo = datosusuarios[4],
      nombre_usuario = datosusuarios[5],
    $('#cedula').val(cedula);
    $('#nombres').val(nombres);
    $('#apellidos').val(apellidos);
    $('#cargo').val(cargo);
    $('#nombre_usuario').val(nombre_usuario);
    $('#id_usuario').val(idu);
  },

  clickModificarUsuario: function (e) {
    e.preventDefault();
    $post = $('#ModificarUsuarios');
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        $('#exito_modificar_usuario').removeClass('hide');
        setTimeout(function () {
          $("#exito_modificar_usuario").addClass("hide");
          location.reload();
        }, 3000);
        $(".limpiar").val('');
      } else {
        $('#respuesta_guardado').text(respuesta.mensaje);
        $('#error_modificar_usuario').removeClass('hide');
        setTimeout(function () {
          $("#error_modificar_usuario").addClass("hide");
        }, 3000);
      }
    }, 'json');
  },

  clickConfigurarUsuario: function (e) {
    e.preventDefault();
    $post = $('#ConfigurarUsuarios');
    $.post($post.attr('action'), $post.serialize(), function (respuesta) {
      if (respuesta.status === 'OK') {
        $('#exito_configurando_cuenta').removeClass('hide');
        setTimeout(function () {
          $("#exito_configurando_cuenta").addClass("hide");
          location.reload();
        }, 3000);
        $(".limpiar").val('');
      } else {
        $('#respuesta_guardado').text(respuesta.mensaje);
        $('#error_configurando_cuenta').removeClass('hide');
        setTimeout(function () {
          $("#error_configurando_cuenta").addClass("hide");
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