<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


 public function __construct(){

  parent::__construct();
  $this->load->model(array('Mloguin'));

 }


	public function index()
	{
   $this->session->sess_destroy();
		$this->load->view('admin/login');



	}

public function logueo(){

  $user = $this->input->post('txtuser');
  $pass = $this->input->post('txtpass');
  $resultado = $this->Mloguin->validacion($user,$pass);

   if ($info = $resultado->row()) {
   $datos_session = array(
       'usuarioid' => $info->usuarioid,
       'nombre' => $info->nombre,
       'apepat' =>$info->apepat,
       	'rol_id'=>$info->rolid,
       'documento' =>$info->documento,
       	'alm_id'=>$info->contratoid,
       'acceso_id'=>$info->acceso_almacenid

     );
$this->session->set_userdata($datos_session);





//acceso a menus con acceso
	 	$menus_permitidos=$this->Mloguin->getmenusaccesibles($info->acceso_almacenid,$info->contratoid);
			foreach ($menus_permitidos as $key) {
			//asignacion a la session
			$this->session->set_userdata('acceso_menu_'.$key->menuid,1);

			}




      //acceso a submenus
    			$submenus_permitidos=$this->Mloguin->getsubmenus($info->acceso_almacenid,$info->contratoid);
    			//asignacion a la sesion
    			foreach ($submenus_permitidos as $key) {
    				$this->session->set_userdata('acceso_submenu_'.$key->submenuid,1);
    			}
//var_dump($submenus_permitidos);


echo "1";

}else {
  echo'<div class="alert alert-danger alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <h4><i class="icon fa fa-ban"></i> Error</h4>
         Usted no cuenta con acceso a este almacen o ingreso un usuario incorrecto...
         </div>';
}


}




public function logout(){
  $this->session->sess_destroy();
  redirect('Login');
}




}
