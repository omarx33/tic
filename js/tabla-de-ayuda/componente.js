$(document).ready(function(){
 tabla_componente = tabla_componente2();




$('#tbl_componente tbody').on('click', 'tr', function () {
      var data = tabla_componente.row( this ).data();
      $('tr').removeClass('info');
      $(this).addClass('info');
      $('.btn-editar').removeClass( "disabled" );
    //  $('.modal-title').html('Correlativos');
    if (data.estado==01) {
       $('#estado').bootstrapToggle('on');
    }else {
       $('#estado').bootstrapToggle('off');
    }
      $('#id').val(data.idcomponente);
      $('#nombre').val(data.descripcion);

  } );



});


$('#estado').bootstrapToggle({
      on: 'Activo',
      off: 'Inactivo',
			onstyle:'success',
			offstyle:'default',
			width:80,

    });


function tabla_componente2(){

	var tbl=$('#tbl_componente').DataTable({

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
					"url":baseurl+"Componente/getall",
					"type":"post",
					dataSrc:''
				},
				"columns":[

					{title:"NOMBRE",data:"descripcion"},
					{title:"ESTADO",data:"estado"}

				]

	});
	return tbl;
}


function borrarinputs(){
	$('#nombre').val('');
	$('#estado').bootstrapToggle('on');
}




$('#btn_submit').on('click',function(e){
	e.preventDefault();
		$.ajax({
			url:baseurl+"Componente/save",
			type:"post",
			data:$('#form_componente').serialize(),
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
            	$('#tbl_componente').dataTable().fnDestroy();
				 tabla_componente = tabla_componente2();
						$('#editar_modal').modal('hide');
						$('#msg').html('');
					}
			}
		});
});
