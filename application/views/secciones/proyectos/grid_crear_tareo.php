<div class="col-md-12 table-responsive" id="tbl_tareo">
<table class="table table-bordered table-condensed table-hover">
<thead>
  <tr>
    <th>Item</th>
    <th>Codigo</th>
    <th>Apellidos</th>
    <th>Nombre</th>
    <th>Cargo</th>
    <?php for ($i=0; $i < $dias+1; $i++) {
      $date = date($fechainicio);
      //Incrementando 2 dias
    $mod_date = strtotime($date."+".$i." days");
    echo "<th>".date("d",$mod_date) . "\n"."</th>";
    } ?>
  </tr>
</thead>
<tbody>
  <?php $item=1; foreach ($personas as $key): ?>
    <tr>
      <td><?php echo $item ?></td>
      <td><?php echo $key->codigo_personal ?></td>
      <td><?php echo $key->apellidos ?></td>
      <td><?php echo $key->nombre_personal ?></td>
      <td><?php echo $key->cargo_personal ?></td>
      <?php for ($i=0; $i<$dias+1; $i++) {
      echo "<td>T</td>";
      } ?>
    </tr>
  <?php $item++; endforeach; ?>
</tbody>
</table>
</div>
