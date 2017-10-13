$(document).ready(function() {

	$("button[id='eliminar']").click(function() {
		event.preventDefault();
		
		if ($("input:checked").length > 0) {
			var table = document.getElementById('tablausuarios'), 
				rows = table.getElementsByTagName('tr'),
				i, j, cells, valorCheck, usuario;

			for (i = 0, j = rows.length; i < j; ++i) {
				cells = rows[i].getElementsByTagName('td');
				if (!cells.length) {
					continue;
				}
				var valorCheck = cells[0].innerHTML;
			}
			var rta = confirm("¿Confirma que desea dar de baja el usuario seleccionado?")
				if (rta) {
					var ID = $("td").val();
					var URL_POST = 'Eliminar_usuario';
					var posting = $.post( URL_POST, { id_usuario: ID, auth: PSWD } );
					posting.done(function() {
						alert("Cambios realizados con éxito");
					});
				}
		} else {
			alert('Por favor, seleccione el usuario que desea dar de baja');
		}
	});
});