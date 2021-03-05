<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ficha_tecnica extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
      $this->load->model(array('Mficha_tecnica','Mcorrelativo'));
  }

  function index()
  {

  }

//-------inicia la actualizacion del crontab
public function actualizar(){
echo  $valor = $this->Mficha_tecnica->Actualizar_estado();
}

public function actualizar_noche(){
echo  $valor = $this->Mficha_tecnica->Actualizar_estado_noche();
}

//------fin

public function getempresa(){
$selarea = $this->input->post('elegido');
$area = $this->Mficha_tecnica->consulta_area($selarea);
echo json_encode($area);
}



 public function get_detalle_ficha(){
   $correlativo = $this->input->post('idnota');
   $empresa = $this->input->post('empresa');
   $data['img_art']=  $this->Mficha_tecnica->getarticulo();
   $data['detalle']=  $this->Mficha_tecnica->get_detalle_ficha($correlativo,$empresa);
   $data['correlativo']=$correlativo;
   $this->load->view('secciones/movimientos/detalle_ficha',$data);
 }






  public function ficha_tecnica(){
    $periodo=$this->input->post('periodo');
    $empresa=$this->input->post('empresa');
  //$empresa = '3';

    $fechainicial=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,0,10))));
    $fechafinal=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,-10))));
  $data['ficha']=$this->Mficha_tecnica->getficha($fechainicial,$fechafinal,$empresa);
  $this->load->view('secciones/movimientos/ficha_tecnica', $data);

  }

  public function save(){

                            $accion   =         $this->input->post('txtAccion');
                            $empresa             = $this->input->post('empresais');
                            $nro_ticket_pendientes= $this->input->post('nro_ticket_pendientes');
                            $nro_ticket_pendientes_e= $this->input->post('nro_ticket_pendientes_e');
                            $solicitante         = $this->input->post('solicitante');
                            $correlativo         = $this->input->post('correlativo');
                        //    $usuario             = $this->input->post('user_tic');
                          $usuario             = $this->session->userdata('nombre')." ".$this->session->userdata('apepat');
                            $descripcion         = $this->input->post('descripcion');
                            $requerimiento       = $this->input->post('requerimiento');
                            $centro_costo       = $this->input->post('area');
                            $area1               = $this->Mficha_tecnica->busca_area($this->input->post('area'),$empresa);

  if (strlen($empresa)>0 and strlen($solicitante)>0 and strlen($correlativo)>0 and strlen($usuario)>0 ) {
  //--validar campos vacios

if ($accion=='nuevo') {
// agregar resgistro de correlativo
 if ($empresa == 3) {
     $this->Mcorrelativo->actualizar_correlativo('FT ROCKDRILL',$this->input->post('correlativo'));
 } else if($empresa == 2){
       $this->Mcorrelativo->actualizar_correlativo('FT CODRISE',$this->input->post('correlativo'));
 }else {
          $this->Mcorrelativo->actualizar_correlativo('FT HELIX',$this->input->post('correlativo'));
 }



   $valor =  $this->Mficha_tecnica->ficha_tecnica($empresa,$nro_ticket_pendientes,$solicitante,$correlativo,$usuario,$descripcion,$area1,$requerimiento,$centro_costo);

                      if ($valor == 1) {
                        $data['ficha']=$this->Mficha_tecnica->getficha();
                        $this->load->view('secciones/movimientos/ficha_tecnica', $data);
                      }else {
                        echo "0";
                      }



} elseif ($accion=='editar') {
//editar registro
     $valor =  $this->Mficha_tecnica->editar_ficha($empresa,$nro_ticket_pendientes_e,$solicitante,$correlativo,$usuario,$descripcion,$area1,$requerimiento,$centro_costo);
     if ($valor == 1) {
       $data['ficha']=$this->Mficha_tecnica->getficha();
       $this->load->view('secciones/movimientos/ficha_tecnica', $data);
     }else {
       echo "0";
     }
}else {
 "errorr";
}
//------
}else {
  echo "3";
}



  }









  public function get_correlativo(){
 $empresa = $this->input->post('empresa');

    $this->db->select('correlativo');
          $this->db->from('correlativo');
        if ($empresa == "2") {
            $this->db->where('tipo', 'FT CODRISE');
        } else if($empresa == "3"){
        $this->db->where('tipo', 'FT ROCKDRILL');
        }else{
            $this->db->where('tipo', 'FT HELIX');
        }

          $query=$this->db->get();
          $correlativo=$query->row(0)->correlativo;
        //  echo str_pad($correlativo, 6, "0", STR_PAD_LEFT);
        echo $correlativo+1;
  }





public function eliminar(){
 $id = $this->input->post('id');
 $empresa = $this->input->post('empresa');
 $this->Mficha_tecnica->eliminar_cab_det($id,$empresa);
$nafectados =  $this->Mficha_tecnica->eliminar($id,$empresa);
 $this->Mficha_tecnica->eliminar_stock($id,$empresa);
if ($nafectados >0) {
  echo "se elimino: ".$nafectados." filas";
}else {
  echo "no se eliminaron: ".$nafectados." filas";
}

}


public function eliminar_det(){
 $id = $this->input->post('id');
   $this->Mficha_tecnica->stock($id);
$nafectados =  $this->Mficha_tecnica->eliminar_det($id);
if ($nafectados >0) {
  echo "se elimino: ".$nafectados." usuario";
}else {
  echo "no se eliminaron: ".$nafectados." usuarios";
}

}


public function save_files(){
    $empresa=$this->input->post('idempresa');
  $descripcion=$this->input->post('descripcion');
  $fuente=$this->input->post('fuente');
  $precio_ref=$this->input->post('precio_ref');
  $cantidad=$this->input->post('cantidad');
  $comentario=$this->input->post('comentario');
  $correlativo2=$this->input->post('correlativo2');
  $img=$this->input->post('img');
  $accion=$this->input->post('txtAccion_detalle');
  $id_detalle=$this->input->post('id_detalle');
if (strlen($descripcion)>0 and strlen($fuente)>0 AND strlen($precio_ref) and strlen($cantidad)>0 and strlen($comentario)>0 and strlen($img)>0) {
//validar vacios

if ($accion == 'nuevo') {
  $archivo= array('descripcion'=>$descripcion,
                  'cantidad'=>$cantidad,
                  'precio_ref'=>$precio_ref,
                  'comentario'=>$comentario,
                  'fuente'=>$fuente,
                  'correlativo'=>$correlativo2,
                  'img'=>$img,
                  'empresa'=>$empresa
                );
                  $this->db->insert('ficha_detalle',$archivo);

                  echo $correlativo2;
}
elseif ($accion == 'editar') {
//echo "actualizar";
  echo  $this->Mficha_tecnica->update_detalle_ficha($id_detalle,$descripcion,$fuente,$precio_ref,$correlativo2,$cantidad,$comentario,$img);
} else {
echo "0";
}


//validar vacios fin
}else {
  echo "algun campo esta vacio";
}


}




//-----------------------------------
}
