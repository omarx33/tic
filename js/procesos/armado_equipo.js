$(document).on('click','.eliminar',function(e){
  //alert($('#empresa').val());

    let   id=    $(this).attr('data-id');
    let   fila = $(this).closest('tr');
  //  alert(id);

  alertify.confirm('eliminar componente', '¿seguro de retirar el componente del equipo?',
                      function(){

                        $.ajax({
                          url:baseurl+"Componente/eliminar_equipos_det",
                         type:"post",
                         data:{id:id},
                         success:function(data) {
                            alertify.success(data);
                            fila.hide();

                         }
                                       });
                    }, function(){
                    alertify.error('no se eliminaron los datos')
                  });


  });


  $(document).on('click','.agregar_componente',function(){
    $.ajax({
    url:baseurl+"Componente/get_stock",
    data:"empresa="+$('#empresa').val(),
    type:"post",
    dataType:"json",
    success:function(data){
      $('select[name=idcomponente]').find('option').remove();
      $('select[name=idcomponente]').append('<option value="">Seleccione Codigo / Serie</option>');
    $.each(data,function(i,item){
      if (item.codigo_contable == "") {
          $('select[name=idcomponente]').append('<option value="'+item.idstock+'">'+item.serie+'</option>');
      }else {
          $('select[name=idcomponente]').append('<option value="'+item.idstock+'">'+item.codigo_contable+'</option>');
      }

    });
    }
    });

    $('#add_modal').modal('show');
  })


//--------------------------------------------
