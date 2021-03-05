<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>

Equipos de TIC
        </h1>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->

        <div class="box box-solid">

            <div class="box-body">
    <!--  text -->
      <input type="hidden" id="equipoid" value="">
      <div id="equipo_grid">
        <div class="row">
            <div class="col-md-12">
              <div class="box-header with-border">
                    <button type="button" name="button" class="btn btn-secondary pull-right disabled btn-editar"  >Editar</button>
                  <button type="button" name="button" class="btn btn-primary pull-right" id="btn_modal">Nuevo</button>
             </div>
            </div>
       </div>

                <div  class="table-responsive">
                  <table  id='table' class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="display:none">#</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Ubicación</th>
                        <th>Empresa</th>
                        <th>Observaciones</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($equipos as $key): ?>
                        <tr>
                          <td style="display:none"><?php echo $key->docentry ?></td>
                          <td><?php echo $key->nombre_equipo ?></td>
                          <td><?php if ($key->estado<>1): ?>
                            Asignado
                          <?php else: ?>
                            Disponible
                          <?php endif; ?></td>
                          <td><?php if ($key->nom_area!=''): ?>
                            <?php echo $key->nom_area ?>
                          <?php else: ?>
                            <?php echo "-" ?>
                          <?php endif; ?></td>
                          <td><?php echo $key->nom_empresa ?></td>
                          <td><?php if ($key->observaciones!=''): echo $key->observaciones; else:  echo "-"; endif; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
      </div>

            </div>

        </div>

    </section>

</div>


<script type="text/javascript">
  $(document).ready(function(){
    $('#table').DataTable();
  })

  $(document).on('click','#btn_modal',function(){
    let id=0;
    $.post(baseurl+"Componente/get_detalle_equipo/nuevo/"+id,
    function(data){
      $('#equipo_grid').html(data);
    });
  });

  $(document).on('click','.btn-editar',function(){
    let id=$('#equipoid').val();
    $.post(baseurl+"Componente/get_detalle_equipo/editar/"+id,
    function(data){
      $('#equipo_grid').html(data);
    });
  });

  $(document).on('click','#table tbody tr', function () {
        let valor=$(this).find('td').eq(0).html();
       $('#equipoid').val(valor);

       $('.btn-editar').removeClass( "disabled" );
       $('.btn-editar').attr("disabled", false);
       $('tr').removeClass('info');
       $(this).addClass('info');

  });

</script>
