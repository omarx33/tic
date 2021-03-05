
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
              Área

                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
            <!--  text -->
                     <table class="table table-bordered table-hover" id="tbl_area">
                       <thead>

                       </thead>
                       <tbody>

                       </tbody>
                     </table>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->








        <div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="editar_modal">
          <div class="modal-dialog " role="document">
        		<form method="post" id="form_area">
            <div class="modal-content">
        			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
              </div>
              <div class="modal-body">
        				<div class="form-group">
        					<div id="msg"></div>
        				</div>
        		<!--		<input type="hidden" name="txtSeriedoc" id="txtSeriedoc">-->
        				<input type="hidden" name="id" id="id">
               	<input type="hidden" name="txtAccion" id="txtAccion">


         <div class="row">
           <div class="col-md-6">
             <div class="form-group">
               <label for="">Descripción:</label>
               <input type="text" name="descripcion" value="" class="form-control" id="descripcion">
             </div>
           </div>

          <div class="col-md-6">
            <div class="form-group">
                <label>Estado</label>
                <br>

                    <input type="checkbox" name="estado"  data-toggle="toggle" data-size="normal" id="estado">

            </div>
          </div>



         </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_submit">Guardar</button>
              </div>
            </div>
        		</form>
          </div>
        </div>
