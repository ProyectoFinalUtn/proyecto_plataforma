    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol.css">
        <link href="//cdn.jsdelivr.net/openlayers.contextmenu/latest/ol3-contextmenu.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol3-layerswitcher.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        
        <script src="<?php echo base_url(); ?>assets/js/importarZona.js" defer></script>
        
    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
        table { border-collapse: collapse; width: 100%; border-spacing:0; display:table; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); }
        td { padding: 8px ; }
        .errorMsg { color: #a00 }
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Normativa > Zonas de Influencia > Nueva Zona de Influencia</div>
            <div style="padding:16px;">
                <div class="container">
                    <?php
                        echo "<p></p>";
                        echo "<h1>Nueva Zona de Influencia de VANT</h1>";
                        echo "<p>Elija un archivo <b>geojson</b> con la capa a importar y especifique el radio de influencia.</p>";
                        echo "<div class=\"form-group\" id=\"nombre_zona\"> <label>Nombre de la Capa *</label>";
                        echo "<input type=\"text\" class=\"form-control\" name=\"nombre_zona\" placeholder=\"Completa el nombre de la capa a importar\"></div>";
                        echo "<div class=\"form-group\" id=\"radio_zona\"> <label>Radio de Influencia *</label>";
                        echo "<input type=\"number\" class=\"form-control\" name=\"radio\" placeholder=\"Completa el radio de influencia\"></div>";
                        echo "<div class=\"form-group\" id=\"archivo\"> <label>Archivo a importar</label>";
                        echo "<input type=\"file\" class=\"form-control\" name=\"archivo\" placeholder=\"Elija el archivo geojson de su sistema\" accept=\".geojson\"></div>";
                        echo "<div class=\"form-group\" id=\"detalle_zona\"> <label>Detalle</label>";
                        echo "<textarea style=\"height:80px;width:100%;padding-top:8px;padding-left:8px;font-size:10px;border: 0.5px solid\" type=\"text\" name=\"detalle_zona\"></textarea>";
                        echo "<p></p>";
                        echo "<input type=\"submit\" class=\"btn btn-secondary\" name=\"Importar\" value=\"Importar\"></input><p></p>";
                    ?>
                </div>
            </div>
        </div>
    </body>