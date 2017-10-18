<html>
    <title>Información de Solicitudes de Excepción</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script src="<?php echo base_url(); ?>assets/js/global.js" defer></script>
        <script src="<?php echo base_url(); ?>assets/js/Chart.js" defer></script>
        <script src="<?php echo base_url(); ?>assets/js/Chart.min.js" defer></script>
    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
        table { border-collapse: collapse; width: 100%; border-spacing:0; display:table; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); }
        thead, th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: inherit; opacity: 0.7; }
        img { width: 50%; }
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Información de Usuarios VANT > Solicitudes de Excepción</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">Solicitudes de excepción de usuarios de VANT</h1>
                <p class="my-4"><i>Información estadística sobre las excepciones solicitadas por los usuarios que utilizan la aplicación</i></p>
                <div id="tabla-solicitudes" style="overflow-x:auto;">
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
                            $max = 0;
                            foreach ($solicitudes as $solicitud)
                            {
                                if ($max < 25) {
                                    echo "<tr><td>".$solicitud['idSolicitud']."</td>";
                                    echo "<td>".$solicitud['apellido']." ".$solicitud['nombre']."</td>";
                                    echo "<td>".$solicitud['latitud'].",".$solicitud['longitud']."</td>";
                                    echo "<td>".$solicitud['radioVuelo']."</td>";
                                    echo "<td>".$solicitud['fecha']."</td>";
                                    echo "<td>".$solicitud['horaVueloDesde']." - ".$solicitud['horaVueloHasta']."</td>";
                                    echo "<td>".$solicitud['usuarioAprobador']."</td>";
                                    echo "<td>".$solicitud['descripcionEstadoSolicitud']."</td>";
                                    echo "</tr>";
                                    $max = $max + 1;
                                }
                                else {
                                    break;
                                }
                            }
                        ?>
                    </table>
                </div>
                <p></p>
                <div id="chart-container">
                    <canvas id="graficoFecha" width="400" height="100"></canvas>
                    <script src="<?php echo base_url(); ?>assets/js/graficoSolicitudes.js"></script>
                </div>
                <div class="row" id="graficos">
                    <div class="col-md-4 p-4" style="text-align: center;">
                        <img class="img-fluid d-block rounded-circle mx-auto" src="./assets/img/info_chart.png"><br>
                    </div>
                    <div class="col-md-4 p-4" style="text-align: center;">
                        <p><h2>Configuración de gráfico</h2></p>
                        <p><i>Elija su configuración de ejes y tipo de gráfico<br>y presione Calcular para refrescar el gráfico</i></p>
                        <p>
                            <b>Eje X</b>
                            <br>
                            <select name="ejeX">
                                <option value="fecha" selected="selected">Fecha solicitada</option>
                                <option value="horario">Horario solicitado</option>
                                <option value="momento">Momento del día</option>
                                <option value="marca">Marca del VANT</option>
                                <option value="modelo">Modelo del VANT</option>
                                <option value="estado">Estado de la Solicitud</option>
                            </select>
                        </p>
                        <p>
                            <b>Eje Y</b><br>
                            <select name="ejeY">
                                <option value="cantidad_sol" selected="selected">Cantidad de solicitudes</option>
                            </select>
                        </p>
                        <p>
                            <b>Tipo de gráfico</b><br>
                            <select name="tipoGrafico">
                                <option value="bar" selected="selected">Barra</option>
                                <option value="line">Lineal</option>
                                <option value="radar">Radar</option>
                                <option value="pie">Torta</option>
                                <option value="doughnut">Dona</option>
                            </select>
                        </p>
                        <p><button type="button" class="btn btn-secondary" name="Calcular">Calcular</button></p>
                    </div>
                    <div class="col-md-4 p-4" style="text-align: center;">
                        <img class="img-fluid d-block rounded-circle mx-auto" src="./assets/img/info_chart_type.png"><br>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
