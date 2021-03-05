<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtareo extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function get_clasificacion(){
    $this->db->select('*');
    $this->db->from('clasificaciones_dia');
    $clasificacion=$this->db->get();
    return $clasificacion->result();
  }

  public function saveClasificacion($objeto){
    $this->db->insert('clasificaciones_dia', $objeto);
    if($this->db->affected_rows()>0){
      return 1;
    }
    else{
      return 0;
    }
  }
  public function updateClasificacion($objeto,$id){
    $this->db->where('id_clasificacion', $id);
    $this->db->update('clasificaciones_dia', $objeto);
    if($this->db->affected_rows()>0){
      return 1;
    }
    else{
      return 0;
    }
  }


  public function crear_periodo($info){
    $this->db->insert('periodo_tareo', $info);
    if($this->db->affected_rows()>0){
      return 1;
    }
    else{
      return 0;
    }
  }

  public function get_periodo_abierto(){
    $contrato=$this->session->userdata('alm_id');
    return $this->db->query("SELECT periodo_tareo FROM periodo_tareo WHERE estado=0 and contrato=".$contrato." and (cierre_operaciones='0' or cierre_gestionhumana='0')")->result();
/*
    $this->db->select('periodo_tareo');
    $this->db->from('periodo_tareo');
    $this->db->where('estado',0);
    //$this->db->where('estado_dlibres',1);
    $this->db->or_where('cierre_operaciones','');

    $this->db->or_where('cierre_gestionhumana','');
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    return $this->db->get()->result();*/
  }

  public function get_periodo_para_cerrar(){
    $this->db->select('periodo_tareo');
    $this->db->from('periodo_tareo');
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    $this->db->where('estado',0);
    $this->db->order_by('fecha_fin','asc');
    $this->db->limit(1);
    $query=$this->db->get();
    return $query->row('periodo_tareo');
  }
  public function get_periodo(){

    $this->db->select('periodo_tareo');
    $this->db->from('periodo_tareo');
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    return $this->db->get()->result();
  }
  public function limpiartareo($periodo){
    $numperiodo=substr($periodo, -2);
    $this->db->query("DELETE tareo_mensual".$numperiodo." WHERE periodo='".$periodo."' and contrato=".$this->session->userdata('alm_id')."");
    /*$this->db->where('periodo',$periodo);
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    $this->db->delete('tareo_mensual');*/

    if($this->db->affected_rows()>0){
      $this->db->where('periodo_tareo',$periodo);
      $this->db->where('contrato',$this->session->userdata('alm_id'));
      $this->db->delete('periodo_tareo');

      return  "El tareo mensual ha sido borrado, por favor aperture nuevamente el mes";
    }else {
      return 'No se puede cerrar el tareo mensual';
    }
  }

  public function get_vacaciones($periodo){
    $this->db->select('t0.*,concat(t1.apepat_personal," ",t1.apemat_personal,", ",t1.nombre_personal) trabajador');
    $this->db->from('vacaciones t0');
    $this->db->join('personal_contrato t1','t1.codigo_personal=t0.personal');
    $this->db->where('t0.periodo',$periodo);
    $this->db->where('t0.contrato',$this->session->userdata('alm_id'));
    return $this->db->get()->result();
  }

  public function validarvacaciones($trabajador,$fecha1,$fecha2,$periodo){

    $this->db->select('fecha_inicio');
    $this->db->from('periodo_tareo');
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    $this->db->where('periodo_tareo',$periodo);
    $this->db->limit(1);
    $query=$this->db->get();
    $inicio=date('Y-m-d',strtotime($query->row('fecha_inicio')));

    $this->db->select('fecha_fin');
    $this->db->from('periodo_tareo');
    $this->db->where('contrato',$this->session->userdata('alm_id'));
    $this->db->where('periodo_tareo',$periodo);
    $this->db->limit(1);
    $query2=$this->db->get();
    $fin=date('Y-m-d',strtotime($query2->row('fecha_fin')));

    if (($inicio<=$fecha1 and $fecha1<=$fin) and ($inicio<=$fecha2 and $fecha2<=$fin)) {
      $numperiodo=substr($periodo, -2);
      $data['personal']=$trabajador;
      $data['fecha_inicio']=$fecha1;
      $data['fecha_fin']=$fecha2;
      $data['periodo']=$periodo;
      $data['contrato']=$this->session->userdata('alm_id');
      $this->db->insert('vacaciones',$data);
      if ($this->db->affected_rows()<1) {
        return "error al programar vacaciones";
      }else {
        $dateincio= new DateTime($inicio);
        $datetime1 = new DateTime($fecha1);
        $datetime2 = new DateTime($fecha2);
        $datefin= new DateTime($fin);

        $diff1=$dateincio->diff($datetime1);
        $diff2=$dateincio->diff($datetime2);

        $difftotal=$dateincio->diff($datefin);

        $diasv="";
        for ($i=$diff1->days+1; $i<=$diff2->days+1 ; $i++) {
          $diasv=$diasv."dia".$i."='V',";
        }

        $vacaciones=trim($diasv, ',');

        $this->db->query("UPDATE tareo_mensual".$numperiodo." SET ".$vacaciones." WHERE codigo_personal='".$trabajador."'");
        return "Vacaciones Aceptadas";

      }


    }else {
      return "Vacaciones Rechazadas";
    }
  }

  public function eliminar_vacaciones($id){

    $this->db->select('periodo');
    $this->db->from('vacaciones');
    $this->db->where('docentry',$id);
    $consulta=$this->db->get();
    $periodo=$consulta->row('periodo');
    if ($consulta->num_rows()>0) {

          $this->db->select('fecha_inicio');
          $this->db->from('periodo_tareo');
          $this->db->where('contrato',$this->session->userdata('alm_id'));
          $this->db->where('periodo_tareo',$periodo);
          $this->db->limit(1);
          $query=$this->db->get();
          $inicio=date('Y-m-d',strtotime($query->row('fecha_inicio')));

          $this->db->select('fecha_inicio');
          $this->db->from('vacaciones');
          $this->db->where('docentry',$id);
          $vacini=date('Y-m-d',strtotime($this->db->get()->row('fecha_inicio')));

          $this->db->select('fecha_fin');
          $this->db->from('vacaciones');
          $this->db->where('docentry',$id);
          $vacfin=date('Y-m-d',strtotime($this->db->get()->row('fecha_fin')));

          $this->db->select('personal');
          $this->db->from('vacaciones');
          $this->db->where('docentry',$id);
          $consulta2=$this->db->get();
          $trabajador=$consulta2->row('personal');

          $dateperiodo=new DateTime($inicio);
          $dateinicio=new DateTime($vacini);
          $datefin=new DateTime($vacfin);

          $diff1=$dateperiodo->diff($dateinicio);
          $diff2=$dateperiodo->diff($datefin);

          $diasv="";
          for ($i=$diff1->days+1; $i<=$diff2->days+1 ; $i++) {
            $diasv=$diasv."dia".$i."='T',";
          }
          $numperiodo=substr($periodo, -2);
          $vacaciones=trim($diasv, ',');

          $this->db->query("UPDATE tareo_mensual".$numperiodo." SET ".$vacaciones." WHERE codigo_personal='".$trabajador."'");

          $this->db->where('docentry', $id);
          $this->db->delete('vacaciones');

          return "Vacaciones Eliminadas";

    }else {
      return "No se anularon las vacaciones";
    }
  }

  public function eliminar_clasificacion($id){
    $this->db->where('id_clasificacion', $id);
    $this->db->delete('clasificaciones_dia');


    return "Clasificacion eliminada";

  }
  public function eliminar_tipo($id){
    $this->db->where('id_tipo_trabajador', $id);
    $this->db->delete('tipo_trabajadores');


    return "Tipo de Trabajador eliminado";

  }
public function get_tareo($periodo,$tipo){
  $contrato=$this->session->userdata('alm_id');
  $numperiodo=substr($periodo, -2);
$query=$this->db->query("SELECT t0.*, concat(t1.apepat_personal, ' ', t1.apemat_personal, ', ', t1.nombre_personal)  trabajador, cargo_personal
FROM tareo_mensual".$numperiodo." t0
JOIN personal_contrato t1 ON t1.codigo_personal=t0.codigo_personal
WHERE t0.contrato = '".$contrato."'
AND t0.periodo = '".$periodo."'
AND t1.id_tipo_personal = '".$tipo."'");
/*
  $this->db->select('t0.*,concat(t1.apepat_personal," ",t1.apemat_personal,", ",t1.nombre_personal)  trabajador, cargo_personal');
  $this->db->from('tareo_mensual t0');
  $this->db->join('personal_contrato t1','t1.codigo_personal=t0.codigo_personal');
  $this->db->where('t0.contrato',$this->session->userdata('alm_id'));
  $this->db->where('t0.periodo',$periodo);
  $this->db->where('t1.id_tipo_personal',$tipo);*/
  $data=$query->result();

  return $data;
}


public function asignar_dlibres($periodo,$personal,$query,$dia,$tipo){
  $contrato=$this->session->userdata('alm_id');
$numperiodo=substr($periodo, -2);
  if ($tipo=="DL") {
    $vacaciones=$this->db->query("SELECT $dia FROM tareo_mensual".$numperiodo." WHERE contrato='".$contrato."' and periodo='".$periodo."' and codigo_personal='".$personal."'");
    //
    if($vacaciones->row()->$dia=='V'){
      return 'V';
    }else{

      $this->db->query("UPDATE tareo_mensual".$numperiodo." SET ".$query." WHERE contrato='".$contrato."' and periodo='".$periodo."' and codigo_personal='".$personal."'");
      echo $vacaciones->row()->$dia;
    }
  }else {
    $vacaciones=$this->db->query("SELECT $dia FROM tareo_mensual".$numperiodo." WHERE contrato='".$contrato."' and periodo='".$periodo."' and codigo_personal='".$personal."'");
      if($vacaciones->row()->$dia=='V'){
        return "V";
      }else{
        $this->db->query("UPDATE tareo_mensual".$numperiodo." SET ".$query." WHERE contrato='".$contrato."' and periodo='".$periodo."' and codigo_personal='".$personal."'");
        return 1;
      }

  }
}
public function cerrar_dlibres($periodo){
  $this->db->set('estado_dlibres',1);
  $this->db->where('periodo_tareo',$periodo);
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->update('periodo_tareo');

  if($this->db->affected_rows()<1){
    return 0;
  }else {
    return 1;
  }

}

public function get_tareodiario($periodo,$tipo,$dia){

$contrato=$this->session->userdata('alm_id');
  $query=$this->db->query("SELECT * FROM dia_cerrado WHERE periodo='".$periodo."' and dia='".$dia."' and contrato='".$contrato."'");
$numperiodo=substr($periodo, -2);
if ($query->num_rows()<1) {
  $tareo_diario=$this->db->query("SELECT t0.codigo_personal,t1.apemat_personal,t1.apepat_personal,t1.nombre_personal,case when t0.dia".$dia." is null then 'T' else t0.dia".$dia." end as 'dia' FROM tareo_mensual".$numperiodo." t0 INNER JOIN personal_contrato t1 on t1.codigo_personal=t0.codigo_personal and t1.contrato=t0.contrato WHERE t0.periodo='".$periodo."' and t1.id_tipo_personal='".$tipo."'and t0.contrato='".$contrato."'");
  return $tareo_diario->result();
}else {
  return 1;
}
}

public function get_tareooperaciones($periodo,$tipo,$dia){

$contrato=$this->session->userdata('alm_id');
$numperiodo=substr($periodo, -2);
$this->db->select('estado');
$this->db->from('dia_cerrado');
$this->db->where('periodo',$periodo);
$this->db->where('dia',$dia);
$this->db->where('contrato',$contrato);
$query=$this->db->get();
$estado=$query->row('estado');
if ($query->num_rows()<1) {
    return 0;
} else {
  if ($estado==1) {
    $tareo_diario=$this->db->query("SELECT t0.codigo_personal,t1.apemat_personal,t1.apepat_personal,t1.nombre_personal,case when t0.dia".$dia." is null then 'T' else t0.dia".$dia." end as 'dia' FROM tareo_mensual".$numperiodo." t0 INNER JOIN personal_contrato t1 on t1.codigo_personal=t0.codigo_personal and t1.contrato=t0.contrato WHERE t0.periodo='".$periodo."' and t1.id_tipo_personal='".$tipo."'and t0.contrato='".$contrato."'");
    return $tareo_diario->result();
  }if($estado==2){
    return 2;
  }
  else {
    return 0;
  }
}

}

public function get_tareorrhh($periodo,$tipo,$dia){

  $contrato=$this->session->userdata('alm_id');
  $numperiodo=substr($periodo, -2);
  $this->db->select('estado');
  $this->db->from('dia_cerrado');
  $this->db->where('periodo',$periodo);
  $this->db->where('dia',$dia);
  $this->db->where('contrato',$contrato);
  $query=$this->db->get();
  $estado=$query->row('estado');

  if ($query->num_rows()<1) {
    return 0;
  } else {
    if ($estado==2) {
      $tareo_diario=$this->db->query("SELECT t0.codigo_personal,t1.apemat_personal,t1.apepat_personal,t1.nombre_personal,case when t0.dia".$dia." is null then 'T' else t0.dia".$dia." end as 'dia' FROM tareo_mensual".$numperiodo." t0 INNER JOIN personal_contrato t1 on t1.codigo_personal=t0.codigo_personal and t1.contrato=t0.contrato WHERE t0.periodo='".$periodo."' and t1.id_tipo_personal='".$tipo."'and t0.contrato='".$contrato."'");
      return $tareo_diario->result();
    }else {
      return 0;
    }
  }

}


public function asignar_dia($tipo,$dia,$periodo,$personal){
$contrato=$this->session->userdata('alm_id');
$numperiodo=substr($periodo, -2);
$this->db->query("UPDATE tareo_mensual".$numperiodo." SET dia".$dia."='".$tipo."' WHERE codigo_personal='".$personal."' and contrato='".$contrato."' and periodo='".$periodo."'");
if($this->db->affected_rows()<1){
  return 0;
}else {
  $mensaje="se asigno ".$tipo;
  return $mensaje;
}
}

public function grabardia($tareodia,$periodo,$contrato,$dia){
$numperiodo=substr($periodo, -2);
foreach ($tareodia as $key) {
$this->db->query("UPDATE tareo_mensual".$numperiodo." set dia".$dia."='".$key->dia."' WHERE codigo_personal='".$key->codigo_personal."' and periodo='".$periodo."' and contrato='".$contrato."'");
}
return "El dia ha sido grabado";
}

public function tiempo_extra($codigo_personal,$periodo,$dia,$tiempo_extra,$tipo){

$this->db->select('*');
$this->db->from('tiempo_extra');
$this->db->where('codigo_personal',$codigo_personal);
$this->db->where('periodo',$periodo);
$this->db->where('dia',$dia);
$this->db->where('tipo',$tipo);
$query=$this->db->get();

if ($query->num_rows()<1) {
  $this->db->insert('tiempo_extra',$tiempo_extra);
  return "Se añadio correctamente";
} else {
  return "No es permitido el ingreso de tiempo adicional para este día";
}
}

public function cerrar_dia($fecha,$periodo){
  $contrato=$this->session->userdata('alm_id');
  $query=$this->db->query("SELECT * FROM dia_cerrado WHERE periodo='".$periodo."' and dia='".$fecha."' and contrato='".$contrato."'");

  if($query->num_rows()>=1){
    echo "El día ya fue cerrado";
  }else {
    $data=array('periodo'=>$periodo,
                'dia'=>$fecha,
                'contrato'=>$contrato,
                'estado'=>'1');
    $this->db->insert('dia_cerrado',$data);

    echo "Se cerro el dia";
  }

}


public function cerrar_dialima($fecha,$periodo,$estadonew)

{
  $contrato=$this->session->userdata('alm_id');

  $this->db->select('estado');
  $this->db->from('dia_cerrado');
  $this->db->where('periodo',$periodo);
  $this->db->where('dia',$fecha);
  $this->db->where('contrato',$contrato);
  $estado=$this->db->get()->row('estado');

  if ($estado==1) {
    $this->db->set('estado',$estadonew);
    $this->db->where('periodo',$periodo);
    $this->db->where('dia',$fecha);
    $this->db->where('contrato',$contrato);
    $this->db->update('dia_cerrado');

    return  "Se cerro el dia";
  }
  if ($estado==2) {
    $this->db->set('estado',$estadonew);
    $this->db->where('periodo',$periodo);
    $this->db->where('dia',$fecha);
    $this->db->where('contrato',$contrato);
      $this->db->update('dia_cerrado');
    return  "Se cerro el dia";
  }
  else {
    return "ERROR, El día ya fue cerrado";
  }
}

public function consultar_tareo($periodo){

  $contrato=$this->session->userdata('alm_id');
$numperiodo=substr($periodo, -2);
  $query=$this->db->query("SELECT t0.*, t2.id_tipo_trabajador, concat(t1.apepat_personal, ' ', t1.apemat_personal, ', ', t1.nombre_personal)  trabajador, t2.desc_tipo_trabajador, t1.cargo_personal FROM tareo_mensual".$numperiodo." t0 JOIN personal_contrato t1 ON t1.codigo_personal=t0.codigo_personal JOIN tipo_trabajadores t2 ON t2.id_tipo_trabajador=t1.id_tipo_personal WHERE t0.contrato = '".$contrato."' AND t0.periodo = '".$periodo."' ORDER BY t2.id_tipo_trabajador asc");

/*
  $this->db->select('t0.*,t2.id_tipo_trabajador,concat(t1.apepat_personal," ",t1.apemat_personal,", ",t1.nombre_personal)  trabajador,t2.desc_tipo_trabajador , t1.cargo_personal');
  $this->db->from('tareo_mensual t0');
  $this->db->join('personal_contrato t1','t1.codigo_personal=t0.codigo_personal');
  $this->db->join('tipo_trabajadores t2','t2.id_tipo_trabajador=t1.id_tipo_personal');
  $this->db->where('t0.contrato',$this->session->userdata('alm_id'));
  $this->db->where('t0.periodo',$periodo);
  $this->db->order_by('t2.id_tipo_trabajador asc');*/
  $data=$query->result();

  return $data;
}

public function dias_apoyo($periodo,$tiempo_extra){
  $contrato=$this->session->userdata('alm_id');
  /*$query='SELECT t2.apepat_personal,t2.apemat_personal,t2.nombre_personal,SUM(t0.cantidad) "dias",concat("-",GROUP_CONCAT(t0.motivo)) "motivo",concat("-",GROUP_CONCAT(t0.fecha)) "fecha",t2.cargo_personal FROM tiempo_extra t0 JOIN periodo_tareo t1 ON t0.periodo=t1.periodo_tareo and t0.contrato=t1.contrato JOIN personal_contrato t2 ON t2.codigo_personal=t0.codigo_personal and t2.contrato=t1.contrato WHERE t0.periodo ="2019-03" AND t0.tipo="DA" AND t0.contrato=1 GROUP BY t2.apepat_personal,t2.apemat_personal,t2.nombre_personal,t2.cargo_personal';*/
  $this->db->select('t2.apepat_personal,t2.apemat_personal,t2.nombre_personal,SUM(t0.cantidad) "dias",concat("-",GROUP_CONCAT(t0.motivo)) "motivo",concat("-",GROUP_CONCAT(t0.fecha)) "fecha",t2.cargo_personal');
  $this->db->from('tiempo_extra t0');
  $this->db->join('periodo_tareo t1','t0.periodo=t1.periodo_tareo and t0.contrato=t1.contrato');
  $this->db->join('personal_contrato t2','t2.codigo_personal=t0.codigo_personal and t2.contrato=t1.contrato');
  $this->db->where('t0.periodo',$periodo);
  $this->db->where('t0.tipo',$tiempo_extra);
  $this->db->where('t0.contrato',$contrato);
  $this->db->group_by('t2.apepat_personal,t2.apemat_personal,t2.nombre_personal, t2.cargo_personal');
  //$this->db->order_by('concat(t2.apepat_personal, " ", t2.apemat_personal, ", ", t2.nombre_personal)','asc');

  $data=$this->db->get()->result();

  return $data;
}
public function horas_extra($periodo,$tiempo_extra){
  $contrato=$this->session->userdata('alm_id');
  /*$query='SELECT t2.apepat_personal,t2.apemat_personal,t2.nombre_personal,SUM(t0.cantidad) "dias",concat("-",GROUP_CONCAT(t0.motivo)) "motivo",concat("-",GROUP_CONCAT(t0.fecha)) "fecha",t2.cargo_personal FROM tiempo_extra t0 JOIN periodo_tareo t1 ON t0.periodo=t1.periodo_tareo and t0.contrato=t1.contrato JOIN personal_contrato t2 ON t2.codigo_personal=t0.codigo_personal and t2.contrato=t1.contrato WHERE t0.periodo ="2019-03" AND t0.tipo="DA" AND t0.contrato=1 GROUP BY t2.apepat_personal,t2.apemat_personal,t2.nombre_personal,t2.cargo_personal';*/
  $this->db->select('t2.apepat_personal,t2.apemat_personal,t2.nombre_personal,SUM(t0.cantidad) "horas",concat("-",GROUP_CONCAT(t0.motivo)) "motivo",concat("-",GROUP_CONCAT(t0.fecha)) "fecha",t2.cargo_personal');
  $this->db->from('tiempo_extra t0');
  $this->db->join('periodo_tareo t1','t0.periodo=t1.periodo_tareo and t0.contrato=t1.contrato');
  $this->db->join('personal_contrato t2','t2.codigo_personal=t0.codigo_personal and t2.contrato=t1.contrato');
  $this->db->where('t0.periodo',$periodo);
  $this->db->where('t0.tipo',$tiempo_extra);
  $this->db->where('t0.contrato',$contrato);
  $this->db->group_by('t2.apepat_personal,t2.apemat_personal,t2.nombre_personal, t2.cargo_personal');
  //$this->db->order_by('concat(t2.apepat_personal, " ", t2.apemat_personal, ", ", t2.nombre_personal)','asc');

  $data=$this->db->get()->result();

  return $data;
}

public function cierremes($periodo){
  $contrato=$this->session->userdata('alm_id');
  if ($this->session->userdata('rol_id')==20 or $this->session->userdata('rol_id')==22) {
      $this->db->set('cierre_operaciones',1);
  }
  if ($this->session->userdata('rol_id')==21 or $this->session->userdata('rol_id')==22) {
      $this->db->set('cierre_gestionhumana',1);
  }

  $this->db->where('periodo_tareo',$periodo);
  $this->db->where('contrato',$contrato);
  $this->db->update('periodo_tareo');


  $this->db->select('cierre_gestionhumana');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $cierre_gestionhumana=$this->db->get()->row('cierre_gestionhumana');

  $this->db->select('cierre_operaciones');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('periodo_tareo',$periodo);
  $cierre_operaciones=$this->db->get()->row('cierre_operaciones');

  if($cierre_gestionhumana+$cierre_operaciones>1){
    $this->db->set('estado',1);
    $this->db->where('periodo_tareo',$periodo);
    $this->db->where('contrato',$contrato);
    $this->db->update('periodo_tareo');
  }

  return 1;
}

public function get_periodo_cerrados(){
  $this->db->select('periodo_tareo');
  $this->db->from('periodo_tareo');
  $this->db->where('contrato',$this->session->userdata('alm_id'));
  $this->db->where('estado',1);
  $query=$this->db->get();

  return $query->result();
}
public function aperturames($periodo){
  $contrato=$this->session->userdata('alm_id');

  $this->db->set('cierre_gestionhumana',0);
  $this->db->set('cierre_operaciones',0);
  $this->db->set('estado',0);
  $this->db->where('periodo_tareo',$periodo);
  $this->db->where('contrato',$contrato);
  $this->db->update('periodo_tareo');

  return 1;
}

public function aperturadia($dia){
  $this->db->where('docentry', $dia);
  $this->db->delete('dia_cerrado');
  return 1;
}

public function dias_cerrados($periodo){
    $contrato=$this->session->userdata('alm_id');

    $this->db->select('*');
    $this->db->from('dia_cerrado');
    $this->db->where('periodo',$periodo);
    $this->db->where('contrato',$contrato);
    $this->db->order_by('dia_cerrado','desc');
    return $this->db->get()->result();

}

public function consultar_tareo_excel($periodo){
  $numperiodo=substr($periodo, -2);
  $anterior=$numperiodo-1;
  $numanterior=str_pad($anterior, 2, "0", STR_PAD_LEFT);
  $dateant=date('Y-m-d',strtotime($periodo));
  $periodoanterior = date('Y-m',strtotime($dateant."-1 month"));
  $contrato=$this->session->userdata('alm_id');
  $query=$this->db->query("SELECT t3.id_tipo_trabajador, concat(t2.apepat_personal, ' ', t2.apemat_personal, ', ', t2.nombre_personal)  trabajador, t3.desc_tipo_trabajador, t2.cargo_personal ,t1.*,t0.dia1 'diaactual1',t0.dia2 'diaactual2',t0.dia3 'diaactual3',t0.dia4 'diaactual4',t0.dia5 'diaactual5',t0.dia6 'diaactual6',t0.dia7 'diaactual7',t0.dia8 'diaactual8',t0.dia9 'diaactual9',t0.dia10 'diaactual10',t0.dia11 'diaactual11',t0.dia12 'diaactual12',t0.dia13 'diaactual13',t0.dia14 'diaactual14',t0.dia15 'diaactual15',t0.dia16 'diaactual16',t0.dia17 'diaactual17',t0.dia18 'diaactual18',t0.dia19 'diaactual19',t0.dia20 'diaactual20',t0.dia21 'diaactual21',t0.dia22 'diaactual22',t0.dia23 'diaactual23',t0.dia24 'diaactual24',t0.dia25 'diaactual25',t0.dia26 'diaactual26',t0.dia27 'diaactual27',t0.dia28 'diaactual28',t0.dia29 'diaactual29',t0.dia30 'diaactual30',t0.dia31 'diaactual31' from tareo_mensual".$numperiodo." t0 LEFT join tareo_mensual".$numanterior." t1 on t1.codigo_personal=t0.codigo_personal and t1.contrato=t0.contrato JOIN personal_contrato t2 ON t2.codigo_personal=t1.codigo_personal JOIN tipo_trabajadores t3 ON t3.id_tipo_trabajador=t2.id_tipo_personal WHERE t0.contrato = '".$contrato."' AND t0.periodo = '".$periodo."' and t1.contrato = '".$contrato."' AND t1.periodo='".$periodoanterior."' ORDER BY t3.id_tipo_trabajador asc");
  $data=$query->result();

  return $data;
}

public function consultar_tareo_excelmes($periodo){
  $numperiodo=substr($periodo, -2);
  $contrato=$this->session->userdata('alm_id');
  $query=$this->db->query("SELECT t3.id_tipo_trabajador, concat(t2.apepat_personal, ' ', t2.apemat_personal, ', ', t2.nombre_personal)  trabajador, t3.desc_tipo_trabajador, t2.cargo_personal ,t1.* from tareo_mensual".$numperiodo." t1  JOIN personal_contrato t2 ON t2.codigo_personal=t1.codigo_personal JOIN tipo_trabajadores t3 ON t3.id_tipo_trabajador=t2.id_tipo_personal WHERE t1.contrato = '".$contrato."' AND t1.periodo = '".$periodo."'  ORDER BY t3.id_tipo_trabajador asc");
  $data=$query->result();

  return $data;
}
public function plantilla_starsoft($periodo){
  $query=$this->db->query('SELECT t0.codigo_personal,concat(apepat_personal," ",apemat_personal," ",nombre_personal) as "trabajador",t0.periodo,t0.contrato,concat(t0.dia1,"-",t0.dia2,"-",t0.dia3,"-",t0.dia4,"-",t0.dia5,"-",t0.dia6,"-",t0.dia7,"-",t0.dia8,"-",t0.dia9,"-",t0.dia10,"-",t0.dia11,"-",t0.dia12,"-",t0.dia13,"-",t0.dia14,"-",t0.dia15,"-",t0.dia16,"-",t0.dia17,"-",t0.dia18,"-",t0.dia19,"-",t0.dia20,"-",t0.dia21,"-",t0.dia22,"-",t0.dia23,"-",t0.dia24,"-",t0.dia25,"-",t0.dia26,"-",t0.dia27,"-",t0.dia28,"-",COALESCE(t0.dia29,""),"-",COALESCE(t0.dia30,""),"-",COALESCE(t0.dia31,"")) as "trabajados",(SELECT SUM(t2.cantidad) FROM tiempo_extra t2 where t2.codigo_personal=t0.codigo_personal and t2.tipo="HE" group by t2.cantidad) as "hora_extra",(SELECT SUM(t2.cantidad) FROM tiempo_extra t2 where t2.codigo_personal=t0.codigo_personal and t2.tipo="DA" group by t2.cantidad) as "dia_apoyo" FROM tareo_mensual03 t0 inner JOIN personal_contrato t1 on t1.codigo_personal=t0.codigo_personal  WHERE t0.periodo="'.$periodo.'"');
  $data=$query->result();

  return $data;
}
}
