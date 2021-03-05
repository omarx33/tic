<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Mmarca'));
  }

  function index()
  {

  }

  public function getall(){
    $marca=$this->Mmarca->getmarca();
    echo json_encode($marca);
  }


  public function save(){
    $accion         = $this->input->post('txtAccion');
    $id             = $this->input->post('id');
    $nombre         = $this->input->post('nombre');
    $ruta           = $this->input->post('ruta');
    $descripcion    = $this->input->post('descripcion');
    $estado='';
    if($this->input->post('estado')=='on'){
      $estado="01";
    }
    if($this->input->post('estado')==''){
      $estado="00";
    }
//-------------------
    if (strlen($nombre)>0 AND strlen($ruta)>0 AND strlen($descripcion)>0) {

              if($accion=='nuevo'){
                  echo $this->Mmarca->save($id,$nombre,$ruta,$descripcion,$estado);
             }elseif ($accion=='editar') {
                  echo $this->Mmarca->update($id,$nombre,$ruta,$descripcion,$estado);

             }else {
               echo "0";
             }

    }else {
        echo "3";
    }
//-------------------


  }

}
