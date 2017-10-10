<html>
    <title>ABM de Usuarios de la Plataforma</title>
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
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Usuarios</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">Usuarios Administradores de Normativa</h1>
                <p>
                    <a href="Nuevo_usuario" class="btn navbar-btn ml-2 text-white btn-secondary">Nuevo</a>
                    <button type="button" id="eliminar" class="btn navbar-btn ml-2 text-white btn-secondary">Eliminar</button>
                </p>
                <div id="tabla-usuariosadmin" style="overflow-x:auto;">
                    <table>
                        <thead id="header" style="background-color: #004ea2; color:#ffffff;">
                            <tr id="headers">
                              <th></th>
                              <th>Nombre de Usuario</th>
                              <th>Nombre</th>
                              <th>Apellido</th>
                              <th>Número de Documento</th>
                              <th>Correo Electrónico</th>
                              <th></th>
                            </tr>
                        </thead>
                        <?php
                            foreach ($listadoUsuariosAdmin as $usuario)
                            {
                                echo "<tr><td><input type=\"radio\" name=\"seleccionado\"></input></td>";
                                echo "<td>".$usuario['usuario']."</td>";
                                echo "<td>".$usuario['nombre']."</td>";
                                echo "<td>".$usuario['apellido']."</td>";
                                echo "<td>".$usuario['nro_documento']."</td>";
                                echo "<td>".$usuario['email']."</td>";
                                echo "<td><a href=\"Editar_usuario?idUsuario=".$usuario['id_usuario']."\" class=\"btn navbar-btn ml-2 text-white btn-secondary\">Editar</a></td></tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
