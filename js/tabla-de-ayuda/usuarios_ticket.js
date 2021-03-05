$(document).ready(function(){
  control_de_menu($('#menu_user_ticket'));
tabla_usuarios_ticket = tabla_usuarios_ticket2();

$('#tbl_usuarios_ticket tbody').on('click', 'tr', function () {
      var data = tabla_usuarios_ticket.row( this ).data();
      $('tr').removeClass('info');
      $(this).addClass('info');
     $('.btn-editar').removeClass( "disabled" );
    $('#id').val(data.idusuario);
    //$('#id').val($(this).find('td').eq(2).html());
    $('#nombres').val($(this).find('td').eq(0).html());
    $('#apellidos').val($(this).find('td').eq(1).html());
    $('#dni').val($(this).find('td').eq(2).html());
    $('#correo').val($(this).find('td').eq(4).html());
    $('#area').val(data.idarea);
    $('#empresa').val(data.idempresa);
    $('#cargo').val($(this).find('td').eq(3).html());
    if (data.estado==01) {
       $('#estado').bootstrapToggle('on');
    }else {
       $('#estado').bootstrapToggle('off');
    }
  } );



});





$('#estado').bootstrapToggle({
      on: 'Activo',
      off: 'Inactivo',
			onstyle:'success',
			offstyle:'default',
			width:80,

    });


function tabla_usuarios_ticket2(){

	var tbl=$('#tbl_usuarios_ticket').DataTable({

    "language": {
         "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
       },

       dom: 'Bfrtp',
          buttons: [
             {
                 text: 'Nuevo',
                 className: 'bg-light-blue-active color-palette',
                 action: function ( e, dt, node, config ) {
                   $('.modal-title').html('Nuevo Registro');

                   $('#txtAccion').val('nuevo');
                   $('#editar_modal').modal('show');
                  borrarinputs();
                 $('.btn-editar').addClass( "disabled" );

                 }
             },

              {
                  text: 'Editar',
                  className:'disabled btn-editar',
                  action: function ( e, dt, node, config ) {
                     $('#txtAccion').val('editar');
                     $('#editar_modal').modal('show');
                     $('.modal-title').html('Editar');
                  }
              }

          ],


				"pagin":true,
				"ajax":{
					"url":baseurl+"Usuarios_ticket/getall",
					"type":"post",
					dataSrc:''
				},
				"columns":[

        //	{title:"#",data:"nombres"},

					{title:"NOMBRES",data:"nombres"},
					{title:"APELLIDOS",data:"apellidos"},
          {title:"DNI",data:"dni"},
          {title:"CARGO",data:"cargo"},
          {title:"CORREO",data:"correo"},
          {title:"AREA",data:"area"},
          {title:"EMPRESA",data:"empresa"},
          {title:"ESTADO",data:"estado"}

				],
				"columnDefs":[
					{
						targets:[7],
						data:"estado",
						render:function(data,type,row){
								if(data=='01'){
									return '<span class="label label-success">Activo</span>'
								}
								if (data=='00') {
									return '<span class="label label-default">Inactivo</span>'
								}else {
              	return '<span class="label label-danger">Inexistente</span>'
                }
						}
					}
				]

	});
	return tbl;
}



function borrarinputs(){
	$('#nombres').val('');
  $('#apellidos').val('');
  $('#dni').val('');
  $('#correo').val('');
  $('#empresa').val('');
  $('#area').val('');
  $('#cargo').val('');
  $('#estado').bootstrapToggle('on');
}






$('#btn_submit').on('click',function(e){
	e.preventDefault();
		$.ajax({
			url:baseurl+"Usuarios_ticket/save",
			type:"post",
			data:$('#usuarios_ticket').serialize(),
			success:function(data){
				if(data=='0'){
		alertify.error("No se modifico ningun dato");
    $('#editar_modal').modal('hide');
    $('#msg').html('');
						}
						else if(data=="2"){
          //  alertify.error("El usuario existe");
          Swal.fire({
        position: 'top-end',
        type: 'info',
        title: 'El usuario existe',
        showConfirmButton: false,
        timer: 2000
      });
            $('#editar_modal').modal('hide');
            $('#msg').html('');
					}else if (data=="3") {
                alertify.error("Algún dato esta vacío , Verifique de nuevo");
            //    $('#editar_modal').modal('hide');
                $('#msg').html('');
          }else {
						alertify.success(data);
          	$('#tbl_usuarios_ticket').dataTable().fnDestroy();
	         tabla_usuarios_ticket = tabla_usuarios_ticket2();
						$('#editar_modal').modal('hide');
						$('#msg').html('');
					}
			}
		});
});
