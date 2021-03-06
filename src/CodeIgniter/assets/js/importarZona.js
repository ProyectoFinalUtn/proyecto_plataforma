$(document).ready(function() {

	bootbox.setDefaults({ backdrop: false });
    $("input:submit").click(function() {
        event.preventDefault();
        $("div.errorMsg").remove();
        var ARCHIVO = $("input[name='archivo']").val();
        var tipoArchivo = ARCHIVO.slice(ARCHIVO.indexOf(".") + 1, ARCHIVO.length);
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

            var selectedFile = document.getElementById('input_file').files[0];
            bootbox.confirm("¿Confirma que desea importar la zona de influencia?", function(result) {

                if (result) {

                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var zonas = reader.result;                        
                        var NOMBRE = $("input[name='nombre_zona']").val();
                        var RADIO = $("input[name='radio_zona']").val();                        
                        var ARCHIVO = zonas;
                        var DETALLE = $("textarea[name='detalle_zona']").val();
                        var URL_POST = 'Zonas_influencia/guardar_zona_influencia';
                        var data = {
                            nombre_zona: NOMBRE,
                            radio_zona: RADIO,
                            archivo: ARCHIVO,
                            detalle_zona: DETALLE
                        };
                        data = JSON.stringify(data);
                        $.ajax({
                            type: 'POST',
                            data: 'data=' + data,
                            url: URL_POST,
                            success: function(response) {
                                if (response == '"true"') {
									bootbox.alert("La capa fue importada con éxito");
                                    clearDraw();
                                    buscaZonas();
								}
                            }
                        });
                    }                    
                    reader.readAsText(selectedFile);

                }

            });


        }
    });

});