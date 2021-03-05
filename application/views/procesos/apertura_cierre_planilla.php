<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Apertura y Cierre de Planilla de Movilidad
        </h1>
    </section>
    <section class="content">
        <!-- Default box -->
    <div class="box box-solid">

        <div class="box-body">
      <div id="equipo_grid">
        <div class="row">
            <div class="col-md-12">
              <div class="box-header with-border">
                    <button type="button" name="button" class="btn btn-secondary pull-right disabled btn-editar" >Editar</button>
                  <button type="button" name="button" class="btn btn-primary pull-right" id="btn_modal">Nuevo</button>
             </div>
            </div>
       </div>
                <div  class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Planilla</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $item=1; foreach ($planillas as $key): ?>
                        <?php if ($key->estado==0): ?>
                          <tr>
                            <td style="display:none"><?php echo $key->docentry ?></td>
                            <td><?php echo $item ?></td>
                            <td><?php echo $key->correlativo ?></td>
                            <td><?php echo $key->fecha ?></td>
                            <td><button type="button" class="btn btn-danger cerrar" data-id="<?php echo $key->docentry?>" name="button">Cerrar</button> </td>
                          </tr>
                        <?php endif; ?>
                      <?php $item++; endforeach; ?>
                    </tbody>
                  </table>
                </div>
      </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="add_modal">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Componente</h4>
      </div>
      <div class="modal-body">
        <form id="form_gasto" action="index.html" method="post">
          <div class="row">
            <div class="col-md-12">
              <h4>*Consulte al área de recepción para el correlativo del formato</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Correlativo de la Planilla</label>
              <input type="text" class="form-control" name="correlativo" id="correlativo" value="">
              <input type="hidden" class="form-control" name="docentry" id="docentry" value="">
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d') ?>">
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_submit">Agregar</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  $(document).on('click','#btn_modal',function(){
    $('#correlativo').attr('readonly',false);
        $('#add_modal').modal('show');
        $('#docentry').val('0');
  })
  $(document).on('click','.btn-editar',function(){
    $('#correlativo').attr('readonly',false);
        $('#add_modal').modal('show');
  })

  $(document).on('click','.cerrar',function(){
    var id = $(this).attr('data-id');

    $.ajax({
    url:baseurl+"Usuarios/cerrar_planilla",
    data:"id="+id,
    type:"post",
    success:function(data){
      location.reload();
    }

    });
  })

  $(document).on('click','#btn_submit',function(){
    $.ajax({
    url:baseurl+"Usuarios/crear_planilla",
      data:$('#form_gasto').serialize(),
    type:"post",
    success:function(data){
      location.reload();
    }

    });
  })

    $(document).on('click','table tbody tr', function () {

          let id=$(this).find('td').eq(0).html();
          $('#docentry').val(id);
          let correlativo=$(this).find('td').eq(2).html();
          $('#correlativo').val(correlativo);
          let fecha=$(this).find('td').eq(3).html();
          $('#fecha').val(fecha);
         //$('#correlativo').attr('readonly',false);
         $('.btn-editar').removeClass( "disabled" );
         $('.btn-editar').attr("disabled", false);
         $('tr').removeClass('info');
         $(this).addClass('info');

    });
</script>
