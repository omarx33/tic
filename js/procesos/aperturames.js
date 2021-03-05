$(document).ready(function(){
  control_de_menu($('#menu_aperturames'));
});


$(document).on('click','.eliminar_cierre',function(e){
  e.preventDefault();
  var periodo=$(this).attr('data-id');
$.post(baseurl+'Tareo/aperturar_mes',{periodo:periodo},function(data){
  alertify.success('Aperturado exitosamente');
  setTimeout(function(){window.location.href = baseurl+"Inicio/aperturarmes"},1000);
});
});
