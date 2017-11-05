$(document).ready(function() {
	
	bootbox.setDefaults({ backdrop: false });
	
	$("button[id='eliminar']").click(function() {
		event.preventDefault();
		
		if ($("input:checked").length > 0) {
			var fila = $("input:checked").closest("tr");
			var NORM = fila.find("td:eq(2)").text();
			bootbox.confirm({
				message: "¿Confirma que desea dar de baja la normativa <"+NORM+">?",
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
						var ID = fila.find("td:eq(1)").text();
						var URL_POST = 'Eliminar_normativa';
						var posting = $.post( URL_POST, { id_normativa: ID } );
						posting.done(function() {
							bootbox.alert("Normativa <"+NORM+"> dada de baja exitosamente. Fuera de vigencia.",
								function(){
									var URL = "Normativas";
									$(location).attr('href', URL);
								});
						});
					}	
				}
			});
		} else {
			bootbox.alert("Por favor, seleccione la normativa que desea dar de baja");
		}
	});
});