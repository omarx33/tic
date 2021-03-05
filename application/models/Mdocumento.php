<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdocumento extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More

  }


 public function get_cabecera($correlativo,$empresa){
    $this->db->select('ft.empresa,ft.usuario_tic, concat(us.nombres," ",us.apellidos) fullname_solicitante,ft.correlativo,concat(u.nombres," ",u.apellidos) fullname,DATE_FORMAT(ft.fecha_creacion,"%d/%m/%Y") fecha_creacion,ft.area as descripcion');
    $this->db->from('ficha_tecnica ft');
    $this->db->join('usuario as u', 'u.idusuario = ft.usuario_tic', 'left');
  //  $this->db->join('area as a', 'ft.area=a.idarea', 'left');
    $this->db->join('usuario us', 'ft.solicitante = us.idusuario', 'left');
  $this->db->where('ft.empresa', $empresa);
    $this->db->where('correlativo', $correlativo);
    $query=$this->db->get();
    return $query->row();
 }




 public function get_detalle($correlativo,$empresa){
   $this->db->select('fd.idficha,fd.descripcion,fd.precio_ref,fd.fuente,fd.cantidad,fd.comentario,fd.estado,fd.img,a.imagen as imagen,a.descripcion as nom_img');
   $this->db->from('ficha_detalle fd');
   $this->db->join('articulos a', 'fd.img = a.idarticulos', 'left');
    $this->db->where('correlativo',$correlativo);
        $this->db->where('fd.empresa',$empresa);
    $query=$this->db->get();
    return $query->result();
}

}
