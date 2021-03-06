    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
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
            <div id="breadcrumb" style="padding-left:8px;"><a href="Panel">G.O. Guide</a> > <a href="Informacion">Información de Usuarios VANT</a> > VANT</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">VANT</h1>
                <i>Información estadística sobre los VANT registrados por la aplicación</i>
                <div class="row" id="graficos" style="padding-left:16px;">
                    <div class="col-md-4 p-4" style="text-align: left;">
                        <h2>Configuración de gráfico</h2>
                        <p><i>Elija los datos a calcular, filtrando por provincia, localidad y período entre fechas.
                        <br>Elija el tipo de gráfico y presione Calcular para actualizarlo.</i></p>
                        <p><i>Puede exportar su reporte a Microsoft Excel presionando Exportar reporte</i></p>
                        <div class="row">
                            <div class="col-md-4 p-4" style="text-align: left;">
                                <p>
                                    <b>Dato 1</b><br>
                                    <p>
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
                                </p>
                                <p>
                                    <b>Dato 2</b><br>
                                    <p>
                                        <select name="ejeY">
                                            <option value="cantidad" selected="selected">Cantidad de VANT</option>
                                        </select>
                                    </p>
                                </p>
                            </div>
                            <div class="col-md-4 p-4" style="text-align: left;">
                                <p>
                                    <b>Provincia</b><br>
                                    <p>
                                        <select name="filtro_provincia">
                                            <option value="0" selected="selected">Todo el país</option>
                                            <?php
                                            foreach ($provincias as $provincia)
                                            {
                                                echo "<option value=\"".$provincia['id_provincia']."\">".$provincia['provincia']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </p>
                                </p>
                                <p>
                                    <b>Localidad</b><br>
                                    <p>
                                        <select name="filtro_localidad">
                                            <option value="0" selected="selected">Toda la provincia</option>
                                        </select>
                                    </p>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 p-4" style="text-align: left;">
                                <p>
                                    <b>Fecha Desde</b><br>
                                    <p><input type="date" name="filtro_desde" value="2017-01-01"></input</p>
                                </p>
                                <p>
                                    <b>Fecha Hasta</b><br>
                                    <p><input type="date" name="filtro_hasta" value="2018-01-01"></input></p>
                                </p>
                            </div>
                            <div class="col-md-4 p-4" style="text-align: left;">
                                <b>Tipo de gráfico</b>
                                <p>
                                <select name="tipoGrafico">
                                    <option value="line" selected="selected">Lineal</option>
                                    <option value="bar" >Barra</option>
                                    <option value="radar">Radar</option>
                                    <option value="pie">Torta</option>
                                    <option value="doughnut">Dona</option>
                                </select>
                                </p>
                                <p><button type="button" class="btn btn-secondary" name="Calcular">Calcular gráfico</button></p>
                                <p><button type="button" class="btn btn-secondary" name="Exportar">Exportar reporte</button></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 p-4" style="text-align: center;">
                                <img class="img-fluid d-block rounded-circle mx-auto" src="./assets/img/info_chart.png"><br>
                            </div>
                            <div class="col-md-4 p-4" style="text-align: center;">
                                <img class="img-fluid d-block rounded-circle mx-auto" src="./assets/img/info_chart_type.png"><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 p-4" style="text-align: center;">
                        <canvas id="graficoPeso" width="400" height="200"></canvas>
                        <script src="<?php echo base_url(); ?>assets/js/graficoVant.js"></script>
                    </div>
                </div>
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
            </div>
        </div>
        <p></p>
    </body>