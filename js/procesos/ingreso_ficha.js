$(document).ready(function(){

  $(document).on('change','#componente',function(e){
      $("#componente option:selected").each(function () {
  elegido=$(this).val();
  //alert(elegido);
  if (elegido == 1) {
    $('#div_capacidad').html('<label>CAPACIDAD</label><input type="text" class="form-control" name="capacidad" id="capacidad">');
  }else {
      $('#div_capacidad').html("");
  }

  });
  });

tabla_ficha($('#empresa').val());



});

//----------------------------

$('#empresa').on('change',function(e){
tabla_ficha($('#empresa').val());
});
//------------------------



function tabla_ficha(empresa){
  $.post(baseurl+"Ingreso_ficha/lista/",
  {empresa:empresa},
  function(data){

    $("#tbl_ingreso_ficha").html(data);
  $('#lista_ficha').DataTable();
  });
}
function detalle_ingreso(id){
  var empresa = $('#empresa').val();
  $.post(baseurl+"Ingreso_ficha/detalle_ingreso/"+id+"/"+empresa,
  function(data){
    $('#tbl_ingreso_ficha').html(data);
  });
}

$(document).on('click','.detalle',function(e){
  e.preventDefault();
  var id=$(this).attr('data-id');
 detalle_ingreso(id);
});





$(document).on('click','#btn_retroceder',function(e){

tabla_ficha($('#empresa').val());

});





$(document).on('click','.agregar-stock',function(e){
  $.ajax({
    url:baseurl+"Marca/get_marca",
    type:"post",
    dataType:"json",
    success:function(data){
      $.each(data,function(i,item){
      $('select[name=marca]').append('<option value="'+item.idmarca+'">'+item.descripcion+'</option>');
      });
    }
  });

  let   id=    $(this).attr('data-id');
$('#detalle-ingreso').modal('show');
borrarinputs();
let codigo=$(this).attr('data-codigo');
let empresa=$(this).attr('data-empresa');
let tipo=$(this).attr('data-tipo')
$('#tipo_componente').val(tipo);
if (tipo==5 || tipo==6) {
  $('#tipo_condicion').show();
}else {
  $('#tipo_condicion').hide();
}
if(tipo==4 || tipo==7 || tipo==8){
  $('#capacidad').show();
    $('#label_capacidad').show();
}else {
  $('#capacidad').hide();
    $('#label_capacidad').hide();
}
$('#capac_mr').val(0);
$('#capac_dd').val(0);
$('#capac_tj').val(0);
$.ajax({
  url:baseurl+"Ingreso_ficha/codigo_contable",
  type:"post",
  data:'codigo='+codigo+'&empresa='+empresa,
  beforesend:function(){
    $('#btn_ingreso_detalle').attr('disabled',true);
  },
  success:function(data){
    $('#btn_ingreso_detalle').attr('disabled',false);
    $('#codigo_contable').val(data);
  }
});
  $('#codigo').val($(this).attr('data-codigo'));
  $('#producto').val($(this).attr('data-producto'));
    $('#descripcion').val($(this).attr('data-descripcion'));
    $('#cantidad').val(1);
    $('#empresa_id').val($(this).attr('data-empresa'));
  $('#correlativo').val($(this).attr('data-correlativo'));
    $('#iddetallle').val($(this).attr('data-id'));
});



$(document).on('change','#cant_recibida',function(e){
    let id = $(this).parent().parent().find('td').eq(5).html();
		let valor=$(this).val();
//---
$.ajax({
  url:baseurl+"Ingreso_ficha/actualizar_cantidad",
  data:{
        valor:valor,
        id:id
      },
  type:"post",
  success:function(data){
switch (data) {
  case "1":
    alertify.success("se actualizo la cantidad");
  /*  swal({
      title: "Registrado",
      text: "se actualizo la cantidad",
      icon: "success",
      timer: 2000
    });*/
    break;

    case "2":
     alertify.error("El campo texto esta vacio");
/*    swal({
      title: "El campo texto está vacío",
      text: "no se actualizo la cantidad",
      icon: "warning",
      timer: 2000
    });*/
      break;

  default:
    alertify.error("error");
}
  }
})
//----

});


function borrarinputs(){
	$('#codigo').val('');
	$('#descripcion').val('');
	$('#cantidad').val('');
  $('#componente').val("");
  $('#serie').val("");
    $('#marca').val(" ");
    $('#capacidad').val("");
      $('#comentario').val("");
        $('#modelo').val("");
}



$(document).on('click','#btn_ingreso_detalle',function(e){
  let tipo=$('#tipo_componente').val();
  let capac_mr=$('#capac_mr').val();
  let capac_dd=$('#capac_dd').val();
  let capac_tj=$('#capac_tj').val();
    e.preventDefault();
    if ((tipo!=5 || tipo!=6) && (capac_mr==0 || capac_dd==0  || capac_tj==0 )) {
      $.ajax({
        url:baseurl+"Ingreso_ficha/save",
        type:"post",
        data:$('#ingreso_ficha').serialize(),
        beforesend:function(){
          $('#btn_ingreso_detalle').attr('disabled',true);
        },
        success:function(data){
switch (data) {
  case "1":
    alertify.success("Se agrego el registro");
    location.reload();
    break;

    case "2":
      alertify.error("Algun dato esta vacio");

      break;
  default:

  alertify.error("Error");

}

        }
      });
    } else {
      alert('Desea especificar las capacidades')
    }

});
