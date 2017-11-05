$(document).ready(function() {
	
	bootbox.setDefaults({ backdrop: false });
	
	$("input:submit").click(function() {
		event.preventDefault();
		bootbox.confirm({
			message: "¿Confirma que desea procesar la solicitud?",
			buttons: {
				confirm: {
					label: 'Si'
				},
				cancel: {
					label: 'No'
				}
			},
			callback: function (rta) {
				if (rta) {
					var ID = $("input[name='idSolicitud']").attr("value");
					var ESTADO = $("select[name='estadoNuevo']").val();
					var ADMIN = $("input[name='usuarioAprobador']").attr("value");
					var URL_POST = $("form").attr("action");
					var posting = $.post( URL_POST, { idSolicitud: ID, estadoNuevo: ESTADO, usuarioAprobador: ADMIN, Procesar: 1 } );
					posting.done(function() {
						bootbox.alert("Solicitud procesada con éxito!",
							function(){
								var URL = "Listar_solicitudes";
								$(location).attr('href', URL);
							}
						);
					});
				}
			}
		});
	});

});