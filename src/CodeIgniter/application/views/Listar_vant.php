<html>
    <title>Información VANT</title>
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
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Información de Usuarios VANT > VANT</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">VANT</h1>
                <p class="my-4"><i>Información estadística sobre los VANT registrados por la aplicación</i></p>
                <div id="tabla-vant" style="overflow-x:auto;">
                    <table>
                        <thead id="header" style="background-color: #004ea2; color:#ffffff;">
                            <tr id="headers">
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>N° Serie</th>
                              <th>Fabricante</th>
                              <th>Origen</th>
                              <th>Año Fabricación</th>
                              <th>Alto</th>
                              <th>Ancho</th>
                              <th>Largo</th>
                              <th>Velocidad Máx</th>
                              <th>Altura Máx</th>
                              <th>Peso</th>
                              <th>Color</th>
                              <th>Lugar de Guardado</th>
                            </tr>
                        </thead>
                        <?php
                            $max = 0;
                            foreach ($vant as $cadaVant)
                            {
                                if ($max < 25){
                                    echo "<tr><td>".$cadaVant['marca']."</td>";
                                    echo "<td>".$cadaVant['modelo']."</td>";
                                    echo "<td>".$cadaVant['nroSerie']."</td>";
                                    echo "<td>".$cadaVant['fabricante']."</td>";
                                    echo "<td>".$cadaVant['lFab']."</td>";
                                    echo "<td>".$cadaVant['anioFab']."</td>";
                                    echo "<td>".$cadaVant['alto']."</td>";
                                    echo "<td>".$cadaVant['ancho']."</td>";
                                    echo "<td>".$cadaVant['largo']."</td>";
                                    echo "<td>".$cadaVant['velMax']."</td>";
                                    echo "<td>".$cadaVant['altMax']."</td>";
                                    echo "<td>".$cadaVant['peso']."</td>";
                                    echo "<td>".$cadaVant['color']."</td>";
                                    echo "<td>".$cadaVant['lGuardado']."</td></tr>";
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
                    <canvas id="graficoPeso" width="400" height="100"></canvas>
                    <script src="<?php echo base_url(); ?>assets/js/graficoVant.js"></script>
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
                                <option value="marca">Marca</option>
                                <option value="modelo">Modelo</option>
                                <option value="fabricante">Fabricante</option>
                                <option value="lFab">Origen</option>
                                <option value="anioFab">Año Fabricación</option>
                                <option value="peso" selected="selected">Peso</option>
                                <option value="altMax">Altura Máx</option>
                                <option value="velMax">Velocidad Máx</option>
                                <option value="alto">Alto</option>
                                <option value="ancho">Ancho</option>
                                <option value="largo">Largo</option>
                                <option value="color">Color</option>
                            </select>
                        </p>
                        <p>
                            <b>Eje Y</b><br>
                            <select name="ejeY">
                                <option value="cantidad" selected="selected">Cantidad de VANT</option>
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
                        <p><i>Presione para exportar el cálculo de reporte a Excel</i></p>
                        <p><button type="button" class="btn btn-secondary" name="Exportar">Exportar reporte</button></p>
                    </div>
                    <div class="col-md-4 p-4" style="text-align: center;">
                        <img class="img-fluid d-block rounded-circle mx-auto" src="./assets/img/info_chart_type.png"><br>
                    </div>
                </div>
            </div>
        </div>
        <p></p>
    </body>
</html>