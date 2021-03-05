<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marticulos extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  public function getarticulos(){
    $this->db->select('*');
    $this->db->from('articulos');
    $query=$this->db->get();
    return $query->result();
  }


  public function update($id,$descripcion,$u_medida,$codigo_ss,$estado){
    $data = array(
      'codigo_ss' => $codigo_ss,
      'descripcion' => $descripcion,
      'unidad' => $u_medida,
      'estado' => $estado

                  );
                  $this->db->where('idarticulos', $id);
                  $this->db->update('articulos',$data);
                  if ($this->db->affected_rows()>0) {
                    echo "se agrego";
                  }else {
                    return 1;
                  }

  }

}
