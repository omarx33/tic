
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content">

              <div class="box box-default">

                <div class="box-header with-border">

                  <div class="row">
                  <div class="col-md-3">
                    <div class="box-header with-border">
                      <h3>Lista de Personal</h3>
                      <h3><?php $periodoant='2019-01'; echo date('Y-m',strtotime($periodoant."- 1 month")); ?></h3>
                    </div>
                  </div>
                  </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">


                  <div class="row">
                      <div class="col-md-12 table-responsive" id="personal" >
                        <table class="table table-bordered table-condensed table-hover">
                          <thead>
                            <tr>
                              <th>Item</th>
                              <th>Codigo</th>
                              <th>Apellidos</th>
                              <th>Nombres</th>
                              <th>Cargo</th>
                              <th>Fecha de Ingreso</th>
                              <th>Acciones</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php $item=1; foreach ($personas as $key): ?>
                              <tr>
                                <td><?php echo $item ?></td>
                                <td><?php echo $key->codigo_personal ?></td>
                                <td><?php echo $key->apepat_personal.' '.$key->apemat_personal ?></td>
                                <td><?php echo $key->nombre_personal ?></td>
                                <td><?php echo $key->cargo_personal ?></td>
                                <td><?php echo $key->fecha_actualizacion ?></td>
                                <td><input type="submit" name="" value="Baja" class="btn btn-danger eliminar" data-id="<?php echo $key->codigo_personal ?>" data-toggle="modal" data-target="#baja-personal">
                                </td>
                          </tr>

                            <?php $item++; endforeach; ?>
                          </tbody>
                        </table>
                      </div>

                  </div>



                </div>
                <!-- /.box-body -->

</div>
            </section>
            <!-- /.content -->

        <!-- /.content-wrapper -->
</div>

<div class="modal fade" id="baja-personal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="font-size:20px;" >Baja de Personal</h4>
      </div>

        <div class="modal-body">
          <form id="form_baja" method="post">


            <div class="row">
              <div class="col-md-4">
                <label for="">Fecha de Resición</label>
              </div>
              <div class="col-md-4">
                <input type="date" class="form-control"  name="fechabaja" id="fechabaja">
              </div>
              <input type="hidden" name="codpersona" value="" id="codpersona">

            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
              <label for="">Motivo</label>
              </div>
              <div class="col-md-4">
                <input type="radio" name="motivo" value="R">RENUNCIA <br>
                <input type="radio" name="motivo" value="FC">FIN DE CONTRATO
              </div>
            </div>
          </div>
          </form>


      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="eliminar" data-dismiss="modal">Dar de Baja</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script type="text/javascript">


$(document).ready(function(){
  control_de_menu($('#menu_baja_personal'));
});
$(document).ready(function(){
  $('table').DataTable({
    "order": [['0','asc']]
  });
});

$(document).on('click','.eliminar',function(e){
  var fila=$(this).parent().parent();
    var item=fila.find('td').eq(1).html();
    $('#codpersona').val(item);

});
$(document).on('click','#eliminar',function(e){
    var fila=$(this).parent().parent();
    var item=$('#codpersona').val();
    var fecha=$('#fechabaja').val();
    var tipo=$('input[name="motivo"]:checked').val();
  alertify.confirm('Baja Personal', 'Al continuar confirmará que el colaborador ya no pertenecerá al Contrato, para el reintegro debe contactarse con RRHH .¿Desea dar de baja al pesonal?',
  function(){//confirma
     $.ajax({
       url:baseurl+'Personal/baja_personal',
       data: "codigo_personal="+item+"&fechabaja="+fecha+"&tipo="+tipo,
       type:"post",
       dataType:"json",
       success:function(data){
        if(data.afectados==1){
             fila.hide();

             alertify.success('El personal fue dado de baja');

           }else{
             fila.addClass("danger");
             alertify.success('El personal no pertenece al contrato');
           }
       }

     })

    },
                    function(){//cancela
                      alertify.error('Error');
                    });

});
</script>
