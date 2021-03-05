var tbl_usuarios;

$(document).ready(function(){
	tbl_usuarios= dt_usuarios();

	$('#tbl_usuarios tbody').on('click', 'tr', function () {
        var data = tbl_usuarios.row( this ).data();
        $('tr').removeClass('info');
        $(this).addClass('info');
        $('.btn-editar').removeClass( "disabled" );
        //setear datos al modal
        $('#txtIdUsuario').val(data.usuarioid);
        $('#txtNombres').val(data.nombre);
        $('#txtApepat').val(data.apepat);
        $('#txtApemat').val(data.apemat);
        $('#txtDni').val(data.documento);
        $('#txtCargo').val(data.cargo);
        $('#txtCorreo').val(data.correo);
				$('#txtArea').val(data.correo);
        $('#cboTipo').val(data.rolid);
        $.ajax({
        	url:baseurl+"Usuarios/accesos",
        	type:"post",
        	data:{"usuarioid":data.usuarioid},
        	success:function(data){
        		$('#tbl_accesos').html(data);

        	}
        });
        //alert( 'You clicked on '+data.nombre+'\'s row' );
    } );

});
function dt_usuarios(){
	var tbl_usuarios=$('#tbl_usuarios').DataTable({
		"language": {
	       "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
	     },

		dom: 'Bfrtp',
        buttons: [
            {
                text: 'Nuevo',
                className: 'bg-light-blue-active color-palette',
                action: function ( e, dt, node, config ) {
									$('#txtIdUsuario').val('');
									$('#txtNombres').val('');
											$('#txtApepat').val('');
											$('#txtApemat').val('');
											$('#txtDni').val('');
											$('#txtCorreo').val('');
											$('#txtArea').val('');
											$('#cboTipo').val('');

												$('#txtCargo').val('');
                	$('#modal_titulo').html('Nuevo usuario');
                	$('#txtAccion').val('nuevo');
                    $('#m_user_edit').modal('show');
                    $('.btn-editar').addClass( "disabled" );
                    $.ajax({
			        	url:baseurl+"Usuarios/accesos",
			        	type:"post",
			        	data:{"usuarioid":'0'},
			        	success:function(data){
			        		$('#tbl_accesos').html(data);
			        	}
			        });

                }
            },
            {
                text: 'Editar',
                className:'disabled btn-editar',
                action: function ( e, dt, node, config ) {
                	$('#modal_titulo').html('Editar usuario');
                	$('#txtAccion').val('editar');
                    $('#m_user_edit').modal('show');

                }
            }

        ],
		"pagin":true,
		'ajax':{
		      "url":baseurl+"Usuarios/get",
		      "type":"POST",
		       dataSrc:''

		},
		'columns':[
			{data:"usuarioid"},
			{data:"nombre"},
			{data:"apepat"},
			{data:"apemat"},
			{data:"documento"},
			{data:"cargo"},
			{data:"correo"},
			{data:"rol"},

		],
		"columnDefs":[
			{
				"targets":[7],
				"data":"rol",
				"render":function(data,type,row){
					if(row.rolid==1){
						return '<span class="label bg-black color-palette">'+data+'</span>';
					}
					else if( row.rolid==2){
						return '<span class="label label-primary">'+data+'</span>'
					}
					else if(row.rolid==11 || row.rolid==12 || row.rolid==13){
						return '<span class="label label-success">'+data+'</span>'
					}
					else if(row.rolid==16 || row.rolid==17){
						return '<span class="label label-warning">'+data+'</span>'
					}
					else if(row.rolid==null || row.rolid==14){
						return '<span class="label label-default">Sin acceso</span>'
					}
					else if(row.rolid==18){
						return '<span class="label label-info">'+data+'</span>'
					}
				}
			}
		]
	});

	return tbl_usuarios;
}


function borrarinputs(){
		$('#txtIdUsuario').val('');
		$('#txtNombres').val('');
        $('#txtApepat').val('');
        $('#txtApemat').val('');
        $('#txtDni').val('');
        $('#txtCorreo').val('');
				$('#txtArea').val('');
        $('#cboTipo').val('');
				  $('#txtFirma').val('');
}

$('#enviar_form').on('click',function(e){
	if($('#txtNombres').val()!=''){
		if($('#txtApepat').val()!=''){
			if($('#txtDni').val()!=''){
				if($('#txtCorreo').val()!=''){
					var formData = new FormData($("#usuario_form")[0]);
					$.ajax({
						url:baseurl+"Usuarios/save",
						type:"post",
						data:formData,
						contentType:false,
						processData:false,
						beforesend:function(){
								$('#msg-error').html('Grabando...');
						},
						success:function(data){
							if(data==null){
								$('#msg-error').html('<div class="alert alert-success alert-dismissible">'+
                						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                						'<h4><i class="icon fa fa-ban"></i> Registrado!</h4>'+
                						data+
              							'</div>');


								//window.location.replace(baseurl+"Contrato/Usuarios");
							}else{
							$('#msg-error').html('<div class="alert alert-danger alert-dismissible">'+
                						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                						'<h4><i class="icon fa fa-ban"></i> Error!</h4>'+
                						data+
              							'</div>');
								$('#tbl_usuarios').dataTable().fnDestroy();
									tbl_usuarios=dt_usuarios();
									$('#m_user_edit').modal('hide');
									$('#msg-error').html('');
							}
						}
					});


				}else{
					$('#txtCorreo').focus();
					$('#msg-error').html('<div class="alert alert-danger alert-dismissible">'+
                						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                						'<h4><i class="icon fa fa-ban"></i> Error!</h4>'+
                						'Campos vacios'+
              							'</div>');
				}

			}else{
				$('#txtDni').focus();
				$('#msg-error').html('<div class="alert alert-danger alert-dismissible">'+
                						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                						'<h4><i class="icon fa fa-ban"></i> Error!</h4>'+
                						'Campos vacios'+
              							'</div>');
			}

		}else{
			$('#txtApepat').focus();
			$('#msg-error').html('<div class="alert alert-danger alert-dismissible">'+
                						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                						'<h4><i class="icon fa fa-ban"></i> Error!</h4>'+
                						'Campos vacios'+
              							'</div>');
		}

	}else{

		$('#txtNombres').focus();
		$('#msg-error').html('<div class="alert alert-danger alert-dismissible">'+
                						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                						'<h4><i class="icon fa fa-ban"></i> Error!</h4>'+
                						'Campos vacios'+
              							'</div>');
	}


});
