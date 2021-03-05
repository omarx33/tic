<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <section class="content">
            <form action="" method="post" id="form_vacaciones">
              <div class="box box-default">

                <div class="row">
                    <div class="col-md-4">
                      <h1 class="box-title">PROGRAMACION DE VACACIONES</h1>
                    </div>
                </div>
  <div class="box-header with-border">
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
                  <div class="col-md-2">
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
    <h4 class="box-title">Trabajadores</h4>
    <select name="trabajador" class="form-control select2" id="trabajador"  required>
        <option>seleccionar::</option>
      </select>

  </div>

  </div>

    <div class="col-md-1">
  <div class="box-header with-border">
    <h4 class="box-title">Clasificación</h4>
  <input type="text" name="clasificacion" value="V" class="form-control" id="clasificacion" readonly>

  </div>

  </div>



  <div class="col-md-3">
  <div class="box-header with-border">
    <div class="form-group">
            <h4 class="box-title">Rango de Fechas:</h4>

            <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right datepicker fecha_guias flat" name="form_periodo"></div>
            <!-- /.input group -->
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
    <div class="box-header with-border">
        <div class="box-header with-border">
            <div class="box-header with-border">
              <button type="button" id="programar"class="btn btn-success">Programar</button>

      </div>
      </div>
    </div>
  </div>
    </div>
  </div>
                <!-- /.box-header -->
                <div class="box-body">


                  <div class="row">
                      <div class="col-md-12 table-responsive" id="tbl_vac">

                      </div>
                  </div>
                </div>
                <!-- /.box-body -->

  </div>
            </form>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>





<script>
$(document).ready(function(){
  control_de_menu($('#menu_p_vacaciones'));
});
//moment.locale('es');
  $('#reservation').daterangepicker();

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

  $('#reservation').daterangepicker({
  "locale": {
      "format": "DD/MM/YYYY",
      "separator": " - ",
      "applyLabel": "Aplicar",
      "cancelLabel": "Cancelar",
      "fromLabel": "De",
      "toLabel": "Até",
      "customRangeLabel": "Custom",
      "daysOfWeek": [
          "Dom",
          "Lun",
          "Mar",
          "Mie",
          "Jue",
          "Vie",
          "Sáb"
      ],
      "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
      ],
      "firstDay": 0
  }});



  $(document.body).off('change','form select[name=tipo_trabajador]');
  $(document.body).on('change','form select[name=tipo_trabajador]',function(){
    let tipo=$(this).val();
    $.ajax({
      url:baseurl+'Personal/personalxtipo',
      data:{
        "tipo":tipo,
      },
      dataType:'json',
      async:false,
      type:"post",
      success:function(data){

        $('form select[name=trabajador]').find('option:not(:first)').remove();
        $.each(data,function(i,item){
            $('form select[name=trabajador]').append('<option value="'+item.codigo_personal+'">'+item.apepat_personal+' '+item.apemat_personal+', '+item.nombre_personal+'</option>');
        });

      }
    });
  });


  $(document).off('change','form select[name=periodo]');
  $(document).on('change','form select[name=periodo]',function(e){

  let valor=$(this).val();
  $.post(baseurl+"Tareo/get_vacaciones",{periodo:valor},function(data){

  $('#tbl_vac').html(data);
  $('table').DataTable({

    "order": []
  });
});
  });



  $(document).on('click','#programar',function(e){
    var periodo=$('#periodo').val();
    alertify.confirm('Programar Vacaciones', '¿Desea programar las vacaciones del colaborador con las fechas indicadas?',
    function(){
    $.ajax({
    url:baseurl+"Tareo/programar_vacaciones",
    type:"post",
    data:$('#form_vacaciones').serialize(),
    success: function(info){

          alertify.success(info);
          $.post(baseurl+"Tareo/get_vacaciones",{periodo:periodo},function(data){

          $('#tbl_vac').html(data);
          $('table').DataTable({

            "order": []
          });
        });

        },
    error: function (xhr, ajaxOptions, thrownError) {
         alertify.error('Ocurrio un error');
      }
  });
  },
                      function(){//cancela
                        alertify.error('Error');
                      });

  });

    $(document).on('click','.eliminar',function(e){
      var fila=$(this).parent().parent();
      var id=$(this).attr('data-id') ;
      alertify.confirm('Eliminar programacion de vacaciones', '¿Desea eliminar la programacion de vacaciones?',
                         function(){
                           $.ajax({
                           url:baseurl+"Tareo/eliminar_vacaciones",
                           type:"post",
                           data:"id="+id,
                           success: function(info){
                                  fila.hide();
                                 alertify.success(info);
                               },
                           error: function (xhr, ajaxOptions, thrownError) {
                                alertify.error('Ocurrio un error');
                             }
                         });
                                },
                        function(){//cancela
                          alertify.error('Error');
                        });

    });
</script>
