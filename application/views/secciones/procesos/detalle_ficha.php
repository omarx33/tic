

<button type="button" class="btn btn-info" id="btn_retroceder"><i class="glyphicon glyphicon-chevron-left"></i>Atras</button>

<br>
<br>
<table   class="table table-bordered table-hover" id="detalle_ficha">
  <thead>
    <tr>
      <th>#</th>
      <th>CÓDIGO</th>
      <th>PRODUCTO</th>
      <th>DESCRIPCIÓN TÉCNICA</th>
      <th>CANT. SOLICITADA</th>
      <th>CANT. RECIBIDA</th>
      <th style="display:none">ss</th>
      <th>ACCIONES</th>


    </tr>
  </thead>
  <tbody>
      <?php
      $contador = 1;

       foreach ($detalle as $key ): ?>
        <tr>

          <td><?php echo $contador++;  ?></td>
          <td><?php echo $key->codigo_ss; ?></td>
          <td><?php echo $key->producto; ?></td>
          <td><?php echo $key->descripcion; ?></td>
          <td><?php echo $key->cantidad;  ?></td>
          <td><?php echo $key->cantidad_recibida;  ?></td>
          <td style="display:none"><?php echo $key->idficha; ?></td>

          <td><?php if ($key->cantidad==$key->cantidad_recibida): ?>
            <?php echo 'Atendido' ?>
            <?php else: ?>
              <a href="#" class="btn btn-xs btn-success agregar-stock" title="Agregar al stock" data-id="<?php echo $key->idficha ?>"
               data-codigo="<?php echo $key->codigo_ss ?>"
               data-descripcion="<?php echo $key->descripcion ?>"
               data-cantidad="<?php echo $key->cantidad ?>"
              data-empresa="<?php echo $key->empresa ?>"
                data-correlativo="<?php echo $key->correlativo ?>"
                data-tipo="<?php echo $key->tipo ?>"
                  data-cab_id="<?php echo $key->cab_id ?>"
                  data-producto="<?php echo $key->producto ?>"
                ><i class="glyphicon glyphicon-open-file"></i></a>
          <?php endif; ?></td>


        </tr>
      <?php endforeach; ?>
  </tbody>
</table>



<script>

</script>








<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="detalle-ingreso">
  <div class="modal-dialog " role="document">
		<form method="post" id="ingreso_ficha" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Registro</h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div id="msg"></div>
				</div>


        <input type="hidden" name="empresa_id" id="empresa_id"  >
        <input type="hidden" name="iddetallle" id="iddetallle"  >
        <input type="hidden" name="correlativo" id="correlativo"  >
        <input type="hidden" name="tipo_componente" id="tipo_componente"  >
          <input type="hidden" name="cab_id" id="cab_id"  >
       <div class="row">
         <div class="col-md-6">
           <div class="form-group">
             <label for="">CÓDIGO</label>
          <input type="text" class="form-control"  name="codigo" id="codigo" readonly>
             </div>
         </div>
         <div class="col-md-6">
           <div class="form-group">
             <label for="">PRODUCTO</label>
             <input type="text" class="form-control" name="descripcion" id="producto" readonly>
           </div>
         </div>

       </div>

       <div class="row">
         <div class="col-md-12">
           <div class="form-group">
             <label for="">DESCRIPCIÓN TÉCNICA</label>
             <input type="text" class="form-control" name="descripcion" id="descripcion" readonly>
           </div>
         </div>
       </div>

<!-- -->
        <div class="row" id="tipo_condicion">
          <div class="col-md-4">
            <div class="form-group">
              <label>Capac.Memoria (GB)</label>
              <input type="number" class="form-control" name="capac_mr" id="capac_mr" value="0">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Capac.DD (GB)</label>
              <input type="number" class="form-control" name="capac_dd" id="capac_dd" value="0">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Capac.Tarjeta Video (GB)</label>
              <input type="number" class="form-control" name="capac_tj" id="capac_tj" value="0">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="">CANTIDAD</label>
              <input type="number" class="form-control"  name="cantidad" id="cantidad" value='1' readonly>
              </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="">CODIGO CONTABLE</label>
           <input type="text" class="form-control"  name="codigo_contable" id="codigo_contable" readonly>
            </div>
          </div>

    </div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label id="label_capacidad">CAPACIDAD (GB)</label>
    <input type="number" class="form-control" name="capacidad" id="capacidad" value="0">
    </div>
  </div>
</div>






    <div class="row">
      <div class="col-md-4">
        <label>SERIE AUTOMATICA</label>
        <select  name="ser_auto" id="ser_auto" class="form-control ">
          <option value="NO">NO</option>
      <option value="SI">SI</option>
          </select>
      </div>


<div class="col-md-4">
        <label for="">SERIE NRO.</label>
        <input type="text" class="form-control" name="serie"  id="serie">
</div>

<div class="col-md-4">
  <label>MARCA</label>
  <select  name="marca" id="marca" class="form-control select2">
    </select>
</div>


    </div>








    <div class="row">
<div class="col-md-12">
        <label for="">MODELO</label>
        <input type="test" class="form-control" name="modelo"  id="modelo">
</div>


    </div>

    <div class="row">
    <div class="col-md-12">
      <label>COMENTARIO</label>
      <textarea name="comentario" id="comentario" class="form-control" rows="4" cols="40"></textarea>
    </div>
    </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_ingreso_detalle" data-dismiss="modal">Guardar</button>
      </div>
    </div>
		</form>
  </div>
</div>

<script src="<?php echo base_url() ?>js/procesos/ingreso_detalle.js"></script>
