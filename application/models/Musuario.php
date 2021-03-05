<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musuario extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }



  public function get($tipousuario){

  			$this->db->select('u.usuarioid,nombre,apepat,apemat,documento,correo,u.estado,cargo,a.acceso_almacenid,a.rolid,r.rol');
  			$this->db->from('usuario_admin u');
  			$this->db->join('acceso_almacen a','u.usuarioid=a.usuarioid','left');
  			$this->db->join('roles r','r.rolid=a.rolid and r.estado=1','left');
  			//$this->db->where('a.contratoid',$contrato);
  			if($this->session->rol_id!=1){
  				$this->db->where('a.rolid !=',1);
  			}
  			$query=$this->db->get();

  			return $query->result();
  		}


    public function validar($dni,$usuarioid){
  			$this->db->select('usuarioid');
  			$this->db->from('usuario_admin');
  			$this->db->where('documento',$dni);
  			if($usuarioid!=''){
  			$this->db->where('usuarioid !=',$usuarioid);
  		}

  			$query=$this->db->get();

  			return $query->num_rows();
  		}

//----------

public function insertarUsuario($usuario){
  $datos = array('usuarioid' => $usuario['usuarioid'],
          'nombre' => $usuario['nombre'],
          'apepat' =>$usuario['apepat'] ,
          'apemat' => $usuario['apemat'],
          'documento' => $usuario['documento'],
          'correo' => $usuario['correo'],
          'estado' => $usuario['estado'],
          'usuario' => $usuario['usuario'],
          'cargo' => $usuario['cargo'],
          'clave' => $usuario['clave'],

          'fecha_creacion' => $usuario['fecha_creacion']
          );

  if($this->db->insert('usuario_admin',$datos)){
    return $this->db->insert_id();
  }
  else{
    return 0;
  }

}


//--------------




public function insertarAccesos($usuarioid,$contratoid,$rolid){
  $datos = array('rolid' => $rolid,
          'usuarioid'=>$usuarioid,
          'contratoid'=>$contratoid,
          'fecha_creacion'=>date('Y-m-d H:i:s')
           );
  if($rolid!=0){
    if($this->db->insert('acceso_almacen',$datos)){
      $accesoid= $this->db->insert_id();
      $this->db->select('submenuid,'.$accesoid.' as accesoid');
      $this->db->from('detalle_rol');
      $this->db->where('rolid',$rolid);
      $query=$this->db->get();

      if(true){
        return 1;
      }
      else{
        return 0;
      }

    }
    else{
      return 0;
    }
  }else{
    return 0;
  }

}



public function updateUsuario($datos,$idusuario){

    $this->db->where('usuarioid',$idusuario);
    $this->db->update('usuario_admin',$datos);

  }





  public function updateaccesos($idusuario,$rol,$contrato){

  if($rol==0){

    $this->db->where('usuarioid',$idusuario);
    $this->db->where('contratoid',$contrato);
    $this->db->delete('acceso_almacen');

  }
  else{
    $this->db->select('*');
    $this->db->from('acceso_almacen');
    $this->db->where('usuarioid',$idusuario);
    $this->db->where('contratoid',$contrato);
    $query=$this->db->get();
    if($query->num_rows()==0){
      $datosacceso = array('rolid' => $rol,
                          'usuarioid'=>$idusuario,
                          'contratoid'=>$contrato,
                          'fecha_creacion'=>date('Y-m-d H:i:s')
                         );
      $this->db->insert('acceso_almacen', $datosacceso);
    }
    else{
      $this->db->set('rolid',$rol);
      $this->db->where('usuarioid',$idusuario);
      $this->db->where('contratoid',$contrato);
      $this->db->update('acceso_almacen');
    }

    echo $this->db->last_query();
  }
}





public function getaccesos($usuarioid){
  $this->db->select('c.contratoid,c.nombre,acceso_almacenid,rolid');
  $this->db->from('contrato c');
  $this->db->join('acceso_almacen a ','c.contratoid=a.contratoid and a.usuarioid='.$usuarioid.'','left');
  $this->db->where('c.estado',1);
  $query=$this->db->get();

  return $query->result();
}




}
