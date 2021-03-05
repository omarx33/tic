
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">

              <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
										  <h4>Movimiento de componentes por OC</h4>

        </div>
              </div>

              </div>
              <div class="box-body" >

<!-- -->
<div class="row">
  <div class="col-md-3">
    <div class="form-group">

      <label for="">EMPRESA</label>
      <select class="form-control" id="empresa" >

        <?php foreach ($empresa as $key): ?>
      <option value="<?php echo $key->idempresa ?>"><?php echo $key->descripcion ?></option>
  <?php endforeach; ?>
      </select>

    </div>
  </div>



        <div class="col-md-3" id="select-tipo">
        <label>FECHA:</label>
        <div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right datepicker fecha_componentes flat" id="periodo"></div>
        </div>



          <div class="col-md-3">

          </div>

          <div class="col-md-3">

          </div>

      </div>

<!-- -->
              <div class="box-header with-border">

                <div class="col-md-12 table-responsive" id="tbl_consulta_mov">

                </div>


                </div>


</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>
