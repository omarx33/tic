
$(document).ready(function(){
//	control_de_menu($('#menu_correlativos'));
	tbl_correlativos=tabla_correlativos();
  $('#tbl_correlativos tbody').on('click', 'tr', function () {
        var data = tbl_correlativos.row( this ).data();
        $('tr').removeClass('info');
        $(this).addClass('info');
        $('.btn-editar').removeClass( "disabled" );
        $('.modal-title').html('Correlativos');
	//		$('.modal-title').html("Correlativos");
				$('#correlativo').val(data.correlativo);
        $('#tipo').val(data.tipo);
      	$('#id').val(data.idcorrelativo);

    } );


});







function tabla_correlativos(){
	var tbl=$('#tbl_correlativos').DataTable({
		dom: 'Bfrtp',
				buttons: [
          {
              text: 'Nuevo',
              className: 'bg-light-blue-active color-palette',
              action: function ( e, dt, node, config ) {
                $('.modal-title').html('Nuevo Registro');
              //  $('#modal_titulo').html('Nuevo usuario');
                $('#txtAccion').val('nuevo');
              	$('#editar_modal').modal('show');
                $('#correlativo').val('');
                $('#tipo').val('');
                $('#test').css('display', 'none');
                $('.btn-editar').addClass( "disabled" );


              }
          },

						{
								text: 'Editar',
								className:'disabled btn-editar',
								action: function ( e, dt, node, config ) {
                  $('#txtAccion').val('editar');
									$('#editar_modal').modal('show');
                  $('#txtAccion').val('editar');
                  $('#test').css('display', '');

								}
						}

				],
				"pagin":true,
				"ajax":{
					"url":baseurl+"Correlativo/getall",
					"type":"post",
					dataSrc:''
				},
				"columns":[


					{title:"Tipo",data:"tipo"},
					{title:"Correlativo",data:"correlativo"}
				]

	});
	return tbl;
}





$('#btn_submit').on('click',function(e){
		$.ajax({
			url:baseurl+"Correlativo/save",
			type:"post",
			data:$('#form_correlativo').serialize(),
			success:function(data){
				if(data==1){
          alertify.success("Se actualizo "+data+" fila");
					$('#tbl_correlativos').dataTable().fnDestroy();
					tbl_correlativos=tabla_correlativos();
					$('#editar_modal').modal('hide');
					$('#msg').html('');
}
else if (data==2) {

  alertify.success("Se agrego correctamente");
  $('#tbl_correlativos').dataTable().fnDestroy();
  tbl_correlativos=tabla_correlativos();
  $('#editar_modal').modal('hide');
  $('#msg').html('');

				}
				else{
			//	alertify.error(data);
			swal({
				title: data,
				text: "Intente de nuevo",
				icon: "error",
				timer: 2000
			});
    //  	$('#editar_modal').modal('hide');
				}
			}
		});
});
