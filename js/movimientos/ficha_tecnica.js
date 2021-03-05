$(document).ready(function(){


  $('.datepicker').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Ultimos 7 Dias' : [moment().subtract(6, 'days'), moment()],
      'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
      'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Ultimo Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(6, 'days'),
    endDate  : moment(),
    locale: {
   format: 'DD/MM/YYYY'
      }
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('dd/mm/yyyy') + ' - ' + end.format('dd/mm/yyyy'))
  }
);



//-----------------------------------------------
$(document).on('click','#btn_modal',function(e){
   var elegido = $('#empresa').val();

   $.ajax({

   url:baseurl+'Ficha_tecnica/getempresa',
   type:'post',
   data:{
   elegido:elegido

   },
   success:function(data){
   //--
   $('#sel_area').html('<label for="">ÁREA: </label><select id="area" name="area" class="form-control select2 "><option>.:Seleccione</option>  </select>');
    var areas=JSON.parse(data);
    $.each(areas,function(i,item){

            $('#area').append('<option value="'+item.CENCOST_CODIGO+'">'+item.CENCOST_CODIGO+ ' - ' +item.CENCOST_DESCRIPCION+'</option>');
          });
          $('.select2').each(function () {
            $(this).select2();
          });
   //--
   }

   });
  });
/*
$.ajax({

url:baseurl+'Ficha_tecnica/getempresa',
type:'post',
data:{
elegido:elegido

},
success:function(data){
//--
$('#sel_area').html('<label for="">ÁREA: </label><select id="area" name="area" class="form-control"><option>.:Seleccione</option>  </select>');
 var areas=JSON.parse(data);
 $.each(areas,function(i,item){

         $('#area').append('<option value="'+item.CENCOST_CODIGO+'">'+item.CENCOST_DESCRIPCION+'</option>');
       });

//--
}

});
*/
//


//------------------------------------------------

tabla_js($('#empresa').val(),$('#periodo').val());



$(document).on('click','#tbl_detalle tbody tr', function () {
$('#id_detalle').val($(this).find('td').eq(0).html());


$('#descripcion').val($(this).find('td').eq(3).html());
$('#precio_ref').val($(this).find('td').eq(4).html());
$('#fuente').val($(this).find('td').eq(5).html());
$('#cantidad').val($(this).find('td').eq(6).html());
$('#comentario').val($(this).find('td').eq(8).html());
$('#img').val($(this).find('td').eq(10).html());
$('#btn_detalle_actualizar').attr("disabled", false);


  } );




//alert($('#empresa').val());

});

$('#empresa').on('change',function(e){
  $('#empresais').val($(this).val());
tabla_js($('#empresa').val(),$('#periodo').val());
});
$('#periodo').on('change',function(e){
tabla_js($('#empresa').val(),$('#periodo').val());
});

function tabla_js(empresa,periodo){
  $.post(baseurl+"Ficha_tecnica/ficha_tecnica/",
    {empresa:empresa,periodo:periodo},
  function(data){
      $('#tbl_ficha_tecnica').html(data);

    });



}



$(document).on('click','#btn_agregar',function(e){

  e.preventDefault();
  $.ajax({
    url:baseurl+"Ficha_tecnica/save",
    type:"post",
    data:$('#ficha_tecnica').serialize(),
    success:function(data){
      if (data == 0) {
        alertify.error("No se pudo guardar");
      }else if (data == 2) {
        alert("Se actualizo la fila");
        $('#myModal2').modal('hide');
        borrarinputs();
      }else if (data == 3){
        alertify.error("Algún campo vacío");
      }else{
        tabla_js($('#empresa').val(),$('#periodo').val());
        alertify.success("Correcto");
        $('#myModal2').modal('hide');
        borrarinputs();
      }
    }
  });

});

function borrarinputs(){
	$('#solicitante').val('');
//	$('#empresais').val('');
//	$('#user_tic').val('');
	$('#descripcion').val('');
  $('#correlativo').val("");
  $('#requerimiento').val("");
  $('#area').val(" ");
  $('#area').hide("");
}


function borrarinputs_detalle(){
	$('#id_detalle').val('');
  //$('#correlativo2').val('');
  $('#descripcion').val('');
  $('#fuente').val('');
  $('#precio_ref').val('');
  $('#cantidad').val('');
  $('#img').val('');

  $('#comentario').val('');

}


$(document).on('click','#btn_modal',function(e){

   var empresa = $('#empresa').val()
 //alert(empresa);
   $.ajax({
     url:baseurl+'Ficha_tecnica/get_correlativo',
     type:'post',
     data : { empresa : empresa },
     beforeSend: function(){
        $('.modal-title').html('');
     },
     success:function(data){
      $('.modal-title').html('Ficha técnica Nro:'+data);
      $('#correlativo').val(data);


     }
   })

});


$(document).on('click','#btn_modal',function(e){
  $('#txtAccion').val('nuevo');
//  alert($('#empresa option:selected').val());
    $('#empresais').val($('#empresa option:selected').val());
  $('#myModal2').modal('show');
     $('#requerimiento').attr('readonly',true);
  borrarinputs();

  $("#nro_ticket_pendientes_e").css("display","none");
  $("#nro_ticket_pendientes").css("display","block");
});



$(document).on('click','.editar-ficha',function(e){
  e.preventDefault();

  $("#nro_ticket_pendientes").css("display","none");
  $("#nro_ticket_pendientes_e").css("display","block");

   var elegido = $('#empresa').val();
    $('#empresais').val(elegido);
   //alert(elegido);
   var area=$(this).attr('data-area');


   $('#requerimiento').attr('readonly',false);
  $('#myModal2').modal('show');
  $.ajax({
  url:baseurl+'Ficha_tecnica/getempresa',
  type:'post',
  data:{ elegido:elegido },
  success:function(data){
  $('#sel_area').html('<label for="">ÁREA: </label><select id="area" name="area" class="form-control select2 "><option>.:Seleccione</option>  </select>');
   var areas=JSON.parse(data);
   $.each(areas,function(i,item){
           $('#area').append('<option value="'+item.CENCOST_CODIGO+'">'+item.CENCOST_DESCRIPCION+'</option>');
         });
         $('.select2').each(function () {
           $(this).select2();
         });

            $('#area').val(area).trigger('change.select2');
  }
  });



  $('#txtAccion').val('editar');
  $('.modal-title').html('Editar ficha');
  //$('#solicitante option[value='+$(this).attr('data-solicitante')+']').attr('selected',true);
  $('#nro_ticket_pendientes_e').val($(this).attr('data-idticket'));
   $('#solicitante').val($(this).attr('data-solicitante')).trigger('change.select2');
  $('#empresa').val($(this).attr('data-empresa'));
//  $('#user_tic').val($(this).attr('data-user_tic'));
  $('#descripcion').val($(this).attr('data-descripcion'));
  $('#correlativo').val($(this).attr('data-correlativo'));
  $('#eliminar_detalle').val($(this).attr('data-correlativo'));
  $('#requerimiento').val($(this).attr('data-requerimiento'));
  //  $('#area option[value='+$(this).attr('data-area')+']').attr('selected',true);

  //  $('#descripcion').show("");
});





//--------------


$(document).on('click','.eliminar',function(e){
//alert($('#empresa').val());
  let   empresa = $('#empresa').val();
  let   id=    $(this).attr('data-id');
  let   fila = $(this).closest('tr');

alertify.confirm('eliminar datos', '¿seguro de eliminar el dato?',
                    function(){

                      $.ajax({
                        url:baseurl+"Ficha_tecnica/eliminar",
                       type:"post",
                       data:{id:id,empresa:empresa},
                       success:function(data) {
                          alertify.success(data);
                          fila.hide();
                       }
                                     });
                  }
                , function(){
                  alertify.error('no se eliminaron los datos')
                });
});



//------------------------



$(document).on('click','.btn_excel',function(e){
   var empresa=$(this).attr('data-empresa');
  var id=$(this).attr('data-id');

  alertify.confirm('Exportar excel', '¿seguro de exportar la información?',
                      function(){

window.open(baseurl+"Exportarexcel/exportar_excel/?id="+id+"&empresa="+empresa);

                    }
                  , function(){
                    alertify.error('no se exporto')
                  });


});




//--------------------------






$(document).on('click','.eliminar_detalle',function(e){

  let   id=    $(this).attr('data-id');
  let   fila = $(this).closest('tr');
// var id =  $('input:hidden[name=id_detalle]').val();
alertify.confirm('eliminar datos', '¿seguro de eliminar el dato?',
                    function(){

                      $.ajax({
                        url:baseurl+"Ficha_tecnica/eliminar_det",
                       type:"post",
                       data:{id:id},
                       success:function(data) {
                          alertify.success(data);
                         listar_detalle(valor,$('#empresa').val());
                       }
                                     });
                  }
                , function(){
                  alertify.error('no se eliminaron los datos')
                });


});




$(document).on('click','#btn_retroceder',function(e){
$('#btn_modal').show("slow");
$('#empresaid').show("slow");
$('#fechaid').show("slow");
tabla_js($('#empresa').val(),$('#periodo').val());

});


$(document).on('click','.verdetalle',function(e){


$('#btn_modal').hide("slow");
$('#empresaid').hide("slow");
$('#fechaid').hide("slow");
  e.preventDefault();
  var id=$(this).attr('data-id');

 listar_detalle(id,$('#empresa').val());


});






function listar_detalle(idnota,empresa){

  $.post(baseurl+"Ficha_tecnica/get_detalle_ficha/",
    {idnota:idnota,empresa:empresa},
  function(data){
    $('#tbl_ficha_tecnica').html(data);
  });
}


$(document).on('click','#btn_detalle',function(e){
		$('#modal-detalle').modal('show');
    $('.modal-title').html('Nuevo Registro');
    $('#txtAccion_detalle').val('nuevo');
     $('#idempresa').val($('#empresa').val());
    $('#btn_detalle_actualizar').attr("disabled", true);
    borrarinputs_detalle();

});




$(document).on('click','#btn_agregar_detalle',function(){


var formData = new FormData($("#ficha_detalle")[0]);
$.ajax({
url:baseurl+"Ficha_tecnica/save_files",
type:"post",
data:formData,
contentType:false,
processData:false,
beforesend:function(){
$('#msg').html('Grabando...');
},
success:function(data){
alertify.success(data);

 listar_detalle(valor,$('#empresa').val());

}

});
});
// detalles




$(document).on('click','#btn_detalle_actualizar',function(e){

	$('#modal-detalle').modal('show');
  $('.modal-title').html('Editar Registro');
  $('#txtAccion_detalle').val('editar');



});
