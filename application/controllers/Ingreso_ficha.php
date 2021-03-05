<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ingreso_ficha extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
        $this->load->model(array('Mingreso_ficha','Mcomponente','Mcorrelativo'));
  }

  function index()
  {

  }


public function consulta_serie(){
     $empresa=$this->input->post('empresa');
    $this->db->select('correlativo');
          $this->db->from('correlativo');
        if ($empresa == "2") {
            $this->db->where('tipo', 'SA CODRISE');
        } else if($empresa == "3"){
        $this->db->where('tipo', 'SA ROCKDRILL');
        }else{
            $this->db->where('tipo', 'SA HELIX');
        }

          $query=$this->db->get();
          $correlativo=$query->row(0)->correlativo;
          echo str_pad($correlativo+1, 6, "0", STR_PAD_LEFT);
        //echo $correlativo+1;

}


  public function lista(){
      $empresa=$this->input->post('empresa');

  $data['ficha']=$this->Mingreso_ficha->get_ficha($empresa);
  $this->load->view('secciones/procesos/lista_ficha', $data);

  }

  public function detalle_ingreso($id,$empresa){
//$empresa = 2;
     $data['componente']=  $this->Mcomponente->getcomponente();
    $data['detalle']=  $this->Mingreso_ficha->detalle_ficha($id,$empresa);
    $this->load->view('secciones/procesos/detalle_ficha',$data);

  }

  public function actualizar_cantidad(){
    $id = $this->input->post('id');
    $valor = $this->input->post('valor');

    if (strlen($valor)>0) {
      echo $this->Mingreso_ficha->actualizar_cantidad($id,$valor);
    }else {
      echo "2";
    }
  }

  public function codigo_contable(){
    $codigo = $this->input->post('codigo');
    $empresa = $this->input->post('empresa');
    $query=$this->db->query('select abrevia,correlativo from correlativo_componente where empresa="'.$empresa.'" and idcomponente = (select tipo from articulos where codigo_ss="'.$codigo.'")');

    if ($query->row('abrevia')=='') {
      echo "";
    } else {
      if ($empresa==2) {
        echo "CDR".$query->row('abrevia').str_pad($query->row('correlativo'), 2, "0", STR_PAD_LEFT);
      }elseif ($empresa==3) {
        echo "ROCK".$query->row('abrevia').str_pad($query->row('correlativo'), 2, "0", STR_PAD_LEFT);
      }elseif ($empresa==4) {
        echo "HEL".$query->row('abrevia').str_pad($query->row('correlativo'), 2, "0", STR_PAD_LEFT);
      }
    }

  }

public function save(){

     $codigo = $this->input->post('codigo');


     $descripcion = $this->input->post('descripcion');
     $cantidad = $this->input->post('cantidad');
     $tipo_componente = $this->input->post('tipo_componente');
     if ($tipo_componente=='4' or $tipo_componente=='8' or $tipo_componente=='7') {
       $codigo_contable = $this->input->post('serie');
     }else {
       $codigo_contable = $this->input->post('codigo_contable');
     }
     $serie = $this->input->post('serie');
     $marca = $this->input->post('marca');
     $capacidad = $this->input->post('capacidad');
     $comentario = $this->input->post('comentario');
     $modelo = $this->input->post('modelo');
        $empresa = $this->input->post('empresa_id');
     $iddetallle = $this->input->post('iddetallle');
     $correlativo = $this->input->post('correlativo');
        $cab_id = $this->input->post('cab_id');
     $capac_mr=$this->input->post('capac_mr');
     $capac_dd=$this->input->post('capac_dd');
     $capac_tj=$this->input->post('capac_tj');

    $ser_auto=$this->input->post('ser_auto');
     $especificaciones='{"capac_mr":"'.$capac_mr.'","capac_dd":"'.$capac_dd.'","capac_tj":"'.$capac_tj.'"}';

     $valor =  (int) $serie2 = $this->input->post('serie');







    if (strlen($codigo)>0 and strlen($descripcion)>0 and strlen($cantidad)>0 and strlen($tipo_componente)>0 and strlen($serie)>0)
    {
//--
if ($ser_auto=='SI') {
  //--ACTUALIZA EL CORRELATIVO
  if ($empresa == 3) {
      $this->Mcorrelativo->actualizar_correlativo('SA ROCKDRILL',$valor);

  } else if($empresa == 2){
        $this->Mcorrelativo->actualizar_correlativo('SA CODRISE',$valor);
  }else {
           $this->Mcorrelativo->actualizar_correlativo('SA HELIX',$valor);
  }
//--
}


//--
      $data = array(
        'codigo' => $codigo ,
        'codigo_contable'=>$codigo_contable,
        'descripcion' => $descripcion,
        'cantidad' => $cantidad,
        'tipo_componente' => $tipo_componente,
        'serie' => $serie,
        'marca'=> $marca,
        'capacidad'=>$capacidad,
        'comentario'=>$comentario,
        'modelo'=>$modelo,
        'empresa'=>$empresa,
        'ficha_detalle'=>$iddetallle,
        'correlativo'=>$correlativo,
        'especificaciones'=>$especificaciones
                    );
        $data2=array('codigo' => $codigo,
                    'codigo_contable' => $codigo_contable,
                    'serie' => $serie,
                    'tipo_mov' => 'I',
                    'empresa'  => $empresa,
                  //  'docref'=>$correlativo,
                  'docref'=>$cab_id,
                    'observaciones' => 'Ingreso por compra');
        echo $valor =  $this->Mingreso_ficha->guardar($data,$data2,$tipo_componente,$iddetallle,$empresa);
    } else {
      echo "2";
    }





}



}
