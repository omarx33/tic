
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">



                <div class="box-header with-border">
										  <h4>STOCK</h4>

        </div>
    <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">EMPRESA</label>
              <select class="form-control" id="empresa" style="width:15%">

                <?php foreach ($empresa as $key): ?>
              <option value="<?php echo $key->idempresa ?>"><?php echo $key->descripcion ?></option>
          <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>


              <div class="box-header with-border">

                <div class="col-md-12 table-responsive" id="tbl_stock">

                </div>


                </div>

</div>
</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>
