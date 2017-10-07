<html>
    <title>Información de Usuarios de VANT</title>
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
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Usuarios VANT</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">Usuarios de VANT</h1>
                <div id="tabla-usuarios">
                    <table>
                        <thead id="header" style="background-color: #004ea2; color:#ffffff;">
                            <tr id="headers">
                              <th>Usuario</th>
                              <th>Apellido</th>
                              <th>Nombre</th>
                              <th>E-mail</th>
                              <th>Edad</th>
                              <th>Sexo</th>
                              <th>Número de documento</th>
                              <th>Domicilio</th>
                              <th>Teléfono</th>
                              <th></th>
                            </tr>
                        </thead>
                        <?php
                            foreach ($usuariosVant as $usuarioVant)
                            {
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
                                echo "<td>Ver Detalle</td>";
                            }
                        ?>
                    </table>
                </div>
            </div>
            <?php
                /* <canvas id="myChart" width="400" height="400"></canvas>
                <script src="<?php echo base_url(); ?>assets/js/infoUsuarios.js"></script> */
            ?>
        </div>
    </body>
</html>