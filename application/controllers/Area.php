<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Marea'));
  }

  function index()
  {

  }


  public function getall(){
    $area=$this->Marea->getarea();
    echo json_encode($area);
  }


  public function save(){



    $accion = $this->input->post('txtAccion');
    $id = $this->input->post('id');
    $descripcion = $this->input->post('descripcion');
    $estado='';


   if (strlen($descripcion)>0 ) {

//if ($this->Marea->exist($descripcion)<1) {

//----

  if($this->input->post('estado')=='on'){
    $estado="01";
  }
  if($this->input->post('estado')==''){
    $estado="00";
  }

  $datos = array( 'idarea' => $id,
                  'descripcion'=>$descripcion,
                  'estado'=>$estado
                 );

   if($accion=='nuevo'){
       echo $this->Marea->save($descripcion,$estado);
  }elseif ($accion=='editar') {
       echo $this->Marea->update($datos,$id);
    //  echo "test";
  }
//------------------------
/*
}else {
  echo "2";
}

*/
}else {
    echo "3";
}

  }

}
