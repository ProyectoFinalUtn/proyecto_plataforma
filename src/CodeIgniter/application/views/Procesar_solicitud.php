<html>
    <title>Solicitud de Excepción</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol.css">
        <link href="//cdn.jsdelivr.net/openlayers.contextmenu/latest/ol3-contextmenu.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol3-layerswitcher.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        
        <script src="<?php echo base_url(); ?>assets/js/global.js" defer></script>
        <script src="<?php echo base_url(); ?>assets/js/solicitud.js" defer></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/ol3/4.3.3/ol.js"></script>
        <script src="//cdn.jsdelivr.net/openlayers.geocoder/latest/ol3-geocoder.js"></script>
        <script src="//cdn.jsdelivr.net/openlayers.contextmenu/latest/ol3-contextmenu.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/olContextMenu.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/utility.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ol3-layerswitcher.js"></script>
    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
        table { border-collapse: collapse; width: 100%; border-spacing:0; display:table; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); }
        td { padding: 8px ; }
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Solicitudes de Excepción > Solicitud n°<?php echo $solicitud->idSolicitud; ?></div>
            <div style="padding:16px;">
            <div class="container">
                <table>
                <tr>
                    <div class="row" style="border-collapse: collapse; width: 100%; border-spacing:0; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); padding:16px; ">
                        <div class="col-md-6">
                                <div id="mapa-solicitud" class="map"></div>
                                <script src="<?php echo base_url(); ?>assets/js/olSolicitud.js"></script>
                        </div>
                        <div class="col-md-6">
                            <?php
                                $cookie_lat = "sol_latitud";
                                $cookie_lat_value = $solicitud->latitud;
                                setcookie($cookie_lat, $cookie_lat_value, time() + (86400), "/"); // 86400 = 1 day
                                $cookie_long = "sol_longitud";
                                $cookie_long_value = $solicitud->longitud;
                                setcookie($cookie_long, $cookie_long_value, time() + (86400), "/"); // 86400 = 1 day
                                $estadosPosibles = array( 1 => "Pendiente", 2 => "Aprobada", 3 => "Rechazada", 4 => "Vencida" );
                                echo "<p></p>";
                                echo "<h1>Número de Solicitud: ".$solicitud->idSolicitud."</h1>";
                                echo "<p>Solicitud de excepción generada por usuario de VANT</p>";
                                echo "<form action=\"Procesar_solicitud\" method=\"post\" enctype=\"multipart/form-data\">";
                                echo "<div class=\"form-group\"> <label>Apellido</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"apellido\" value=\"".$solicitud->apellido."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Nombre</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"nombre\" value=\"".$solicitud->nombre."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Número de Documento</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"documento\" value=\"".$solicitud->documento."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Edad</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"edad\" value=\"".$solicitud->edad."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Correo Electrónico</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"email\" value=\"".$solicitud->email."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Ubicación solicitada</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"ubicacion\" value=\"".$solicitud->latitud.",".$solicitud->longitud."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Radio de vuelo</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"radio\" value=\"".$solicitud->radioVuelo."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Fecha solicitada</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"fecha\" value=\"".$solicitud->fecha."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Horario solicitado: </label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"horario\" value=\"Desde las ".$solicitud->horaVueloDesde." Hasta las ".$solicitud->horaVueloHasta."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Solicitud procesada por</label>";
                                echo "<input type=\"text\" class=\"form-control\" id=\"usuarioProcesador\" placeholder=\"Solicitud aún no procesada\" value=\"".$solicitud->usuarioAprobador."\" disabled> </div>";
                                echo "<div class=\"form-group\"> <label>Estado actual de la solicitud</label><br>";
                                echo "<select name=\"estadoNuevo\" style=\"width:200px;height:20px;\">"."<option value=\"".$solicitud->idEstadoSolicitud."\">" .
                                $solicitud->descripcionEstadoSolicitud."</option>";
                                foreach ($estadosPosibles as $estado => $estadoPosible)
                                {
                                    if (!($estado == $solicitud->idEstadoSolicitud))
                                    {
                                        echo "<option value=\"".$estado."\">";
                                        echo $estadoPosible;
                                        echo "</option>";
                                    }
                                }
                                echo "</select><br><p></p>";
                                echo "<input type=\"hidden\" name=\"usuarioAprobador\" value=\"".$_SESSION['usuario']."\">";
                                echo "<input type=\"hidden\" name=\"idSolicitud\" value=\"".$solicitud->idSolicitud."\">";
                                echo "<input type=\"submit\" class=\"btn btn-secondary\" name=\"Procesar\" value=\"Procesar\"></input><p></p>";
                                echo "</form>";
                            ?>
                        </div>
                    </div>
                </tr>
                </table>
            </div>
            </div>
        </div>
    </body>
</html>
