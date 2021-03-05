
$(document).ready(function () {
  $('.select2').each(function () {
    $(this).select2();
  });
});


$(document).on('change','#empresa',function(){
  var valor = $(this).val();

  if (valor==0) {
    $('#grid_asignacion').html('');
  }else {
    $.post(baseurl+"Componente/get_asignaciones/"+valor,
    function(data){
      $('#grid_asignacion').html(data);
    });

  }
})
$(document).on('click','#btn_modal',function(){
  $.ajax({
  url:baseurl+"Correlativo/get_correlativo_asignacion",
  data:"empresa="+$('#empresa').val(),
  type:"post",
  success:function(data){

    $('#cargo_asignacion').val(data);
  }
  });

  $.ajax({
  url:baseurl+"Usuarios_ticket/getall",
  type:"post",
  dataType:"json",
  success:function(data){
    $('select[name=usuario]').find('option').remove();
    $('select[name=usuario]').append('<option value="0">Seleccione Usuario</option>');
  $.each(data,function(i,item){
  $('select[name=usuario]').append('<option value="'+item.idusuario+'">'+item.nombres+' '+item.apellidos+'</option>');
  });
  }
  });
  $.ajax({
  url:baseurl+"Area/getall",
  type:"post",
  dataType:"json",
  success:function(data){
    $('select[name=area]').find('option').remove();
    $('select[name=area]').append('<option value="0">Seleccione Area</option>');
  $.each(data,function(i,item){
  $('select[name=area]').append('<option value="'+item.idarea+'">'+item.descripcion+'</option>');
  });
  }
  });
  $.ajax({
  url:baseurl+"Componente/get_equipo",
  data:"empresa="+$('#empresa').val(),
  type:"post",
  dataType:"json",
  success:function(data){
    $('select[name=equipo_asignado]').find('option').remove();
    $('select[name=equipo_asignado]').append('<option value="0">Seleccione Equipo</option>');
  $.each(data,function(i,item){
  $('select[name=equipo_asignado]').append('<option value="'+item.docentry+'">'+item.nombre_equipo+'</option>');
  });
  }
  });
  $('#add_modal').modal('show');
  $('.select2').each(function () {
    $(this).select2();
  });

})
$(document).on('change','#equipo_asignado',function(){
  var equipo=$(this).val();
  if (equipo==0) {
    $('#descripcion_equipo').val('');
  } else {
    $.ajax({
    url:baseurl+"Componente/descripcion_equipo",
    data:"equipo="+equipo,
    type:"post",
    dataType:"json",
    success:function(data){
      var fila='';
      $.each(data,function(i,item){
        fila=fila+','+item.componente+' : '+item.descripcion+'('+item.ccontable+')';
      });
      $('#descripcion_equipo').val(fila.substr(1));
      console.log(fila);
    }
    });
  }
})
$(document).on('click','#btn_submit',function(e){
  if ($('#tipo').val()=='0' || $('#equipo_asignado').val()=='0' || $('#area').val()=='0' || $('#usuario').val()=='0'|| $('#cargo_asignacion').val()=='') {
    alert('Por favor complete todos los campos del formulario');
  } else {
    $.ajax({
    url:baseurl+"Componente/generar_cargo_asignacion",
    data:$('#form_asignacion').serialize()+"&empresa="+$('#empresa').val(),
    type:"post",
    beforeSend: function(){
      $('#btn_submit').attr('disabled',true);
    },
    success:function(data){
            swal({
      title: "Cargo de Asignación",
      type:"success",
      text: "Se Realizó la Asignación de Equipo",
      timer: 2000,
       showConfirmButton: false
       });
      setTimeout("window.location.replace('"+baseurl+"Inicio/asignacion_equipo')",2000);
    }
    });
  }
})
$(document).on('click','.ver_detalle',function(e){
    $('#detalle_cargo').modal('show');
    var cargo=$(this).attr('data-id');
    $.ajax({
    url:baseurl+"Componente/get_asignacion_equipo",
    data:"cargo="+cargo,
    type:"post",
    dataType:"json",
    success:function(data){
      $('#cargo_asignacion_id').val(data.cargo_asignacion);
      $('#usuario_id').val(data.nom_usuario);
      if (data.tipo==1) {
      $('#tipo_cargo_id').val('Asignado');
      }
      if (data.tipo==2) {
      $('#tipo_cargo_id').val('Cambio de Dependencia');
      }
      if (data.tipo==3) {
      $('#tipo_cargo_id').val('Préstamo');
      }
      if (data.tipo==4) {
      $('#tipo_cargo_id').val('Entrega de Elemento');
      }
      if (data.tipo==5) {
      $('#tipo_cargo_id').val('Otro');
      }
      $('#equipo_id').val(data.equipo);
      $('#docentry_cargo').val(data.docentry);
      $('#fecha_cargo_id').val(data.fecha_asignacion);
      $('#fecha_devolucion_id').val(data.fecha_devolucion);
      if (data.estado==0) {
      $('#estado_id').val('Devuelto');
      $('#anular_cargo').hide();
    }else {
      $('#estado_id').val('Activo');
      $('#anular_cargo').show();
    }
    $.ajax({
    url:baseurl+"Componente/descripcion_equipo",
    data:"equipo="+data.equipo,
    type:"post",
    dataType:"json",
    success:function(data){
      var fila='';
      var num=1;
      $.each(data,function(i,item){
        fila=fila+
        '<tr><td>'+num+'</td><td>'+item.codigo+'</td>'+'<td>'+item.des_art+'</td><td>'+item.serie+'</td><td>'+item.descripcion+'('+item.ccontable+')'+'</td>'+'</tr>';
              $('#tbl_detalleasignacion tbody').html(fila);
              num++;
      });

    }
  });
    }
    });
})
$(document).on('click','#anular_cargo',function(e){
  var equipo=$('#equipo_id').val();
  var cargo=$('#docentry_cargo').val();
  $.ajax({
  url:baseurl+"Componente/devolucion_equipo",
  data:"equipo="+equipo+"&cargo="+cargo
  ,
  type:"post",
  success:function(data){
            swal({
      title: "Devolución de Equipo",
      type:"success",
      text: "Se Realizó la Devolución de Equipo",
      timer: 2000,
       showConfirmButton: false
       });
      setTimeout("window.location.replace('"+baseurl+"Inicio/asignacion_equipo')",2000);

  }
});
})
