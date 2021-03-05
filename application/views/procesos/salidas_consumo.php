
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">


                <div class="box-header with-border">
										  <h3>SALIDAS POR CONSUMO</h3>

<br>


                      <div class="row">
                        <div class="col-md-3" >
                          <div class="form-group">

  <div id="empresaid">

                            <label for="">EMPRESA</label>
                            <select class="form-control" id="empresa" >

                              <?php foreach ($empresa as $key): ?>
                            <option value="<?php echo $key->idempresa ?>"><?php echo $key->descripcion ?></option>
                        <?php endforeach; ?>
                            </select>
</div>
                          </div>
                        </div>





                              <div class="col-md-3" id="select-fecha">
                                <div id="fechaid">
                              <label>FECHA:</label>
                              <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right datepicker fecha_componentes flat" id="periodo"></div>
                              </div>

</div>

                                <div class="col-md-3">

                                </div>



                                <div class="col-md-3" >
   <button type="button" name="button" id="btn_modal" class="btn btn-info pull-right"   >   Agregar</button>
                                </div>



</div>
        </div>

              <div class="box-header with-border">

                <div class="col-md-12 table-responsive" id="tbl_salida_consumo">

                </div>


                </div>


</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>


<!-- modal -->








<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="modalsalidas">
  <div class="modal-dialog " role="document">
		<form method="post" id="salidas_consumo" autocomplete="off">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div id="msg"></div>
				</div>
        <input type="hidden" name="emp" id="emp" >
				<input type="hidden" name="correlativo" id="correlativo"  >
        <input type="hidden" name="txtAccion" id="txtAccion" >






        <!-- -->
               <div class="row">



        <!-- -->
        



               </div>

<br>



               <div class="row">


                 <div class="col-md-6">
                   <div class="form-group">
                     <label for="">EQUIPO</label>
                  <input type="text" class="form-control" name="equipo" id="equipo" name="equipo">
                   </div>
                 </div>

                 <div class="col-md-6">
                   <div class="form-group">
                     <label for="">TÉCNICO SOLICITANTE</label>
                     <select class="form-control select2" id="use_tic" name="use_tic">
                 <option value="">.:Seleccione</option>
                       <?php foreach ($user_tic as $key): ?>
                     <option value="<?php echo $key->idusuario ?>"><?php echo $key->nombres." ".$key->apellidos ?></option>
                 <?php endforeach; ?>
                     </select>
                   </div>
                 </div>


               </div>


<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="">USUARIO</label>
      <select class="form-control select2" id="usuario" name="usuario">
  <option value="">.:Seleccione</option>
        <?php foreach ($solicitante as $key): ?>
      <option value="<?php echo $key->idusuario ?>"><?php echo $key->nombres." ".$key->apellidos ?></option>
  <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="">ÁREA</label>
      <select class="form-control select2" id="area" name="area">
  <option value="">.:Seleccione</option>
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
              <label>DESCRIPCIÓN</label>
              <textarea name="descripcion" id="descripcion" class="form-control" rows="5" cols="40"></textarea>
            </div>
          </div>

        </div>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_agregar">Guardar</button>
      </div>
    </div>
		</form>
  </div>
</div>
