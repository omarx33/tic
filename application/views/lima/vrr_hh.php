<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <section class="content">
            <div class="box box-default">

                            <div class="box-header with-border">


                              <h3 class="box-title">TAREO DIARIO</h3>
              <!--
                              <select class="form-control" name="">
                                <option value="">ENERO</option>
                                <option value="">FEBRERO</option>
                                <option value="">MARZO</option>
                                <option value="">ABRIL</option>
                              </select>
              -->


                            </div>

                            <form method="post" id="tareo_diario">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="callout callout-warning">
                                              <h4>Indicaciones!</h4>

                                              <p>*Al presionar el boton <span style="color:green"><b>Grabar</b></span> solo se grabará los cambios de la lista mostrada en la tabla según el tipo de trabajador que eligió.</p>
                                              <p>*Para registrar las horas extras <span style="color:yellow"><b>Boton Amarillo</b></span> solo se  tiene permitido 1 hora por trabajador. </p>
                                              <p>*Para registrar los dias de apoyo <span style="color:skyblue"><b>Boton Celeste</b></span> solo seleccione la clasificación "Dia de Apoyo". </p>
                                              <p>*Al termino de la clasificacion en el dia seleccionado para todo el personal, presione el boton <span style="color:red"><b>Cerrar Día</b></span>, esta accion cerrará el día seleccionado y ya no podrá ser modificado.</p>
                                              <p>*Para la apertura del día cerrado, por favor solicitar al área de Operaciones/Gestión Humana</p>
                              </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-2">
                                  <div class="box-header with-border">
                              <h4 class="box-title">Tipo de Trabajo</h4>
                                <select name="tipo_trabajador" class="form-control select2" id="tipo_trabajador" required>
                                  <option value="">seleccionar::</option>
                                    <?php foreach ($tipo as $key): ?>
                                      <option value="<?php echo $key->id_tipo_trabajador ?>"><?php echo $key->desc_tipo_trabajador ?></option>
                                    <?php endforeach; ?>

                                  </select>
                              </div>
                            </div>


                            <div class="col-md-2">
                          <div class="box-header with-border">
                            <h4 class="box-title">Periodo</h4>
                            <select name="periodo" class="form-control select2" id="periodo"  required>
                                <option value="">seleccionar::</option>
                                <?php foreach ($periodo as $key): ?>
                                  <option value="<?php echo $key->periodo_tareo ?>"><?php echo $key->periodo_tareo ?></option>
                                <?php endforeach; ?>
                              </select>

                          </div>

                          </div>


                  <div class="col-md-2">
                  <div class="box-header with-border">
                    <div class="form-group">
                                <label>Fecha:</label>

                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <select class="form-control" name="dia" id="dia">
                                    <option value="">seleccionar::</option>
                                  </select>
                                </div>
                                <!-- /.input group -->
                              </div>

                </div>
                  </div>


                  <div class="col-md-1">
                    <div class="box-header with-border">
                        <div class="box-header with-border">
                            <div class="box-header with-border">
                  <button style="text-align:right" type="button" class="btn btn-primary" id="listar">
                      Listar
                    </button>
                      </div>
                      </div>
                    </div>
                  </div>

                                  <div class="col-md-3">


                                  </div>

                  <div class="col-md-2" >

                    <div class="box-header with-border">
                        <div class="box-header with-border">
                            <div class="box-header with-border">
                  <button style="text-align:right" type="button" class="btn btn-danger" id="cerrardia">
                      Cerrar Dia
                    </button>
                      </div>
                      </div>
                    </div>
                  </div>



                  </div>

                              <!-- /.box-header -->
                              <div class="box-body">


                                <div class="row">
                                    <div class="col-md-12 table-responsive" id="tbl_tareodiario">
                                      <div id="msg">

                                      </div>
                                    </div>
                                </div>
                              </div>
                            </form>

              <!-- /.box-body -->

</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>


<div class="modal fade" id="modal-actual">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="font-size:20px;" id="tipotiempondesc"></h4>
      </div>

        <div class="modal-body">
          <form id="form_tiempoextra" method="post">

            <div class="row">
              <div class="col-md-12">
                <label id="nombre"></label>
              </div>

            </div>
            <div class="row">
              <input type="hidden" name="periodote" value="" id="periodote">
              <input type="hidden" name="diate" value="" id="diate">
              <input type="hidden" name="trabajadorte" value="" id="trabajadorte">
                <input type="hidden" name="tipotiempo" value="" id="tipotiempo">
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="">Tiempo:</label>
                <input type="number" class="form-control" id="tiempo" placeholder="" value="1" readonly name="tiempo">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="">Motivo:</label>
                <textarea class="form-control" id="motivo" name="motivo" rows="3" placeholder="" required></textarea>
              </div>
            </div>


          </div>
          </form>


      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardar_tiempo" data-dismiss="modal">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
