<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salidas_consumo extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
      $this->load->model(array('Msalida_consumo','Mcorrelativo'));
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }

  public function eliminar(){

    $cantidad = 1;
   $id = $this->input->post('id');
   $empresa = $this->input->post('empresa');
 $this->Msalida_consumo->eliminar($id,$empresa);
  $data['ficha'] = $this->Msalida_consumo->get_consulta($id,$empresa);


foreach ($data['ficha']  as $key) {
$valor =  $key->serie;
$this->Msalida_consumo->actualiza_stock_cab($valor,$cantidad);

}


  $nafectados =  $this->Msalida_consumo->eliminar_det_cab($id,$empresa);
  //$this->Msalida_consumo->actualiza_stock($serie,$cantidad);
echo "Se eliminaron las filas";

  }


  public function lista(){
    $periodo=$this->input->post('periodo');
    $empresa=$this->input->post('empresa');

    $fechainicial=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,0,10))));
    $fechafinal=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,-10))));
  $data['ficha']=$this->Msalida_consumo->getsalidas($fechainicial,$fechafinal,$empresa);
  $this->load->view('secciones/procesos/salidas_consumo', $data);

  }



  public function get_correlativo(){
 $empresa = $this->input->post('empresa');

    $this->db->select('correlativo');
          $this->db->from('correlativo');
        if ($empresa == "2") {
            $this->db->where('tipo', 'NS CODRISE');
        } else if($empresa == "3"){
        $this->db->where('tipo', 'NS ROCKDRILL');
        }else{
            $this->db->where('tipo', 'NS HELIX');
        }

          $query=$this->db->get();
          $correlativo=$query->row(0)->correlativo;
        //  echo str_pad($correlativo, 6, "0", STR_PAD_LEFT);
        echo $correlativo+1;
  }



//-----------------------------------

public function getcodigo(){
$empresa = $this->input->post('empresa');
$codigo = $this->Msalida_consumo->consulta_codigo($empresa);
echo json_encode($codigo);
}

public function getserie(){
$dato = $this->input->post('dato');
$empresa = $this->input->post('elegido');
$codigo = $this->Msalida_consumo->consulta_serie($dato,$empresa);
echo json_encode($codigo);
}

public function getserie_id(){
$dato = $this->input->post('dato');

$codigo = $this->Msalida_consumo->consulta_serie_id($dato);
echo json_encode($codigo);
}


//------------------------
public function save(){

   $accion   =         $this->input->post('txtAccion');
   $empresa   =         $this->input->post('emp');
   //$codigo   =         $this->input->post('cod');
   $equipo   =         $this->input->post('equipo');
   $user_tic   =         $this->input->post('use_tic');
   $usuario   =         $this->input->post('usuario');
   $area   =         $this->input->post('area');
   $descripcion   =         $this->input->post('descripcion');
   $correlativo = $this->input->post('correlativo');
// inicio

if (   strlen($area)>0 and strlen($usuario)>0 and strlen($user_tic)>0) {
//--validar campos vacios

if ($accion=='nuevo') {

  // agregar resgistro de correlativo
   if ($empresa == 3) {
       $this->Mcorrelativo->actualizar_correlativo('NS ROCKDRILL',$this->input->post('correlativo'));
   } else if($empresa == 2){
         $this->Mcorrelativo->actualizar_correlativo('NS CODRISE',$this->input->post('correlativo'));
   }else {
            $this->Mcorrelativo->actualizar_correlativo('NS HELIX',$this->input->post('correlativo'));
   }


echo $valor =  $this->Msalida_consumo->agregar($empresa,$equipo,$user_tic,$usuario,$area,$descripcion,$correlativo);



} elseif ($accion=='editar') {

echo  $valor =  $this->Msalida_consumo->editar($empresa,$equipo,$user_tic,$usuario,$area,$descripcion,$correlativo);



}else {
"errorr";
}
//------
}else {
echo "3";
}

/// fin

}




public function get_detalle_salida(){
  $correlativo = $this->input->post('id');
   $empresa = $this->input->post('empresa');

  $data['detalle']=  $this->Msalida_consumo->get_detalle_salida($correlativo,$empresa);
  $data['correlativo']=$correlativo;
  $this->load->view('secciones/procesos/detalle_salida',$data);

}


public function eliminar_det(){
   $id = $this->input->post('id');
   $serie = $this->input->post('serie');
   $cantidad = $this->input->post('cantidad');
 $this->Msalida_consumo->actualiza_stock($serie,$cantidad);
   $this->Msalida_consumo->eliminar_det($id);


}





public function get_acciones(){


   $correlativo = $this->input->post('cod');
   $empresa = $this->input->post('idempresa');
   $accion=$this->input->post('txtAccion_detalle');
   $numero=$this->input->post('id_detalle');
   $codigo=$this->input->post('cod');
   $serie=$this->input->post('serie');
   $cantidad=$this->input->post('cantidad');
   $retiro=$this->input->post('retiro');
   $stock=$this->input->post('stock');
 $id=$this->input->post('id');
  $total = $stock - $cantidad;

if (strlen($codigo)>0 and strlen($serie)>0 and strlen($cantidad)>0 and strlen($retiro)>0) {


if ($accion == 'nuevo') {
 $this->Msalida_consumo->Actualizar_stock($serie,$total);
  $this->Msalida_consumo->agregar_detalle($numero,$serie,$cantidad,$retiro,$empresa,$codigo);

}elseif ($accion == 'editar') {

 //$this->Msalida_consumo->Actualizar_stock($serie,$total);
$this->Msalida_consumo->actualizar_detalle($id,$serie,$cantidad,$retiro,$empresa,$codigo);

}

}else {
  echo "0";
}



}




}
