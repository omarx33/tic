<div class="row">
  <div class="col-md-3">
    <a class="btn btn-info" id="btn_retroceder">Atras</a>
  </div>
</div><br>
<form id="form_equipo" method="post">
  <div class="row">

    <div class="col-md-3">
      <label>Empresa</label>
      <input type="hidden" class="form-control" name="empresa_nom" id="empresa" value="">

        <select class="form-control" name="empresa">
          <option value="0">.:Seleccione Empresa</option>
          <?php foreach ($empresas as $key): ?>
            <option value="<?php echo $key->idempresa ?>"><?php echo $key->descripcion ?></option>
          <?php endforeach; ?>
        </select>

    </div>
    <div class="col-md-3">
      <label>Equipo</label>
      <input type="text" class="form-control" name="codigo_equipo" id="codigo_equipo" value="" readonly>
    </div>

  </div>
  <div class="row">
    <div class="col-md-12">
      <label>Observaciones</label>
      <input type="text" class="form-control" name="observaciones" value="">
    </div>
  </div>
</form>
<br>
<div class="row">
  <div class="col-md-12">
    <button type="button" name="button" class="btn btn-primary pull-right agregar_componente">Agregar Componente</button>
  </div>
</div>
<br>
<div class="table-responsive">
  <table class="table table-bordered table-hover" id="detalle_tbl">
    <thead>
      <tr>
        <th>Equipo</th>
        <th>Descripción</th>
        <th>Serie</th>
      </tr>
    </thead>
    <tbody id="detalle_body">

    </tbody>
  </table>
</div>
<br>
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

            </select>
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <input type="text" name="descripcion_stock" id="descripcion_stock" class="form-control">
            <input type="hidden" id="serie" name="" value="">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_submit">Agregar</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('.select2').select2({

  });
  if ($('select[name=empresa]').val()==0) {
    $('.agregar_componente').attr('disabled',true);
  }else{
    $('.agregar_componente').attr('disabled',false);
  }

})
  $(document).on('click','#btn_retroceder',function(){
  window.location.href = baseurl+'Inicio/armado_equipo';
  })

  $(document).on('click','.agregar_componente',function(){
    $('#add_modal').modal('show');
  })
  $(document).on('change','select[name=empresa]',function(){
$('.agregar_componente').attr('disabled',false);
    $('#empresa').val($(this).val());
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

$('.select2').each(function () {
  $(this).select2({
    theme: 'bootstrap4',
    width: 'style',
    placeholder: $(this).attr('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
  });
});
    }

    });
    $.ajax({
    url:baseurl+"Componente/get_codigoequipo",
    data:"empresa="+$('#empresa').val(),
    type:"post",
    success:function(data){
      $('#codigo_equipo').val(data);
    }

    });

  })
  $(document).on('click','#btn_submit',function(){
    var codigo=$('#idcomponente option:selected').val();
    var idcomponente=$('#idcomponente option:selected').text();
    var descripcion_stock=$('#descripcion_stock').val();
      var serie=$('#serie').val();
      json =0;
    $("#detalle_body tr").each(function () {
    if ($(this).find('td').eq(0).html()==codigo) {
            json++;
          }
});
        $('#add_modal').modal('hide');
  if (json>0) {
    alert('El componente ya es parte del equipo, por favor seleccione otro');
  } else {
    if (codigo=='0') {
      alert('Debe Seleccionar el componente');
    }else {

      var fila= '<tr><td style="display:none" class="codigo">'+codigo+'</td><td class="idcomponente">'
      + idcomponente +'</td><td class="descripcion_stock">'
      + descripcion_stock +'</td><td class="serie_stock">'
      + serie +'</td><td class="eliminar"><button type="button" name="remove" class="btn btn-danger btn_remove">Quitar</button></td></tr>';  //esto seria lo que contendria la fila

$('#detalle_body').append(fila);

$("#idcomponente").val('0').trigger('change');
  document.getElementById("descripcion_stock").value = "";
    }
  }


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
                if($this.attr("class")!='eliminar'){
                  json=json+',"'+$this.attr("class")+'":"'+$this.html()+'"';
                }
          });
          obj=JSON.parse('{'+json.substr(1)+'}');
          json_total=json_total+','+JSON.stringify(obj);

      });

        var array_json=JSON.parse('['+json_total.substr(1)+']');
      $.ajax({
      url:baseurl+"Componente/save_equipo",
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
