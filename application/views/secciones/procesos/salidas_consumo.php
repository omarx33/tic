
<table id="lista_salida" class="table table-bordered table-condensed table-hover">
  <thead>
    <tr>
      <th style="text-align:center">NÚMERO</th>
      <th style="text-align:center">USUARIO</th>
      <th style="text-align:center">ÁREA</th>
      <th style="text-align:center">EQUIPO</th>
        <th style="text-align:center">TÉCNICO</th>
      <th style="text-align:center">EMPRESA</th>
        <th style="text-align:center">DESCRIPCIÓN</th>
        <th style="text-align:center">FECHA</th>
          <th style="text-align:center">ACCIONES</th>

    </tr>
  </thead>

  <tbody>
  <?php foreach ($ficha as $key): ?>
    <tr>

        <td style="text-align:center"><?php echo $key->numero; ?></td>
    <td style="text-align:center"><?php echo $key->full ; ?></td>
        <td style="text-align:center"><?php echo $key->area ; ?></td>
        <td style="text-align:center"><?php echo $key->equipo ; ?></td>
        <td style="text-align:center"><?php echo $key->fullname ; ?></td>
        <td style="text-align:center"><?php echo $key->descripcion; ?></td>
        <td style="text-align:center"><?php echo $key->info; ?></td>
        <td style="text-align:center"><?php echo date('d-m-Y ',strtotime($key->fecha_creacion)); ?></td>
  <td style="text-align:center">

    <a  href="#" data-descripcion="<?php echo $key->equipo ?>"
                 data-tecnico="<?php echo $key->idusuario ?>"
                 data-usuario="<?php echo $key->user ?>"
                 data-area="<?php echo $key->idarea ?>"
                 data-info="<?php echo $key->info ?>"

                  data-numero="<?php echo $key->numero ?>"
      class="btn btn-xs btn-warning editar-salidas"><i class="glyphicon glyphicon-edit"></i></a>
        <a href="#" data-id="<?php echo $key->numero ?>"  class="btn btn-xs btn-primary verdetalle"><i class="glyphicon glyphicon-zoom-in"></i></a>
        <a href="#" class="btn btn-xs btn-danger eliminar"  data-id="<?php echo $key->numero ?>"

          ><i class="glyphicon glyphicon-trash"></i></a>
  </td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
$('#lista_salida').DataTable({

  "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
</script>
