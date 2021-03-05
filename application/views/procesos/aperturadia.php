<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>Apertura de mes</h4>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
          <div class="box-body">
            <div class="row">
              <div class="col-md-1">
                <label for="">PERIODO:</label>
              </div>
              <div class="col-md-3">
                <select class="form-control" id="periodo">
                  <option value="0">.:Seleccione Periodo:.</option>
                  <?php foreach ($periodo as $key): ?>
                      <option value=<?php echo $key->periodo_tareo ?>><?php echo $key->periodo_tareo ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="table-responsive" id="tbl_dias">

            </div>
</div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">

$(document).ready(function(){
  control_de_menu($('#menu_aperturames'));
});

$(document).on('change','#periodo',function(){
  var periodo=$(this).val();
  $.post(baseurl+'Tareo/dias_cerrados',{periodo:periodo},function(data){
    $('#tbl_dias').html(data);
});
});

$(document).on('click','.eliminar_cierre',function(e){
  e.preventDefault();
  var dia=$(this).attr('data-id');
$.post(baseurl+'Tareo/aperturar_dia',{dia:dia},function(data){
  alertify.success('Aperturado exitosamente');
  setTimeout(function(){window.location.href = baseurl+"Inicio/aperturardia"},1000);
});
});

</script>
