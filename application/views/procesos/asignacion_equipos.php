<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Asignación de Equipos</h1>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->

        <div class="box box-solid">

            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <label>Seleccione Empresa</label>
                  <select class="form-control select2" name="empresa" id="empresa">
                    <option value="0">.:Seleccione la Empresa:.</option>
                    <?php foreach ($empresa as $key): ?>
                  <option value="<?php echo $key->idempresa ?>"><?php echo $key->descripcion ?></option>
              <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div id="grid_asignacion">

              </div>
            </div>

        </div>

    </section>

</div>
