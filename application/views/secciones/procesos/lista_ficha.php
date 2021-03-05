
<table id="lista_ficha" class="table table-bordered table-condensed table-hover">
  <thead>
    <tr>
      <th style="text-align:center">NÚMERO</th>
      <th style="text-align:center">U.TÉCNICO</th>
      <th style="text-align:center">REQUERIMIENTO</th>
      <th style="text-align:center">ÁREA</th>
      <th style="text-align:center">SOLICITANTE</th>
      <th style="text-align:center">EMPRESA</th>
      <th style="text-align:center">FECHA</th>
      <th>ESTADO</th>
      <th style="text-align:center">ACCIONES</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($ficha as $key): ?>

        <?php if ($key->atendido<$key->solicitado and $key->nro_requerimiento!=0): ?>
                <tr>
          <td style="text-align:center"><?php echo str_pad($key->correlativo, 7, "0", STR_PAD_LEFT) ?></td>
          <td style="text-align:center"><?php echo $key->usuario_tic; ?></td>
          <td style="text-align:center"><?php echo $key->nro_requerimiento ?></td>
          <td style="text-align:center"><?php echo $key->area; ?></td>
          <td style="text-align:center"><?php echo $key->fullname; ?></td>
          <td style="text-align:center"><?php echo $key->empresa; ?></td>
          <td style="text-align:center"><?php echo $key->fecha_creacion; ?></td>
          <td><?php if ($key->atendido==$key->solicitado): ?>
            <?php echo "ATENDIDO" ?>
          <?php else: ?>
            <?php echo "PENDIENTE" ?>
          <?php endif; ?></td>
        <td style="text-align:center">  <a href="#" data-id="<?php echo $key->id_ficha ?>" class="btn btn-xs btn-primary detalle"><i class="glyphicon glyphicon-zoom-in"></i></a></td>
      </tr>
    <?php endif; ?>

    <?php endforeach; ?>
  </tbody>
</table>
<script>
$(document).ready(function(){
    $('#lista_ficha').DataTable();
})
</script>
