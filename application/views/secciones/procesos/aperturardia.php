
<div class="col-md-12 table-responsive" id="tbl_dias">

  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>N°</th>
        <th>DIA</th>
        <th>ACCION</th>

    </thead>
    <tbody>
      <?php $item=1; foreach ($dias as $key): ?>
        <tr>
          <td><?php echo $item; ?></td>
          <td><?php echo date('Y-m-d',strtotime('-1 day',strtotime ( '+'.$key->dia.' day' , strtotime ( $dateinicio ) ))) ; ?></td>
            <td><a class="btn btn-primary btn-xs eliminar_cierre" href="#" data-id="<?php echo $key->docentry; ?>">Aperturar dia</a></td>

        </tr>
      <?php $item++; endforeach; ?>

    </tbody>
  </table>

</div>
