
$(document).ready(function(){
tabla_marca = tabla_marca2();

$('#tbl_marca tbody').on('click', 'tr', function () {
      var data = tabla_marca.row( this ).data();
      $('tr').removeClass('info');
      $(this).addClass('info');
      $('.btn-editar').removeClass( "disabled" );
    //  $('.modal-title').html('Correlativos');
    if (data.estado==01) {
       $('#estado').bootstrapToggle('on');
    }else {
       $('#estado').bootstrapToggle('off');
    }
      $('#id').val(data.idmarca);
      $('#ruta').val(data.link);
      $('#descripcion').val(data.descripcion);
      $('#nombre').val(data.nombre_marca);

  } );
});




function tabla_marca2(){

	var tbl=$('#tbl_marca').DataTable({

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
                     $('.modal-title').html('Editar Marca');
                  }
              }

          ],






				"pagin":true,
				"ajax":{
					"url":baseurl+"Marca/getall",
					"type":"post",
					dataSrc:''
				},
				"columns":[

					{title:"Nombre",data:"nombre_marca"},
					{title:"Link",data:"link"},
          {title:"Descripción",data:"descripcion"},
          {title:"Estado",data:"estado"}
				],
        "columnDefs":[
          {
            targets:[3],
            data:"estado",
            render:function(data,type,row){
                if(data=='01'){
                  return '<span class="label label-success">Activo</span>'
                }
                if (data=='00') {
                  return '<span class="label label-default">Inactivo</span>'
                }
            }
          }
        ]

	});
	return tbl;
}



function borrarinputs(){
	$('#nombre').val('');
	$('#ruta').val('');
	$('#descripcion').val('');
	$('#estado').bootstrapToggle('on');
}


$('#estado').bootstrapToggle({
      on: 'Activo',
      off: 'Inactivo',
			onstyle:'success',
			offstyle:'default',
			width:80,

    });




$('#btn_submit').on('click',function(e){
	e.preventDefault();
		$.ajax({
			url:baseurl+"Marca/save",
			type:"post",
			data:$('#form_marca').serialize(),
			success:function(data){
				if(data=='0'){
		alertify.error("No se modifico ningun dato");
    $('#editar_modal').modal('hide');
    $('#msg').html('');
						}
						else if(data=="2"){ //no estoy trabajando con valor 2 aun
            alertify.error("El archivo existe");
            $('#editar_modal').modal('hide');
            $('#msg').html('');
					}else if (data=="3") {
                alertify.error("Algún dato esta vacío , Verifique de nuevo");
                $('#editar_modal').modal('hide');
                $('#msg').html('');
          }else {
						alertify.success(data);
            	$('#tbl_marca').dataTable().fnDestroy();
					 tabla_marca = tabla_marca2();
						$('#editar_modal').modal('hide');
						$('#msg').html('');
					}
			}
		});
});
