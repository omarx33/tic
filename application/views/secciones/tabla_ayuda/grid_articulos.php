
<div class="table-responsive">
  <table class="table table-bordered table-hover" name="tbl_detalle" id="tbl_detalle">
    <thead>
      <tr>
        <th>ID</th>
        <th>DESCRIPCIÓN</th>
        <th>UNIDAD</th>
        <th>CÓDIGO S.S.</th>
        <th>TIPO DE COMPONENTE</th>
        <th style="display:none">tc</th>
        <th>IMAGEN</th>
        <th style="display:none;">es</th>
        <th>ESTADO</th>
        <th style="display:none;">s</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($infor as $key): ?>
        <tr>
          <td><?php echo $key->idarticulos; ?></td>
          <td><?php echo $key->descripcion; ?></td>
          <td><?php echo $key->unidad ?></td>
         <td><?php echo $key->codigo_ss ?></td>
         <td><?php echo $key->desc_componente ?></td>
         <td style="display:none"><?php if ($key->tipo!='') {
             echo $key->tipo;
         }else {
           echo "0";
         }?></td>
         <td>   <a href="<?php echo base_url(); ?>assets/img/articulos/articulos_img/<?php echo $key->imagen; ?>" target="_blank">
    <!-- <?php// echo $key->imagen;  ?> para agregar el nombre a la imagen -->
      <img src="<?php echo base_url(); ?>assets/img/articulos/articulos_img/<?php echo $key->imagen; ?>" alt="50px" width="50px"></a>
      <br>
    <?php echo $key->imagen; ?>
      </td>

           <td style="display:none;"> <?php echo $key->estado ?>  </td>
         <?php if ($key->estado == '01'): ?>
     <td>  <span class="label bg-green color-palette">Activo</span></td>

   <?php elseif($key->estado == '00'): ?>
             <td>  <span class="label bg-red color-palette">Inactivo</span> </td>
       <?php endif; ?>

<td style="display:none;"><?php echo $key->imagen;  ?></td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
