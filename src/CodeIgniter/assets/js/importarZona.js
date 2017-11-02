$(document).ready(function() {
	
	$("input:submit").click(function() {
		event.preventDefault();
		$("div.errorMsg").remove();
		var ARCHIVO = $("input[name='archivo']").val();
		var tipoArchivo = ARCHIVO.slice(ARCHIVO.indexOf(".")+1,ARCHIVO.length);
		var ok = true;
		if ($("input[name='nombre_zona']").val() == '') {
			$("div.form-group[id='nombre_zona']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if ($("input[name='radio_zona']").val() == 0) {
			$("div.form-group[id='radio_zona']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if (ARCHIVO == '') {
			$("div.form-group[id='archivo']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		} else {
			if (tipoArchivo != 'geojson') {
				alert('El archivo a importar debe ser del tipo geojson. Por favor ingrese un archivo válido.');
				ok = false;
			}
		}
		if (ok) {
			var rta = confirm("¿Confirma que desea importar la zona de influencia?")
			if (rta) {
				var NOMBRE = $("input[name='nombre_zona']").val();
				var RADIO = $("input[name='radio_zona']").val();
				var ARCHIVO = $("input[name='archivo']").val();
				var DETALLE = $("textarea[name='detalle_zona']").val();
				var URL_POST = 'Zonas_influencia/guardar_zona_influencia'
				var posting = $.post( URL_POST, { nombre_zona: NOMBRE, radio_zona: RADIO, archivo: ARCHIVO, detalle_zona: DETALLE } );
				posting.done(function() {
					alert("Zona de influencia importada con éxito");
					var URL = "Zonas_influencia";
					$(location).attr('href', URL);
				});
			}
		}
	});

});