$(document).ready(function(){


tabla_stock($('#empresa').val());


});



function tabla_stock(empresa){
  $.post(baseurl+"Stock/stock/",
    {empresa:empresa},
  function(data){

    $("#tbl_stock").html(data);

  });
}
$('#empresa').on('change',function(e){
tabla_stock($('#empresa').val());
});
