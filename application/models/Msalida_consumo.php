<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msalida_consumo extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }



  public function getsalidas($inicio,$fin,$empresa){
    $inicio = date('Y-m-d',strtotime($inicio));

    $fin = date('Y-m-d'." ".'23:59:00',strtotime($fin));

   $this->db->select('CONCAT(user.nombres, " ", user.apellidos) as full,cs.descripcion info,a.idarea,user.idusuario as user,u.idusuario,CONCAT(u.nombres, " ", u.apellidos) as fullname,cs.equipo,cs.numero,cs.empresa,e.descripcion,cs.fecha_creacion,a.descripcion area');
   $this->db->from('consumo_salida as cs');
   $this->db->join('area a', 'cs.area = a.idarea');
   $this->db->join('usuario u', 'u.idusuario = cs.tecnico','left');
   $this->db->join('empresa e', 'e.idempresa = cs.empresa','left');
   $this->db->join('usuario as user', 'user.idusuario = cs.usuario','left');
  $this->db->where('cs.empresa', $empresa);
  $this->db->where("cs.fecha_creacion BETWEEN '".$inicio."' AND '".$fin."'");
   $query=$this->db->get();
  $temporal=$query->result();
  return $temporal;
  }




public function consulta_codigo($empresa){
//$this->db->distinct();
//$this->db->select('codigo_ss,descripcion');
//$this->db->from('articulos');
//$this->db->where('estado','01');
//$this->db->where('empresa',$empresa);


$this->db->select('s.codigo,a.descripcion');
$this->db->from('stock s');
$this->db->join('articulos a', 'a.codigo_ss = s.codigo', 'left');
$this->db->where('s.empresa',$empresa);
$this->db->group_by('s.codigo,a.descripcion');

 $query=$this->db->get();
 return $query->result();

  }


  public function consulta_serie($dato,$empresa){
$valor = array('0');
  $this->db->select('*');
  $this->db->from('stock');
  $this->db->where('codigo',$dato);
    $this->db->where('empresa',$empresa);
$this->db->where_not_in('cantidad', $valor);
   $query=$this->db->get();
   return $query->result();

    }

    public function consulta_serie_id($dato){

    $this->db->select('cantidad');
    $this->db->from('stock');
    $this->db->where('idstock',$dato);

     $query=$this->db->get();
     return $query->result();

      }




      public function get_consulta($id,$empresa){

      $this->db->select('serie');
      $this->db->from('consumo_salida_det');
      $this->db->where('empresa',$empresa);
            $this->db->where('numero',$id);
       $query=$this->db->get();
       return $query->result();

        }


    public function editar($empresa,$equipo,$user_tic,$usuario,$area,$descripcion,$correlativo){
      $datos = array(


        'descripcion' => $descripcion,
        'equipo' => $equipo,
        'tecnico' => $user_tic,
        'usuario' => $usuario,
        'area' =>$area
                    );
                      $this->db->where('empresa', $empresa);
                    $this->db->where('numero', $correlativo);
                    $this->db->update('consumo_salida',$datos);
                    if ($this->db->affected_rows()>0) {
                      echo "1";
                    }else {
                      return 0;
                    }

    }





    public function get_detalle_salida($correlativo,$empresa){

    $this->db->select('a.codigo_ss,a.descripcion as articulos,s.descripcion dt,cd.idsalida_det,cd.codigo,cd.numero,s.serie,cd.cantidad,cd.detalle');
    $this->db->from('consumo_salida_det as cd');
    $this->db->join('stock s', 'cd.serie = s.idstock ', 'left');
    $this->db->join('articulos a', 'a.codigo_ss = cd.codigo', 'left');
    $this->db->where('cd.numero', $correlativo);
      $this->db->where('cd.empresa', $empresa);
    $query=$this->db->get();
    return $query->result();

    }






    public function agregar($empresa,$equipo,$user_tic,$usuario,$area,$descripcion,$correlativo){
      $datos = array(
        'numero' => $correlativo ,

        'descripcion' => $descripcion,
        'equipo' => $equipo,
        'tecnico' => $user_tic,
        'usuario' => $usuario,
        'area' =>$area,
        'empresa' => $empresa
                    );

      if($this->db->insert('consumo_salida',$datos)){
        return 1;
      }
      else{
        return 0;
      }

    }


    public function eliminar($id,$empresa){
      $this->db->where("empresa", $empresa);
      $this->db->where("numero", $id);
      $this->db->delete('consumo_salida');
      return $this->db->affected_rows();

    }



    public function Actualizar_stock($serie,$total){

  $data = array('cantidad' => $total);

  $this->db->where('idstock', $serie);
    $this->db->update('stock', $data);
    if ($this->db->affected_rows()>0) {
      echo "1";
    }else {
      return 0;
    }

    }

//-------------


//---------

    public function agregar_detalle($numero,$serie,$cantidad,$retiro,$empresa,$codigo){
      $datos = array(
        'numero' => $numero ,
        'serie' => $serie,
        'cantidad' => $cantidad,
        'detalle' => $retiro,
        'codigo' => $codigo,
        'empresa' => $empresa
                    );

      if($this->db->insert('consumo_salida_det',$datos)){
        return 1;
      }
      else{
        return 0;
      }

    }




    public function actualizar_detalle($id,$serie,$cantidad,$retiro,$empresa,$codigo){

  $data = array(

          'codigo' => $codigo,
          'serie' => $serie,
          'cantidad' => $cantidad,
         'detalle' => $retiro

        );

  $this->db->where('idsalida_det', $id);
    $this->db->update('consumo_salida_det', $data);
    if ($this->db->affected_rows()>0) {
      echo "1";
    }else {
      return 0;
    }

    }





    public function eliminar_det($id){

      $this->db->where("idsalida_det", $id);
      $this->db->delete('consumo_salida_det');
      return $this->db->affected_rows();

    }



        public function eliminar_det_cab($id,$empresa){

          $this->db->where("numero", $id);
            $this->db->where("empresa", $empresa);
          $this->db->delete('consumo_salida_det');
          return $this->db->affected_rows();

        }



    public function actualiza_stock($serie,$cantidad){



$this->db->query("UPDATE stock set cantidad = cantidad + ".$cantidad." where serie = '".$serie."'");

    if ($this->db->affected_rows()>0) {
      echo "1";
    }else {
      return 0;
    }

    }



    public function actualiza_stock_cab($serie,$cantidad){



$this->db->query("UPDATE stock set cantidad = cantidad + ".$cantidad." where idstock = '".$serie."'");

    if ($this->db->affected_rows()>0) {

    }else {
      return 0;
    }

    }








}
