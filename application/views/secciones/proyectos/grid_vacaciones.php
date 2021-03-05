

<div class="col-md-12 table-responsive" id="tbl_vac">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ITEM</th>
        <th>CODIGO</th>
        <th>NOMBRES</th>
        <th>FECHA INICIO</th>
        <th>FECHA FIN</th>
         <th style="text-align:center">ACCIONES</th>

      </tr>

    </thead>
    <tbody>
          <?php $i=1; foreach ($vacaciones as $key): ?>
            <tr>
              <td><?php echo $i ?></td>
              <td><?php echo $key->personal ?></td>
              <td><?php echo $key->trabajador ?></td>
              <td><?php echo $key->fecha_inicio ?></td>
              <td><?php echo $key->fecha_fin ?></td>
              <td><button type="button" class="btn btn-danger btn-sm eliminar" data-id="<?php echo $key->docentry ?>"><i class="glyphicon glyphicon-trash"></i></button></td>
            </tr>
          <?php $i++; endforeach; ?>

    </tbody>
  </table>
</div>
