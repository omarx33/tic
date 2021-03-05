<?php $cdn=base_url().'assets/cdn/'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema T.I.C.</title>
  <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/font-awesome/css/font-awesome.min.css" crossorigin="anonymous">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>bower_components/Ionicons/css/ionicons.min.css" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $cdn; ?>plugins/iCheck/square/blue.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/logo-rock.ico">


      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <h2>SISTEMA DE TIC</h2>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Introduzca sus datos de ingreso</p>

            <div class="form-group">
              <div id="msg">

              </div>
            </div>
            <form id="form-log" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Usuario" name="txtuser" autocomplete="off">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="txtpass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
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
    <script src="<?php echo $cdn; ?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo $cdn; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $cdn; ?>plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    var baseurl="<?php echo base_url();?>";

</script>
<script src="<?php echo base_url();?>js/login.js"></script>
</body>
</html>
