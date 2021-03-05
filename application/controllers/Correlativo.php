<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Correlativo extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Mcorrelativo'));
  }

  function index()
  {

  }


  public function getall(){
      $correlativos=$this->Mcorrelativo->getcorrelativos();
      echo json_encode($correlativos);
    }


    public function save(){
  $valor = $this->input->post('txtAccion');
  $tipo=$this->input->post('tipo');
  $correlativo=$this->input->post('correlativo');
  $id=$this->input->post('id');


  if (strlen($tipo)>0) {
  //--validar campos vacios
if ($valor == 'nuevo') {
//--
     if($this->Mcorrelativo->exist(0,$tipo,'condicional')<1){
        $data = array('tipo' => $tipo,
                      'correlativo' =>0
                           );
    echo  $nafectados = $this->Mcorrelativo->guardar($data);

     }
     else{
       echo "El registro ya existe";
     }

} elseif ($valor == 'editar') {

     if($this->Mcorrelativo->exist($id,$tipo,$correlativo)<1){

         echo $this->Mcorrelativo->save($id,$tipo,$correlativo);
     }
     else{
       echo "El correlativo ya existe";
     }
  //----
}

//fin
}else {
    echo "Algún campo esta vacío";
}



    }
public function get_correlativo_asignacion(){
  $empresa=$this->input->post('empresa');

  if ($empresa==2) {
    $docentry=5;
    $char='CD';
  } elseif($empresa==3) {
    $docentry=4;
    $char='RD';
  } elseif($empresa==4) {
    $docentry=6;
    $char='HL';
  }
  $query=$this->db->query("SELECT correlativo FROM correlativo where idcorrelativo=".$docentry);
  echo $char.str_pad($query->row('correlativo'), 5, "0", STR_PAD_LEFT);
}

}
