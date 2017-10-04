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
                <div id="detalle-solicitudes">
                    <table>
                        <tr>
                            <td>
                                <div id="map" class="map"></div>
                                <script src="<?php echo base_url(); ?>assets/js/olSolicitud.js"></script>
                            </td>
                            <td>
                                <?php
                                    $estadosPosibles = array( 1 => "Pendiente", 2 => "Aprobada", 3 => "Rechazada", 4 => "Vencida" );
                                    echo "<strong>Número de solicitud:</strong> ".$solicitud->idSolicitud."<br>";
                                    echo "<strong>Apellido:</strong> ".$solicitud->apellido."<br>";
                                    echo "<strong>Nombre:</strong> ".$solicitud->nombre."<br>";
                                    echo "<strong>Nro de Documento:</strong> ".$solicitud->documento."<br>";
                                    echo "<strong>Edad:</strong> ".$solicitud->edad."<br>";
                                    echo "<strong>E-mail:</strong> ".$solicitud->email."<br>";
                                    echo "<strong>Latitud:</strong> ".$solicitud->latitud."<br>";
                                    echo "<strong>Longitud:</strong> ".$solicitud->longitud."<br>";
                                    echo "<strong>Radio de vuelo:</strong> ".$solicitud->radioVuelo."<br>";
                                    echo "<strong>Fecha solicitada:</strong> ".$solicitud->fecha."<br>";
                                    echo "<strong>Horario solicitado:</strong> Desde las ".$solicitud->horaVueloDesde." Hasta las ".$solicitud->horaVueloHasta."<br>";
                                    echo "<strong>Solicitud procesada por:</strong> ".$solicitud->usuarioAprobador."<br>";
                                    echo "<strong>Estado actual de la solicitud:</strong> <select name=\"estados\">"."<option value=\"".$solicitud->idEstadoSolicitud."\" selected=\"selected\">" . 
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
                                    echo "</select><br><a href=\"#\">Procesar</a><br>";
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
