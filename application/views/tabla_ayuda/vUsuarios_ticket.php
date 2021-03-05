
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">

              <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
										  <h3>Usuario Ticket</h3>
                      <div class="row">

            </div>
              </div>





              <div class="box-body">

                <div class="table-responsive">
                  <table class="table table-bordered table-hover" id="tbl_usuarios_ticket">
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
		<form method="post" id="usuarios_ticket" autocomplete="off">
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
            <label>NOMBRES</label>
            <input type="text" class="form-control" name="nombres" id="nombres" value="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>APELLIDOS</label>
            <input type="text" class="form-control" name="apellidos" id="apellidos" value="">
          </div>
        </div>
      </div>


            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>DNI</label>
                  <input type="number" step="any" class="form-control" name="dni" id="dni" value="" maxlength="8" step="any" min="0" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>CORREO</label>
                  <input type="text" class="form-control" name="correo" id="correo" value="">
                </div>
              </div>
            </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">EMPRESA</label>

                    <select class="form-control" name="empresa" id="empresa">
                                    <option value="">.:Selección</option>
                      <?php foreach ($empresa as $key): ?>

                          <option value="<?php echo $key->idempresa ?>"><?php echo $key->descripcion ?></option>
                      <?php endforeach; ?>
                    </select>
              </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">ÁREA</label>
                    <select class="form-control" name="area" id="area" >
                      <option value="">.:Selección</option>
                      <?php foreach ($area as $key): ?>
                          <option value="<?php echo $key->idarea ?>"><?php echo $key->descripcion ?></option>
                      <?php endforeach; ?>
                    </select>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>CARGO</label>
              <textarea class="form-control" name="cargo" id="cargo" rows="4" cols="40" placeholder="DESCRIBE EL CARGO"></textarea>
            </div>
          </div>
        </div>

   <div class="row">
     <div class="col-md-12">
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
