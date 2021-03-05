<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marea extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  public function getarea(){
    $this->db->select('*');
    $this->db->from('area');
    $query=$this->db->get();
    return $query->result();
  }

  public function save($descripcion,$estado){
    $data = array(
      'descripcion' => $descripcion ,
      'estado' => $estado
                  );

    if($this->db->insert('area', $data)){
      echo "Se agrego el registro";
    }
    else{
      return 0;
    }

  }


  public function update($data,$id){
 $this->db->where('idarea', $id);
 $this->db->update('area',$data);
if ($this->db->affected_rows()>0) {
  echo "Se actualizo la fila";
}else {
  return 0;
}
  }


 public function exist($descripcion){

   $this->db->select('*');
   $this->db->from('area');
   $this->db->where('descripcion', $descripcion);
   $query=$this->db->get();
   return $query->num_rows();

 }




}
