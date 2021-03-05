
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content">
<div class="box box-default">
              <div class="row">

        <!-- /.col (left) -->
        <div class="col-md-12">

          <!-- /.box -->

          <!-- iCheck -->
          <div class="box box-success">

            <div class="box-header">
             <h3 class="box-title">Lista de Cierre</h3>
             <div class="pull-right hidden-xs" style="" >
               <label>Seleccione fecha</label>
              <input type="month" name="" value="">
             </div>

            </div>


            <div class="box-body">


              <div class="row">
                  <div class="col-md-12 table-responsive" >
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th style="text-align:center">CTR</th>
                          <th style="text-align:center">OPERACIONES</th>
                          <th style="text-align:center">RR.HH</th>





                        </tr>

                      </thead>
                      <tbody>
                        <div class="box-body">
                         <div class="form-group">




                            <tr>
                              <td style="text-align:center"> <input style="width:30px;height:30px" type="checkbox" class="minimal" checked onclick="return false;"></td>
                              <td style="text-align:center"><input style="width:30px;height:30px" type="checkbox" class="minimal"  onclick="return false;"></td>
                              <td style="text-align:center"> <input style="width:30px;height:30px" type="checkbox" class="minimal"  onclick="return false;"></td>



                            </tr>
                            </div>
                            </div>








                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <!-- /.box-body -->


          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->
      </div>
      </div>
            </section>
            <!-- /.content -->

        <!-- /.content-wrapper -->
</div>

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(document).ready(function(){
  control_de_menu($('#menu_t_cerrados'));
});
    $(function () {

$('#example1').DataTable();
      })
</script>
