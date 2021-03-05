<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_ticket extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Musuarios_ticket'));
  }

  function index()
  {

  }



public function getall(){
    $resultado=$this->Musuarios_ticket->getusuarios();
    echo json_encode($resultado);
}





public function save(){
  $accion         = $this->input->post('txtAccion');
  $id             = $this->input->post('id');
  $nombres        = $this->input->post('nombres');
  $apellidos      = $this->input->post('apellidos');
  $dni            = $this->input->post('dni');
  $correo         = $this->input->post('correo');
  $empresa        = $this->input->post('empresa');
  $area           = $this->input->post('area');
  $cargo          = $this->input->post('cargo');
  $estado         = $this->input->post('estado');

//  $estado='';

  if($this->input->post('estado')=='on'){
    $estado="01";
  }
  if($this->input->post('estado')==''){
    $estado="00";
  }
//-------------------si hay valores vacios
  if (strlen($nombres)>0 AND strlen($apellidos)>0 AND strlen($dni)>0 AND strlen($correo)>0 AND strlen($empresa)>0 AND strlen($area)>0 AND strlen($cargo)>0) {
//----si existe

//if ($this->Musuarios_ticket->exist($dni)<1) {
//----
            if($accion=='nuevo'){
                echo $this->Musuarios_ticket->save($id,$nombres,$apellidos,$dni,$correo,$empresa,$area,$cargo,$estado);
           }elseif ($accion=='editar') {
                echo $this->Musuarios_ticket->update($id,$nombres,$apellidos,$dni,$correo,$empresa,$area,$cargo,$estado);

           }else {
             echo "0";
           }
//-----
/*
}else {
  echo "2";
}*/
//----- fin
  }else {
      echo "3";
  }
//-------------------


}



}
