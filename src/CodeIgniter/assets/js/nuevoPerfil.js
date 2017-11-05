$(document).ready(function() {
	
	bootbox.setDefaults({ backdrop: false });
	
	$("input:submit").click(function() {
		event.preventDefault();
		$("div.errorMsg").remove();
		var ok = true;
		if ($("input[name='usuario']").val() == '') {
			$("div.form-group[id='usuario']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
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
		if ($("input[name='password']").val() == '') {
			$("div.form-group[id='password']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if ($("input[name='repeatPassword']").val() == '') {
			$("div.form-group[id='repeatPassword']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if (ok) {
			var CONTRA = hex_md5($("input[name='password']").val());
			var REPEAT = hex_md5($("input[name='repeatPassword']").val());
			if(CONTRA != REPEAT) {
				bootbox.alert("Revise su contraseña, la misma no coincide con la repetición", function(){ /* callback */ });
			} else {
					var USER = $("input[name='usuario']").val();
					var URL_POST = $("form").attr("action");
					var posting = $.post( URL_POST, { usuario: USER, CheckUsuario: 1 } );
					posting.done(function(data) {
						if (data == 'true') {
							bootbox.alert("Ya existe el nombre de usuario. Elija otro distinto", function(){ /* callback */ });
						} else {
							var MAIL = $("input[name='email']").val();
							var URL_POST = $("form").attr("action");
							var posting = $.post( URL_POST, { email: MAIL, CheckMail: 1 } );
							posting.done(function(data) {
								if (data == 'true') {
									bootbox.alert("Ya existe un usuario registrado con ese correo electrónico. Elija otro distinto", function(){ /* callback */ });
								} else {
									bootbox.confirm({
										message: "¿Confirma que desea crear un nuevo usuario administrador?",
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
												var USUARIO = $("input[name='usuario']").val();
												var NOMBRE = $("input[name='nombre']").val();
												var APELLIDO = $("input[name='apellido']").val();
												var DOCUMENTO = $("input[name='documento']").val();
												var EMAIL = $("input[name='email']").val();
												var PSWD = hex_md5($("input[name='password']").val());
												var URL_POST = $("form").attr("action");
												var posting = $.post( URL_POST, { usuario: USUARIO, nombre: NOMBRE, apellido: APELLIDO, documento: DOCUMENTO, email: EMAIL, password: PSWD, Guardar: 1 } );
												posting.done(function() {
													bootbox.alert("Usuario dado de alta con éxito",
														function(){
															var URL = "Usuarios_admin";
															$(location).attr('href', URL);
														});
												});
											}
										}
									});
								}
							});
						}
					});
			}
		}
	});

});