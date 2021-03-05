<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmarca extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getmarca(){
    $this->db->select('*');
    $this->db->from('marca');

    $query=$this->db->get();

    return $query->result();
  }


  public function save($id,$nombre,$ruta,$descripcion,$estado){

    $data = array(
      'nombre_marca'      => $nombre ,
      'link'        => $ruta,
      'descripcion' => $descripcion,
      'estado'      => $estado
                  );

    if($this->db->insert('marca', $data)){
      echo "Se agrego el registro";
    }
    else{
      return 0;
    }
  }


      public function update($id,$nombre,$ruta,$descripcion,$estado){
        $data = array(
          'nombre_marca'      => $nombre ,
          'link'        => $ruta,
          'descripcion' => $descripcion,
          'estado'      => $estado
                      );

     $this->db->where('idmarca', $id);
     $this->db->update('marca',$data);
    if ($this->db->affected_rows()>0) {
      echo "Se actualizo la fila";
    }else {
      return 0;


    }
  }


}
