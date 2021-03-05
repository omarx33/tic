$(document).ready(function(){
$('.select2').select2();

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

tabla_js($('#empresa').val(),$('#periodo').val());
});

//-------------------------------------

$('#empresa').on('change',function(e){
  $('#empresa').val($(this).val());


tabla_js($('#empresa').val(),$('#periodo').val());
});



function tabla_js(empresa,periodo){
  $.post(baseurl+"Salidas_consumo/lista/",
    {empresa:empresa,periodo:periodo},
  function(data){
     $('#tbl_salida_consumo').html(data);

    });

}






//------------------------


$(document).on('click','#btn_modal',function(e){

borrarinputs();
  $('#modalsalidas').modal('show');
  $('.modal-title').html('Nuevo Registro');
  $('#emp').val($('#empresa').val());
  $('#txtAccion').val('nuevo');

   var empresa = $('#empresa').val();


   $.ajax({
     url:baseurl+'Salidas_consumo/get_correlativo',
     type:'post',
     data : { empresa : empresa },
     beforeSend: function(){
        $('.modal-title').html('');
     },
     success:function(data){
      $('.modal-title').html('Salida Nro:'+data);
      $('#correlativo').val(data);


     }
   })

//...

  });

//--------------------------
/*
$('#sel_codigo').on('change',function(e){
var dato = $('#cod').val();
$.ajax({

url:baseurl+'Salidas_consumo/getserie',
type:'post',
data:{
dato:dato

},
success:function(data){
//--
$('#sel_serie').html('<label for="">SERIE: </label><select id="serie" name="serie" class="form-control select2 "><option>.:Seleccione</option>  </select>');
 var ser=JSON.parse(data);
 $.each(ser,function(i,item){

         $('#serie').append('<option value="'+item.idstock+'">'+item.serie+'</option>');

       });


       $('.select2').each(function () {
         $(this).select2();
       });
//--





}

});


});

*/


function borrarinputs(){
	//$('#cod').val('');
	$('#equipo').val('');
  $('#use_tic').val("");
  $('#usuario').val("");
  $('#area').val("");
  $('#descripcion').val("");
  //  $('#area').hide("");
}




  $(document).on('click','#btn_agregar',function(e){

    e.preventDefault();

      $.ajax({
        url:baseurl+"Salidas_consumo/save",
        type:"post",
        data:$('#salidas_consumo').serialize(),
        success:function(data){



            $('#modalsalidas').modal('hide');
         tabla_js($('#empresa').val(),$('#periodo').val());

//alert(data);

        }
      });

  });




  $(document).on('click','.editar-salidas',function(e){


      $('#modalsalidas').modal('show');
      $('.modal-title').html('Editar Registro');
      $('#emp').val($('#empresa').val());
      $('#txtAccion').val('editar');


      $('#equipo').val($(this).attr('data-descripcion'));
      $('#use_tic').val($(this).attr('data-tecnico'));
      $('#usuario').val($(this).attr('data-usuario'));
      $('#area').val($(this).attr('data-area'));
      $('#descripcion').val($(this).attr('data-info'));
        $('#correlativo').val($(this).attr('data-numero'));
    //  $('#cod').val($(this).attr('data-codigo'));



  //    var empresa = $('#empresa').val();




  });





  $(document).on('click','.verdetalle',function(e){

  //  $('#ss').val($(this).attr('data-cod'));


  $('#btn_modal').hide("slow");
  $('#empresaid').hide("slow");
  $('#fechaid').hide("slow");
    e.preventDefault();
    var id=$(this).attr('data-id');





   listar_detalle(id,$('#empresa').val());


  });

  function listar_detalle(id,empresa){

    $.post(baseurl+"Salidas_consumo/get_detalle_salida/",
      {id:id,empresa:empresa},
    function(data){
//alert(data);
     $('#tbl_salida_consumo').html(data);
    });
  }



  $(document).on('click','#btn_retroceder',function(e){
  $('#btn_modal').show("slow");
  $('#empresaid').show("slow");
  $('#fechaid').show("slow");
  tabla_js($('#empresa').val(),$('#periodo').val());

  });


  $(document).on('click','.eliminar',function(e){
  //alert($('#empresa').val());
    let   empresa = $('#empresa').val();
    let   id=    $(this).attr('data-id');
    let   fila = $(this).closest('tr');

  alertify.confirm('eliminar datos', '¿seguro de eliminar el dato?',
                      function(){

                        $.ajax({
                          url:baseurl+"Salidas_consumo/eliminar",
                         type:"post",
                         data:{id:id,empresa:empresa},
                         success:function(data) {
                           alertify.success(data);
                           fila.hide();

                          // alert(data);
                         }
                                       });
                    }
                  , function(){
                    alertify.error('no se eliminaron los datos')
                  });
  });



  $(document).on('click','#btn_detalle',function(e){
  borrarinputs_det();
  let   empresa = $('#empresa').val();
  		$('#modal-detalle').modal('show');
      $('.modal-title').html('Nuevo Registro');
      $('#txtAccion_detalle').val('nuevo');
       $('#idempresa').val($('#empresa').val());
      $('#btn_detalle_actualizar').attr("disabled", true);


    //  borrarinputs_detalle();
    $.ajax({

    url:baseurl+'Salidas_consumo/getcodigo',
    type:'post',
    data:{
    empresa:empresa
    },
    success:function(data){
    //--
    $('#sel_codigo').html('<label for="">CÓDIGO: </label><select id="cod" name="cod" class="form-control select2 " ><option value="">.:Seleccione</option>  </select>');
     var codigo=JSON.parse(data);
     $.each(codigo,function(i,item){

             $('#cod').append('<option value="'+item.codigo+'">'+item.codigo+" - "+item.descripcion+'</option>');

           });
           $('.select2').each(function () {
             $(this).select2();
           });

    }

    });



  });




  $(document).on('click','#btn_agregar_detalle',function(e){

    e.preventDefault();

      $.ajax({
        url:baseurl+"Salidas_consumo/get_acciones",
        type:"post",
        data:$('#ficha_detalle').serialize(),
        success:function(data){


          $('#modalsalidas').modal('hide');
       listar_detalle(valor2,$('#empresa').val());
//alert(data);

        }
      });


    });


//--------------------

$(document).on('click','#detalle_salida tbody tr', function () {
    $('#cantidad').val($(this).find('td').eq(3).html());
  $('#retiro').val($(this).find('td').eq(4).html());
//alert($(this).find('td').eq(5).html());
  $('#cod').val($(this).find('td').eq(5).html());
    $('#id').val($(this).find('td').eq(6).html());
$('#btn_detalle_actualizar').attr("disabled", false);
  } );


  function borrarinputs_det(){

  	$('#cod').val('');
    $('#serie').val("");
    $('#stock').val("");
    $('#cantidad').val("1");
    $('#retiro').val("");
        $('#id').val("");
    //  $('#area').hide("");
  }


  $(document).on('click','#btn_detalle_actualizar',function(e){
  		$('#modal-detalle').modal('show');
      $('.modal-title').html('Editar Registro');
      $('#txtAccion_detalle').val('editar');
       $('#idempresa').val($('#empresa').val());
let   empresa = $('#empresa').val();
       $.ajax({

       url:baseurl+'Salidas_consumo/getcodigo',
       type:'post',
       data:{
       empresa:empresa
       },
       success:function(data){
       //--
       $('#sel_codigo').html('<label for="">CÓDIGO: </label><select id="cod" name="cod" class="form-control select2 " ><option value="">.:Seleccione</option>  </select>');
        var codigo=JSON.parse(data);
        $.each(codigo,function(i,item){

                $('#cod').append('<option value="'+item.codigo+'">'+item.codigo+" - "+item.descripcion+'</option>');

              });
              $('.select2').each(function () {
                $(this).select2();
              });

       }

       });

  });





  $(document).on('click','.eliminar_detalle',function(e){

    let   id=    $(this).attr('data-id');
    let   serie=    $(this).attr('data-serie');
      let   cantidad=    $(this).attr('data-cantidad');
    let   fila = $(this).closest('tr');

//alert(id);
alertify.confirm('eliminar datos', '¿seguro de eliminar el dato?',
                    function(){

                      $.ajax({
                        url:baseurl+"Salidas_consumo/eliminar_det",
                       type:"post",
                       data:{id:id,serie:serie,cantidad:cantidad},
                       success:function(data) {
                //  alert(data);
                   listar_detalle(valor2,$('#empresa').val());
                       }
                                     });
                  }
                , function(){
                  alertify.error('no se eliminaron los datos')
                });



  });
