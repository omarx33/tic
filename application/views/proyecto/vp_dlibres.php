<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">




              <div class="box-header with-border">


                <h3 class="box-title">PROGRAMACIÓN DE DÍAS LIBRES</h3>
<!--
                <select class="form-control" name="">
                  <option value="">ENERO</option>
                  <option value="">FEBRERO</option>
                  <option value="">MARZO</option>
                  <option value="">ABRIL</option>
                </select>
-->


              </div>
              <!-- /.box-header -->
        <form id="form_dlibre" action="" method="post">
          <div class="box-body">
            <div class="row">
              <div class="col-md-2">
            <div class="box-header with-border">
              <h4 class="box-title">Periodo</h4>
              <select name="periodo" class="form-control select2" id="periodo"  required>
                  <option>seleccionar::</option>
                  <?php foreach ($periodo as $key): ?>
                    <option value="<?php echo $key->periodo_tareo ?>"><?php echo $key->periodo_tareo ?></option>
                  <?php endforeach; ?>
                </select>

            </div>

            </div>
              <div class="col-md-3">
                <div class="box-header with-border">
            <h4 class="box-title">Tipo de Trabajo</h4>
              <select name="tipo_trabajador" class="form-control select2" id="tipo_trabajador" required>
                  <option>seleccionar::</option>
                  <?php foreach ($tipo as $key): ?>
                    <option value="<?php echo $key->id_tipo_trabajador ?>"><?php echo $key->desc_tipo_trabajador ?></option>
                  <?php endforeach; ?>

                </select>
            </div>
          </div>



<div class="col-md-2">
<div class="box-header with-border">
    <div class="box-header with-border">
        <div class="box-header with-border">
<button style="text-align:right" type="button" class="btn btn-success" id="visualizar">
Visualizar
</button>
  </div>
  </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="callout callout-warning">
                <h4>Indicaciones!</h4>

                <p>*Antes de elegir los días libre, consulte la programacion de vacaciones.</p>
                <p>*Al activar caja automaticamente se asignara el día como <b>DL</b> ("Dia libre"). </p>
                <p>*Al termino de la programación de los días libresa todos el personal, presione el boton <span style="color:blue"><b>Programar días Libres</b></span>, este accion cerrar el mes unicamente para la programación de dias libres.</p>
</div>
  </div>
</div>

            <div class="row">
              <div class="col-md-12" id="msg">
              </div>
                <div class="col-md-12 table-responsive" id="tbl_dl" >

                </div>

            </div>
            <div class="row" id="divenvio" style="display:none;">
        <div class="col-md-12">
          <br>
          <br>
        <button type="button" name="button" id="btn_preenvio" class="btn btn-primary" data-target="#modal-danger" data-toggle="modal">Programar días Libres</button>
        </div>
      </div>
          </div>
        </form>
              <!-- /.box-body -->

</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>




<script type="text/javascript">
$(document).ready(function(){
  control_de_menu($('#menu_p_dlibres'));
});


$(document).on('click','#visualizar',function(e){
var periodo=$('select[name=periodo]').val();
var tipo=$('select[name=tipo_trabajador]').val();
$.post(baseurl+"Tareo/get_tareo",{periodo:periodo,tipo:tipo},function(data){
  $('#tbl_dl').html(data);

});
});



$(document).on('change','.dlibre',function(e){
var periodo=$('#periodo').val();
var dia=$(this).attr('data-id') ;
var fila=$(this).parent().parent();
var personal=fila.find('td').eq(1).html();
var estaSeleccionado = $(this).is(":checked");
if(estaSeleccionado){
//  alert(dia+' '+personal+' '+periodo)

    $.ajax({
    url:baseurl+"Tareo/asignar_dlibres",
    type:"post",
    data:"dia="+dia+"&personal="+personal+"&tipo=DL"+"&periodo="+periodo,
    success: function(info){
          if (info=='V') {


            alertify.error('El trabajador tiene dia de vacaciones');

          }else{

            alertify.success('Dia libre asignado');
          }
        },
    error: function (xhr, ajaxOptions, thrownError) {
         alertify.error('Ocurrio un error');
      }
  });

  //  fila.find('td').eq(6).html('DL');
}else {
  var tipo=$(this).html() ;
  $.ajax({
  url:baseurl+"Tareo/asignar_dlibres",
  type:"post",
  data:"dia="+dia+"&personal="+personal+"&tipo="+tipo+"&periodo="+periodo,
  success: function(info){
    if (info==1) {
      $(this).attr('data-tipo',"")
    }
      },
  error: function (xhr, ajaxOptions, thrownError) {
       alertify.error('Ocurrio un error');
    }
});
}

});
$(document).on('click','#actualizar',function(e){
  var periodo=$('#periodo').val();
  
  $.ajax({
    url:baseurl+"Tareo/cerrar_dlibres",
    type:"post",
    data:"periodo="+periodo,
    success: function(info){
      if (info==1) {
        alertify.success('Los días libres han sido actualizado');
        location.reload();
      }else {
        alertify.error('No se pudo cerrar los dias libres');
      }
    },
    error:function (xhr, ajaxOptions, thrownError) {
         alertify.error('Ocurrio un error');
      }
  });
});
</script>
