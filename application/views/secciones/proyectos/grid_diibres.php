
<div class="col-md-12 table-responsive" id="tbl_dl">
  <button type="button" class="btn btn-info" name="button" id="actualizar">Cerrar Dias Libres</button>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th rowspan="2">N°</th>
        <th rowspan="2">CODIGO</th>
        <th rowspan="2">NOMBRES</th>
        <th rowspan="2">CARGO</th>
        <th colspan="<?php $diff=$dateinicio->diff($datefin); $dias=$diff->days; $total=$dias+1; echo $total ?>" style="text-align:center">Días</th>

      </tr>

      <tr>
        <?php
        $diff=$dateinicio->diff($datefin);
        $dias=$diff->days;
        for ($i=0; $i < $dias+1; $i++) {

          $date = date($inicio);
          //Incrementando 2 dias
        $mod_date = strtotime($date."+".$i." days");
        echo "<th>".date("d",$mod_date) . "\n"."</th>";
        } ?>

      </tr>
    </thead>
    <tbody>
      <?php $item=1; foreach ($personas as $key): ?>
        <tr>
          <td><?php echo $item; ?></td>
          <td class="personal"><?php echo $key->codigo_personal ?></td>
          <td><?php echo $key->trabajador ?></td>
          <td><?php echo $key->cargo_personal ?></td>
          <?php
          $diff=$dateinicio->diff($datefin);
          $dias=$diff->days;
          for ($i=0; $i < $dias+1; $i++) {

          echo "<td class='validardia".($i+1)."'><input type='checkbox' class='dlibre'  data-id='dia".($i+1)."'> </td><td class='dia".($i+1)."' style='display:none;'>0</td>";

          } ?>
        </tr>
      <?php $item++; endforeach; ?>

    </tbody>
  </table>

</div>
