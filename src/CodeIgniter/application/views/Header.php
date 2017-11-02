<!DOCTYPE html>
 <html>
  <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>

   </style>
   <title>Plataforma de Administración de Normativa</title>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/popper.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" ></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/doc.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles.css">
<link href="https://unpkg.com/ol3-geocoder/build/ol3-geocoder.min.css" rel="stylesheet">
<link href="//cdn.jsdelivr.net/openlayers.contextmenu/latest/ol3-contextmenu.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ol3-layerswitcher.css">


<script src="<?php echo base_url(); ?>assets/js/bootstrap-submenu.min.js" defer></script>
<script src="<?php echo base_url(); ?>assets/js/docs.js" defer></script>

   
</head>
<body>
 <!-- depends on your template design -->
 <div class="dashboard-wrapper">
    <div class="main-content">
        <nav class="navbar navbar-expand-md bg-secondary navbar-dark" style="background-color: #00082c;">
            <div class="container">
              <a class="navbar-brand" href="Panel"><img src="assets/img/logo_menu.png" style="width:25%"></a>
              <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" style="color:white;">
                    <?php echo $menu;?>
                </div>
                <a class="btn navbar-btn ml-2 text-white btn-secondary" href="Mi_perfil"><i class="fa d-inline fa-lg fa-2x fa-user-circle-o"></i> <?php echo $_SESSION['usuario']; ?></a>
              </div>
            </div>
        </nav>
