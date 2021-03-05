<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcorrelativo extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getcorrelativos(){
    $this->db->select('*');
    $this->db->from('correlativo');

    $query=$this->db->get();

    return $query->result();
  }



  public function exist($id,$tipo,$correlativo){
  $this->db->select('*');
  $this->db->from('correlativo');
// $this->db->where('idcorrelativo',$id);
  $this->db->where('tipo', $tipo);
  if ($correlativo != 'condicional') {
    $this->db->where('correlativo', $correlativo);
  }
  $query=$this->db->get();
  return $query->num_rows();
}



public function save($id,$tipo,$correlativo){
    $data = array(
      'tipo' => $tipo ,
      'correlativo' => $correlativo
                  );
      $this->db->where('idcorrelativo', $id);
      $this->db->update('correlativo',$data);
      return $this->db->affected_rows();

}


public function guardar($data){
   $this->db->insert('correlativo',$data);
  if ($this->db->affected_rows()>0) {
    echo 2;
  }else {
    echo "0";
  }
}



public function actualizar_correlativo($tipo,$correlativo){
    $data = array(

      'correlativo' => $correlativo
                  );
      $this->db->where('tipo', $tipo);
      $this->db->update('correlativo',$data);
  //    return $this->db->affected_rows();
//si se ejecuta retornara valor 1

}


}
