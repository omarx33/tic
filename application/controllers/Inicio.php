<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {


  public function __construct()
     {
         parent::__construct();

         // load Session Library
         $this->load->library('session');

         // load url helper
         $this->load->helper('url');

   			$this->load->model('Mperfil');

     }
	public function index()
	{

	//	$this->load->view('admin/login');

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('layouts/vInicio');
		$this->load->view('layouts/footer');

	}




  public function Usuarios(){

      $data['perfiles_creados']=$this->Mperfil->getperfiles();
      $data['areas']=$this->Mperfil->getareas();
      $this->load->view('layouts/header');
      $this->load->view('layouts/aside');
      $this->load->view('usuarios/grid_usuarios',$data);
      $this->load->view('layouts/footer');
  }



public function Perfiles(){
 $this->load->model('Mperfil');
  $data['menus']=$this->Mperfil->getmenus();
  $data['submenus']=$this->Mperfil->getsubmenus();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('perfiles/grid_perfiles',$data);
  $this->load->view('layouts/footer');

}





public function Usuarios_ticket(){
  $this->load->model(array('Musuarios_ticket'));
  $data['empresa']=$this->Musuarios_ticket->getempresa();

  $data['area']=$this->Musuarios_ticket->getarea();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('tabla_ayuda/vUsuarios_ticket',$data);
  $this->load->view('layouts/footer');

}



public function Correlativo(){
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('tabla_ayuda/vCorrelativo');
  $this->load->view('layouts/footer');
}


public function area(){
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('tabla_ayuda/vArea');
  $this->load->view('layouts/footer');
}


public function marca(){
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('tabla_ayuda/vMarca');
  $this->load->view('layouts/footer');
}




public function Componente(){
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('tabla_ayuda/vComponente');
  $this->load->view('layouts/footer');
}


public function ficha_tecnica(){



  $this->load->model(array('Musuarios_ticket'));
  $this->db->select('correlativo');
  $this->db->from('correlativo');
  $this->db->where('tipo', 'FT ROCKDRILL');
  $this->db->or_where('tipo','FT HELIX');
  $this->db->or_where('tipo','FT CODRISE');
  $query=$this->db->get();
	$data['correlativo']=$query->row(0)->correlativo;
  $data['solicitante']=$this->Musuarios_ticket->getsolicitante();
  $data['empresa']=$this->Musuarios_ticket->getempresa();
  $data['user_tic']=$this->Musuarios_ticket->getusuariotic();
  $data['area_centrocosto']=$this->Musuarios_ticket->area_centrocosto();
  $data['tickets_pendientes'] = $this->Musuarios_ticket->getTickets();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('movimientos/vFicha_tecnica',$data);
  $this->load->view('layouts/footer');
}


public function Articulos(){
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $query=$this->db->query('select*from componente');
  $data['componentes']=$query->result();
  $this->load->view('tabla_ayuda/vArticulos',$data);
  $this->load->view('layouts/footer');

}

public function Ingreso_ficha(){
  $this->load->model(array('Musuarios_ticket'));
  $data['empresa']=$this->Musuarios_ticket->getempresa();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('procesos/vIngreso_ficha',$data);
  $this->load->view('layouts/footer');

}

public function armado_equipo(){
  $this->load->model(array('Mcomponente'));
  $data['equipos']=$this->Mcomponente->get_equipos();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('procesos/armado_equipo',$data);
  $this->load->view('layouts/footer');

}

public function Stock(){

  $this->load->model(array('Musuarios_ticket'));
  $data['empresa']=$this->Musuarios_ticket->getempresa();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('consultas/vStock',$data);
  $this->load->view('layouts/footer');

}

public function asignacion_equipo(){

  $this->load->model(array('Musuarios_ticket'));
  $data['empresa']=$this->Musuarios_ticket->getempresa();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('procesos/asignacion_equipos',$data);
  $this->load->view('layouts/footer');

}
public function apertura_cierre_planilla(){

  $this->load->model(array('Musuarios_ticket'));
  $data['planillas']=$this->Musuarios_ticket->get_planilla();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('procesos/apertura_cierre_planilla',$data);
  $this->load->view('layouts/footer');

}public function registro_planilla(){

  $this->load->model(array('Musuarios_ticket'));
  $planilla=$this->Musuarios_ticket->get_ultimaplanilla();
  $data['planilla']=$planilla;
  $query=$this->db->query('select * from planilla_movilidad where estado like "1" order by fecha desc limit 1');
  if ($query->num_rows()>0) {
     $data['condicion']=1;
  } else {
    $data['condicion']=0;
  }


  $data['gastos']=$this->Musuarios_ticket->get_gastosplanilla($planilla->docentry);
  $data['tecnicos']=$this->Musuarios_ticket->getusuariotic();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('procesos/registro_planilla',$data);
  $this->load->view('layouts/footer');

}public function formato_planilla(){

  $this->load->model(array('Musuarios_ticket'));
  $data['planillas']=$this->Musuarios_ticket->get_planilla();
  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('procesos/formato_planilla',$data);
  $this->load->view('layouts/footer');

}
public function Mov_componentes(){

  $this->load->model(array('Musuarios_ticket'));
  $data['empresa']=$this->Musuarios_ticket->getempresa();

  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('consultas/vMov_componentes',$data);
  $this->load->view('layouts/footer');

}

public function Mov_componentes_oc(){

  $this->load->model(array('Musuarios_ticket'));
  $data['empresa']=$this->Musuarios_ticket->getempresa();

  $this->load->view('layouts/header');
  $this->load->view('layouts/aside');
  $this->load->view('consultas/vMov_componentes_oc',$data);
  $this->load->view('layouts/footer');

}

  public function Salidas_consumo(){
    $this->load->model(array('Musuarios_ticket'));
    $data['empresa']=$this->Musuarios_ticket->getempresa();
    $data['solicitante']=$this->Musuarios_ticket->getsolicitante();
    $data['user_tic']=$this->Musuarios_ticket->getusuariotic();
    $data['area']=$this->Musuarios_ticket->getarea();
    $data['equipo']=$this->Musuarios_ticket->getEquipos();
    //  $data['articulos']=$this->Musuarios_ticket->getarticulo();
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('procesos/salidas_consumo',$data);
    $this->load->view('layouts/footer');
  }


  /* Dashboard */

  public function Dashboard(){

    $this->load->model(array('Mdashboard'));

    $cantidad_cod = 0;
    $cantidad_rock = 0;
    $cantidad_hel = 0;

    $cantidad_cod = 0;
    $cantidad_rock = 0;
    $cantidad_hel = 0;

    //------
    $data['valor']=$this->Mdashboard->consulta_rock();
    foreach ($data['valor']  as $key) {
      $requerimiento =  $key->nro_requerimiento;
      $codigo_rock =  $key->codigo_ss;
      $cantidad_rock += $this->Mdashboard->consulta_starsoft_rock($requerimiento,$codigo_rock);
    }
    $data['cant_rock']=round($cantidad_rock,2);
    //---

    $data['valorcod']=$this->Mdashboard->consulta_cod();
    foreach ($data['valorcod']  as $key) {
      $requerimiento =  $key->nro_requerimiento;
      $codigo_cod =  $key->codigo_ss;
      $cantidad_cod += $this->Mdashboard->consulta_starsoft_cod($requerimiento,$codigo_cod);
    }
    $data['cant_cod']=round($cantidad_cod,2);

    //-------------

    $data['valorhel']=$this->Mdashboard->consulta_hel();
    foreach ($data['valorhel']  as $key) {
      $requerimiento =  $key->nro_requerimiento;
      $codigo_hel =  $key->codigo_ss;
      $cantidad_hel += $this->Mdashboard->consulta_starsoft_hel($requerimiento,$codigo_hel);
    }
    $data['cant_hel']=round($cantidad_hel,2);


    $data['cod']=$this->Mdashboard->equipo_cod();
    $data['rock']=$this->Mdashboard->equipo_rock();
    $data['hel']=$this->Mdashboard->equipo_hel();

    $data['cod_dis']=$this->Mdashboard->equipo_cod_dis();
    $data['rock_dis']=$this->Mdashboard->equipo_rock_dis();
    $data['hel_dis']=$this->Mdashboard->equipo_hel_dis();

    /* Obtener consumo por área */
    // $data['consumo_sql_area_codrise'] = $this->Mdashboard->csm_sql_area_codrise();
    // $data['consumo_sql_area_rockdrill'] = $this->Mdashboard->csm_sql_area_rockdrill();
    // $data['consumo_sql_area_helix'] = $this->Mdashboard->csm_sql_area_helix();


    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('dashboard/vReporte',$data);
    $this->load->view('layouts/footer');
  }

  public function Lista_servicio(){
    $this->load->model(array('Mservicio'));
    $data = array(
      'empresas' => $this->Mservicio->getEmpresas(),
      'areas' => $this->Mservicio->getAreas(),
    );
    $this->load->pre_view('servicio/listar', $data);
  }


  /* Reportes */

  public function Reporte_consumo_empresa(){
    $this->load->model(array('Mreporte'));
    $data = array(
      'empresas' => $this->Mreporte->getEmpresas(),
    );
    $this->load->pre_view('reporte/consumo_empresa', $data);
  }

  public function Reporte_consumo_area(){
    $this->load->model(array('Mreporte'));
    $data = array(
      'empresas' => $this->Mreporte->getEmpresas(),
      'areas' => $this->Mreporte->getAreas(),
    );
    $this->load->pre_view('reporte/consumo_area', $data);
  }
}
