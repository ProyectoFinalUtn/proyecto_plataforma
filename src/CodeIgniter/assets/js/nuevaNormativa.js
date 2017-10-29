$(document).ready(function() {
	var editor = new Quill('#editor', {
    modules: {
		toolbar: '#toolbar'
	},
	placeholder: 'Ingresa el contenido de la normativa',
	theme: 'snow'	
	});
	$("input:submit").click(function() {
		event.preventDefault();
		$("div.errorMsg").remove();
		var ok = true;
		if ($("input[name='descripcion']").val() == '') {
			$("div.form-group[id='descripcion']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if ($("input[name='fecha_desde']").val() == '') {
			$("div.form-group[id='fecha_desde']").append('<div class="errorMsg"><b>Este campo es obligatorio</b></div>');
			ok = false;
		}
		if (ok) {
			var rta = confirm("¿Confirma que desea dar de alta la nueva normativa?")
			if (rta) {
				var about = document.querySelector("input[name='contenido']");
				about.value = JSON.stringify(editor.getContents());
				var RESOLUCION = $("input[name='descripcion']").val();
				var DESDE = $("input[name='fecha_desde']").val();
				var HASTA = $("input[name='fecha_hasta']").val();
				var CONTENT = about.value;
				var CONTENT_HTML = editor.root.innerHTML;
				var URL_POST = $("form").attr("action");
				var posting = $.post( URL_POST, { descripcion: RESOLUCION, fecha_desde: DESDE, fecha_hasta: HASTA, contenido: CONTENT, contenido_html: CONTENT_HTML, Guardar: 1 } );
				posting.done(function() {
					alert("Normativa creada con éxito");
					var URL = "Normativas";
					$(location).attr('href', URL);
				});
			}
		}
	});

});