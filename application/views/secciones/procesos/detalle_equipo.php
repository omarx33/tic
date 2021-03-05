<div class="row">
  <div class="col-md-3">
    <a class="btn btn-info" id="btn_retroceder">Atras</a>
  </div>
</div>
<form id="form_equipo" method="post">
  <div class="row">
    <div class="col-md-3">
      <label>Equipo</label>
      <input type="text" class="form-control" name="codigo_equipo" value="<?php echo $cabecera->nombre_equipo ?> " readonly>
            <input type="hidden" id="docentry_equipo" name="docentry_equipo" value="<?php echo $cabecera->docentry ?>">
    </div>
    <div class="col-md-3">
      <label>Empresa</label>
      <input type="hidden" id="empresa" value="<?php echo $cabecera->empresa ?>">
      <input type="text" class="form-control" name="" value="<?php echo $cabecera->nom_empresa ?>" readonly>

    </div>
    <div class="col-md-3">

        <label>Estado</label>
        <?php if ($cabecera->estado==0): ?>
        <input type="text" class="form-control" name="estado_nom" value="Asignado" readonly>
          <?php else: ?>
        <input type="text" class="form-control" name="estado_nom" value="Disponible" readonly>
        <?php endif; ?>

    </div>
    <div class="col-md-3">

        <label>Usuario</label>
        <?php if ($cabecera->estado==0): ?>
        <input type="text" class="form-control" name="usuario_nom" value="<?php echo $cabecera->nom_usuario ?>" readonly>
        <input type="hidden" class="form-control" name="usuario" value="<?php echo $cabecera->usuario ?>">
        <input type="hidden" class="form-control" name="estado" value="<?php echo $cabecera->estado ?>">
          <?php else: ?>
        <input type="text" class="form-control" name="usuario_nom" value="" readonly>
        <?php endif; ?>

    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label>Observaciones</label>
      <input type="text" class="form-control" name="observaciones" value="<?php echo $cabecera->observaciones ?>">
    </div>
  </div>
</form><br>
<div class="row">
  <div class="col-md-12">
    <button type="button" name="button" class="btn btn-primary pull-right agregar_componente"  >Agregar  Componente</button>
  </div>
</div><br>
<div class="table-responsive">
  <table class="table table-bordered table-hover" id="detalle_tbl">
    <thead>
      <tr>
        <th>Equipo</th>
        <th>Descripción</th>
        <th>Serie</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="detalle_body">
      <?php foreach ($detalle as $key): ?>
        <tr>
          <td style="display:none" class="codigo"><?php echo $key->docentry ?></td>
          <td class="idcomponente"><?php echo $key->codigo_contable ?></td>
          <td class="descripcion_stock"><?php echo $key->desc_tecnica ?></td>
          <td class="serie_stock"><?php echo $key->serie ?></td>
        <td class="eliminar_stock">  <a href="#" class="btn btn-xs btn-danger eliminar"  data-id="<?php echo $key->docentry ?>"><i class="glyphicon glyphicon-trash"></i></a> </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    <button type="button" name="button" class="btn btn-primary pull-right save">Guardar Equipo</button>
  </div>
</div>
<div class="modal fade"  role="dialog" aria-labelledby="mySmallModalLabel" id="add_modal">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Componente</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Elija el componente</label>
            <select class="form-control select2" style="width: 100%;"  name="idcomponente" id="idcomponente">
              <option value="0">.:Seleccione</option>
              <?php foreach ($componentes as $key): ?>
                <option value="<?php echo $key->idstock ?>"><?php echo $key->codigo_contable ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <input type="text" name="descripcion_stock" id="descripcion_stock" class="form-control">
            <input type="hidden" id="serie" name="" value="">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_submit">Guardar</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('.select2').each(function () {
    $(this).select2({
      theme: 'bootstrap4',
      width: 'style',
      placeholder: $(this).attr('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  });
})
  $(document).on('click','#btn_retroceder',function(){
  window.location.href = baseurl+'Inicio/armado_equipo';

  })


  $(document).on('change','#idcomponente',function(){
    $.ajax({
    url:baseurl+"Componente/get_descripcion_stock",
    data:"idcomponente="+$('#idcomponente').val(),
    type:"post",
    dataType:"json",
    success:function(data){
      $('#descripcion_stock').val(data.descripcion);
      $('#serie').val(data.serie);
    }

    });
  })

  $(document).on('click','#btn_submit',function(){
        $('#add_modal').modal('hide');
    json =0;
  $("#detalle_body tr").each(function () {
  if ($(this).find('td').eq(0).html()==codigo) {
          json++;
        }
});
if (json>0) {
  alert("El componente ya es parte del equipo, por favor seleccione otro")
} else {
  $.ajax({
  url:baseurl+"Componente/get_stock",
  data:"empresa="+$('#empresa').val(),
  type:"post",
  dataType:"json",
  success:function(data){
    $('select[name=idcomponente]').find('option').remove();
    $('select[name=idcomponente]').append('<option value="">Seleccione Codigo</option>');
  $.each(data,function(i,item){
  $('select[name=idcomponente]').append('<option value="'+item.idstock+'">'+item.codigo_contable+'</option>');
  });
  }

  });

  var codigo=$('#idcomponente option:selected').val();
  var idcomponente=$('#idcomponente option:selected').text();
  var descripcion_stock=$('#descripcion_stock').val();
  var serie=$('#serie').val();

  if (codigo=='0') {
    alert('Debe Seleccionar el componente');
  }else {

    var fila= '<tr><td style="display:none" class="codigo">'+codigo+'</td><td class="idcomponente">'
    + idcomponente +'</td><td class="descripcion_stock">'
    + descripcion_stock +'</td><td class="serie_stock">'
    + serie +'</td><td class="eliminar_stock"><a href="#" class="btn btn-xs btn-danger eliminar"  data-id="'+codigo+'"><i class="glyphicon glyphicon-trash"></i></a></td></tr>';  //esto seria lo que contendria la fila

//alert(fila);
$('#detalle_body').append(fila);
$.ajax({
url:baseurl+"Componente/agregar_componente",
data:"idcomponente="+idcomponente+"&equipo="+$('#docentry_equipo').val(),
type:"post",
success:function(data){
alertify.success(data);
}

});


document.getElementById("descripcion_stock").value = "";
  }
}


  })

  $(document).on('click', '.btn_remove', function() {
  var fila = $(this).parent().parent();
    fila.remove();
  });
  $(document).on('click','.save',function(){
    alertify.confirm('Guardar los cambios para el equipo', 'Creación de Equipo',function(){
      var json="";
      var json_total="";
        $("#detalle_tbl tbody tr").each(function () {
          json ="";
          $(this).find("td").each(function () {
                $this=$(this);
                if($this.attr("class")!='eliminar_stock'){
                  json=json+',"'+$this.attr("class")+'":"'+$this.html()+'"';
                }
          });
          obj=JSON.parse('{'+json.substr(1)+'}');
          json_total=json_total+','+JSON.stringify(obj);

      });

        var array_json=JSON.parse('['+json_total.substr(1)+']');
      $.ajax({
      url:baseurl+"Componente/update_equipo",
      data:$('#form_equipo').serialize()+ "&tbldetalle=" + JSON.stringify(array_json),
      type:"post",
      success:function(data){
        if (data>0) {
          location.reload();
        }
      },
                           error: function (xhr, ajaxOptions, thrownError) {

                                alertify.error('Ocurrio un error');

                             }

      });
    },
    function(){
      alertify.error('Cancelado');
    })

  })
</script>
