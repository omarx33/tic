<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mstock extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


/*

    public function getstock($empresa){
     $this->db->select('*');
     $this->db->from('stock');
     $this->db->where('empresa', $empresa);
     $query=$this->db->get();
    $temporal=$query->result();
    return $temporal;
    }
*/

public function getstock($empresa){
 $this->db->select('s.codigo_contable,s.correlativo,s.fecha_creacion,a.descripcion as art_desc,m.descripcion as marc,s.idstock,s.codigo,s.descripcion,s.serie,s.marca,s.modelo,s.capacidad,s.cantidad,s.empresa');
 $this->db->from('stock s');
 $this->db->join('marca m', 's.marca = m.idmarca');
$this->db->join('articulos as a', 'a.codigo_ss = s.codigo');
 $this->db->where('s.empresa', $empresa);
 $query=$this->db->get();
$temporal=$query->result();
return $temporal;
}




}
