<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musuarios_ticket extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

public function area_centrocosto(){
    $bdcontabilidad=$this->load->database('004contabilidad',TRUE);
    $bdcontabilidad->select('*');
    $bdcontabilidad->from('010BDCONTABILIDAD..CENTRO_COSTOS');
    $bdcontabilidad->where('len(cencost_codigo)', 6);
    $query=$bdcontabilidad->get();
    return $query->result();
}


  public function getusuarios(){

  $this->db->select('idempresa,idarea,u.estado,u.idusuario,u.nombres,u.apellidos,u.dni,u.correo,u.cargo,a.descripcion as area,e.descripcion as empresa');
  $this->db->from('usuario u');
  $this->db->join('area a', 'u.area_idarea=a.idarea');
  $this->db->join('empresa e', 'u.empresa_idempresa=e.idempresa');
  $this->db->order_by('u.idusuario','DESC');
  $query=$this->db->get();
  return $query->result();
}


public function getempresa(){
  $this->db->select('*');
  $this->db->from('empresa');
  $this->db->where('idempresa !=', 1);
  $query=$this->db->get();
  return $query->result();

}

public function getEquipos(){
  $this->db->where("estado","1");
  $this->db->select("eqt.docentry, eqt.nombre_equipo");
  $this->db->from("equipo_tic eqt");
  $query=$this->db->get();
  return $query->result();
}


public function getarticulo(){
  $this->db->select('*');
  $this->db->from('articulos');
  $query=$this->db->get();
  return $query->result();

}

public function getsolicitante(){
  $this->db->select('*');
  $this->db->from('usuario');
  $query=$this->db->get();
  return $query->result();

}

public function getarea(){
  $this->db->select('*');
  $this->db->from('area');
  $query=$this->db->get();
  return $query->result();

}

public function getusuariotic(){
  $this->db->select('*');
  $this->db->from('usuario');
  $this->db->where('tipo', 2);
  $query=$this->db->get();
  return $query->result();
}



public function save($id,$nombres,$apellidos,$dni,$correo,$empresa,$area,$cargo,$estado){

  $data = array(
    'nombres'           => $nombres ,
    'apellidos'         => $apellidos,
    'dni'               => $dni,
    'correo'            => $correo,
    'empresa_idempresa' => $empresa,
    'area_idarea'       => $area,
    'cargo'             => $cargo,
    'estado'            => $estado
                );

  if($this->db->insert('usuario', $data)){
    echo "Se agrego el registro";
  }
  else{
    return 0;
  }
}
//-----------


public function update($id,$nombres,$apellidos,$dni,$correo,$empresa,$area,$cargo,$estado){
  $data = array(
    'nombres'              => $nombres ,
    'apellidos'            => $apellidos,
    'dni'                  => $dni,
    'correo'               => $correo,
    'empresa_idempresa'    => $empresa,
    'area_idarea'          => $area,
    'cargo'                => $cargo,
    'estado'               => $estado
                );

$this->db->where('idusuario', $id);
$this->db->update('usuario',$data);
if ($this->db->affected_rows()>0) {
echo "Se actualizo la fila";
}else {
return 0;


}




}

public function exist($dni){

  $this->db->select('*');
  $this->db->from('usuario');
  $this->db->where('dni', $dni);
  $query=$this->db->get();
  return $query->num_rows();

}

public function get_planilla(){
  return $this->db->query('select * from planilla_movilidad ')->result();

}

public function get_ultimaplanilla(){
  return $this->db->query('select * from planilla_movilidad where estado like "0" order by fecha desc limit 1')->row();

}

public function get_gastosplanilla($planilla){
    return $this->db->query('select *, (select concat(nombres," ",apellidos) from usuario where idusuario=t1.usuario) as usuario_nom from planilla_gastos t1 where t1.planilla like "'.$planilla.'"')->result();
}
//--------------




}
