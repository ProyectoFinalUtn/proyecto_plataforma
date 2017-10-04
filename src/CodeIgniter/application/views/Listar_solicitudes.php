<html>
    <title>Listado de Solicitudes de Excepción</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script src="<?php echo base_url(); ?>assets/js/global.js" defer></script>
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
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Solicitudes de Excepción</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">Solicitudes de excepción de usuarios de VANT</h1>
                <div id="tabla-solicitudes">
                    <table>
                        <thead id="header" style="background-color: #004ea2; color:#ffffff;">
                            <tr id="headers">
                              <th>Número de Solicitud</th>
                              <th>Nombre de Usuario</th>
                              <th>Ubicación (x,y)</th>
                              <th>Radio (m)</th>
                              <th>Fecha solicitada</th>
                              <th>Horario solicitado</th>
                              <th>Usuario Controlador</th>
                              <th>Estado</th>
                              <th></th>
                            </tr>
                        </thead>
                        <?php
                            $estadosPosibles = array( 1 => "Pendiente", 2 => "Aprobada", 3 => "Rechazada", 4 => "Vencida" );
                            foreach ($solicitudes as $solicitud)
                            {
                                echo "<tr><td>".$solicitud['idSolicitud']."</td>";
                                echo "<td>".$solicitud['apellido']." ".$solicitud['nombre']."</td>";
                                echo "<td>".$solicitud['latitud'].",".$solicitud['longitud']."</td>";
                                echo "<td>".$solicitud['radioVuelo']."</td>";
                                echo "<td>".$solicitud['fecha']."</td>";
                                echo "<td>".$solicitud['horaVueloDesde']." - ".$solicitud['horaVueloHasta']."</td>";
                                echo "<td>".$solicitud['usuarioAprobador']."</td>";
                                echo "<td><select name=\"estados\">"."<option value=\"".$solicitud['idEstadoSolicitud']."\" selected=\"selected\">" . 
                                    $solicitud['descripcionEstadoSolicitud']."</option>";
                                foreach ($estadosPosibles as $estado => $estadoPosible)
                                {
                                    if (!($estado == $solicitud['idEstadoSolicitud']))
                                    {
                                        echo "<option value=\"".$estado."\">";
                                        echo $estadoPosible;
                                        echo "</option>";
                                    }
                                }
                                echo "</select></td><td><a href=\"Procesar_solicitud\">Editar</a></td></tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
