<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-4.0.0-beta.1.css" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
</head>
<style>
    h1,h2,h3,h4 { font-family: "Montserrat", sans-serif; }
    div,button, nav { font-family: "Montserrat", sans-serif; }
    a { color: inherit;} 
    a:hover { text-decoration:none; }
</style>
<body>
  <div class="main">
    <div id="breadcrumb" style="padding-left:8px;">G.O. Guide > Panel</div>
    <div class="py-5 text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="pb-3 text-secondary">Bienvenido al panel de administración de normativas.</h1>
          </div>
        </div>
        <div class="row">
          <div class="text-right col-md-6">
            <div class="row my-5">
                <div class="col-2 order-lg-2 col-2 text-center"><a href="normativas"><i class="d-block fa fa-3x fa-file-text-o"></i></a></div>
              <div class="col-10 text-lg-right text-left order-lg-1">
                <h3 class="text-primary">Normativas</h3>
                <p>Definir los contenidos de las
                  <br>normativas de VANT</p>
              </div>
            </div>
            <div class="row my-5">
                <div class="col-2 order-lg-2 col-2 text-center"><a href="zonas_influencia"><i class="d-block fa fa-map-o fa-3x"></i></a></div>
              <div class="col-10 text-lg-right text-left order-lg-1">
                <h3 class="text-primary">Zonas de Influencia</h3>
                <p>Definir las zonas restringidas para
                    <br>uso de VANT mediante importación</p>
              </div>
            </div>
            <div class="row my-5">
                <div class="col-2 order-lg-2 col-2 text-center"><a href="zonas_temporales"><i class="d-block fa  fa-3x fa-calendar-o"></i></a></div>
              <div class="col-10 text-lg-right text-left order-lg-1">
                <h3 class="text-primary">Zonas Temporales</h3>
                <p>Definir zonas de influencia
                  <br>para un período determinado de tiempo</p>
              </div>
            </div>
          </div>
          <div class="text-left col-md-6">
            <div class="row my-5">
                <div class="col-2 text-center"><a href="usuarios_admin"><i class="d-block fa fa-3x fa-user"></i></a></div>
              <div class="col-10">
                <h3 class="text-primary">Usuarios</h4>
                <p>Administrar los usuarios de la plataforma
                  <br>de normativas</p>
              </div>
            </div>
            <div class="row my-5">
                <div class="col-2 text-center"><a href="informacion"><i class="d-block mx-auto fa  fa-3x fa-area-chart"></i></a></div>
              <div class="col-10">
                <h3 class="text-primary">Información</h3>
                <p>Obtener información de los usuarios de VANT
                  <br>que utilizan la aplicación</p>
              </div>
            </div>
            <div class="row my-5">
                <div class="col-2 text-center"><a href="listar_solicitudes"><i class="d-block fa  fa-inbox fa-3x"></i></a></div>
              <div class="col-10">
                <h3 class="text-primary">Solicitudes</h3>
                <p>Procesar solicitudes de excepción
                  <br>de los usuarios de VANT</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

