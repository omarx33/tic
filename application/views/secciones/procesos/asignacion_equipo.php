<!--  text -->
  <input type="hidden" id="equipoid" value="">
  <div id="asignacion_equipo_grid">
    <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">
          <button type="button" name="button" class="btn btn-primary pull-right" id="btn_modal">Nuevo</button>
         </div>
        </div>
   </div>

            <div id='table' class="table-responsive">
              <table id="tabla" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>CARGO DE ASIGNACIÓN</th>
                    <th>USUARIO</th>
                    <th>EQUIPO</th>
                    <th>AREA</th>
                    <th>TIPO</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $item=1; foreach ($asignaciones as $key): ?>
                    <tr>
                      <td><?php echo $item ?></td>
                      <td><?php echo $key->cargo_asignacion ?></td>
                      <td><?php echo $key->nom_usuario ?></td>
                      <td><?php echo $key->nom_equipo ?></td>
                      <td><?php echo $key->nom_area ?></td>
                      <td><?php
                        switch ($key->tipo) {
                  case 1:
                    echo "<span class='label bg-black disabled color-palette'>Asignado</span>";
                    break;
                    case 2:
                      echo "<span class='label bg-black-active color-palette'>Cambio de Dependencia</span>";
                      break;
                      case 3:
                        echo "<span class='label bg-black-active color-palette'>Préstamo</span>";
                        break;
                        case 4:
                          echo "<span class='label bg-black-active color-palette'>Entrega de Elemento</span>";
                          break;
                          case 5:
                            echo "<span class='label bg-black-active color-palette'>Otro</span>";
                            break;
                  default:
                    // code...
                    break;
                }?></td>
                      <td>
                          <button type="button" class="btn btn-primary ver_detalle" data-id="<?php echo $key->docentry ?>" name="button"><i class="glyphicon glyphicon-eye-open"></i>  </button>
                          <a type="button" class="btn btn-success cargo_asignacion" href="<?php echo base_url() ?>/Reportes/cargo_asignacion/<?php echo $key->docentry  ?>" target="_blank"><i class="glyphicon glyphicon-list-alt"></i>  </a>
                          <a type="button" class="btn btn-success cargo_traslado"href="<?php echo base_url() ?>/Reportes/cargo_traslado/<?php echo $key->docentry  ?>" target="_blank"><i class="fas fa-dolly"></i>  </a>
                      </td>
                    </tr>
                  <?php $item++; endforeach; ?>
                </tbody>
              </table>
            </div>
  </div>
  <div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="add_modal">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Crear Cargo de Asignación</h4>
        </div>
        <div class="modal-body">
          <form id="form_asignacion" method="post">
            <div class="row">
              <div class="col-md-12">
                <label>CARGO DE ASIGNACION</label>
                <input type="text" class="form-control" name="cargo_asignacion" id="cargo_asignacion" value="" readonly>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <label>Elija al Usuario</label>
                <select class="form-control select2" style="width: 100%;"  name="usuario" id="usuario">

                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <label>Elija el Área</label>
                <select class="form-control select2" style="width: 100%;"  name="area" id="area">

                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <label>Elija el Equipo</label>
                <select class="form-control select2" style="width: 100%;"  name="equipo_asignado" id="equipo_asignado">

                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <label>Tipo de Cargo</label>
                <select class="form-control select2" style="width: 100%;"  name="tipo" id="tipo">
                  <option value="0">Seleccione Tipo</option>
                  <option value="1">Asignación</option>
                  <option value="2">Cambio de Dependencia</option>
                  <option value="3">Préstamo</option>
                  <option value="4">Entrega de Elemento</option>
                  <option value="5">Otro</option>
                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <label>Especificaciones</label>
                <textarea name="descripcion_equipo" id="descripcion_equipo" class="form-control" rows="8" cols="80" readonly></textarea>
              </div>
            </div><br>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="btn_submit">Generar Asignación</button>
        </div>
      </div>

    </div>
  </div>
  <div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="detalle_cargo">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Detallado de Cargo de Asignación</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <label>Cargo Asignación</label>
              <input type="text" class="form-control" name="cargo_asignacion" id="cargo_asignacion_id" value="" readonly>
              <input type="hidden" name="" value="" id="docentry_cargo">
            </div>
            <div class="col-md-4">
              <label>Usuario</label>
              <input type="text" class="form-control" name="usuario" value="" id="usuario_id" readonly>
            </div>
            <div class="col-md-4">
              <label>Tipo de Cargo</label>
              <input type="text" class="form-control" name="tipo_cargo" value="" id="tipo_cargo_id" readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha de Asignación</label>
              <input type="text" class="form-control" name="fecha_cargo" id="fecha_cargo_id" value="" readonly>
            </div>
            <div class="col-md-4">
              <label>Fecha de Devolución</label>
              <input type="text" class="form-control" name="fecha_devolucion" id="fecha_devolucion_id" value="" readonly>
            </div>
            <div class="col-md-4">
              <label>Estado</label>
              <input type="text" class="form-control" name="estado" id="estado_id" value="" readonly>
              <input type="hidden" id="equipo_id" name="" value="">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tbl_detalleasignacion">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Codigo</td>
                  <td>Descripción</td>
                    <td>Serie</td>
                    <td>Descripción técnica</td>

                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-12">
              <button type="button" name="button" class="btn btn-danger pull-right" id="anular_cargo">Devolución de Equipo</button>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>

    </div>
  </div>
<script>

$('#tabla').DataTable({

  "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});

</script>
