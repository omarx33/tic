<div class="col-md-12 table-responsive" id="tbl_tareodiario">
  <div class="row">
    <div class="col-md-10">

    </div>
    <div class="col-md-2 pull-right" >

      <button style="text-align:right" type="button" class="btn btn-success" id="grabardia">
      Grabar
      </button>

    </div>
  </div>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>N°</th>
        <th>CODIGO</th>
        <th>NOMBRES</th>
        <th>CLASIFICACIÓN</th>
        <th>ACCIONES</th>


      </tr>

    </thead>
    <tbody>
      <div class="box-body">
       <div class="form-group">
          <?php $i=1; foreach ($tareodiario as $key): ?>
            <tr <?php if ($key->dia=='R' or $key->dia=='FC'): ?>
              <?php echo 'style="display:none;"' ?>
            <?php endif; ?> >
              <td class="item"><?php echo $i ?></td>
              <td class="codigo_personal"><?php echo $key->codigo_personal ?></td>
              <td class="nombre"><?php echo $key->apepat_personal." ".$key->apemat_personal.", ".$key->nombre_personal ?></td>
              <td class="changediatd"><select class="form-control changedia" name="">
                  <?php foreach ($clasificacion as $row): ?>
                    <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $key->dia): ?>
                      <?php echo "selected"; ?>
                    <?php endif; ?>> <?php echo $row->desc_clasificacion  ?>

                  </option>
                  <?php $i++; endforeach; ?>
              </select> </td>
              <td  class="dia" style="display:none;"><?php if ($key->dia=='' or $key->dia=='T') {
                echo 'T';
              }else {
                echo $key->dia;
              } ?></td>
              <td class="hextra" style="display:none;">
              <button style="text-align:right" type="button" class="btn btn-warning horas_extra" data-id="<?php echo $key->codigo_personal ?>" data-toggle="modal" data-target="#modal-actual">
                  <span class="glyphicon glyphicon-time"></span>
                </button>
              </td>
              <td class="dapoyo" style="display:none;">
                <button style="text-align:right" type="button" class="btn btn-info dias_apoyo" data-id="<?php echo $key->codigo_personal ?>" data-toggle="modal" data-target="#modal-actual">
                <span class="glyphicon glyphicon-calendar"></span>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>

    </tbody>
  </table>
</div>
