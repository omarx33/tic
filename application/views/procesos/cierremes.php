
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h4>Cierre de mes</h4>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                      <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i> Tener en cuenta!</h4>
      El cierre muestra el mes despues del ultimo cierre.
  </div>
    <form id="form_cierre">
      <input type="hidden" id="periodo" name="periodo" value="<?php echo $periodo ?>">
      <?php if ($periodo!=''){ ?>
        <button type="button" class="btn btn-primary btn-block" id="btn_cierre_mes">

            Cerrar periodo <?php echo $periodo ?>
        </button>
      <?php }else{ ?>

      <div class="callout callout-danger">
        <h4>Sin registros!</h4>

        <p>No hay periodos para cerrar</p>
      </div>

    <?php } ?>

    </form>

    <div id="msg">

    </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <script type="text/javascript">
        $(document).ready(function(){
          control_de_menu($('#menu_cierremes'));
        });
        $(document).on('click','#btn_cierre_mes',function(e){
          var periodo=$('#periodo').val();
          alertify.confirm('Cierre de Mes', '¿Desea cerrar el mes?',
          function(){
            $.ajax({
            url:baseurl+"Tareo/cierremes",
            type:"post",
            data:"periodo="+periodo,
            beforeSend:function(){
              $('#btn_cierre_mes').attr('disabled',true);
               $('#msg').html('<br><br> <center><img src="http://192.168.1.7/almacenes-virtuales/assets/img/espera.gif"> <h5>Por favor espere a que el proceso termine, no actualize ni cambie de pagina</h5></center><br> ');

               $(window).on("beforeunload", function(e) {
                  return '¿Cancelar todo?';
                });

            },
            success:function(info){
                $(window).off("beforeunload");
                $('#msg').hide();
                alertify.success('El periodo fue cerrado exitosamente');

            },
            error:function (xhr, ajaxOptions, thrownError) {
                 alertify.error('Ocurrio un error');
              }
          });

                             },
                            function(){//cancela
                              alertify.error('Error');
                            });
        });
        </script>
