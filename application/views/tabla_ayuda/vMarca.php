
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">

              <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
										  <h3>MARCA</h3>
                      <div class="row">

            </div>
              </div>





              <div class="box-body">

                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="tbl_marca">
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
		<form method="post" id="form_marca">
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



     <div class="form-group">
       <label for="">Nombre:</label>
       <input type="text" name="nombre" value="" class="form-control" id="nombre">



      <label for="">Ruta:</label>
      <input type="text" name="ruta" value="" class="form-control" id="ruta">

      <label>Descripción:</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="5" cols="60"></textarea>

      <label>Estado:</label>
<br>
      <input type="checkbox" name="estado"  data-toggle="toggle" data-size="normal" id="estado">




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
