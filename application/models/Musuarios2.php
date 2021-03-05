<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musuarios2 extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  public function getusuarios(){

    $this->db->select('u.estado,u.idusuario,u.nombres,u.apellidos,u.dni,u.correo,u.cargo,a.descripcion as area,e.descripcion as empresa');
    $this->db->from('usuario u');
    $this->db->join('area a', 'u.area_idarea=a.idarea', 'left');
    $this->db->join('empresa e', 'u.empresa_idempresa=e.idempresa', 'left');
    $this->db->order_by('u.idusuario','DESC');
    $query=$this->db->get();
    return $query->result();
  }






}
