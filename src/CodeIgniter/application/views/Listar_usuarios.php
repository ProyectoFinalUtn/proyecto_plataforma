    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
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
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Información de Usuarios VANT > Usuarios VANT</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">Usuarios de VANT</h1>
                <p class="my-4"><i>Información estadística sobre los usuarios de VANT que utilizan la aplicación</i></p>
                <div id="tabla-usuarios" style="overflow-x:auto;">
                    <table>
                        <thead id="header" style="background-color: #004ea2; color:#ffffff;">
                            <tr id="headers">
                              <th>Usuario</th>
                              <th>Apellido</th>
                              <th>Nombre</th>
                              <th>E-mail</th>
                              <th>Edad</th>
                              <th>Sexo</th>
                              <th>Documento</th>
                              <th>Domicilio</th>
                              <th>Teléfono</th>
                              <th>Cantidad de VANT</th>
                            </tr>
                        </thead>
                        <?php
                            $max = 0;
                            foreach ($usuariosVant as $usuarioVant)
                            {
                                if ($max < 25){
                                    echo "<tr><td>".$usuarioVant['usuario']."</td>";
                                    echo "<td>".$usuarioVant['apellido']."</td>";
                                    echo "<td>".$usuarioVant['nombre']."</td>";
                                    echo "<td>".$usuarioVant['email']."</td>";
                                    echo "<td>".$usuarioVant['edad']."</td>";
                                    echo "<td>".$usuarioVant['sexo']."</td>";
                                    echo "<td>".$usuarioVant['nroDoc']."</td>";
                                    echo "<td>".$usuarioVant['calle']." ".$usuarioVant['nro']." ".$usuarioVant['piso']." ".$usuarioVant['dpto'].
                                            ", ".$usuarioVant['localidad'].", ".$usuarioVant['provincia']."</td>";
                                    echo "<td>".$usuarioVant['telefono']."</td>";
                                    echo "<td>".$usuarioVant['cantidadvant']."</td></tr>";
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
                    <canvas id="graficoEdad" width="400" height="100"></canvas>
                    <script src="<?php echo base_url(); ?>assets/js/graficoUsuarios.js"></script>
                </div>
                <div class="row" id="graficos">
                    <div class="col-md-4 p-4" style="text-align: center;">
                        <img class="img-fluid d-block rounded-circle mx-auto" src="./assets/img/info_chart.png"><br>
                    </div>
                    <div class="col-md-4 p-4" style="text-align: center;">
                        <p><h2>Configuración de gráfico</h2></p>
                        <p><i>Elija los datos junto con el tipo de gráfico<br>y presione Calcular para refrescar el gráfico</i></p>
                        <div class="row">
                            <div class="col-md-4 p-4" style="text-align: left;">
                                <p>
                                    <b>Dato 1</b><br>
                                    <p>
                                        <select name="ejeX">
                                            <option value="edad" selected="selected">Edad</option>
                                            <option value="sexo">Sexo</option>
                                            <option value="provincia">Provincia</option>
                                            <option value="localidad">Localidad</option>
                                            <option value="zona_interes">Zona de Interés</option>
                                        </select>
                                    </p>
                                </p>
                                <p>
                                    <b>Dato 2</b><br>
                                    <p>
                                        <select name="ejeY">
                                            <option value="cantidad" selected="selected">Cantidad de VANT</option>
                                            <option value="vuelos">Cantidad de Vuelos</option>
                                        </select>
                                    </p>
                                </p>
                            </div>
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