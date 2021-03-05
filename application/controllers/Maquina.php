<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquina extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Mmaquinas');
  }

  function getmaquinas()
  {
     $maquinas=$this->Mmaquinas->getmaquinas();
     echo json_encode($maquinas);
  }

    public function save(){
      $maquina=$this->input->post('maquina');
      $idmaquina=$this->input->post('idmaquina');
      $contrato=$this->input->post('contrato');
      $objeto = array('descripcion' => $maquina,
                      'idcontrato' =>$contrato
                    );
      if($idmaquina==''){
        if($this->Mmaquinas->save($objeto)==1){
          echo 'Registrado exitosamente';
        }
        else{
          echo 'No se registro';
        }
      }
      else{
        if($this->Mmaquinas->update($objeto,$idmaquina)==1){
          echo 'Actualizado exitosamente';
        }
        else{
          echo 'No se actualizo ningun registro';
        }
      }
    }

}
