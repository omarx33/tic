
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">

              <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
										  <h3>CORRELATIVOS</h3>
                      <div class="row">

            </div>
              </div>





              <div class="box-body">

                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="tbl_correlativos" style="whidth:100%">
                    <thead>

                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>



            </div>
            </div>



</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>







<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="editar_modal">
  <div class="modal-dialog " role="document">
		<form method="post" id="form_correlativo">
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
       <label for="">Tipo:</label>
       <input type="text" name="tipo" value="" class="form-control" id="tipo">
     </div>
   </div>

<div id="test">
  <div  class="col-md-6">
    <div class="form-group">
      <label for="">Número:</label>
      <input type="text" name="correlativo" value="" class="form-control" id="correlativo">
    </div>
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
