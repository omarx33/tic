$(document).ready(function(){
  control_de_menu($('#menu_operaciones'));
});

$(document.body).off('change','form select[name=periodo]');
$(document.body).on('change','form select[name=periodo]',function(){
  let periodo=$(this).val();
  $.ajax({
    url:baseurl+'Tareo/getdias',
    data:{
      "periodo":periodo,
    },
    dataType:'json',
    type:"post",
    success:function(data){
   $('form select[name=dia]').find('option:not(:first)').remove();
      $.each(data,function(i,item){
          $('form select[name=dia]').append('<option value="'+(i+1)+'">'+item+'</option>');
      });
    }
  });
});


    $(document).off('change','#tipo_trabajador');
    $(document).on('change','#tipo_trabajador',function(e){
      if ($('#tipo_trabajador option:selected').val()==2 || $('#tipo_trabajador option:selected').val()==4 ) {
          $('.hextra').removeAttr('style');
      }else {
    $('.hextra').css("display","none");
      }
  });




  $(document).off('change','#dia');
  $(document).on('change','#dia',function(e){
    let periodo=$('#periodo').val();
    let dia=$('#dia').val();
    let tipo=$('#tipo_trabajador').val();

    $.post(baseurl+"Tareo/get_tareodiario",{periodo:periodo,dia:dia,tipo:tipo},function(data){
      if (data==1) {
          alert('Dia Cerrado!! No se permite la edicion del día seleccionado, por favor comuniquese con el área de Operaciones o Gestion Humana');
          location.reload();
      }else {
            $('#tbl_tareodiario').html(data);
      }
  });
});



    $(document).on('click','.horas_extra',function(e){
      let trabajador=$(this).attr('data-id');
      let periodo=$('#periodo').val();
      let dia=$('#dia').val();
      var fila=$(this).parent().parent();
          var personal=fila.find('td').eq(2).html();
      $('#trabajadorte').val(trabajador);
      $('#periodote').val(periodo);
      $('#diate').val(dia);
      $('#tipotiempo').val('HE');
      $('#tipotiempondesc').text('Hora Extra');
      $('#nombre').text(personal);
    })


    $(document).on('click','.dias_apoyo',function(e){
      let trabajador=$(this).attr('data-id');
      let periodo=$('#periodo').val();
      let dia=$('#dia').val();
      var fila=$(this).parent().parent();
      var personal=fila.find('td').eq(2).html();
      $('#trabajadorte').val(trabajador);
      $('#periodote').val(periodo);
      $('#diate').val(dia);
      $('#tipotiempo').val('DA');
      $('#tipotiempondesc').text('Dia de Apoyo');
      $('#nombre').text(personal);
    })




    $(document).on('click','#guardar_tiempo',function(e){

        alertify.confirm('Validacion', '¿Desea guardar?',
        function(){

          $('#tbl_tareo').removeAttr('style');
          alertify.success('Informacion guardada') }
      , function(){
          alertify.error('Error')});

      });

   $(document).on('change','.changedia',function(e){
        let valor=$(this).val();
        var dia=$('#dia').val();
        var periodo=$('#periodo').val();
    var fila=$(this).parent().parent();
        var personal=fila.find('td').eq(1).html();
    fila.find('td').eq(4).html(valor);

  $.ajax({
    url:baseurl+"Tareo/asignar_dia",
    type:"post",
    data:"tipo="+valor+'&dia='+dia+'&periodo='+periodo+'&personal='+personal,
    success: function(info){
        alertify.success(info);

      if ($(this).val()=='DA') {

      fila.find('td').eq(6).removeAttr('style');

      }else {
       fila.find('td').eq(6).css({'display':'none'});
    }

        },
    error: function (xhr, ajaxOptions, thrownError) {
         alertify.error('Ocurrio un error');
      }
  });
    });

$(document).on('click','#grabardia',function(e){
  var fecha=$('#dia option:selected').text();
    var dia=$('#dia').val();
  var periodo=$('#periodo').val();
  alertify.confirm ('Grabar Dia','¿Desea grabar las actualizaciones del dia '+fecha+'?',
                    function(){
                      var json="";
                var json_total="";
                        $("#tbl_tareodiario tbody tr").each(function () {
                          json ="";
                          $(this).find("td").each(function () {
                                $this=$(this);
                                if($this.attr("class")=='codigo_personal' || $this.attr("class")=='dia'){
                                  json=json+',"'+$this.attr("class")+'":"'+$this.html()+'"';
                                }


                          });
                          obj=JSON.parse('{'+json.substr(1)+'}');
                          json_total=json_total+','+JSON.stringify(obj);

                      });

                var array_json=JSON.parse('['+json_total.substr(1)+']');
                $.ajax({
                  url:baseurl+"Tareo/grabardia",
                  type:"post",
                  data:"periodo="+periodo+"&dia="+dia+"&tbldetalle=" + JSON.stringify(array_json),
                  beforeSend:function(){
                    $('#grabardia').prop('disabled',true);
                  },
                  success: function(data){
                    $('#grabardia').prop('disabled',false);
                       alertify.success(data);
                  },
                  error: function (xhr, ajaxOptions, thrownError) {

                       alertify.error('Ocurrio un error');

                    }
                });
              },function(){alertify.error("Error");});
});

$(document).on('click','#guardar_tiempo',function(e){
if ($('#tiempo').val()==1) {
  $.ajax({
    url:baseurl+"Tareo/tiempo_extra",
    type:"post",
    data:$('#form_tiempoextra').serialize(),
    beforeSend:function(){
      $('#guardar_tiempo').prop('disabled',true);
    },
    success: function(data){
         alertify.success(data);
    },
    error: function (xhr, ajaxOptions, thrownError) {

         alertify.error('Ocurrio un error');

      }
  });
}else {
  alert("El valor tiene que ser 1");
}
});

$(document).on('click','#cerrardia',function(e){
  var fecha=$('#dia option:selected').val();
  var periodo=$('#periodo').val();
alertify.confirm('Cierre de dia','Al cerrar el dia ya no podrá realizar ninguna modificación posterior,¿Desea cerrar este día?',function (e){
  $.ajax({
    url:baseurl+"Tareo/cerrar_dia",
    type:"post",
    data:"dia="+fecha+'& periodo='+periodo,
    beforeSend:function(data){
      $('#cerrardia').prop('disabled',true);
    },
    success: function(data){
         alertify.success(data);
         location.reload();
    },
    error: function (xhr, ajaxOptions, thrownError) {
         alertify.error('Ocurrio un error');
      }
  });

},function(){
           alertify.error('Cancelado');
});

});
$(window).on("beforeunload", function(e) {
   return '¿Cancelar todo?';
 });
