$(document).ready(function() {

	$("button[id='eliminar']").click(function() {
		event.preventDefault();
		
		if ($("input:checked").length > 0) {
			var fila = $("input:checked").closest("tr");
			var NORM = fila.find("td:eq(2)").text();
			var rta = confirm("¿Confirma que desea dar de baja la normativa <"+NORM+">?")
				if (rta) {
					var ID = fila.find("td:eq(1)").text();
					var URL_POST = 'Eliminar_normativa';
					var posting = $.post( URL_POST, { id_normativa: ID } );
					posting.done(function() {
						alert("Normativa <"+NORM+"> dada de baja exitosamente. Fuera de vigencia.");
						var URL = "Normativas";
						$(location).attr('href', URL);
					});
				}
		} else {
			alert('Por favor, seleccione la normativa que desea dar de baja');
		}
	});
});