<?php echo form_open('/sessions/authenticate','class="form-control"'); ?>
<?php	$nombreUsuario = array('name' => 'nombreUsuario',
	'placeholder' =>  '');
	$password = array('name' =>  'password' ,
	'placeholder' => '');

?>
<html>
    <title>Plataforma de Administración de Normativa</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <head>
        <style>
            body {font-family: 'Montserrat', sans-serif; align-content: center; text-align: center;background-image: url("../assets/img/fondoLogin.jpg");background-position: center;background-size: cover;}
            button {border:none;display:inline-block;outline:0;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:#ffffff;background-color:#00082c;text-align:center;cursor:pointer;white-space:nowrap}
            a:link {color: #00082c;text-decoration: none;}
        </style>
    </head>
    <body>
        <div style="position:absolute;top:40%;left:50%;transform:translate(-40%,-50%);-ms-transform:translate(-40%,-50%)">
            <button onclick="document.getElementById('id01').style.display='block'" type="button" style="padding:32px 64px;">Login</button>
        </div>
        <div id="id01" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
            <div style="margin:auto;background-color:#fff;position:relative;padding:0;outline:0;max-width:600px;box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19)">
                <div style="text-align:center"><br>
                    <img src="../assets/img/logo_goguide.png" style="width:50%">
                </div>
                <div class="form-group has-feedback">
                    <?php echo form_label('Usuario','usuario')?>
                        <br>
                    <?php echo form_input($nombreUsuario)?>
                    <p>
                    <?php echo form_label('Contraseña','password')?>
                        <br>
                    <?php echo form_password($password)?>
                    </p>
                    <p>
                    <?php echo form_submit('','Ingresar', 'style="border:none;display:inline-block;outline:0;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:#ffffff;background-color:#00082c;text-align:center;cursor:pointer;white-space:nowrap"')?>
                    <?php echo form_close()?>
                    </p>
                </div>
                <div style="border-top:1px solid #ccc!important;padding-top:16px!important;padding-bottom:16px!important">
                    <button onclick="document.getElementById('id01').style.display='none'" type="button">Cerrar</button>
                    <span style="float:right!important;padding:8px 16px!important">Olvidaste tu <a href="#">contraseña?</a></span>
                </div>
            </div>
        </div>
    </body>
</html>
