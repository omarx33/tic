<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller{

  public function __construct()
  {

    parent::__construct();
    //Codeigniter : Write Less Do More
      $this->load->model(array('Marticulos'));
  }

  function index()
  {

  }


  public function listar(){
       $data3['infor']=$this->Marticulos->getarticulos();
    $this->load->view('secciones/tabla_ayuda/grid_articulos', $data3);

  }


  public function getall(){
    $area=$this->Marticulos->getarticulos();
    echo json_encode($area);
  }




  public function save(){
$valor = $this->input->post('txtAccion');
$documento = "articulos_img";
$id  = $this->input->post('id');
$descripcion=$this->input->post('descripcion');
$u_medida=$this->input->post('u_medida');
$codigo_ss=$this->input->post('codigo_ss');
$imagen=$this->input->post('name_imagen');
$tipo=$this->input->post('tipo_componente');
$estado='';
if($this->input->post('estado')=='on'){
  $estado="01";
}
if($this->input->post('estado')==''){
  $estado="00";
}


if (strlen($descripcion)>0 and strlen($u_medida)>0 and strlen($codigo_ss)>0 ) {
//validar valores vacios



if ($valor == 'nuevo') {
  //------



    $carpeta = "./assets/img/articulos/".$documento."";

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }


    $config = [
      "upload_path" => $carpeta,
      'allowed_types' => "gif|jpg|png|pdf|doc|docx"
    ];
  $this->load->library("upload",$config);


  if ($this->upload->do_upload('imagen')) {

  $data = $this->upload->data();

  $archivo= array('descripcion'=>$descripcion,
                  'codigo_ss'=>$codigo_ss,
                  'imagen'=>$data['file_name'],
                  'unidad'=>$u_medida,
                  'estado'=>$estado,
                  'tipo'=>$tipo
                );
                  $this->db->insert('articulos',$archivo);
  //$msg='se subio ';
  $data3['infor']=$this->Marticulos->getarticulos();
  $this->load->view('secciones/tabla_ayuda/grid_articulos', $data3);

  }else{

     $msg=$this->upload->display_errors();

  }

  //--------------
} elseif ($valor == 'editar') {

//--------------------------
 $carpeta = "./assets/img/articulos/articulos_img/";

unlink($carpeta);
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
  $carpeta = "./assets/img/articulos/".$documento."";
  $config = [
    "upload_path" => $carpeta,
    'allowed_types' => "gif|jpg|png|pdf|doc|docx"
  ];
$this->load->library("upload",$config);
if ($this->upload->do_upload('imagen')) {

$data = $this->upload->data();
$archivo= array('descripcion'=>$descripcion,
                'codigo_ss'=>$codigo_ss,
                'imagen'=>$data['file_name'],
                'unidad'=>$u_medida,
                'estado'=>$estado,
                'tipo'=>$tipo
              );

              $this->db->where('idarticulos',$id );
              $this->db->update('articulos',$archivo);
              if ($this->db->affected_rows()>0) {
                echo "se actualizo";
              }else {
                return 1;
              }

/*
            }else{

              echo $msg=$this->upload->display_errors();
            }*/
//-----------------------------------
}else {
echo "error";
}






  //fin validacion

}else{
  echo $u_medida." ".$descripcion." ".$codigo_ss;
  }



}
}
}
