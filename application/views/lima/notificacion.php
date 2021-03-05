
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h4>Notificaión Mensual a Contrato</h4>
</section>
<!-- Main content -->
<section class="content">
<!-- Default box -->
<div class="box box-solid">
<div class="box-body">
<form class="" id="form_notificacion" method="post">

  <div class="row">
    <div class="col-md-3">
      <div class="box-header with-border">
        <div class="form-group">
            <h6 class="box-title">Fecha y Hora de Entrega: </h6>
      <div class="input-group date">
        <input id="datetime" name="datetime" class="form-control">
      </div>
    </div>

      </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="box-header with-border">
        <div class="form-group">
            <h6 class="box-title">Reporte de Horas Extras: </h6>
      <div class="input-group date">
        <input type="date" name="horas_extra" id="horas_extra" class="form-control">
      </div>
    </div>

      </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="box-header with-border">
        <div class="form-group">
            <h6 class="box-title">Cierre de Mes: </h6>
      <div class="input-group date">
        <input type="date" name="cierre_mes" id="cierre_mes" class="form-control">
      </div>
    </div>

      </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="box-header with-border">
        <div class="form-group">
            <h6 class="box-title">Fecha para informe de recategorizaciones: </h6>
      <div class="input-group date">
        <input type="date" name="recategorizacion" id="recategorizacion" class="form-control">
      </div>
    </div>

      </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="box-header with-border">
        <div class="form-group">
            <h6 class="box-title">Fecha para cuadro de bonos: </h6>
      <div class="input-group date">
        <input type="date" name="bono" id="bono" class="form-control">
      </div>
    </div>

      </div>
  </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="box-header with-border">
        <div class="form-group">
            <input type="submit" class="btn btn-primary" id="notificar" value="Notificar">
        </div>

      </div>
  </div>
  </div>
</form>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
</section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function(){
  control_de_menu($('#menu_notificacion'));
});
    $('#datetime').datetimepicker({
      step:1
      });


  $(document).on('click','#notificar',function(e){
    $('#form_notificacion').submit(function(ev){
      ev.preventDefault();
      alertify.confirm('Generar Requerimiento de materiales', 'Confirmar para guardar',
                      function(){
                          $.ajax({
                           url:baseurl+"RRHH/notificacion_correo",
                           type:"post",
                           data:$('#form_notificacion').serialize(),
                           beforeSend:function(){
                             $('#notificar').prop('disabled',true);
                           },
                           success: function(data){
                                alertify.success('Correo enviado');
                                $('#notificar').prop('disabled',false);
                           },
                           error: function (xhr, ajaxOptions, thrownError) {

                                alertify.error('Ocurrio un error');
                             }
                         });

                        },
                      function(){
                        alertify.error('Cancelado');
                       });
    });

  });



</script>
