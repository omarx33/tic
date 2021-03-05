
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

          <section class="content">


            <div class="box box-default">

              <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
										  <h4>Ingreso por Ficha Técnica</h4>

        </div>
              </div>

              </div>
              <div class="box-body" >
                         <div class="row" id="espacio">
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
                         <div class="row">
                           <div class="col-md-12">
                             <div class="alert alert-warning alert-dismissible">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
   <h4><i class="icon fa fa-info"></i> Sólo se visualizarán las fichas técnicas sin recepción total y que contengan el registro del requerimiento</p>
 </div>
                           </div>
                         </div>
              <div class="box-header with-border">

                <div class="col-md-12 table-responsive" id="tbl_ingreso_ficha">

                </div>


                </div>


</div>
          </section>
          <!-- /.content -->

      <!-- /.content-wrapper -->
</div>
