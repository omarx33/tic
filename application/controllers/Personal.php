<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
  $this->load->model(array('Mpersonal'));
  }

  function savetipo()
  {
$desc_tipo_trabajador=$this->input->post('desc_tipo_trabajador');
$id_tipo_trabajador=$this->input->post('id_tipo_trabajador');
$objeto = array('desc_tipo_trabajador' => $desc_tipo_trabajador,
                'estado' =>1
              );
if($id_tipo_trabajador==''){
  if($this->Mpersonal->savetipo($objeto)==1){
    echo 'Registrado exitosamente';
  }
  else{
    echo 'No se registro';
  }
}
else{
  if($this->Mpersonal->updateTIPO($objeto,$id_tipo_trabajador)==1){
    echo 'Actualizado exitosamente';
  }
  else{
    echo 'No se actualizo ningun registro';
  }
}
  }


  public function importar_personal(){
    $personal=json_decode($this->input->post('tbldetalle'));

    $validarregistro=$this->Mpersonal->savepersonal($personal);
    echo $validarregistro;
  }

  public function personalxtipo(){
    $tipo=$this->input->post('tipo');
    $respuesta=$this->Mpersonal->personalxtipo($tipo);
    echo json_encode($respuesta);
  }

  public function baja_personal(){

    $codigo_personal=$this->input->post('codigo_personal');
    $fechabaja=$this->input->post('fechabaja');
    $tipo=$this->input->post('tipo');
    $respuesta=$this->Mpersonal->baja_personal($codigo_personal,$fechabaja,$tipo);
    echo $respuesta;

  }

}
