$(document).ready(function() {

	$("input:submit").click(function() {
		event.preventDefault();
		$("div.errorMsg").remove();
		
		var ok = true;
		if ($("input[name='nombre']").val() == '') {
			$("div.form-group[id='nombre']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if ($("input[name='apellido']").val() == '') {
			$("div.form-group[id='apellido']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if ($("input[name='email']").val() == '') {
			$("div.form-group[id='email']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if ($("input[name='password']").val() != '') {
			if ($("input[name='repeatPassword']").val() == '') {
				$("div.form-group[id='repeatPassword']").append('<div class="errorMsg"><b>Por favor, repita la contraseña nueva</b></div>');
				ok = false;
			}
		}
		if ($("input[name='password']").val() == '') {
			if ($("input[name='repeatPassword']").val() != '') {
				$("div.form-group[id='password']").append('<div class="errorMsg"><b>Por favor, repita la contraseña nueva</b></div>');
				ok = false;
			}
		}
		if (ok) {
			var CONTRA = hex_md5($("input[name='password']").val());
			var REPEAT = hex_md5($("input[name='repeatPassword']").val());
			if(CONTRA != REPEAT) {
				alert('Revise su contraseña, la misma no coincide con la repetición');
			} else {
				var MAIL = $("input[name='email']").val();
				var OLD_MAIL = $("input[name='mailGuardado']").val();
				if (MAIL != OLD_MAIL) {
					var URL_POST = $("form").attr("action");
					var posting = $.post( URL_POST, { email: MAIL, CheckMail: 1 } );
					posting.done(function(data) {
						if (data == 'true') {
							alert('Ya existe un usuario registrado con ese correo electrónico. Elija otro distinto');
						} else {
							var rta = confirm("¿Confirma los cambios en su perfil?")
							if (rta) {
								var ID = $("input[name='id_usuario']").val();
								var PERSONA = $("input[name='id_persona']").val();
								var NOMBRE = $("input[name='nombre']").val();
								var APELLIDO = $("input[name='apellido']").val();
								var DOCUMENTO = $("input[name='documento']").val();
								var EMAIL = $("input[name='email']").val();
								var PSWD = hex_md5($("input[name='password']").val());
								var URL_POST = $("form").attr("action");
								var posting = $.post( URL_POST, { id_usuario: ID, password: PSWD, id_persona: PERSONA, nombre: NOMBRE, apellido: APELLIDO, documento: DOCUMENTO, email: EMAIL, Guardar: 1 } );
								posting.done(function() {
									alert("Cambios realizados con éxito");
								});
							}
						}
					});
				} else {
					var rta = confirm("¿Confirma los cambios en su perfil?")
					if (rta) {
						var ID = $("input[name='id_usuario']").val();
						var PERSONA = $("input[name='id_persona']").val();
						var NOMBRE = $("input[name='nombre']").val();
						var APELLIDO = $("input[name='apellido']").val();
						var DOCUMENTO = $("input[name='documento']").val();
						var EMAIL = $("input[name='email']").val();
						var PSWD = hex_md5($("input[name='password']").val());
						var URL_POST = $("form").attr("action");
						var posting = $.post( URL_POST, { id_usuario: ID, password: PSWD, id_persona: PERSONA, nombre: NOMBRE, apellido: APELLIDO, documento: DOCUMENTO, email: EMAIL, Guardar: 1 } );
						posting.done(function() {
							alert("Cambios realizados con éxito");
						});
					}
				}
			}
			
		}
		
	});

});