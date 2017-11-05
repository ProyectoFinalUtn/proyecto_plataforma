$(document).ready(function() {
	
	bootbox.setDefaults({ backdrop: false });

	$("button[id='eliminar']").click(function() {
		event.preventDefault();
		
		if ($("input:checked").length > 0) {
			var fila = $("input:checked").closest("tr");
			var USER = fila.find("td:eq(1)").text();
			bootbox.confirm({
				message: "¿Confirma que desea dar de baja el usuario seleccionado <"+USER+">?",
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
						var ID = $("td").val();
						var URL_POST = 'Eliminar_usuario';
						var posting = $.post( URL_POST, { usuario: USER } );
						posting.done(function() {
							bootbox.alert("Usuario <"+USER+"> dado de baja",
								function(){
									var URL = "Usuarios_admin";
									$(location).attr('href', URL);
								});
						});
					}
				}
			});
		} else {
			bootbox.alert("Por favor, seleccione el usuario que desea dar de baja", function(){ /* callback */ });
		}
	});
	
});