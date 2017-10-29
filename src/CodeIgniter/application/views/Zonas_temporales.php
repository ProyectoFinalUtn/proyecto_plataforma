    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol.css">
        <link href="//cdn.jsdelivr.net/openlayers.contextmenu/latest/ol3-contextmenu.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol3-layerswitcher.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        
        <script src="//cdnjs.cloudflare.com/ajax/libs/ol3/4.3.3/ol.js"></script>
        <script src="//cdn.jsdelivr.net/openlayers.geocoder/latest/ol3-geocoder.js"></script>
        <script src="//cdn.jsdelivr.net/openlayers.contextmenu/latest/ol3-contextmenu.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/olContextMenu.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/utility.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ol3-layerswitcher.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Normativa > Zonas Restringidas Temporales</div>
            <div style="padding:16px;">
                <div class="container">
                    <div id="map" class="map"></div>
                    <script src="<?php echo base_url(); ?>assets/js/olTemporales.js"></script>
                </div>
            </div>
        </div>
    </body>