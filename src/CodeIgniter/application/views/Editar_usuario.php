    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">

        <script src="<?php echo base_url(); ?>assets/js/md5.js" defer></script>
        <script src="<?php echo base_url(); ?>assets/js/editaPerfil.js" defer></script>

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
            <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Usuarios > Editar Usuario</div>
            <div style="padding:16px;">
            <div class="container">
                <table>
                <tr>
                    <div class="row" style="border-collapse: collapse; width: 100%; border-spacing:0; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); padding:16px; ">
                        <div class="col-md-6">
                            <?php
                                echo "<p></p>";
                                echo "<h1>Usuario Administrador de Normativa</h1>";
                                echo "<p>Edita los datos de usuario</p>";
                                echo "<form action=\"Editar_usuario\" method=\"post\" enctype=\"multipart/form-data\">";
                                echo "<div class=\"form-group\" id=\"usuario\"> <label>Nombre de Usuario</label>";
                                echo "<input type=\"text\" class=\"form-control\" name=\"usuario\" value=\"".$perfil->usuario."\" disabled> </div>";
                                echo "<div class=\"form-group\" id=\"nombre\"> <label>Nombre *</label>";
                                echo "<input type=\"text\" class=\"form-control\" name=\"nombre\" value=\"".$perfil->nombre."\"> </div>";
                                echo "<div class=\"form-group\" id=\"apellido\"> <label>Apellido *</label>";
                                echo "<input type=\"text\" class=\"form-control\" name=\"apellido\" value=\"".$perfil->apellido."\"> </div>";
                                echo "<div class=\"form-group\" id=\"documento\"> <label>Número de Documento</label>";
                                echo "<input type=\"number\" class=\"form-control\" name=\"documento\" value=\"".$perfil->nro_documento."\"> </div>";
                                echo "<div class=\"form-group\" id=\"email\"> <label>Correo Electrónico *</label>";
                                echo "<input type=\"text\" class=\"form-control\" name=\"email\" value=\"".$perfil->email."\"> </div>";
                                echo "<div class=\"form-group\" id=\"password\"> <label>Cambiar contraseña</label>";
                                echo "<input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Completa contraseña\"></div>";
                                echo "<div class=\"form-group\" id=\"repeatPassword\"> <label>Repita contraseña</label>";
                                echo "<input type=\"password\" class=\"form-control\" name=\"repeatPassword\" placeholder=\"Vuelva a repetir la contraseña\"></div>";
                                echo "<p></p>";
                                echo "<input type=\"hidden\" name=\"id_usuario\" value=\"".$perfil->id_usuario."\">";
                                echo "<input type=\"hidden\" name=\"id_persona\" value=\"".$perfil->id_persona."\">";
                                echo "<input type=\"hidden\" name=\"mailGuardado\" value=\"".$perfil->email."\">";
                                echo "<input type=\"submit\" class=\"btn btn-secondary\" name=\"Guardar\" value=\"Guardar\"></input><p></p>";
                                echo "</form>";
                            ?>
                        </div>
                    </div>
                </tr>
                </table>
            </div>
            </div>
        </div>
    </body>