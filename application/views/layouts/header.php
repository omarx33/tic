<?php $cdn=base_url().'assets/cdn/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de TIC</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo-rock.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $cdn;?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo $cdn;?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/alertify/css/alertify.min.css" />
    <!-- include a theme -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/alertify/css/themes/default.css" />
    <!-- bootstrap -->
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  

    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <!-- alertify -->

<!--  -->
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

    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $cdn;?>dist/css/skins/_all-skins.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>





<!-- select bottstarp -->


 <!-- fin del select -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a  class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>S</b>T</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>TIC</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $cdn;?>dist/img/avatar5.png" class="user-image" alt="User Image">
                                <?php if(!$this->session->userdata('nombre')){
    redirect(base_url().'Login');
}?>
                                <span class="hidden-xs"><?php echo $this->session->userdata('nombre'); ?></span>
                            </a>
                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" >
                                    <li><a href="<?php echo base_url() ?>Inicio/Usuarios"><i class="fa fa-user-plus"></i>Usuarios</a></li>
                                    <li><a href="<?php echo base_url() ?>Inicio/Perfiles"><i class="fa fas fa-users"></i>Administrar Perfil</a></li>
                                <li >
                                            <a href="<?php echo base_url() ?>Login/logout"> <i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                                    <!-- /.row -->
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
