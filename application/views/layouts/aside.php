        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header" style="font-size: 11px ">MENU DE NAVEGACIÓN</li>
                    <li>
                        <a href="<?php echo base_url() ?>Inicio">
                            <i class="fa fa-home"></i> <span>Inicio</span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-eye"></i> <span> Dashboard</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url() ?>Inicio/Dashboard"><i class="fa fa-circle-o"></i> REPORTE DEL MES</a></li>
                                    <!--  <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Clientes</a></li>
                        -->
                        </ul>
                    </li>


                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i> <span>Tabla de Ayuda</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url() ?>Inicio/area"><i class="fa fa-circle-o"></i> Área</a></li>
                            <li><a href="<?php echo base_url() ?>Inicio/Correlativo"><i class="fa fa-circle-o"></i> Correlativo</a></li>
                            <li><a href="<?php echo base_url() ?>Inicio/Usuarios_ticket" id="menu_user_ticket"><i class="fa fa-circle-o"></i> Usuarios ticket</a></li>
                            <li><a href="<?php echo base_url() ?>Inicio/marca"><i class="fa fa-circle-o"></i> Marca</a></li>
                            <li><a href="<?php echo base_url() ?>Inicio/Componente"><i class="fa fa-circle-o"></i> Componente</a></li>
                           <li><a href="<?php echo base_url() ?>Inicio/Articulos"><i class="fa fa-circle-o"></i> Artículos</a></li>
                          <!--  <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Clientes</a></li>
                        -->
                        </ul>
                    </li>

                        <li class="treeview">
                        <a href="#">
                            <i class="fas fa-folder-open"></i> <span>Documentos</span>

                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url() ?>Inicio/ficha_tecnica"><i class="fa fa-circle-o"></i>Ficha Técnica</a></li>
                          <!--  <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Generar Factura</a></li> -->
                        </ul>
                    </li>




                                        <li class="treeview">
                                            <a href="#">
                                                <i class="fas fa-coffee"></i> </i> <span>Procesos</span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="<?php echo base_url() ?>Inicio/Ingreso_ficha"><i class="fa fa-circle-o"></i>  Ingreso por Ficha Técnica</a></li>
                                                <li><a href="<?php echo base_url() ?>Inicio/armado_equipo"><i class="fa fa-circle-o"></i>  Armado de Equipo</a></li>
                                                <li><a href="<?php echo base_url() ?>Inicio/asignacion_equipo"><i class="fa fa-circle-o"></i>  Asignación de Equipo</a></li>
                                                <li><a href="<?php echo base_url() ?>Inicio/Salidas_consumo"><i class="fa fa-circle-o"></i>  Salidas por consumo</a></li>
                                                    <!--  <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Clientes</a></li>
                                            -->
                                            </ul>
                                        </li>
                                        <li class="treeview">
                                            <a href="#">
                                                <i class="fas fa-cubes"></i> <span>Planilla de Movilidad</span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="<?php echo base_url() ?>Inicio/apertura_cierre_planilla"><i class="fa fa-circle-o"></i>Apertura Y Cierre</a></li>
                                                <li><a href="<?php echo base_url() ?>Inicio/registro_planilla"><i class="fa fa-circle-o"></i>Registro de Movilidad</a></li>
                                                <li><a href="<?php echo base_url() ?>Inicio/formato_planilla"><i class="fa fa-circle-o"></i>Formato de Planilla</a></li>
                                                    <!--  <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Clientes</a></li>
                                            -->
                                            </ul>
                                        </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-search-plus"></i> <span>Consultas</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url() ?>Inicio/Stock"><i class="fa fa-circle-o"></i> Stock</a></li>
                            <li><a href="<?php echo base_url() ?>Inicio/Mov_componentes"><i class="fa fa-circle-o"></i> Movimientos</a></li>
                            <li><a href="<?php echo base_url() ?>Inicio/Mov_componentes_oc"><i class="fa fa-circle-o"></i> Componentes por OC</a></li>
                        </ul>
                    </li>

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->
