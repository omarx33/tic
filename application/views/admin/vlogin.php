<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- base_url() = http://localhost/ventas_ci/-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/font-awesome/css/font-awesome.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/AdminLTE.min.css">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>assets/template/dist/img/logo-grande.png" />
</head>

<body class="hold-transition login-page" style="background-image: url(<?php echo base_url()?>assets/template/dist/img/fondo2.jpg);background-repeat: no-repeat;background-position:center;height: 500px;background-size: cover;" >
    <div class="login-box">
      





        <!-- /.login-logo -->
        <div class="login-box-body">
          <div class="login-logo" style="font-size:2em;">
Sistema de Control de Tareo - CTR  <b>ROCKDRILL</b>
  </div>
            <p class="login-box-msg">Introduzca sus datos de ingreso</p>
<div class="form-group">
  <div id="msg">

  </div>
</div>
            <form  method="post" id="form-log">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Usuario" name="txtuser" id="txtuser">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Contraseña" name="txtpass" id="txtpass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
         <select name="contrato" id="contratos" class="form-control">


         </select>
       </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" id="ingreso" >Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->







    </div>
    <!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/template/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/template/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
  var baseurl="<?php echo base_url();?>";
</script>
<script  src="<?php echo base_url()?>js/login.js"></script>
</body>
</html>
