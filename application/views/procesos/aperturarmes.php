
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h4>Apertura de mes</h4>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                  <div class="box-body">
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Periodo</th>
      <th>Dia cerrrado</th>
      <th>Acciones</th>
    </tr>

  </thead>
  <tbody>
    <?php $item=1; foreach ($periodo as $key): ?>
      <tr>
        <td><?php echo  $item ?></td>
        <td><?php echo $key->periodo_tareo ?></td>
        <td><a class="btn btn-danger btn-xs eliminar_cierre" href="#" data-id="<?php echo $key->periodo_tareo; ?>">Aperturar periodo</a></td>
      </tr>
    <?php $item++; endforeach; ?>
  </tbody>
</table>

</div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
