
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">


                <div class="box-header with-border">
										  <h4>Ficha Técnica</h4>




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

                <div class="table-responsive" id="tbl_ficha_tecnica">

                </div>


                </div>

</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>











<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="myModal2">
  <div class="modal-dialog modal-lg" role="document">
		<form method="post" id="ficha_tecnica" autocomplete="off">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div id="msg"></div>
				</div>
        <input type="hidden" name="empresais" id="empresais" >
				<input type="hidden" name="correlativo" id="correlativo" >
        <input type="hidden" name="txtAccion" id="txtAccion" >



        <div class="row">
          <div class="col-md-2">
            <div class="form group">
              <label>TICKET PENDIENTE</label>
              <div id="draw_t_pendientes">
                <input type="text" class="form-control" name="nro_ticket_pendientes_e" id="nro_ticket_pendientes_e"/>
                <select class="form-control" name="nro_ticket_pendientes" id="nro_ticket_pendientes">
                  <option selected disabled>.::. Selección</option>
                  <?php foreach ($tickets_pendientes as $key): ?>
                    <option value="<?php echo $key->ticket_pendiente ?>"><?php echo $key->ticket_pendiente;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="">SOLICITANTE</label>
              <select class="form-control select2" style="width:100%" name="solicitante" id="solicitante">
                <option value="">.:Selección</option>
                <?php foreach ($solicitante as $key): ?>
                    <option value="<?php echo $key->idusuario ?>"><?php echo $key->nombres." ".$key->apellidos ?></option>
                <?php endforeach; ?>
              </select>
              </div>
          </div>

          <div class="col-md-5">
            <div class="form-group">
              <label for="">REQUERIMIENTO</label>
             <input type="text"  class="form-control" name="requerimiento" id="requerimiento" value="0" readonly>
              </div>
          </div>


        </div>


<!-- -->
       <div class="row">



<!-- -->
         <div class="col-md-12" id="sel_area">

             </div>

       </div>







       <br>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>DESCRIPCIÓN</label>
              <textarea name="descripcion" id="descripcion" class="form-control" rows="4" cols="40"></textarea>
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
