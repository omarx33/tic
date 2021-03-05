
$(document).ready(function(){
	tbl_area=tabla_area();

  $('#tbl_area tbody').on('click', 'tr', function () {
        var data = tbl_area.row( this ).data();
        $('tr').removeClass('info');
        $(this).addClass('info');
        $('.btn-editar').removeClass( "disabled" );
        $('.modal-title').html('Editar Registro');
	//		$('.modal-title').html("Correlativos");
	//			$('#estado').val(data.estado);
       if (data.estado==01) {
         	$('#estado').bootstrapToggle('on');
       }else {
         	$('#estado').bootstrapToggle('off');
       }

        $('#descripcion').val(data.descripcion);
      	$('#id').val(data.idarea);

    } );

});


$('#estado').bootstrapToggle({
      on: 'Activo',
      off: 'Inactivo',
			onstyle:'success',
			offstyle:'default',
			width:80,

    });




function tabla_area(){

	var tbl=$('#tbl_area').DataTable({
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
                  $('#estado').bootstrapToggle('off');
                   $('#txtAccion').val('nuevo');
                 	$('#editar_modal').modal('show');
                  //	$('#estado').bootstrapToggle('on');
                   $('#descripcion').val('');

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



   								}
   						}

   				],





				"pagin":true,
				"ajax":{
					"url":baseurl+"Area/getall",
					"type":"post",
					dataSrc:''
				},
				"columns":[

					{title:"Descripción",data:"descripcion"},
					{title:"Estado",data:"estado"}


				],
				"columnDefs":[
					{
						targets:[1],
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







$('#btn_submit').on('click',function(e){
	e.preventDefault();
		$.ajax({
			url:baseurl+"Area/save",
			type:"post",
			data:$('#form_area').serialize(),
			success:function(data){
				if(data=='0'){
		alertify.error("ocurrio un error");
						}
						else if(data=="3"){
            alertify.error("Algún campo esta vacio");
					}else {
						alertify.success(data);
						$('#tbl_area').dataTable().fnDestroy();
						tbl_area=tabla_area();
						$('#editar_modal').modal('hide');
						$('#msg').html('');
					}
			}
		});
});
