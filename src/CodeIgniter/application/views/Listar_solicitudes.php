<html>
    <title>Listado de Solicitudes de Excepción</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
    </style>
    <body>
        <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Solicitudes de Excepción</div>
        <div id="tabla-solicitudes" style="padding:16px; text-align: center;">
            <?php
                foreach ($solicitudes as $solicitud)
                    {
                        echo "<p><b>Solicitud número ".$solicitud['idSolicitud']."</b><br>";
                        echo $solicitud['idUsuarioVant']."<br>";
                        echo $solicitud['latitud'].",".$solicitud['latitud']."<br>";
                        echo $solicitud['idSolicitud']."</p>";
                    };
            ?>
        </div>
    </body>
</html>
