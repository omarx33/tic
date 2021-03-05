<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareo extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Mtareo','Mpersonal'));
  }

  public function saveclasificacion()
  {
    $desc_clasificacion=$this->input->post('desc_clasificacion');
    $id_clasificacion=$this->input->post('id_clasificacion');
    $codigo=$this->input->post('codigo');
    $objeto = array('desc_clasificacion' => $desc_clasificacion,
                    'codigo' =>$codigo
                  );
    if($id_clasificacion==''){
      if($this->Mtareo->saveClasificacion($objeto)==1){
        echo 'Registrado exitosamente';
      }
      else{
        echo 'No se registro';
      }
    }
    else{
      if($this->Mtareo->updateClasificacion($objeto,$id_clasificacion)==1){
        echo 'Actualizado exitosamente';
      }
      else{
        echo 'No se actualizo ningun registro';
      }
    }
  }



public function crear_periodo(){
  $fechames=str_replace('/','-',substr($this->input->post('rango'),-10));
  $fecha1= new DateTime(str_replace('/','-',substr($this->input->post('rango'),0,10)));
  $fecha2= new DateTime(str_replace('/','-',substr($this->input->post('rango'),-10)));
  $periodo=date('Y-m',strtotime($fechames));


  $data['periodo_tareo']=$periodo;
  $data['fecha_inicio']=date('Y-m-d',strtotime(str_replace('/','-',substr($this->input->post('rango'),0,10)))) ;
  $data['fecha_fin']=date('Y-m-d',strtotime(str_replace('/','-',substr($this->input->post('rango'),-10))));
  $data['contrato']=$this->session->userdata('alm_id');
  $data['estado']=0;
  $data['estado_dlibres']=0;
  $data['cierre_operaciones']=0;
  $data['cierre_gestionhumana']=0;
  $diff = $fecha1->diff($fecha2);

  $this->db->select('*');
  $this->db->from('periodo_tareo');
  $this->db->where('periodo_tareo',$periodo);
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $query=$this->db->get();
  if($query->num_rows()<1){
    if($diff->days > 31){
      echo 1;
    }else {

      if($this->Mtareo->crear_periodo($data)==1){
        echo str_pad($diff->days, 2, "0", STR_PAD_LEFT).'/'.$periodo;
      }else {
        echo 0;
      }
    }
  }else {
    echo 'x';
  };
}

public function mostrartabla($dias,$periodo){

    $data['personas']=$this->Mpersonal->listarpersonaltareo($periodo);

    $this->db->select('fecha_inicio');
    $this->db->from('periodo_tareo');
    $this->db->where('periodo_tareo',$periodo);
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    $query=$this->db->get();
    $data['fechainicio']=$query->row('fecha_inicio');

    $data['periodo']=$periodo;
    $data['dias']=$dias;
    $this->load->view('secciones/proyectos/grid_crear_tareo',$data);
}

public function eliminar_periodo(){
  $periodo=substr($this->input->post('periodo'),3, 7);

  $limpiartareo=($this->Mtareo->limpiartareo($periodo));

  echo $limpiartareo;
}

public function get_vacaciones(){
  $periodo=$this->input->post('periodo');

  $data['vacaciones']=$this->Mtareo->get_vacaciones($periodo);
  $this->load->view('secciones/proyectos/grid_vacaciones',$data);

}

public function programar_vacaciones(){
  $periodo=$this->input->post('periodo');
  $trabajador=$this->input->post('trabajador');
  $fecha_inicio=date('Y-m-d',strtotime(str_replace('/','-',substr($this->input->post('form_periodo'),0,10)))) ;
  $fecha_fin=date('Y-m-d',strtotime(str_replace('/','-',substr($this->input->post('form_periodo'),-10))));

  $data=$this->Mtareo->validarvacaciones($trabajador,$fecha_inicio,$fecha_fin,$periodo);

  echo $data;
}

public function eliminar_vacaciones(){
  $id=$this->input->post('id');
  $eliminar=$this->Mtareo->eliminar_vacaciones($id);

  echo $eliminar;
}

public function eliminar_clasificacion(){
  $id=$this->input->post('id');
  $eliminar=$this->Mtareo->eliminar_clasificacion($id);

  echo $eliminar;
}
public function eliminar_tipo(){
  $id=$this->input->post('id');
  $eliminar=$this->Mtareo->eliminar_tipo($id);

  echo $eliminar;
}
public function get_tareo(){
  $periodo=$this->input->post('periodo');
  $tipo=$this->input->post('tipo');

  $this->db->select('fecha_inicio');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $this->db->limit(1);
  $query=$this->db->get();
  $inicio=$query->row('fecha_inicio');
  $dateinicio=date('Y-m-d',strtotime($inicio));
  $data['inicio']=$inicio;
  $this->db->select('fecha_fin');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $this->db->limit(1);
  $query2=$this->db->get();
  $fin=$query2->row('fecha_fin');
  $datefin=date('Y-m-d',strtotime($fin));
  $data['dateinicio']= new DateTime($dateinicio);
  $data['datefin'] = new DateTime($datefin);

  $data['personas']=$this->Mtareo->get_tareo($periodo,$tipo);

  $this->load->view('secciones/proyectos/grid_diibres',$data);
}
public function asignar_dlibres(){
  $periodo=$this->input->post('periodo');
  $personal=$this->input->post('personal');
  $tipo=$this->input->post('tipo');
  $dia=$this->input->post('dia');
  $query=$dia."='".$tipo."'";

  echo $this->Mtareo->asignar_dlibres($periodo,$personal,$query,$dia,$tipo);
}

public function cerrar_dlibres(){
  $periodo=$this->input->post('periodo');

  echo $this->Mtareo->cerrar_dlibres($periodo);
}

public function getdias(){
  $periodo=$this->input->post('periodo');
  $this->db->select('fecha_inicio');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $this->db->limit(1);
  $query=$this->db->get();
  $inicio=$query->row('fecha_inicio');
  $dateinicio=date('Y-m-d',strtotime($inicio));

  $this->db->select('fecha_fin');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $this->db->limit(1);
  $query2=$this->db->get();
  $fin=$query2->row('fecha_fin');
  $datefin=date('Y-m-d',strtotime($fin));

  $inicio= new DateTime($dateinicio);
  $fin = new DateTime($datefin);
  $diff= $inicio->diff($fin);
  $dias=$diff->days;
  $days="";
  for ($i=0; $i < $dias+1; $i++) {

   $days=$days.date("d-m-Y",strtotime($dateinicio."+".$i." days")).",";
 }
$array= explode(',', trim($days, ','));
 echo json_encode($array);
}

public function get_tareodiario(){
  $periodo=$this->input->post('periodo');
  $tipo=$this->input->post('tipo');
  $dia=$this->input->post('dia');
  $data['clasificacion']=$this->Mtareo->get_clasificacion();
  $data['periodo']=$periodo;
  $data['tipo']=$tipo;
  $data['dia']=$dia;

if ($this->session->userdata('rol_id')==20) {
  $data['tareodiario']=$this->Mtareo->get_tareooperaciones($periodo,$tipo,$dia);
if ($data['tareodiario']==2) {
  echo 2;
}
elseif(($data['tareodiario']==0)) {
  echo 0;
}else /*($data['tareodiario']!=0 or $data['tareodiario']!=2)*/ {
    $this->load->view('secciones/proyectos/grid_tareodiario',$data);
}
}

elseif ($this->session->userdata('rol_id')==21) {
  $data['tareodiario']=$this->Mtareo->get_tareorrhh($periodo,$tipo,$dia);
if ($data['tareodiario']!=0) {
    $this->load->view('secciones/proyectos/grid_tareodiario',$data);
}else {
  echo 0;
}
}

else  {
  $data['tareodiario']=$this->Mtareo->get_tareodiario($periodo,$tipo,$dia);
if ($data['tareodiario']!=1) {
    $this->load->view('secciones/proyectos/grid_tareodiario',$data);
}else {
  echo 1;
}
}

}


public function asignar_dia(){
  $tipo=$this->input->post('tipo');
  $dia=$this->input->post('dia');
  $periodo=$this->input->post('periodo');
  $personal=$this->input->post('personal');
  echo $this->Mtareo->asignar_dia($tipo,$dia,$periodo,$personal);
}

public function grabardia(){
$tareodia=json_decode($this->input->post('tbldetalle'));
$periodo=$this->input->post('periodo');
$contrato=$this->session->userdata('alm_id');
$dia=$this->input->post('dia');

echo $this->Mtareo->grabardia($tareodia,$periodo,$contrato,$dia);
}

public function tiempo_extra(){
  $codigo_personal=$this->input->post('trabajadorte');
  $periodo=$this->input->post('periodote');
  $dia=$this->input->post('diate');
  $tipo=$this->input->post('tipotiempo');
  $tiempo_extra=array('periodo'=>$this->input->post('periodote'),
                      'codigo_personal'=>$this->input->post('trabajadorte'),
                      'contrato'=>$this->session->userdata('alm_id'),
                      'dia'=>$this->input->post('diate'),
                      'fecha'=>date('Y-m-d',strtotime($this->input->post('fechate'))),
                      'tipo'=>$this->input->post('tipotiempo'),
                      'cantidad'=>$this->input->post('tiempo'),
                      'motivo'=>$this->input->post('motivo'));

echo $this->Mtareo->tiempo_extra($codigo_personal,$periodo,$dia,$tiempo_extra,$tipo);
}


public function cerrar_dia(){
  $fecha=$this->input->post('dia');
  $periodo=$this->input->post('periodo');

  if ($this->session->userdata('rol_id')==20) {
    echo $this->Mtareo->cerrar_dialima($fecha,$periodo,2);
  }
  if ($this->session->userdata('rol_id')==21) {
    echo $this->Mtareo->cerrar_dialima($fecha,$periodo,3);
  }elseif($this->session->userdata('rol_id')==22) {
    echo $this->Mtareo->cerrar_dia($fecha,$periodo);
  }

}
public function consulta_tareo(){
  $periodo=$this->input->post('periodo');
   $contrato=$this->session->userdata('alm_nombre');

  $this->db->select('fecha_inicio');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $this->db->limit(1);
  $query=$this->db->get();
  $inicio=$query->row('fecha_inicio');
  $dateinicio=date('Y-m-d',strtotime($inicio));
  $data['inicio']=$inicio;


  $this->db->select('fecha_fin');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $this->db->limit(1);
  $query2=$this->db->get();
  $fin=$query2->row('fecha_fin');
  $datefin=date('Y-m-d',strtotime($fin));

  $data['dateinicio']= new DateTime($dateinicio);
  $data['datefin'] = new DateTime($datefin);

  $data['personas']=$this->Mtareo->consultar_tareo($periodo);

  $numperiodo=substr($periodo, -2);
  $contrato=$this->session->userdata('alm_id');
  $data['dia29']=$this->db->query("SELECT count(dia29)
  FROM tareo_mensual".$numperiodo."
  WHERE `contrato` = '".$contrato."'
  AND `periodo` = '".$periodo."'")->result();
/*  ('count(dia29)');
  $this->db->from('tareo_mensual');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo',$periodo);*/
  $data['dia30']=$this->db->query("SELECT count(dia30)
  FROM tareo_mensual".$numperiodo."
  WHERE `contrato` = '".$contrato."'
  AND `periodo` = '".$periodo."'")->result();

  /*$this->db->select('count(dia30)');
  $this->db->from('tareo_mensual');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo',$periodo);
  $data['dia30']=$this->db->get()->row('count(dia30)');*/

  $data['dia31']=$this->db->query("SELECT count(dia31)
  FROM tareo_mensual".$numperiodo."
  WHERE `contrato` = '".$contrato."'
  AND `periodo` = '".$periodo."'")->result();
  /*
  $this->db->select('count(dia31)');
  $this->db->from('tareo_mensual');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo',$periodo);
  $data['dia31']=$this->db->get()->row('count(dia31)');
*/
  $this->load->view('secciones/consultas/grid_tareo',$data);
}
public function cierremes(){
  $periodo=$this->input->post('periodo');
  return $this->Mtareo->cierremes($periodo);
}

public function aperturar_mes(){
  $periodo=$this->input->post('periodo');
  return $this->Mtareo->aperturames($periodo);
}
public function aperturar_dia(){
  $dia=$this->input->post('dia');
  return $this->Mtareo->aperturadia($dia);
}
public function dias_cerrados(){
  $periodo=$this->input->post('periodo');


    $this->db->select('fecha_inicio');
    $this->db->from('periodo_tareo');
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    $this->db->where('periodo_tareo',$periodo);
    $this->db->limit(1);
    $query2=$this->db->get();
    $inicio=$query2->row('fecha_inicio');
    $data['dateinicio']=date('Y-m-d',strtotime($inicio));

  $data['dias']=$this->Mtareo->dias_cerrados($periodo);
  $this->load->view('secciones/procesos/aperturardia',$data);
}
}
