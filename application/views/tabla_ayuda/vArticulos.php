<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>


        </h1>
    </section>


    <!-- Main content -->
    <section class="content">
        <!-- Default box -->

        <div class="box box-solid">

            <div class="box-body">
    <!--  text -->

    <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">





            <div class="col-md-3">
                <h4>      Artículos</h4>
            </div>
                <button type="button" name="button" class="btn btn-secondary pull-right disabled btn-editar"  >Editar</button>
              <button type="button" name="button" class="btn btn-primary pull-right" id="btn_modal">Nuevo</button>

        </div>
        </div>

        </div>


<div id="espacio">

</div>

            <div id='table'>

            </div>
<!--
<div id="tbl_articulo">

</div>
-->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->















        <div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="editar_modal">
          <div class="modal-dialog " role="document">
        		<form method="post" id="form_articulos"  enctype="multipart/form-data" autocomplete="off">
            <div class="modal-content">
        			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
              </div>
              <div class="modal-body">
        				<div class="form-group">
        					<div id="msg"></div>
        				</div>
        		<!--		<input type="hidden" name="txtSeriedoc" id="txtSeriedoc">-->
        				<input type="hidden" name="id" id="id">
               	<input type="hidden" name="txtAccion" id="txtAccion">
                <input type="hidden" name="name_imagen" id="name_imagen">


<div class="row">
  <div class="col-md-12">
    <label>DESCRIPCIÓN</label>
    <input type="text" class="form-control" name="descripcion" id="descripcion" >
  </div>


</div>
<div class="row">
  <div class="col-md-6">
    <label>U.MEDIDA</label>
    <input type="text" class="form-control" name="u_medida" id="u_medida">
  </div>
  <div class="col-md-6">
    <label>CÓDIGO SS</label>
    <input type="text" class="form-control" name="codigo_ss" id="codigo_ss" >
  </div>


</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Tipo de Componente</label>
      <select class="form-control" id="tipo_componente" name="tipo_componente">
        <option value="0">Elija componente</option>
        <?php foreach ($componentes as $key): ?>
          <option value="<?php echo $key->idcomponente ?>"><?php echo $key->descripcion ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
</div>
<div class="row">


  <div class="col-md-6">

    <div class="form-group">
        <label>Estado</label>
        <br>

            <input type="checkbox" name="estado"  data-toggle="toggle" data-size="normal" id="estado">

    </div>
  </div>

  <div class="col-md-6">
    <label>IMAGEN</label>
    <input type="file" name="imagen" id="imagen" >
  </div>
</div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_submit">Guardar</button>
              </div>
            </div>
        		</form>
          </div>
        </div>
