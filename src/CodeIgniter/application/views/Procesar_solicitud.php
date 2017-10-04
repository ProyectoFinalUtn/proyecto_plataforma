<html>
    <title>Solicitud de Excepción</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
        table { border-collapse: collapse; width: 100%; border-spacing:0; display:table; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); }
        thead, th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: inherit; opacity: 0.7; }
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Solicitudes de Excepción > Solicitud n°<?php echo $solicitud->idSolicitud; ?></div>
            <div style="padding:16px;">
                <div id="detalle-solicitudes">
                        <?php
                            $estadosPosibles = array( 1 => "Pendiente", 2 => "Aprobada", 3 => "Rechazada", 4 => "Vencida" );
                            echo "Número de solicitud ".$solicitud->idSolicitud."<br>";
                            echo "Apellido: ".$solicitud->apellido."<br>";
                            echo "Nombre: ".$solicitud->nombre."<br>";
                            echo "Nro de Documento: ".$solicitud->documento."<br>";
                            echo "Edad: ".$solicitud->edad."<br>";
                            echo "E-mail: ".$solicitud->email."<br>";
                            echo "Latitud: ".$solicitud->latitud."<br>";
                            echo "Longitud".$solicitud->longitud."<br>";
                            echo "Radio de vuelo: ".$solicitud->radioVuelo."<br>";
                            echo "Fecha solicitada: ".$solicitud->fecha."<br>";
                            echo "Horario solicitado: Desde las ".$solicitud->horaVueloDesde." Hasta las ".$solicitud->horaVueloHasta."<br>";
                            echo "Solicitud procesada por: ".$solicitud->usuarioAprobador."<br>";
                            echo "Estado actual de la solicitud: <select name=\"estados\">"."<option value=\"".$solicitud->idEstadoSolicitud."\" selected=\"selected\">" . 
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
                </div>
            </div>
        </div>
    </body>
</html>
