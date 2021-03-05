
$('#ser_auto').on('change',function(e){
var empresa = $('#empresa_id').val();
var valor = $('#ser_auto').val();
if (valor == 'SI') {
//alert(valor);

$.ajax({
  url:baseurl+'Ingreso_ficha/consulta_serie',
  type:'post',
  data : { empresa : empresa },

  success:function(data){
   $("#serie").attr("readonly","readonly");
  $('#serie').val(data);

  }
})



}else {
    $('#serie').val('');
     $("#serie").removeAttr("readonly");
}



});
