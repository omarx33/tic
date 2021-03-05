
<table id="lista_ficha_tecnica" class="table table-bordered table-condensed table-hover">
  <thead>
    <tr>
      <th style="text-align:center">NÚMERO</th>
      <th style="text-align:center">REQUERIMIENTO</th>
      <th style="text-align:center">NRO TICKET</th>
      <th style="text-align:center">TÉCNICO</th>
      <th style="text-align:center">ÁREA</th>
      <th style="text-align:center">SOLICITANTE</th>
      <th style="text-align:center">EMPRESA</th>
      <th style="text-align:center">DESCRIPCIÓN</th>
      <th style="text-align:center">FECHA</th>
      <th style="text-align:center">ACCIONES</th>

    </tr>
  </thead>

  <tbody>
  <?php foreach ($ficha as $key): ?>
    <tr>


        <td style="text-align:center"><?php echo $key->correlativo; ?></td>
        <td style="text-align:center"><?php echo $key->nro_requerimiento; ?></td>
        <td style="text-align:center"><?php echo $key->idticket; ?></td>
        <td style="text-align:center"><?php echo $key->usuario_tic ; ?></td>
        <td style="text-align:center"><?php echo $key->area; ?></td>
        <td style="text-align:center"><?php echo $key->fullname; ?></td>
        <td style="text-align:center"><?php echo $key->empresa; ?></td>
        <td style="text-align:center"><?php echo $key->descripcion_ficha; ?></td>
        <td style="text-align:center"><?php echo date('d-m-Y H:i:s',strtotime($key->fecha_creacion)); ?></td>
        <td style="text-align:center">
          <a title="actualizar" href="#" data-correlativo="<?php echo $key->correlativo ?>"
                      data-idticket="<?php echo $key->idticket ?>"
                       data-solicitante="<?php echo $key->idusuario ?>"
                       data-empresa="<?php echo $key->idempresa ?>"

                       data-area="<?php echo str_pad($key->centro_costo,6,"0",STR_PAD_LEFT); ?>"
                       data-descripcion="<?php echo $key->descripcion_ficha ?>"
                       data-requerimiento="<?php echo $key->nro_requerimiento ?>"
            class="btn btn-xs btn-warning editar-ficha"><i class="glyphicon glyphicon-edit"></i></a>
          <a href="#" title="detalle" data-id="<?php echo $key->correlativo ?>" class="btn btn-xs btn-primary verdetalle"><i class="glyphicon glyphicon-zoom-in"></i></a>

          <a title="imprimir" href="<?php echo base_url() ?>Reportes/pFicha_tecnica/?correlativo=<?php echo $key->correlativo ?>&empresa=<?php echo $key->idempresa ?>" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>


          <a href="#" title="eliminar" class="btn btn-xs btn-danger eliminar"  data-id="<?php echo $key->correlativo ?>"><i class="glyphicon glyphicon-trash"></i></a>
          <a href="#" title="excel" data-id="<?php echo $key->correlativo ?>"  data-empresa="<?php echo $key->idempresa ?>" class="btn btn-xs btn-success btn_excel" title="Click para descargar el formato excel"><i class="glyphicon glyphicon-save-file"></i>  </a>
        </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
$('#lista_ficha_tecnica').DataTable({

  "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
</script>
