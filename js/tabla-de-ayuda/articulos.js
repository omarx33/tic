$(document).ready(function(){
$('.btn-editar').attr("disabled", true);
 $('.btn-editar').addClass( "disabled" );
tabla_articulos=tabla_js();

$(document).on('click','#tbl_detalle tbody tr', function () {
     $('.btn-editar').removeClass( "disabled" );
     $('.btn-editar').attr("disabled", false);
     $('tr').removeClass('info');
$(this).addClass('info');
    $('#id').val($(this).find('td').eq(0).html());
    $('#descripcion').val($(this).find('td').eq(1).html());
    $('#u_medida').val($(this).find('td').eq(2).html());
    $('#codigo_ss').val($(this).find('td').eq(3).html());
    var tipo=$(this).find('td').eq(5).html();
    //alert(tipo);
    $('#tipo_componente option[value='+ tipo +']').attr('selected',true);
    $('#name_imagen').val($(this).find('td').eq(9).html());
  //alert($(this).find('td').eq(9).html());
 valo = $(this).find('td').eq(7).html();
 if (valo==01) {
    $('#estado').bootstrapToggle('on');
 }else {
    $('#estado').bootstrapToggle('off');
 }




});



});

function tabla_js(){
  $.post(baseurl+"Articulos/listar/",
  function(data){
      $('#table').html(data);
      $('#tbl_detalle').DataTable();


    });




}


//--------------------
function borrarinputs(){
  	$('#id').val('');
	$('#descripcion').val('');
  $('#u_medida').val('UND');
  $('#codigo_ss').val('');
  $('#imagen').val('');
  // $('#imagen').val('');
  $('#estado').bootstrapToggle('on');
}
$('#estado').bootstrapToggle({
      on: 'Activo',
      off: 'Inactivo',
			onstyle:'success',
			offstyle:'default',
			width:80,

    });





$(document).on('click','#btn_modal',function(e){
  $('.modal-title').html('Nuevo Registro');
  $('#txtAccion').val('nuevo');
	$('#editar_modal').modal('show');
  borrarinputs();
  $('.btn-editar').attr("disabled", true);
   $('.btn-editar').addClass( "disabled" );
   $('#imagen').attr("disabled", false);
});

$(document).on('click','.btn-editar',function(e){
  $('.modal-title').html('Editar Registro');
  $('#txtAccion').val('editar');
	$('#editar_modal').modal('show');
 //$('#imagen').attr("disabled", true);

});




$(document).on('click','#btn_submit',function(){

var formData = new FormData($("#form_articulos")[0]);
$.ajax({
url:baseurl+"Articulos/save",
type:"post",
data:formData,
contentType:false,
processData:false,
beforesend:function(){

},
success:function(data){
//  alert(data);
//console.log(data);


if (data==0) {
alert(data);
}else if (data==1) {
  alertify.error("Ocurrio un error");
}else {
  alertify.success("Correcto");
    $('#editar_modal').modal('hide');
tabla_articulos=tabla_js();
}





}

});
});
