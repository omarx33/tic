<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <section class="content">
            <div class="box box-default">

              <div class="row">
                  <div class="col-md-4">
                    <div class="box-header with-border">
					             <h1 class="box-title">REPORTE DE HORAS EXTRAS</h1>
				            </div>
                  </div>
              </div>


              <!-- /.box-header -->
              <div class="box-body">


                <div class="row">
                    <div class="col-md-12 table-responsive" >
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>PERIODO</th>
                            <th>CODIGO</th>


                          </tr>

                        </thead>
                        <tbody>
                          <?php foreach ($periodo as $key): ?>
                            <tr>
                              <td><?php echo $key->periodo_tareo ?></td>
                              <td><a type="button" class="btn btn-edit btn-sm btn-info" target="_blank" href="<?php echo base_url()?>/Reportes/horas_extra/<?php echo $key->periodo_tareo ?>"><i class="glyphicon glyphicon-print"></i></a></td>
                            </tr>
                          <?php endforeach; ?>
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
<script type="text/javascript">
$(document).ready(function(){
  control_de_menu($('#menu_reporte_horas_extra'));
});
</script>
