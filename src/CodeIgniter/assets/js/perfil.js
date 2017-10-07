$(document).ready(function() {

	$("input:submit").click(function() {
		event.preventDefault();
		var rta = confirm("¿Confirma los cambios en su perfil?")
		if (rta) {
			var ID = $("input[name='id_usuario']").val();
			var PERSONA = $("input[name='id_persona']").val();
			var NOMBRE = $("input[name='nombre']").val();
			var APELLIDO = $("input[name='apellido']").val();
			var DOCUMENTO = $("input[name='documento']").val();
			var EMAIL = $("input[name='email']").val();
			var URL_POST = $("form").attr("action");
			var posting = $.post( URL_POST, { id_usuario: ID, id_persona: PERSONA, nombre: NOMBRE, apellido: APELLIDO, documento: DOCUMENTO, email: EMAIL, Guardar: 1 } );
			posting.done(function() {
				alert("Cambios realizados con éxito");
			});
		}
	});

});