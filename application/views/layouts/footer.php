<?php $cdn=base_url().'assets/cdn/'; ?>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>COPYRIGHT © 2019 ÁREA DE TIC - ROVHECO DATA - ROCKDRILL S.A.C -TODOS LOS DERECHOS RESERVADOS
        </footer>
    </div>
    <!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="<?php echo $cdn;?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $cdn;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo $cdn; ?>bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script  src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $cdn; ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $cdn; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $cdn; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- -->
<script src="<?php echo $cdn; ?>bower_components/alertify/alertify.min.js"></script>

<script lang = "javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js">  </script>

<!--SELECT 2 -->

 <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet"> <!-- for live demo page -->
<!-- select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- SlimScroll -->
<script src="<?php echo $cdn;?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="<?php echo $cdn;?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $cdn;?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $cdn;?>dist/js/demo.js"></script>
<?php if($this->uri->segment(2)=='Usuarios'){ ?>
<script src="<?php echo base_url() ?>js/usuario.js"></script>
<?php } ?>

<script src="<?php echo base_url() ?>js/inicio.js"></script>

<script src="<?php echo base_url() ?>js/perfil.js"></script>

<?php if($this->uri->segment(2)=='Usuarios_ticket'){ ?>
<script src="<?php echo base_url() ?>js/tabla-de-ayuda/usuarios_ticket.js"></script>
<?php } ?>
<?php if($this->uri->segment(2)=='area'){ ?>
<script src="<?php echo base_url() ?>js/tabla-de-ayuda/area.js"></script>
<?php } ?>
<?php if($this->uri->segment(2)=='marca'){ ?>
<script src="<?php echo base_url() ?>js/tabla-de-ayuda/marca.js"></script>
<?php } ?>

<?php if($this->uri->segment(2)=='Componente'){ ?>
<script src="<?php echo base_url() ?>js/tabla-de-ayuda/componente.js"></script>
<?php } ?>
<?php if($this->uri->segment(2)=='Correlativo'){ ?>
<script src="<?php echo base_url() ?>js/tabla-de-ayuda/correlativo.js">
</script>
<?php } ?>
<?php if($this->uri->segment(2)=='ficha_tecnica'){ ?>

<script src="<?php echo base_url() ?>js/movimientos/ficha_tecnica.js">
</script>
<?php } ?>
<?php if($this->uri->segment(2)=='Articulos'){ ?>

<script src="<?php echo base_url() ?>js/tabla-de-ayuda/articulos.js">
</script>
<?php } ?>


<?php if($this->uri->segment(2)=='Ingreso_ficha'){ ?>

<script src="<?php echo base_url() ?>js/procesos/ingreso_ficha.js">
</script>
<?php } ?>


<?php if($this->uri->segment(2)=='Stock'){ ?>
<script src="<?php echo base_url() ?>js/consultas/stock.js">
</script>
<?php } ?>

<?php if($this->uri->segment(2)=='Mov_componentes'){ ?>
<script src="<?php echo base_url() ?>js/consultas/mov_componentes.js">
</script>
<?php } ?>

<?php if($this->uri->segment(2)=='Mov_componentes_oc'){ ?>
<script src="<?php echo base_url() ?>js/consultas/mov_componentes_oc.js">
</script>
<?php } ?>

<?php if($this->uri->segment(2)=='armado_equipo'){ ?>
<script src="<?php echo base_url() ?>js/procesos/armado_equipo.js">
</script>
<?php } ?>
<?php if($this->uri->segment(2)=='asignacion_equipo'){ ?>
<script src="<?php echo base_url() ?>js/procesos/asignacion_equipo.js">
</script>
<?php } ?>

<?php if($this->uri->segment(2)=='Salidas_consumo'){ ?>
<script src="<?php echo base_url() ?>js/procesos/salidas_consumo.js">
</script>
<?php } ?>

<script>


$(document).ready(function () {
$('.sidebar-menu').tree()
})
</script>
<script>
	var baseurl="<?php echo base_url(); ?>";
</script>
</body>
</html>
