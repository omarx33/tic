
<table id="lista_ficha" class="table table-bordered table-condensed table-hover">
  <thead>
    <tr>
      <th style="text-align:center">#</th>
      <th style="text-align:center">CÓDIGO</th>
      <th style="text-align:center">SERIE</th>
         <th style="text-align:center">FECHA</th>
        <th style="text-align:center">ESTADO</th>
    </tr>
  </thead>

  <tbody>
  <?php
   $contador = 1;
  foreach ($lista as $key): ?>
    <tr>
       <td style="text-align:center"><?php echo $contador++; ?></td>
        <td style="text-align:center"><?php echo $key->codigo_contable; ?></td>
        <td style="text-align:center"><?php echo $key->serie; ?></td>
       <td style="text-align:center"><?php echo $key->fecha_creacion; ?></td>
   <td style="text-align:center">

<?php switch ($key->estado) {
  case '11':
    echo "<span class='label bg-black disabled color-palette'>Emitido</span>";
    break;
    case '12':
      echo "<span class='label bg-green-active color-palette'>Anulado</span>";
      break;
  default:
  echo "<span class='label bg-green-active color-palette'>Anulado</span>";
    break;
} ?>

   </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
$('#lista_ficha').DataTable({

  "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
</script>
