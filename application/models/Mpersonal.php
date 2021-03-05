<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpersonal extends CI_Model{

  public function __construct()
  {
    parent::__construct();

  }


  public function get_newpersonal($idalmacen){

  $filtro=$this->personal_activo($this->session->userdata('alm_id'));
  $room_id= "'";
   foreach($filtro as $row){
      $room_id = $room_id.$row->codigo_personal."','";
    }
   //$codigo = implode(",",$room_id);
   $codigo_personal = trim($room_id, ",'");
  $starsoft=$this->load->database('starsoft',TRUE);
  $query=$starsoft->query("select CODTRAB,APEPAT,APEMAT,NOMBRE,CARGO,DOCIDEN,departamento,FECHAING from ROCKDRILL..TRABAJADORES where departamento like '%".$idalmacen."%' and SITUACIÓN='1' and CODTRAB not in('".$codigo_personal."')");
/* $starsoft->select('CODTRAB,APEPAT,APEMAT,NOMBRE,CARGO,DOCIDEN,departamento');
  $starsoft->from('ROCKDRILL..TRABAJADORES');
  $starsoft->like('departamento',$idalmacen);
  $starsoft->where('SITUACIÓN',1);
  $starsoft->where_not_in('CODTRAB',$room_id);
  $query=$starsoft->get();*/
  return $query->result();
  }

public function personal_activo($contrato){
  $this->db->select('*');
  $this->db->from('personal_contrato');
  $this->db->where('estado',1);
  $this->db->where('contrato',$contrato);
  $query2=$this->db->get();
  $filtro=$query2->result();
  return $filtro;
}

public function tipo_trabajador(){
  $this->db->select('*');
  $this->db->from('tipo_trabajadores');
  $this->db->where('estado',1);
  return $this->db->get()->result();
}

public function savetipo($objeto){
  $this->db->insert('tipo_trabajadores', $objeto);
  if($this->db->affected_rows()>0){
    return 1;
  }
  else{
    return 0;
  }
}
public function updatetipo($objeto,$id){
  $this->db->where('id_tipo_trabajador', $id);
  $this->db->update('tipo_trabajadores', $objeto);
  if($this->db->affected_rows()>0){
    return 1;
  }
  else{
    return 0;
  }
}

public function savepersonal($personal){
  $error='';
  $data=array();
  foreach ($personal as $key) {
    $fila=array();
    if ($key->habilitado==1) {
      if ($this->existe_personal($key->codigo_personal)<1) {
          $newpersonal= array('codigo_personal'=>$key->codigo_personal,
                              'apepat_personal'=>$key->apepat_personal,
                              'apemat_personal'=>$key->apemat_personal,
                              'nombre_personal'=>$key->nombre_personal,
                              'dociden_personal'=>$key->dociden_personal,
                              'cargo_personal'=>$key->cargo_personal,
                              'depart_personal'=>$key->depart_personal,
                              'id_tipo_personal'=>$key->id_tipo_personal,
                              'id_maquina'=>$key->id_maquina,
                              'fecha_actualizacion'=>date('Y-m-d',strtotime($key->fecha_actualizacion)),
                              'contrato'=>$this->session->userdata('alm_id'),
                              'estado'=>'1');
            $this->db->insert('personal_contrato', $newpersonal);
      }else {
        $this->db->set('contrato',$this->session->userdata('alm_id'));
        $this->db->set('fecha_actualizacion',date('Y-m-d',strtotime($key->fecha_actualizacion)));
        $this->db->set('estado',1);
        $this->db->set('cargo_personal',$key->cargo_personal);
        $this->db->set('depart_personal',$key->depart_personal);
        $this->db->set('id_tipo_personal',$key->id_tipo_personal);
        $this->db->set('id_maquina',$key->id_maquina);
        $this->db->where('codigo_personal',$key->codigo_personal);
        $this->db->where('estado',0);
        $this->db->update('personal_contrato');
      }
    }

  }

  $this->db->select('periodo_tareo');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('estado','0');
  $this->db->order_by('fecha_fin','desc');
  $this->db->limit(1);
  $query2=$this->db->get();
  $periodo=$query2->row('periodo_tareo');

  if ($query2->num_rows()>0) {
    foreach ($personal as $row) {
      if ($row->habilitado==1) {
        if ($this->existe_tareo($row->codigo_personal,$periodo)<1){
          $newtareo=array('codigo_personal'=>$row->codigo_personal,
                          'contrato'=>$this->session->userdata('alm_id'),
                          'periodo'=>$periodo);

  $numperiodo=substr($periodo, -2);
  if ($numperiodo=='01') {
    $this->db->insert('tareo_mensual01', $newtareo);
  }
  elseif ($numperiodo=='02') {
    $this->db->insert('tareo_mensual02', $newtareo);
  }
  elseif ($numperiodo=='03') {
    $this->db->insert('tareo_mensual03', $newtareo);
  }
  elseif ($numperiodo=='04') {
    $this->db->insert('tareo_mensual04', $newtareo);
  }
  elseif ($numperiodo=='05') {
    $this->db->insert('tareo_mensual05', $newtareo);
  }
  elseif ($numperiodo=='06') {
    $this->db->insert('tareo_mensual06', $newtareo);
  }
  elseif ($numperiodo=='07') {
    $this->db->insert('tareo_mensual07', $newtareo);
  }
  elseif ($numperiodo=='08') {
    $this->db->insert('tareo_mensual08', $newtareo);
  }
  elseif ($numperiodo=='09') {
    $this->db->insert('tareo_mensual09', $newtareo);
  }
  elseif ($numperiodo=='10') {
    $this->db->insert('tareo_mensual10', $newtareo);
  }
  elseif ($numperiodo=='11') {
    $this->db->insert('tareo_mensual11', $newtareo);
  }
  elseif ($numperiodo=='12') {
    $this->db->insert('tareo_mensual12', $newtareo);
  }
  $contrato=$this->session->userdata('alm_id');
  $posterior=$numperiodo-1;
  $numposterior=str_pad($posterior, 2, "0", STR_PAD_LEFT);
  $año=str_pad($periodo,5);
  $this->db->query("INSERT INTO tareo_mensual".$numposterior." (codigo_personal, contrato, periodo) VALUES ('".$codigo_personal."', '".$contrato."', '".$año.$numposterior."')");

        }else {
          $this->db->select('fecha_inicio');
          $this->db->from('periodo_tareo');
          $this->db->where('contrato',$this->session->userdata('alm_id'));
          $this->db->where('estado','0');
          $this->db->order_by('fecha_fin','desc');
          $this->db->limit(1);
          $query=$this->db->get();
          $fecha_inicio=$query->row('fecha_inicio');

          $this->db->select('fecha_fin');
          $this->db->from('periodo_tareo');
          $this->db->where('contrato',$this->session->userdata('alm_id'));
          $this->db->where('estado','0');
          $this->db->order_by('fecha_fin','desc');
          $this->db->limit(1);
          $query2=$this->db->get();
          $fecha_fin=$query2->row('fecha_fin');

          $ingreso=date('Y-m-d');
          $ini=date('Y-m-d',strtotime($fecha_inicio));
          $fin=date('Y-m-d',strtotime($fecha_fin));


          $datebaja=new DateTime($baja);
          $dateinicio=new DateTime($ini);
          $datefin=new DateTime($fin);
          $diasv="";
          $diff1=$datebaja->diff($dateinicio);
          $diff2=$datefin->diff($dateinicio);

          for ($i=$diff1->days+1; $i<=$diff2->days+1 ; $i++) {
            $diasv=$diasv."dia".$i."='',";
          }
            $numperiodo=substr($periodo, -2);
          $baja=trim($diasv, ',');
          $this->db->query("UPDATE tareo_mensual".$numperiodo." SET ".$baja." WHERE codigo_personal='".$codigo_personal."' and periodo='".$periodo."'");

        }
      }

    }
    return $periodo;
    //return 'Personal Actualizado e ingresado al Tareo';
  }else {
    return 'Personal Actualizado';
  }
}



public function existe_tareo($codigo,$periodo){
    $numperiodo=substr($periodo, -2);
    $contrato=$this->session->userdata('alm_id');

    $query=$this->db->query("SELECT * FROM tareo_mensual".$numperiodo." WHERE contrato".$contrato." and periodo='".$periodo."' and codigo_personal='".$codigo."'");
  /*$this->db->select('*');
  $this->db->from('tareo_mensual');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo',$periodo);
  $this->db->where('codigo_personal',$codigo);
  $query=$this->db->get();*/
  return $query->num_rows();
}

public function existe_personal($codigo){
  $this->db->select('codigo_personal');
  $this->db->from('personal_contrato');
  $this->db->where('codigo_personal',$codigo);
  $query=$this->db->get();
  return $query->num_rows();
}

public function baja_personal($codigo_personal,$fechabaja,$tipo){
  $this->db->select('fecha_inicio');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('estado','0');
  $this->db->order_by('fecha_fin','desc');
  $this->db->limit(1);
  $query=$this->db->get();
  $fecha_inicio=$query->row('fecha_inicio');

  $this->db->select('fecha_fin');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('estado','0');
  $this->db->order_by('fecha_fin','desc');
  $this->db->limit(1);
  $query2=$this->db->get();
  $fecha_fin=$query2->row('fecha_fin');

  $this->db->select('periodo_tareo');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('estado','0');
  $this->db->order_by('fecha_fin','desc');
  $this->db->limit(1);
  $query2=$this->db->get();
  $periodo=$query2->row('periodo_tareo');

if ($fecha_inicio<=$fechabaja and $fecha_fin>=$fechabaja) {

  $baja=date('Y-m-d',strtotime($fechabaja));
  $ini=date('Y-m-d',strtotime($fecha_inicio));
  $fin=date('Y-m-d',strtotime($fecha_fin));


  $datebaja=new DateTime($baja);
  $dateinicio=new DateTime($ini);
  $datefin=new DateTime($fin);
  $diasv="";
  $diff1=$datebaja->diff($dateinicio);
  $diff2=$datefin->diff($dateinicio);
  $contrato=$this->session->userdata('alm_id');
  for ($i=$diff1->days+1; $i<=$diff2->days+1 ; $i++) {
    $diasv=$diasv."dia".$i."='".$tipo."',";
  }
  $numperiodo=substr($periodo, -2);
  $baja=trim($diasv, ',');
  $this->db->query("UPDATE tareo_mensual".$numperiodo." SET ".$baja." WHERE codigo_personal='".$codigo_personal."' and periodo='".$periodo."' and contrato='".$contrato."'");
  $posterior=$numperiodo+1;
  $numposterior=str_pad($posterior, 2, "0", STR_PAD_LEFT);
  $año=str_pad($periodo,5);
  $this->db->query("INSERT INTO tareo_mensual".$numposterior." (codigo_personal, contrato, periodo) VALUES ('".$codigo_personal."', '".$contrato."', '".$año.$numposterior."')");
  for ($i=1; $i<=31 ; $i++) {
    $dias=$dias."dia".$i."='".$tipo."',";
  }
  $bajapost=trim($dias, ',');
  $this->db->query("UPDATE tareo_mensual".$numposterior." SET ".$bajapost." WHERE codigo_personal='".$codigo_personal."' and periodo='".$periodo."' and contrato='".$contrato."'");

  if(!empty($codigo_personal)){

       $this->db->set('estado','0');
       $this->db->where('codigo_personal',$codigo_personal);
       $this->db->update('personal_contrato');
   }
$respuesta=$this->db->affected_rows();
     return $respuesta;
}else {
  return "La fecha no esta dentro del rango del mes activo";
}


 }

public function listarpersonaltareo($periodo){

$filtro=$this->personal_activo($this->session->userdata('alm_id'));
    $numperiodo=substr($periodo, -2);

foreach ($filtro as $key) {
    $data=array('codigo_personal'=>$key->codigo_personal,
          'contrato'=>$this->session->userdata('alm_id'),
          'periodo'=>$periodo);

if ($numperiodo=='01') {
      $this->db->insert('tareo_mensual01', $data);
}
elseif ($numperiodo=='02') {
  $this->db->insert('tareo_mensual02', $data);
}elseif ($numperiodo=='03') {
  $this->db->insert('tareo_mensual03', $data);
}
elseif ($numperiodo=='04') {
  $this->db->insert('tareo_mensual04', $data);
}
elseif ($numperiodo=='05') {
  $this->db->insert('tareo_mensual05', $data);
}
elseif ($numperiodo=='06') {
  $this->db->insert('tareo_mensual06', $data);
}
elseif ($numperiodo=='07') {
  $this->db->insert('tareo_mensual07', $data);
}
elseif ($numperiodo=='08') {
  $this->db->insert('tareo_mensual08', $data);
}
elseif ($numperiodo=='09') {
  $this->db->insert('tareo_mensual09', $data);
}
elseif ($numperiodo=='10') {
  $this->db->insert('tareo_mensual10', $data);
}
elseif ($numperiodo=='11') {
  $this->db->insert('tareo_mensual1', $data);
}
elseif ($numperiodo=='12') {
  $this->db->insert('tareo_mensual12', $data);
}


      $this->db->last_query().'<br>';
}
$contrato=$this->session->userdata('alm_id');

    $query = $this->db->query("SELECT t1.codigo_personal, t1.contrato, t0.periodo, concat(t1.apepat_personal, ' ', t1.apemat_personal) apellidos, t1.nombre_personal, t1.cargo_personal FROM tareo_mensual".$numperiodo." t0 JOIN personal_contrato t1 ON t1.codigo_personal=t0.codigo_personal and t0.contrato=t1.contrato WHERE t0.contrato='".$contrato."' AND t0.periodo='".$periodo."' AND t1.estado=1");
  /*$this->db->select('t1.codigo_personal,t1.contrato,t0.periodo,concat(t1.apepat_personal," ",t1.apemat_personal) apellidos,t1.nombre_personal,t1.cargo_personal');
  $this->db->from('tareo_mensual t0');
  $this->db->join('personal_contrato t1','t1.codigo_personal=t0.codigo_personal and t0.contrato=t1.contrato');
  $this->db->where('t0.contrato',);
  $this->db->where('t0.periodo',$periodo);
  $this->db->where('t1.estado',1);*/

  return $query->result();
}

public function personalxtipo($tipo){
  $this->db->select('*');
  $this->db->from('personal_contrato');
  $this->db->where('id_tipo_personal',$tipo);
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('estado',1);
  $query = $this->db->get();
  return $query->result();
}

}
