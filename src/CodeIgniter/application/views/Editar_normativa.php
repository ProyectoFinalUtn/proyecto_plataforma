    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-4.0.0-beta.1.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link href="<?php echo base_url(); ?>assets/css/quill.snow.css" rel="stylesheet">
        
        <script src="<?php echo base_url(); ?>assets/js/quill.js" defer></script>
        <script src="<?php echo base_url(); ?>assets/js/editaNormativa.js" defer></script>

    </head>
    <style>
        h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
        div,button, nav { font-family: "Montserrat", sans-serif; }
        a { color: inherit;} 
        a:hover { text-decoration:none; }
        table { border-collapse: collapse; width: 100%; border-spacing:0; display:table; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); }
        td { padding: 8px ; }
        .errorMsg { color: #a00 }
        #editor { height: 375px; overflow-y: auto; }
    </style>
    <body>
        <div class = "main">
            <div id="breadcrumb" style="padding-left:8px;"><a href="Panel">G.O. Guide</a> > <a href="Normativas">Normativas</a> > Editar Normativa</div>
            <div style="padding:16px;">
            <div class="container">
                <table>
                <tr>
                    <div class="row" style="border-collapse: collapse; width: 100%; border-spacing:0; box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19); padding:16px; ">
                        <form action="Editar_normativa" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                                <?php
                                    echo "<p></p>";
                                    echo "<h1>".$normativa->descripcion."</h1>";
                                    echo "<p>Normativa de VANT</p>";
                                    echo "<div class=\"form-group\" id=\"descripcion\"> <label>Resolución *</label>";
                                    echo "<input type=\"text\" class=\"form-control\" name=\"descripcion\" value=\"".$normativa->descripcion."\"></div>";
                                    echo "<div class=\"form-group\" id=\"fecha_desde\"> <label>Fecha de Vigencia - Desde *</label>";
                                    echo "<input type=\"date\" class=\"form-control\" name=\"fecha_desde\" value=\"".$normativa->fecha_desde."\"></div>";
                                    echo "<div class=\"form-group\" id=\"fecha_hasta\"> <label>Fecha de Vigencia - Hasta</label>";
                                    echo "<input type=\"date\" class=\"form-control\" name=\"fecha_hasta\" value=\"".$normativa->fecha_hasta."\"></div>";
                                    echo "<input type=\"hidden\" name=\"id_normativa\" value=\"".$normativa->id_normativa."\">";
                                    echo "<p></p>";
                                    echo "<input type=\"submit\" class=\"btn btn-secondary\" name=\"Guardar\" value=\"Guardar\"></input><p></p>";
                                ?>
                            </div>
                            <div class="col-md-6">
                                <h4>Contenido de la Normativa</h4>
                                <div id="toolbar">
                                    <select class="ql-size">
                                        <option value="small">Chica</option>
                                        <option selected></option>
                                        <option value="large">Grande</option>
                                        <option value="huge">Enorme</option>
                                    </select>
                                    <button class="ql-bold" data-toggle="tooltip" data-placement="bottom" title="Negrita">Negrita</button>
                                    <button class="ql-italic" data-toggle="tooltip" data-placement="bottom" title="Cursiva">Cursiva</button>
                                    <button class="ql-underline" data-toggle="tooltip" data-placement="bottom" title="Subrayado">Subrayado</button>
                                    <button class="ql-script" value="sub" data-toggle="tooltip" data-placement="bottom" title="Sub-texto"></button>
                                    <button class="ql-script" value="super" data-toggle="tooltip" data-placement="bottom" title="Super-texto"></button>
                                    <select class="ql-color">
                                        <option selected></option>
                                        <option value="red"></option>
                                        <option value="orange"></option>
                                        <option value="yellow"></option>
                                        <option value="green"></option>
                                        <option value="blue"></option>
                                        <option value="purple"></option>
                                    </select>
                                    <select class="ql-background">
                                        <option selected></option>
                                        <option value="red"></option>
                                        <option value="orange"></option>
                                        <option value="yellow"></option>
                                        <option value="green"></option>
                                        <option value="blue"></option>
                                        <option value="purple"></option>
                                    </select>
                                </div>
                                <input type="hidden" name="contenido">
                                    <div id="editor"><?php echo $normativa->contenido; ?></div>
                                </input>
                            </div>
                        </form>
                    </div>
                </tr>
                </table>
            </div>
            </div>
        </div>
    </body>