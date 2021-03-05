
<div class="col-md-12 table-responsive" id="tbl_tareo">
  <div class="row">
    <div class="col-md-10">

    </div>
    <div class="col-md-2">

        <button type="button" class="btn btn-success" name="button" id="excel">Exportar en Excel</button>
        <button type="button" class="btn btn-primary" name="button" id="starsoft">Plantilla Starsoft</button>
    </div>
  </div>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th rowspan="2">N°</th>
        <th rowspan="2">CODIGO</th>
        <th rowspan="2">NOMBRES</th>
        <th rowspan="2">CARGO</th>
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
          <td><?php echo $key->desc_tipo_trabajador ?></td>
          <td><?php  if($key->dia1==''){ echo 'T';}else{echo $key->dia1;} ?></td>
          <td><?php if($key->dia2==''){echo 'T';}else {echo $key->dia2;} ?></td>
          <td><?php if($key->dia3==''){echo 'T';}else {echo $key->dia3;} ?></td>
          <td><?php if($key->dia4==''){echo 'T';}else {echo $key->dia4;} ?></td>
          <td><?php if($key->dia5==''){echo 'T';}else {echo $key->dia5;} ?></td>
          <td><?php if($key->dia6==''){echo 'T';}else {echo $key->dia6;} ?></td>
          <td><?php if($key->dia7==''){echo 'T';}else {echo $key->dia7;} ?></td>
          <td><?php if($key->dia8==''){echo 'T';}else {echo $key->dia8;} ?></td>
          <td><?php if($key->dia9==''){echo 'T';}else {echo $key->dia9;} ?></td>
          <td><?php if($key->dia10==''){echo 'T';} else{ echo $key->dia10;} ?></td>
          <td><?php if($key->dia11==''){echo 'T';} else{ echo $key->dia11;} ?></td>
          <td><?php if($key->dia12==''){echo 'T';} else{ echo $key->dia12;} ?></td>
          <td><?php if($key->dia13==''){echo 'T';} else{ echo $key->dia13;} ?></td>
          <td><?php if($key->dia14==''){echo 'T';} else{ echo $key->dia14;} ?></td>
          <td><?php if($key->dia15==''){echo 'T';} else{ echo $key->dia15;} ?></td>
          <td><?php if($key->dia16==''){echo 'T';} else{ echo $key->dia16;} ?></td>
          <td><?php if($key->dia17==''){echo 'T';} else{ echo $key->dia17;} ?></td>
          <td><?php if($key->dia18==''){echo 'T';} else{ echo $key->dia18;} ?></td>
          <td><?php if($key->dia19==''){echo 'T';} else{ echo $key->dia19;} ?></td>
          <td><?php if($key->dia20==''){echo 'T';} else{ echo $key->dia20;} ?></td>
          <td><?php if($key->dia21==''){echo 'T';} else{ echo $key->dia21;} ?></td>
          <td><?php if($key->dia22==''){echo 'T';} else{ echo $key->dia22;} ?></td>
          <td><?php if($key->dia23==''){echo 'T';} else{ echo $key->dia23;} ?></td>
          <td><?php if($key->dia24==''){echo 'T';} else{ echo $key->dia24;} ?></td>
          <td><?php if($key->dia25==''){echo 'T';} else{ echo $key->dia25;} ?></td>
          <td><?php if($key->dia26==''){echo 'T';} else{ echo $key->dia26;} ?></td>
          <td><?php if($key->dia27==''){echo 'T';} else{ echo $key->dia27;} ?></td>
          <td><?php if($key->dia28==''){echo 'T';} else{ echo $key->dia28;} ?></td>
          <?php if ($dia29!='0' or $dia29!=''): ?>
          <td><?php if($key->dia29==''){echo 'T';} else{ echo $key->dia29;} ?></td>
          <?php endif; ?>
          <?php if ($dia30!='0' or $dia30!=''): ?>
          <td><?php if($key->dia30==''){echo 'T';} else{ echo $key->dia30;} ?></td>
          <?php endif; ?>
          <?php if ($dia31!='0' or $dia31!=''): ?>
          <td><?php if($key->dia31==''){echo 'T';} else{ echo $key->dia31;} ?></td>
          <?php endif; ?>

        </tr>
      <?php $item++; endforeach; ?>

    </tbody>
  </table>

</div>
