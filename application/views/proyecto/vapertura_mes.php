<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">

              <div class="row">
              <div class="col-md-3">
                <div class="box-header with-border">
                  <h1>Apertura de mes</h3>
              </div>
              </div>

              </div>

              <div class="box-header with-border">

                <div class="row">




                      <div class="col-md-3">
                      <div class="box-header with-border">
                        <div class="form-group">
                                <h4 class="box-title">Rango de Fechas:</h4>

                                <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right datepicker fecha_guias flat" name="form_periodo"></div>
                                <!-- /.input group -->
                              </div>
                        <!--

                        <!--
                      <h4 class="box-title">Inicio</h4>
                      <input type="date" name="" class="form-control" value="">
                      -->
                      </div>

                      </div>
                      <div class="col-md-1">
                        <input type="hidden" id='periodo' value="">
                      </div>
                      <div class="col-md-2  pull-right hidden-xs" >
                  <br><br>
                  <button style="text-align:right" type="button" class="btn btn-success" id="btn_aperturar_mes" data-toggle="modal" data-target="#modal-danger">
                    <i class="fa fa-retweet"></i>
                    Aperturar
                  </button>
                  <button style="text-align:right" type="button" class="btn btn-danger" id="btn_limpiar_mes" data-toggle="modal" data-target="#modal-danger">
                    <i class="fa fa-retweet"></i>
                    Limpiar
                  </button>



              </div>
              <!-- /.box-header -->

                  </div>
                </div>
              <div class="box-body">
                <div class="row">
                    <div class="col-md-12" id="msg">

                    </div>
                    <div class="col-md-12 table-responsive" id="tbl_tareo">

                    </div>
                </div>
              </div>
              <!-- /.box-body -->

</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>



<script>
$(document).ready(function(){
  control_de_menu($('#menu_apertura_mes'));
});


$('.datepicker').daterangepicker(
{

startDate: moment().subtract(6, 'days'),
endDate  : moment(),
locale: {
format: 'DD/MM/YYYY'
  }
},
function (start, end) {
$('#daterange-btn span').html(start.format('dd/mm/yyyy') + ' - ' + end.format('dd/mm/yyyy'))
}
);



$(document).on('click','#btn_aperturar_mes',function(e){
    var rango=$('.datepicker').val();
    alertify.confirm('Aperturar Tareo', 'Se actualizaran los días seleccionados como días trabajados .¿Desea aperturar el mes?',
    function(){
    $.ajax({
    url:baseurl+"Tareo/crear_periodo",
    type:"post",
    data:"rango=" +rango,
    beforeSend:function(){
      $('#msg').html('<br><br> <center><img src="http://192.168.1.7/almacenes-virtuales/assets/img/espera.gif"></center><br> ');
    },
    success: function(info){
      if (info=='x') {
        $('#msg').html('<div class="callout callout-danger"><h1>Error!</h1><p>El mes ya ha sido aperturado</p></div>');
      }
      else if (info==1) {
        $('#msg').hide();
        alertify.error("ERROR!!! Por favor corregir el rango de fecha.");
      }
      else if (info==0) {
        $('#msg').hide();
         alertify.error('Seleccione correctamente el rango de fechas');
      }else {
        $('#msg').hide();
        $('#periodo').val(info);
          alertify.success('Se genero correctamente el tareo mensual');
          $.post(baseurl+"Tareo/mostrartabla/"+info,function(data){
           $('#tbl_tareo').html(data);
          });
      }
         },
    error: function (xhr, ajaxOptions, thrownError) {
         alertify.error('Ocurrio un error');
      }
  });
  }, function(){
      alertify.error('No se actualizaron los días laborales')});
  });



  $(document).on('click','#btn_limpiar_mes',function(e){
    var periodo=$('#periodo').val();
      alertify.confirm('Restaurar Mes', 'Se restauraran los días del mes de tareo .¿Desea restaurar el mes?',
      function(){
        $.ajax({
        url:baseurl+"Tareo/eliminar_periodo",
        type:"post",
        data:"periodo=" +periodo,
        beforeSend:function(){
          $('#tbl_tareo').hide();
          $('#msg').html('<br><br> <center><img src="http://192.168.1.7/almacenes-virtuales/assets/img/espera.gif"></center><br> ');
        },
        success: function(info){
            $('#msg').hide();
            $('#periodo').val('');
              alertify.success(info);
              location.reload();
             },
        error: function (xhr, ajaxOptions, thrownError) {
             alertify.error('Ocurrio un error');
          }
      });
      }
    , function(){
        alertify.error('No se restauro el mes de tareo')});

    });

</script>
