
<table id="lista_stock" class="table table-bordered table-condensed table-hover">
  <thead>
    <tr>
      <th style="text-align:center">#</th>
      <th style="text-align:center">FICHA TÉCNICA</th>
      <th style="text-align:center">FECHA DE INGRESO</th>
      <th style="text-align:center">CÓDIGO</th>
      <th style="text-align:center">DESCRIPCIÓN PRODUCTO</th>
      <th style="text-align:center">DESCRIPCIÓN TÉCNICA</th>
          <th style="text-align:center">C.CONTABLE</th>
      <th style="text-align:center">SERIE</th>
      <th style="text-align:center">MARCA</th>
      <th style="text-align:center">MODELO</th>
      <th style="text-align:center">CAPACIDAD</th>
          <th style="text-align:center">CANTIDAD</th>
    </tr>
  </thead>

  <tbody>
  <?php foreach ($lista as $key): ?>
    <tr>
        <td style="text-align:center"><?php echo $key->idstock; ?></td>
        <td style="text-align:center"><?php echo $key->correlativo; ?></td>
        <td style="text-align:center"><?php echo $key->fecha_creacion; ?></td>
        <td style="text-align:center"><?php echo $key->codigo; ?></td>
        <td style="text-align:center"><?php echo $key->art_desc; ?></td>
        <td style="text-align:center"><?php echo $key->descripcion ; ?></td>
        <td style="text-align:center"><?php echo $key->codigo_contable; ?></td>
        <td style="text-align:center"><?php echo $key->serie; ?></td>
        <td style="text-align:center"><?php echo $key->marc; ?></td>
        <td style="text-align:center"><?php echo $key->modelo; ?></td>
        <td style="text-align:center"><?php echo $key->capacidad; ?></td>
        <td style="text-align:center"><?php echo $key->cantidad; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
$('#lista_stock').DataTable({

  "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
</script>
