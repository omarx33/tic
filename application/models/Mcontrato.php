<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontrato extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function get($estado){

    $this->db->select("contratoid,nombre,estado");
    $this->db->from("contrato");
    if($estado!='all'){
    $this->db->where("estado",$estado);
    }
    $query=$this->db->get();

    return $query->result();
  }





}
