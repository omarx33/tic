<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mingreso_ficha extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  public function get_ficha($empresa){
    $this->db->select('ft.nro_requerimiento,ft.centro_costo,ft.area,ft.nro_requerimiento,(SELECT COUNT(*) FROM ficha_detalle WHERE (cantidad-cantidad_recibida)=0 AND correlativo=ft.correlativo AND empresa=ft.empresa) as "atendido",
    (SELECT COUNT(*) FROM ficha_detalle WHERE correlativo=ft.correlativo AND empresa=ft.empresa) as "solicitado" ,ft.descripcion as descripcion_ficha,u.idusuario,ft.usuario_tic,ft.id_ficha,
    ft.correlativo,ft.fecha_creacion,CONCAT(u.nombres, " ", u.apellidos) as fullname,e.descripcion as empresa,e.idempresa');
    $this->db->from('ficha_tecnica ft');

    $this->db->join('usuario u', 'u.idusuario = ft.solicitante','left');
    $this->db->join('empresa e', 'e.idempresa = ft.empresa','left');
    $this->db->where('ft.empresa', $empresa);

   $query=$this->db->get();
  $result=$query->result();
  return $result;
  }


  public function detalle_ficha($correlativo,$empresa){
    $this->db->select('ft.id_ficha as cab_id,ft.empresa,fd.idficha,fd.correlativo,fd.descripcion,fd.cantidad,fd.img,fd.cantidad_recibida,a.codigo_ss,a.descripcion as producto,a.tipo');
    $this->db->from('ficha_detalle as fd');
    $this->db->join('articulos a', 'fd.img = a.idarticulos', 'left');
    $this->db->join('ficha_tecnica ft', 'ft.correlativo = fd.correlativo', 'left');
    $this->db->where('ft.id_ficha', $correlativo);
    $this->db->where('fd.empresa', $empresa);
    $query=$this->db->get();
    return $query->result();
  }



  public function actualizar_cantidad($id,$valor){
    $data = array('cantidad_recibida' => $valor );
    $this->db->where('idficha', $id);
    $this->db->update('ficha_detalle', $data);
    if ($this->db->affected_rows()>0) {
      echo "1";
    }else {
      return 0;
    }
  }



  public function guardar($data,$data2,$tipo_componente,$iddetallle,$empresa){

    if($this->db->insert('stock', $data)){
      if ($this->db->insert('movtic', $data2)) {
        $this->db->set('correlativo','correlativo+1',FALSE);
        $this->db->where('idcomponente',$tipo_componente);
        $this->db->where('empresa',$empresa);
        $this->db->update('correlativo_componente');

        $this->db->set('cantidad_recibida','cantidad_recibida+1',FALSE);
        $this->db->where('idficha',$iddetallle);
        $this->db->update('ficha_detalle');

        $CONDICION=$this->db->query('select * from ficha_detalle where idficha="'.$iddetallle.'" and cantidad=cantidad_recibida');
        if ($CONDICION->num_rows()>0) {
          $this->db->set('estado',1);
          $this->db->where('idficha',$iddetallle);
          $this->db->update('ficha_detalle');
        }
              echo "1";
      }else {
              echo "0";
      }

    }
    else{
      return 0;
    }
  }

}
