$(document).ready(function() {

	$("button[id='eliminar']").click(function() {
		event.preventDefault();
		
		if ($("input:checked").length > 0) {
			var fila = $("input:checked").closest("tr");
			var USER = fila.find("td:eq(1)").text();
			var rta = confirm("¿Confirma que desea dar de baja el usuario seleccionado <"+USER+">?")
				if (rta) {
					var ID = $("td").val();
					var URL_POST = 'Eliminar_usuario';
					var posting = $.post( URL_POST, { usuario: USER } );
					posting.done(function() {
						alert("Usuario <"+USER+"> dado de baja");
						$(".main").empty();
						var URL = "Usuarios_admin";
						$(".main").load(URL);
					});
				}
		} else {
			alert('Por favor, seleccione el usuario que desea dar de baja');
		}
	});
});