

<button type="button" class="btn btn-info" id="btn_retroceder"><i class="glyphicon glyphicon-chevron-left"></i>Atras</button>
<button type="button" class="btn btn-success" id="btn_detalle"></i>Agregar </button>
<button type="button" class="btn btn-warning" id="btn_detalle_actualizar" disabled="true"></i>Actualizar</button>
<br>
<br>

<table   class="table table-bordered table-hover" id="detalle_salida">
  <thead>
    <tr>
      <th>#</th>
      <th>D.TÉCNICA</th>
      <th>SERIE</th>
      <th>CANTIDAD</th>
      <th>DETALLE</th>
      <th style="display:none">d</th>
  <th style="display:none">d</th>
  <th>CÓDIGO</th>
  <th>ARTÍCULO</th>
  <th>ACCIONES</th>
    </tr>
  </thead>
  <tbody>
      <?php
  $contador = 1;

       foreach ($detalle as $key ): ?>
        <tr>

          <td><?php echo $contador++;  ?></td>
          <td><?php echo $key->dt; ?></td>
          <td><?php echo $key->serie; ?></td>
          <td><?php echo $key->cantidad; ?></td>
          <td><?php echo $key->detalle; ?></td>
          <td style="display:none"><?php echo $key->codigo; ?></td>
      <td style="display:none"><?php echo $key->idsalida_det; ?></td>
        <td><?php echo $key->codigo_ss; ?></td>
      <td><?php echo $key->articulos; ?></td>
      <td>  <a href="#" class="btn btn-xs btn-danger eliminar_detalle"
         data-cantidad="<?php echo $key->cantidad ?>"
         data-serie="<?php echo $key->serie ?>"
         data-id="<?php echo $key->idsalida_det ?>"><i class="glyphicon glyphicon-trash"></i></a>   </td>
        </tr>
      <?php endforeach; ?>
  </tbody>
</table>



<!-- -->










<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="modal-detalle">
  <div class="modal-dialog " role="document">
		<form method="post" id="ficha_detalle" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div id="msg"></div>
				</div>


        <input type="hidden" name="txtAccion_detalle" id="txtAccion_detalle" >
        <input type="hidden" name="id_detalle" id="id_detalle" value="<?php echo $correlativo  ?>">
          <input type="hidden" name="idempresa" id="idempresa">
      <input type="hidden" name="id" id="id">





          <div class="row">

            <div class="col-md-12" id="sel_codigo">

                </div>

          </div>
<br>
          <div class="row">
            <div class="col-md-6" id="sel_serie">

                </div>

                <div class="col-md-6" id="cant_stock">

                    </div>
          </div>

<br>
        <div class="row">

          <div class="col-md-12">
            <div class="form-group">
              <label>CANTIDAD</label>
            <input type="number" min="0" step="any" class="form-control" name="cantidad" id="cantidad" readonly>
            </div>
          </div>






        </div>





        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">MOTIVO DE RETIRO</label>
             <textarea class="form-control" name="retiro" id="retiro" rows="3" cols="30"></textarea>
              </div>
          </div>

        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_agregar_detalle" data-dismiss="modal">Guardar</button>
      </div>
    </div>
		</form>
  </div>
</div>

<script  >




$('.select2').each(function () {
  $(this).select2();
});

$('#sel_codigo').on('change',function(e){
  elegido = $('#empresa').val();
var dato = $('#cod').val();
$.ajax({

url:baseurl+'Salidas_consumo/getserie',
type:'post',
data:{
dato:dato,elegido
},
success:function(data){
//--
$('#sel_serie').html('<label for="">SERIE: </label><select id="serie" name="serie" class="form-control select2" ><option value="">.:Seleccione</option>  </select>');
 var ser=JSON.parse(data);
 $.each(ser,function(i,item){

         $('#serie').append('<option value="'+item.idstock+'">'+item.serie+'</option>');

       });
       $('.select2').each(function () {
         $(this).select2();
       });
//--

}

});

});
//-------------------------------------------


$('#sel_serie').on('change',function(e){
var dato = $('#serie').val();

//alert(elegido);

if (dato != '') {
  $.ajax({
  url:baseurl+'Salidas_consumo/getserie_id',
  type:'post',
  data:{
  dato:dato,elegido
  },
  success:function(data){
  //--
     var codigo=JSON.parse(data);

      $('#cant_stock').html('<label>STOCK ACTUAL</label><input type="text" readonly class="form-control" name="stock" id="stock" value="'+codigo[0].cantidad+'">');

  //alert(data);
  }
  });
}



});




  $('#detalle_salida').DataTable();

  var valor2 = <?php   echo $correlativo; ?>
</script>
