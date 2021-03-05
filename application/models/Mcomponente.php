<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcomponente extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


    public function getcomponente(){
      $this->db->select('*');
      $this->db->from('componente');
      $query=$this->db->get();
      return $query->result();
    }

    public function save($nombre,$estado){

      $data = array(
        'descripcion'        => $nombre ,
        'estado'             => $estado
                    );

      if($this->db->insert('componente', $data)){
        echo "Se agrego el registro";
      }
      else{
        return 0;
      }
    }



    public function update($id,$nombre,$estado){
      $data = array(
        'descripcion'        => $nombre ,
        'estado'             => $estado
                    );

   $this->db->where('idcomponente', $id);
   $this->db->update('componente',$data);
  if ($this->db->affected_rows()>0) {
    echo "Se actualizo la fila";
  }else {
    return 0;


  }
}

public function get_equipos(){
  return   $query1=$this->db->query("SELECT *,(SELECT descripcion FROM area where idarea=t1.ubicacion) 'nom_area',(select CONCAT(nombres,' ',apellidos) from usuario where idusuario=t1.usuario) as'nom_usuario',(select descripcion from empresa where idempresa=t1.empresa) as 'nom_empresa' FROM equipo_tic t1 ")->result();
}

public function save_equipo($equipo,$detalle){
  $this->db->insert('equipo_tic',$equipo);

  $id=$this->db->insert_id();

  foreach ($detalle as $key) {
    $data = array('equipoid' => $id,
                  'codigo_contable'=>$key->idcomponente,
                  'estado'=>1,
                  'fecha_asignacion'=>date('d-m-Y'));
    $this->db->insert('equipo_detalle',$data);
    $serie=$this->db->query("select*from stock where codigo_contable='".$key->idcomponente."'");
    $movimiento = array('codigo_contable' => $key->idcomponente,
                        'serie' => $serie->row('serie'),
                        'codigo'=>$serie->row('codigo'),
                        'tipo_mov'=>'S',
                        'empresa'=>$equipo['empresa'],
                        'docref'=>'',
                        'fecha'=>date('Y-m-d'),
                        'observaciones'=>'Armado de Equipo:'.$equipo['nombre_equipo']);
    $this->db->insert('movtic',$movimiento);

    $this->db->set('cantidad','cantidad-1',FALSE);
    $this->db->where('codigo_contable',$key->idcomponente);
    $this->db->update('stock');
  }
  $this->db->set('correlativo','correlativo+1',FALSE);
  $this->db->where('idcomponente',9);
  $this->db->where('empresa',$equipo['empresa']);
  $this->db->update('correlativo_componente');
  return $id;
}
/*
public function update_equipo($equipoid,$equipo,$detalle){
  $this->db->where('docentry',$equipoid);
  $this->db->update('equipo_tic',$equipo);

  foreach ($detalle as $key) {
    $data = array('equipoid' => $equipoid,
                  'codigo_contable'=>$key->idcomponente,
                  'estado'=>1,
                  'fecha_asignacion'=>date('d-m-Y'));
  }
}*/







    public function getlistamov($inicio,$fin,$empresa){

     $inicio = date('Y-m-d',strtotime($inicio));

     $fin = date('Y-m-d'." ".'23:59:00',strtotime($fin));

      $this->db->select('*');
      $this->db->from('movtic');
      $this->db->where('empresa', $empresa);
    $this->db->where("fecha_creacion BETWEEN '".$inicio."' AND '".$fin."'");
      $query=$this->db->get();
      return $query->result();

    }



        public function getlistamov_oc($inicio,$fin,$empresa){

         $inicio = date('Y-m-d',strtotime($inicio));

         $fin = date('Y-m-d'." ".'23:59:00',strtotime($fin));

          $this->db->select('*');
          $this->db->from('movtic');
          $this->db->where('empresa', $empresa);
          $this->db->where('tipo_mov', "I");
        $this->db->where("fecha_creacion BETWEEN '".$inicio."' AND '".$fin."'");
          $query=$this->db->get();
          return $query->result();

        }




        public function eliminar_equipos_det($id){
          $estado = '0';
          $data = array('estado' => $estado );


            $this->db->where('docentry', $id);
            $this->db->update('equipo_detalle', $data);
            if ($this->db->affected_rows()>0) {
              $componente=$this->db->query("SELECT * FROM equipo_detalle WHERE docentry=".$id);
              $serie=$this->db->query("select*from stock where codigo_contable='".$componente->row('codigo_contable')."'");
              $movimiento = array('codigo_contable' => $componente->row('codigo_contable'),
                                  'serie' => $serie->row('serie'),
                                  'codigo'=>$serie->row('codigo'),
                                  'tipo_mov'=>'I',
                                  'docref'=>'',
                                  'observaciones'=>'Retiro de Equipo',
                                  'empresa'=>$serie->row('empresa'));
              $this->db->insert('movtic',$movimiento);

              $this->db->set('cantidad',1);
              $this->db->where('codigo_contable', $componente->row('codigo_contable'));
              $this->db->update('stock');


              return 1;
            }else {
              return 0;
            }
    }

    public function especificaciones($equipo){
      $query2=$this->db->query("SELECT t1.especificaciones FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and (t1.tipo_componente=5 or t1.tipo_componente=6) and t0.equipoid=".$equipo);
      return '['.$query2->row('especificaciones').']';
    }
}
