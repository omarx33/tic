

<?php $cdn=base_url().'assets/cdn/';
date_default_timezone_set('America/Lima');
$time =  Date('Y-m-d h:i:s');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Satisfaccion al Cliente </title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/select2/dist/css/select2.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/Ionicons/css/ionicons.min.css" >

  <link href="<?php echo base_url()?>/assets/plugins/file-input/fileinput.min.css"  rel="stylesheet" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $cdn; ?>dist/css/AdminLTE.min.css">
  <style media="screen">
  *,*:after, *:before{
    margin: 0px;
    padding: 0px;
    -webkit-box-sizing: border-box ;
    -moz-box-sizing: border-box ;
    -box-sizing : border-box ;
  }

  #contenedor_carga{
    background-color: rgba(238,238,245,0.9);
    height: 100%;
    width: 100%;
    position: fixed;
    -webkit-transition: all 1s ease ;
    -o-transition: all 1s ease ;
    transition: all 1s ease ;
    z-index: 100000 ;
  }

  #carga{
    border: 15px solid #0D3456;
    border-top-color: #185B97 ;
    border-top-style: groove;
    height: 100px;
    width: 100px;
    border-radius: 100%;

    position: absolute;
    top: 0;
    left: 0 ;
    right: 0 ;
    bottom: 0 ;
    margin: auto;
    -webkit-animation: girar 1.5s linear infinite ;
    -o-animation: girar 1.5s linear infinite ;
    animation: girar 1.5s linear infinite ;
  }

#logo{
  position: absolute;
  top: 20%;
  margin: auto;
  text-align: center;


}



#logo {
  -webkit-animation: animation 5000ms linear both;
  animation: animation 5000ms linear both;
}

/* Generated with Bounce.js. Edit at http://bouncejs.com#%7Bs%3A%5B%7BT%3A%22t%22%2Ce%3A%22b%22%2Cd%3A1000%2CD%3A0%2Cf%3A%7Bx%3A-300%2Cy%3A0%7D%2Ct%3A%7Bx%3A0%2Cy%3A0%7D%2Cs%3A5%2Cb%3A4%7D%2C%7BT%3A%22c%22%2Ce%3A%22s%22%2Cd%3A500%2CD%3A0%2Cf%3A%7Bx%3A1%2Cy%3A1%7D%2Ct%3A%7Bx%3A15%2Cy%3A1%7D%2Cs%3A5%2Cb%3A4%7D%5D%7D */


.animation-target {
  -webkit-animation: animation 1000ms linear both;
  animation: animation 1000ms linear both;
}

/* Generated with Bounce.js. Edit at http://bouncejs.com#%7Bs%3A%5B%7BT%3A%22t%22%2Ce%3A%22b%22%2Cd%3A1000%2CD%3A0%2Cf%3A%7Bx%3A-300%2Cy%3A0%7D%2Ct%3A%7Bx%3A0%2Cy%3A0%7D%2Cs%3A5%2Cb%3A4%7D%2C%7BT%3A%22c%22%2Ce%3A%22s%22%2Cd%3A500%2CD%3A0%2Cf%3A%7Bx%3A1%2Cy%3A1%7D%2Ct%3A%7Bx%3A15%2Cy%3A1%7D%2Cs%3A5%2Cb%3A4%7D%5D%7D */

@-webkit-keyframes animation {
  0% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -300, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -300, 0, 0, 1); }
  1.3% { -webkit-transform: matrix3d(3.905, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -237.02, 0, 0, 1); transform: matrix3d(3.905, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -237.02, 0, 0, 1); }
  2.55% { -webkit-transform: matrix3d(4.554, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -182.798, 0, 0, 1); transform: matrix3d(4.554, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -182.798, 0, 0, 1); }
  4.1% { -webkit-transform: matrix3d(4.025, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -125.912, 0, 0, 1); transform: matrix3d(4.025, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -125.912, 0, 0, 1); }
  5.71% { -webkit-transform: matrix3d(3.039, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -79.596, 0, 0, 1); transform: matrix3d(3.039, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -79.596, 0, 0, 1); }
  8.11% { -webkit-transform: matrix3d(1.82, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -31.647, 0, 0, 1); transform: matrix3d(1.82, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -31.647, 0, 0, 1); }
  8.81% { -webkit-transform: matrix3d(1.581, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -21.84, 0, 0, 1); transform: matrix3d(1.581, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -21.84, 0, 0, 1); }
  11.96% { -webkit-transform: matrix3d(1.034, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 4.825, 0, 0, 1); transform: matrix3d(1.034, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 4.825, 0, 0, 1); }
  12.11% { -webkit-transform: matrix3d(1.023, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 5.53, 0, 0, 1); transform: matrix3d(1.023, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 5.53, 0, 0, 1); }
  15.07% { -webkit-transform: matrix3d(0.947, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 12.662, 0, 0, 1); transform: matrix3d(0.947, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 12.662, 0, 0, 1); }
  16.12% { -webkit-transform: matrix3d(0.951, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 13.007, 0, 0, 1); transform: matrix3d(0.951, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 13.007, 0, 0, 1); }
  27.23% { -webkit-transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.352, 0, 0, 1); transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.352, 0, 0, 1); }
  27.58% { -webkit-transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.121, 0, 0, 1); transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.121, 0, 0, 1); }
  38.34% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.311, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.311, 0, 0, 1); }
  40.09% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.291, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.291, 0, 0, 1); }
  50% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.048, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.048, 0, 0, 1); }
  60.56% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0.007, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0.007, 0, 0, 1); }
  82.78% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); }
  100% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); }
}

@keyframes animation {
  0% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -300, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -300, 0, 0, 1); }
  1.3% { -webkit-transform: matrix3d(3.905, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -237.02, 0, 0, 1); transform: matrix3d(3.905, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -237.02, 0, 0, 1); }
  2.55% { -webkit-transform: matrix3d(4.554, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -182.798, 0, 0, 1); transform: matrix3d(4.554, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -182.798, 0, 0, 1); }
  4.1% { -webkit-transform: matrix3d(4.025, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -125.912, 0, 0, 1); transform: matrix3d(4.025, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -125.912, 0, 0, 1); }
  5.71% { -webkit-transform: matrix3d(3.039, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -79.596, 0, 0, 1); transform: matrix3d(3.039, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -79.596, 0, 0, 1); }
  8.11% { -webkit-transform: matrix3d(1.82, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -31.647, 0, 0, 1); transform: matrix3d(1.82, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -31.647, 0, 0, 1); }
  8.81% { -webkit-transform: matrix3d(1.581, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -21.84, 0, 0, 1); transform: matrix3d(1.581, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -21.84, 0, 0, 1); }
  11.96% { -webkit-transform: matrix3d(1.034, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 4.825, 0, 0, 1); transform: matrix3d(1.034, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 4.825, 0, 0, 1); }
  12.11% { -webkit-transform: matrix3d(1.023, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 5.53, 0, 0, 1); transform: matrix3d(1.023, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 5.53, 0, 0, 1); }
  15.07% { -webkit-transform: matrix3d(0.947, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 12.662, 0, 0, 1); transform: matrix3d(0.947, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 12.662, 0, 0, 1); }
  16.12% { -webkit-transform: matrix3d(0.951, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 13.007, 0, 0, 1); transform: matrix3d(0.951, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 13.007, 0, 0, 1); }
  27.23% { -webkit-transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.352, 0, 0, 1); transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.352, 0, 0, 1); }
  27.58% { -webkit-transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.121, 0, 0, 1); transform: matrix3d(1.001, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 2.121, 0, 0, 1); }
  38.34% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.311, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.311, 0, 0, 1); }
  40.09% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.291, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.291, 0, 0, 1); }
  50% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.048, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -0.048, 0, 0, 1); }
  60.56% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0.007, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0.007, 0, 0, 1); }
  82.78% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); }
  100% { -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); }
}


  @keyframes girar {
    from {transform: rotate(0deg); }
    to {transform: rotate(360deg);}
  }

    .content-wrapper,.main-footer{

      margin-left: 20px;
      margin-right: 20px;
    }
    .main-footer{
      margin-left: 0px;
      margin-right: 0px;
    }
    body {
      background-color: #ecf0f5;
    }
  </style>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $cdn; ?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-rock.ico" />

  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css" />
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <!-- Google Font  http://cdn.rockdrillgroup.net/admin-lte/-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" crossorigin="anonymous">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>-->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- alertify -->
<link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/alertify/css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/alertify/css/themes/default.css" />
<!--  -->
<link href="<?php echo $cdn; ?>plugins/bootstrap-datetimepicker/css/jquery.datetimepicker.min.css" rel="stylesheet">
<script src="<?php echo $cdn; ?>plugins/bootstrap-datetimepicker/js/jquery.datetimepicker.full.js"></script>
<div class="content-wrapper">

    <section class="content">
      <style media="screen">
      .container{
  margin-top: 30px;
  margin-bottom: 15px;

}
.wizards{
  overflow: hidden;
  position: relative;
  margin-top: 20px;
}
.progressbar{
  position: absolute;
  top: 24px;
  left: 0;
  width: 100%;
  height: 1px;
  background: #ddd;
}
.progress-line{
  position: absolute;
  top: 0;
  left: 0;
  height: 1px;
  background: #185B97;

}
.form-wizard{
  position: relative;
  float: left;
  width: 16%;
  padding: 0 5px;
  text-align: center;
}
.wizard-icon{
  display: inline-block;
  width: 40px;
  height: 40px;
  margin-top: 4px;
  background: #ddd;
font-size: 16px;
  color: #fff;
  line-height: 40px;
-moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
}
.form-wizard.activated .wizard-icon{
  background: #fff;
  border: 1px solid #185B97;
  color: #185B97;
  line-height: 38px;
}
.form-wizard.active .wizard-icon{
  width: 48px;
  height: 48px;
  margin-top: 0;
  background: #185B97;
  font-size: 22px;
  line-height: 48px;
}
.form-wizard p {
  color: #ccc;
}
.form-wizard.activated p {
  color: #185B97;
}
.form-wizard.active p {
  color: #185B97;
}
fieldset {
  display: none;
  text-align: left;
}

.wizard-buttons {
  text-align: right;
}
.input-error {
  border-color: red;
}
.btn-previous{
  background-color: lightgrey;
}
.btn-next{
  background-color: #185B97;
  color: white;
}

.btn-next2{
  background-color: white;
  color: white;
}
iframe{
  width: 100%;
  height: 400px;
  border: 1px solid #ccc;
}
.observaciones {
  border-color: #E1E1E1;
  border-width: 1px;
  border-style: solid;
  width:1000;
  height:40px;
  border-radius: 5%;
  box-sizing: border-box;
  resize: vertical;
}

      </style>

    </head>
    <div id="contenedor_carga">
      <div class="row"  id="logo">
<img src="<?php echo base_url() ?>assets/img/logo_RD.png" height="30%" width="30%" alt="">
      </div>
      <div  class="row" id="carga"></div>
    </div>
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
              <form  method="post"  enctype="multipart/form-data" id="form_encuesta">
                <div  >
                <img src="<?php echo base_url() ?>assets/img/logo_RD.png" height="20%" width="20%" alt="">
                <h1 align="center" style="color:#3D3F1F">Registro de Encuesta <i class="fa fa-file-text-o"></i></h1>
               </div>

                  <div class="wizards">
                      <div class="progressbar">
                          <div class="progress-line" data-now-value="12.11" data-number-of-steps="5" style="width: 12.11%;"></div> <!-- 19.66% -->
                      </div>
                      <div class="form-wizard active">
                          <div class="wizard-icon"><i class="fa fa-user"></i></div>
                          <p>Datos Generales</p>
                      </div>
                      <div class="form-wizard">
                          <div class="wizard-icon"><i class="fa fa-exclamation"></i></div>
                          <p>Instrucciones</p>
                      </div>


                      <?php
                      $int= intval($numero);

                      foreach ($grupo as $key) {?>
                        <div class="form-wizard">
                            <div class="wizard-icon"><i class="fa fa-file-alt"></i></div>
                            <p><?php echo $key->nomgrupo ?></p>
                        </div>
                      <?php } ?>
                      <div class="form-wizard">
                          <div class="wizard-icon"><i class="fa fa-file-alt"></i></div>
                          <p>PASO <?php echo $numero ?></p>
                      </div>

                  </div>

                  <fieldset>
                  <div class="datoscliente">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">NOMBRE DEL REPRESENTANTE DEL CLIENTE</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value=""  required placeholder="Campo obligatorio">
                      </div>
                      <!--<div class="col-md-6">
                        <label for="">TIPO DE CONTACTO</label> <br>
                        <input type="radio" name="tipo_contacto" value="telefonico">telefonico <br>
                        <input type="radio" name="tipo_contacto" value="presencial">presencial <br>
                        <input type="radio" name="tipo_contacto" value="digital">digital
                      </div>-->
                    </div>
                    <br><br>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">CARGO</label>
                        <input type="text" class="form-control" name="cargo" id="cargo" value="" required  placeholder="Campo obligatorio">
                      </div>
                      <div class="col-md-6">
                        <label for="">EMPRESA</label>
                        <input type="text" class="form-control" name="lugar" id="lugar" value="" required  placeholder="Campo obligatorio">
                      </div>
                    </div>
                  </div>

                    <div class="wizard-buttons">
                      <br>
                        <button type="button" class="btn btn-next">Siguiente</button>
                    </div>
                  </fieldset>

                  <fieldset>
                    <div>
                      <p style="font:sans-serif;font-weight:bold;font-size: 14pt;color:#22508E;">INSTRUCCIONES</p>
<p style="font:sans-serif;font-size: 12pt;color:#22508E;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;● Antes de iniciar la encuesta lea bien las instrucciones. </p>
<p style="font:sans-serif;font-size: 12pt;color:#22508E;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;● En forma objetiva y de conciencia, asigne el puntaje correspondiente. </p>
<p style="font:sans-serif;font-size: 12pt;color:#22508E;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;● Califique los siguientes factores de acuerdo con el desempeño de servicio brindado por Rock Drill durante los últimos 6 meses. </p>
<p style="font:sans-serif;font-size: 12pt;color:#22508E;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;● La puntuación a cada pregunta será del 1 al 10, siendo 10 el nivel máximo de conformidad. </p>
<p style="font:sans-serif;font-size: 12pt;color:#22508E;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;● Seleccione el número que considere usted calificar cada pregunta realizada.</p>

                     </div>
                      <!--  <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="inicio" value="yes"> Acepto los términos y condiciones
                        </label>-->
                        <div class="wizard-buttons">
                            <button type="button" class="btn btn-previous">Anterior</button>
                            <button type="button" class="btn btn-next">Siguiente</button>
                        </div>
                  </fieldset>

                  <?php foreach ($grupo as $key): ?>

                                      <fieldset>
                                        <div class="form-group" >
                                          <h1><?php echo $key->nomgrupo ?>:</h1>
                                        </div>
                                        <?php foreach ($preguntas as $row): ?>
                                          <?php if ($key->idgrupo==$row->grupo): ?>
                                            <style media="screen">
                                            .input_hidden {
                                              position: absolute;
                                              left: -9999px;
                                            }

                                         .selected {
                                              border-radius: 100%;
                                              -moz-border-radius: 100%;
                                              -webkit-border-radius: 100%;

                                              box-shadow: 0 0 5px 5px #F4E71E;
                                              transition: 400ms all;
                                              transform:
                                              rotateZ(-10deg)
                                              rotateX(10deg);
                                            }

                                            .pregunta img {
                                              display: inline-block;
                                              cursor: pointer;
                                            }


                                            .pregunta img:hover {
                                              border-radius: 100%;
                                              transition: 500ms all;
                                            }


                                            .observaciones{
                                              display: block;
                                              width: 100%;
                                              height: 34px;
                                              padding: 6px 12px;
                                            }
                                              </style>
                                            <link rel="stylesheet" type="text/css" href="https://csshake.surge.sh/csshake.min.css">
                                            <div class="pregunta" >
                                              <div class="row">
                                                <div class="col-md-2">

                                                </div>
                                                <div class="col-md-1" style="font-size:7pt ;background-color:black;padding-top: 15px;height:50px; border-radius: 15px; width:100px;color:white;text-align:center;">
                                                  <center>INSATISFECHO</center>
                                                </div>
                                                <div class="col-md-6">

                                                </div>
                                                <div class="col-md-1" style="font-size:7pt ;background-color:black;padding-top: 15px;height:50px; border-radius: 15px; width:100px;color:white;text-align:center;">
                                                  <center>MUY SATISFECHO</center>
                                                </div>
                                                <div class="col-md-2">

                                                </div>
                                              </div>
                                              <div class="row" style="margin-top: 100px;">

                                                <div  style="border-style: hidden;">
                                                  <u><h4  style="text-align:center; font-weight: bold;font-size: 150%;" ><?php echo $row->pregunta ?></h4></u>
                                                </div>
                                                <br>
                                                <input type="hidden" class="nropregunta" name="nropregunta" value="<?php echo $row->idpregunta ?>">
                                                <div class="col-md-2">

                                                </div>
                                                <div class="col-md-1">

                                                </div>
                                                <div class="col-md-6" style="text-align:center;" >
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="1">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="1" src="<?php echo base_url() ?>/assets/img/1.png" alt="1" height='8%' width='8%'/>
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="2">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="2" src="<?php echo base_url() ?>/assets/img/2.png"  alt="2" height='8%' width='8%'/>
                                                  <input type="radio"  class="respuesta" name="<?php echo $row->idpregunta ?>" value="3">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="3" src="<?php echo base_url() ?>/assets/img/3.png"  alt="3"height='8%' width='8%' />
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="4">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="4" src="<?php echo base_url() ?>/assets/img/4.png"  alt="4"height='8%' width='8%' />
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="5">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="5" src="<?php echo base_url() ?>/assets/img/5.png"  alt="5" height='8%' width='8%'/>
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="6">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="6" src="<?php echo base_url() ?>/assets/img/6.png"  alt="6" height='8%' width='8%'/>
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="7">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="7" src="<?php echo base_url() ?>/assets/img/7.png"  alt="7" height='8%' width='8%'/>
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="8">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="8" src="<?php echo base_url() ?>/assets/img/8.png"  alt="8" height='8%' width='8%'/>
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="9">
                                                  <img data-name="<?php echo $row->idpregunta ?>" data-value="9" src="<?php echo base_url() ?>/assets/img/9.png"  alt="9" height='8%' width='8%'/>
                                                  <input type="radio" class="respuesta" name="<?php echo $row->idpregunta ?>" value="10" checked>
                                                  <img class="selected" data-name="<?php echo $row->idpregunta ?>" data-value="10" src="<?php echo base_url() ?>/assets/img/10.png"  alt="10" height='8%' width='8%'/>
                                                </div>
                                                <div class="col-md-1">

                                                </div>
                                                <div class="col-md-2">

                                                </div>
                                              </div>
                                              <br>

                                                    <div class="row">
                                                      <div class="col-md-12">
                                                        <h5 style="font-weight:bold">Comentarios </h5>
                                                        <input type="text" class="observaciones" style="display : inline-flex;"   name="obs<?php echo $row->idpregunta?>" rows="4" cols="40">
                                                      </div>
                                                    </div>
                                            </div>
                                              <script type="text/javascript">
                                              $('.pregunta input:radio').addClass('input_hidden');
                                              $('.pregunta img').click(function() {
                                                $(this).addClass('selected').siblings().removeClass('selected');

                                              });
                                              </script>
                                          <?php endif; ?>
                                        <?php endforeach; ?>
                                              <div class="wizard-buttons">
                                                  <button type="button" class="btn btn-previous">Anterior</button>
                                                  <button type="button" class="btn btn-next">Siguiente</button>
                                              </div>
                                      </fieldset>
                  <?php endforeach; ?>


      <fieldset>

          <div class="row">
            <div class="col-md-6">

              <input type="hidden" id="info1" name="nropregunta" value="Como se contacto con nosotros">
                <div class="col-md-8">
                  <label for="">Como se contacto con nosotros: </label>
                  <select class="form-control" name="respuesta" id="forma_contacto">
                    <option value="Web">A travez de Internet</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Whatsapp">Whatsapp</option>
                    <option value="Email">Correo Electronico</option>
                    <option value="Revistas">Revistas</option>
                    <option value="Referido">Por un referido</option>
                    <option value="0">Otro</option>
                  </select>
                  <br>
                  <input type="text" class="form-control" name="respuesta" id="forma_contacto_otro" placeholder="Especifique por favor..." style="display:none;" value="">
                </div>

            </div>
            <div class="col-md-6">
              <label for="">Volvería a contratar algun servicio de Rock Drill</label> <br>
              <input type="hidden" id="info2" name="nropregunta" value="Volvería a contratar algun servicio de Rock Drill">
              <input type="radio" class="respuesta" name="consulta" value="si" selected>SI <br>
              <input type="radio" class="respuesta" name="consulta" value="no">NO
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-md-6">
              <div class="col-md-12">
                <label for="">Recomendaciones</label><br>
                <input type="hidden" id="info3" name="nropregunta" value="Recomendaciones">
                <input type="text" class="form-control" name="respuesta" id="recomendaciones" value="">
              </div>
            </div>
          </div>
                <div class="wizard-buttons">
                      <button type="button" class="btn btn-previous">Anterior</button>
                      <button type="button" class="btn btn-primary" id="registrar"  name="button">Finalizar Encuesta</button>
                </div>

      </fieldset>



           </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="script.js"></script>-->


<!-- ./wrapper -->
<script>

  function changeColor(){
    var contenedor = document.getElementById('contenedor_carga');

    contenedor.style.visibility = 'hidden';
    contenedor.style.opacity = '0';

  }
      setInterval(changeColor, 3000);
</script>
<?php $cdn=base_url().'assets/cdn/'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js" charset="utf-8"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $cdn; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $cdn; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->

<!-- Sparkline -->
<script src="<?php echo $cdn; ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $cdn; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $cdn; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $cdn; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $cdn; ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $cdn; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $cdn; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->

<script src="<?php echo $cdn; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $cdn; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $cdn; ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $cdn; ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $cdn; ?>dist/js/demo.js"></script>
<script src="<?php echo $cdn; ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script  src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<script src="<?php echo $cdn; ?>bower_components/alertify/alertify.min.js"></script>
<script src="<?php echo base_url()?>/assets/plugins/file-input/fileinput.min.js"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script src="<?php echo base_url()?>/assets/plugins/file-input/theme.js"></script>
<!-- optionally if you need translation for your language then include  locale file as mentioned below -->
<script src="<?php echo base_url()?>/assets/plugins/file-input/es.js"></script>
<!-- AdminLTE for demo purposes -->

<script>
	var baseurl="<?php echo base_url(); ?>";
</script>
<?php if($this->uri->segment(2)=='encuesta_rd'){ ?>
<script src="<?php echo base_url() ?>js/encuesta/encuesta.js"></script>
<?php } ?>
<script type="text/javascript">


var Clicked = false;
window.onbeforeunload = confirmExit;

function confirmExit(){
    if (!Clicked) {
        return "¿Quieres salir de esta página?";
    }

}
/*
$(document).on('click','#registrar',function(e){
  let valor=$('input[name="1"]:checked').val()
  alert(valor);
});*/
$(document).on('change','select[id=forma_contacto]',function(e){
var contacto=$(this).val();

if (contacto=='0') {

$('#forma_contacto_otro').show();

}else {

$('#forma_contacto_otro').hide();
}
});


$(document).on('click','#registrar',function(e){
Clicked = true;
 var json="";
var json_total="";
        $(".pregunta").each(function () {
          json ="";
          $(this).find("input").each(function () {
                $this=$(this);
                if($this.attr("class")=='nropregunta' ||  $this.attr("class")=='observaciones'){
                  json=json+',"'+$this.attr("class")+'":"'+$this.val()+'"';
                }
          });
          $(this).find('img').each(function(){
            $this2=$(this);
            if($this2.attr("class")=="selected"){
                  json=json+',"respuesta":"'+$this2.attr('data-value')+'"';
            }
          });

          obj=JSON.parse('{'+json.substr(1)+'}');
          json_total=json_total+','+JSON.stringify(obj);
      });

      var contacto=$('#forma_contacto').val();

      if (contacto=='0') {

        info1=',"nropregunta":"'+$('#info1').val()+'","observaciones":"sin observaciones"'+',"respuesta":"'+$('#forma_contacto_otro').val()+'"';

      }else {

        info1=',"nropregunta":"'+$('#info1').val()+'","observaciones":"sin observaciones"'+',"respuesta":"'+$('#forma_contacto').val()+'"';
      }


        obj1=JSON.parse('{'+info1.substr(1)+'}');
        info2=',"nropregunta":"'+$('#info2').val()+'","observaciones":"sin observaciones"'+',"respuesta":"'+$('input[name=consulta]:checked').val()+'"';
        obj2=JSON.parse('{'+info2.substr(1)+'}');
        info3=',"nropregunta":"'+$('#info3').val()+'","observaciones":"sin observaciones"'+',"respuesta":"'+$('#recomendaciones').val()+'"';
        obj3=JSON.parse('{'+info3.substr(1)+'}');


        json_total2=','+JSON.stringify(obj1)+','+JSON.stringify(obj2)+','+JSON.stringify(obj3);

        json_totaltotal=json_total+json_total2;

var array_json=JSON.parse('['+json_totaltotal.substr(1)+']');
var representante=$('#nombre').val();
var contacto=$('input[name="tipo_contacto"]:checked').val();
var cargo=$('#cargo').val();
var lugar=$('#lugar').val();
  $.ajax({
    url:baseurl+"Encuesta/registro_encuesta",
    type:"post",
    data:"empresa="+lugar+"&representante="+representante+"&cargo="+cargo+"&tbldetalle=" + JSON.stringify(array_json),
    beforeSend:function(){
      $('#registrar').prop('disabled',true);
    },
    success: function(data){
      $('#registrar').prop('disabled',false);
      /*swal({
        title: "¿Estás seguro?",
        text: "Si está seguro de sus respuestas, se registrarán al presionar ok!",
        icon: "warning",
        buttons: true,
        succesMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
*/
          swal({
		          title: "Buen Trabajo",
		            type:"success",
		              text: "¡¡Genial!! Sus respuesta fueron registradas con éxito!!!",
		                timer: 3000,
		                  showConfirmButton: false
		                  });


          setTimeout("window.location.replace('http://satisfaccionalcliente.rockdrillgroup.net/Inicio/successful')",3000);
    /*   } else {
          swal("Revise sus respuestas por favor!");
        }
      });*/
         //alertify.success(data);
         //window.location.replace('http://satisfaccionalcliente.rockdrillgroup.net/Inicio');
    },
    error: function (xhr, ajaxOptions, thrownError) {
      $('#registrar').prop('disabled',true);
         alertify.error('Ocurrio un error');
      }
  });

});

</script>
