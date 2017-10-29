    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <script src="<?php echo base_url(); ?>assets/js/bajaNormativa.js" defer></script>
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
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Normativas</div>
            <div style="padding:16px;">
                <h1 class="pb-3 text-secondary">Normativas de VANT</h1>
                <p>
                    <a href="Nueva_normativa" class="btn navbar-btn ml-2 text-white btn-secondary">Nueva</a>
                    <button type="button" id="eliminar" class="btn navbar-btn ml-2 text-white btn-secondary">Eliminar</button>
                </p>
                <div id="tabla-normativas" style="overflow-x:auto;">
                    <table id="normativas">
                        <thead id="header" style="background-color: #004ea2; color:#ffffff;">
                            <tr id="headers">
                              <th></th>
                              <th>Id</th>
                              <th>Resolución</th>
                              <th>Vigente Desde</th>
                              <th>Vigente Hasta</th>
                              <th></th>
                            </tr>
                        </thead>
                        <?php
                            foreach ($listadoNormativas as $normativa)
                            {
                                echo "<tr><td><input type=\"radio\" name=\"seleccionado\"></input></td>";
                                echo "<td>".$normativa['id_normativa']."</td>";
                                echo "<td>".$normativa['descripcion']."</td>";
                                echo "<td>".$normativa['fecha_desde']."</td>";
                                echo "<td>".$normativa['fecha_hasta']."</td>";
                                echo "<td><a href=\"Editar_normativa?idNormativa=".$normativa['id_normativa']."\" class=\"btn navbar-btn ml-2 text-white btn-secondary\">Editar</a></td></tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>