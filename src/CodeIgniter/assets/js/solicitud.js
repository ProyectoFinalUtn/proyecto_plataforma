$(document).ready(function() {

	$("input:submit").click(function() {
		event.preventDefault();
		var rta = confirm("¿Confirma que desea procesar la solicitud?")
		if (rta) {
			var ID = $("input[name='idSolicitud']").attr("value");
			var ESTADO = $("select[name='estadoNuevo']").val();
			var ADMIN = $("input[name='usuarioAprobador']").attr("value");
			var URL_POST = $("form").attr("action");
			var posting = $.post( URL_POST, { idSolicitud: ID, estadoNuevo: ESTADO, usuarioAprobador: ADMIN, Procesar: 1 } );
			posting.done(function() {
				alert("Solicitud procesada con éxito!");
				var URL = "Listar_solicitudes";
				$(location).attr('href', URL);
			});
		}
	});

});