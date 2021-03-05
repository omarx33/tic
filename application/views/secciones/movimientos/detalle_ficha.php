<br>

<button type="button" class="btn btn-info" id="btn_retroceder"><i class="glyphicon glyphicon-chevron-left"></i>Atras</button>
<button type="button" class="btn btn-success" id="btn_detalle"></i>Agregar</button>
<button type="button" class="btn btn-warning" id="btn_detalle_actualizar" disabled="true"></i>Actualizar</button>
<!--<button type="button" class="btn btn-danger" name="eliminar_detalle" id="eliminar_detalle"><i class="glyphicon glyphicon-trash"></i> Eliminar</button>
-->
<br><br>
<h4>Ficha Técnica:  <span id=""> <?php echo $correlativo  ?></span> </h4>

<table class="table table-bordered table-hover" id="tbl_detalle">
  <thead>
    <tr>
      <th>ID</th>
      <th>CÓDIGO</th>
      <th>PRODUCTO</th>
    <!--  <th>C.COSTO</th> -->
      <th>DESCRIPCIÓN TÉCNICA</th>
      <th>PRE.REFERENCIAL</th>
      <th>FUENTE</th>
      <th>CANT.</th>
      <th>UND.MED</th>
      <th>COMENTARIO</th>
      <th>ESTADO</th>
      <th>IMAGEN</th>
      <th>ELIMINAR</th>
          <th style="display:none">d</th>
      <th style="display:none">d</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($detalle as $key ): ?>
        <tr>

          <td><?php echo $key->idficha;  ?></td>
          <td><?php echo $key->codigo_ss; ?></td>
          <td><?php echo $key->nom_img; ?></td>
        <!--  <td><?php //echo $key->centro_costo; ?></td>-->
          <td><?php echo $key->descripcion;  ?></td>
          <td><?php echo $key->precio_ref;  ?></td>
          <td><?php echo $key->fuente;  ?></td>
          <td><?php echo $key->cantidad;  ?></td>
          <td>UND</td>
          <td><?php echo $key->comentario;  ?></td>
          <td><?php
               if ($key->estado == '1') {
                 echo "<span class='label label-success'>Activo</span>";
               } else {
                echo "<span class='label label-default'>Inactivo</span>";
               }

            ?></td>
        <!--  <td> <img width="80%" height="40%" src="/assets/img/images/000006/la_cura.JPG" ></td>
-->


<td> <a href="<?php echo base_url(); ?>assets/img/articulos/articulos_img/<?php echo $key->imagen; ?>" target="_blank"><?php echo $key->imagen;  ?></a> </td>

<td>  <a href="#" class="btn btn-xs btn-danger eliminar_detalle"  data-id="<?php echo $key->idficha ?>"><i class="glyphicon glyphicon-trash"></i></a>   </td>
<td style="display:none"><?php echo $key->img;  ?></td>
<td style="display:none"><?php echo $key->idarticulos;  ?></td>
        </tr>
      <?php endforeach; ?>
  </tbody>
</table>



<script>
$('#tbl_detalle').DataTable();
</script>






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

				<input type="hidden" name="correlativo2" id="correlativo2" value="<?php echo $correlativo ?>" >
        <input type="hidden" name="txtAccion_detalle" id="txtAccion_detalle" >
        <input type="hidden" name="id_detalle" id="id_detalle">
          <input type="hidden" name="idempresa" id="idempresa">



        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">PRODUCTO</label>

                    <select class="form-control select2" name="img" id="img" style="width: 100%;">
                                    <option value="">.:Selección</option>
                      <?php foreach ($img_art as $key): ?>
                     <!-- imagen -->
                          <option value="<?php echo $key->idarticulos ?>"><?php echo $key->descripcion ?></option>
                      <?php endforeach; ?>
                    </select>
              </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label for="">UND. MED.</label>
      <input type="text" class="form-control" readonly value="UND">
              </div>
          </div>


        </div>


       <div class="row">
         <div class="col-md-12">
           <div class="form-group">
             <label for="">DESCRIPCIÓN</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3" cols="30"></textarea>
             </div>
         </div>

       </div>


        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label>CANTIDAD</label>
            <input type="number" min="0" step="any" class="form-control" name="cantidad" id="cantidad">
            </div>
          </div>



          <div class="col-md-6">
            <div class="form-group">
              <label for="">PREC.REFERENCIAL</label>
             <input type="number" min="0" step="any" class="form-control" name="precio_ref" id="precio_ref" >
              </div>
          </div>




        </div>


        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">FUENTE</label>
     <input type="text" class="form-control" name="fuente" id="fuente" >
              </div>
          </div>

        </div>


        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">COMENTARIO</label>
             <textarea class="form-control" name="comentario" id="comentario" rows="3" cols="30"></textarea>
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

<script>



$('.select2').each(function () {
  $(this).select2();
});
  var valor = <?php   echo $correlativo; ?>

</script>
