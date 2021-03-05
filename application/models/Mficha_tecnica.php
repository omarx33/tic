<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mficha_tecnica extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  public function getficha($inicio,$fin,$empresa){
    $inicio = date('Y-m-d',strtotime($inicio));

    $fin = date('Y-m-d'." ".'23:59:00',strtotime($fin));

   $this->db->select('ft.nro_requerimiento,ft.centro_costo,ft.area,ft.nro_requerimiento,ft.descripcion as descripcion_ficha,u.idusuario,ft.usuario_tic,ft.id_ficha,
   ft.correlativo,ft.fecha_creacion,CONCAT(u.nombres, " ", u.apellidos) as fullname,e.descripcion as empresa,e.idempresa');
   $this->db->from('ficha_tecnica ft');
  // $this->db->join('area a', 'ft.area = a.idarea');
   $this->db->join('usuario u', 'u.idusuario = ft.solicitante','left');
   $this->db->join('empresa e', 'e.idempresa = ft.empresa','left');
  // $this->db->join('usuario as ut', 'ut.idusuario = ft.usuario_tic','left');

  $this->db->where('ft.empresa', $empresa);
        $this->db->where("ft.fecha_creacion BETWEEN '".$inicio."' AND '".$fin."'");
   $query=$this->db->get();
  $temporal=$query->result();
  return $temporal;
  }


  public function getarea(){
    $this->db->select('*');
    $this->db->from('area');
    $query=$this->db->get();
    return $query->result();

  }

  public function getarticulo(){
    $this->db->select('*');
    $this->db->from('articulos');
    $this->db->where('estado', "01");
    $query=$this->db->get();
    return $query->result();

  }







  public function consulta_area($dato){
    $codrise = array('000001','000002','000003','000014','000015','000016','020101','020102','020103','020201',
 '050101','050102','050103','050201','050202','050203','010001','020202','020203','030101','030102','030103','030201',
 '030202','030203','040000','040101','040102','040103','040201','040202','040203','050000','000024','000025','070000',
 '060001','060002','060003','060004','060005','060006','060007','060008','060009','060010','060011','060012','060013',
 '060014','060015','060016','080000','090101','090102','090103','090200','090300','060017','060018','060019','060020',
 '060021','100101','100102','100103','100201','100202','100203','100000','090400','110000','120000','000023');

   $rockdrill = array('000012','000013','000014','000015','010001','000016','000017','000018','000019','000020',
 '000021','000022','000023','100102','000025','000026','000027','000028','000029','000030','000031','000032','000033',
 '000034','000035','000036','000037','100114','100115','100116','000001','000002','000003','000004','000005','000006',
 '000007','000008','000009','000010','000011','020011','020012','020013','020014','000038','100120','100122','100123',
 '100124','000040','000039','000041','000042','000043','020015','000044','030001','030002','030003','030004','030005',
 '030006','000045','000046','100125','000047');

  $helix = array('100101','100102','100103','100104','100105','100106','100107','100108','100109','100110','100111','100112','100113');

      $bdcontabilidad=$this->load->database('004contabilidad',TRUE);
 $bdcontabilidad->select('*');
 if ($dato == '2') {
    $bdcontabilidad->from('010BDCONTABILIDAD.dbo.CENTRO_COSTOS');
  //$bdcontabilidad->where_not_in('CENCOST_CODIGO', $codrise);
 } elseif ($dato == '3') {
     $bdcontabilidad->from('004BDCONTABILIDAD.dbo.CENTRO_COSTOS');
    //   $bdcontabilidad->where_not_in('CENCOST_CODIGO', $rockdrill);
 }else{
  $bdcontabilidad->from('018BDCONTABILIDAD.dbo.CENTRO_COSTOS');
//  $bdcontabilidad->where_in('CENCOST_CODIGO', $helix);
 }

 $bdcontabilidad->where('len(cencost_codigo)',6);
 $query=$bdcontabilidad->get();
  return $query->result();




  }


public function busca_area($valor,$empresa){
$bdcontabilidad=$this->load->database('004contabilidad',TRUE);
  switch ($empresa) {
    case '2':
    $query = $bdcontabilidad->query("SELECT * from [010BDCONTABILIDAD].dbo.CENTRO_COSTOS where len(cencost_codigo)=6 and CENCOST_CODIGO ='".$valor."'");
      break;
      case '3':
        $query = $bdcontabilidad->query("SELECT * from [004BDCONTABILIDAD].dbo.CENTRO_COSTOS where len(cencost_codigo)=6 and CENCOST_CODIGO ='".$valor."'");
        break;
    default:
    $query = $bdcontabilidad->query("SELECT * from [018BDCONTABILIDAD].dbo.CENTRO_COSTOS where len(cencost_codigo)=6 and CENCOST_CODIGO ='".$valor."'");
      break;
  }

 return $numerodefilas=$query->row('CENCOST_DESCRIPCION');

}



  public function ficha_tecnica($empresa,$solicitante,$correlativo,$usuario,$descripcion,$area1,$requerimiento,$centro_costo){
    $datos = array(
      'correlativo' => $correlativo ,
      'area' => $area1,
      'solicitante' => $solicitante,
      'usuario_tic' => $usuario,
      'empresa' => $empresa,
      'descripcion' => $descripcion,
      'nro_requerimiento' =>$requerimiento,
      'centro_costo' => $centro_costo
                  );

    if($this->db->insert('ficha_tecnica',$datos)){
      return 1;
    }
    else{
      return 0;
    }

  }






  public function save_detalle($descripcion,$fuente,$precio_ref,$cantidad,$comentario){
    $data = array(
      'descripcion' => $descripcion ,
      'fuente' => $fuente,
      'precio_ref' => $precio_ref,
      'cantidad' => $cantidad,
      'comentario' => $comentario
                  );

    if($this->db->insert('ficha_detalle', $data)){
      echo "Se agrego el registro";
    }
    else{
      return 0;
    }

  }


  public function editar_ficha($empresa,$solicitante,$correlativo,$usuario,$descripcion,$area1,$requerimiento,$centro_costo){
    $data = array(
      'area' => $area1,
      'solicitante' => $solicitante,
      'empresa' => $empresa,
      'descripcion' => $descripcion,
      'nro_requerimiento' =>$requerimiento,
      'centro_costo' =>$centro_costo
                  );
                    $this->db->where('empresa', $empresa);
                  $this->db->where('correlativo', $correlativo);
                  $this->db->update('ficha_tecnica',$data);
                  if ($this->db->affected_rows()>0) {
                    echo "1";
                  }else {
                    return 0;
                  }

  }




  public function eliminar($id,$empresa){
    $this->db->where("empresa", $empresa);
    $this->db->where("correlativo", $id);
    $this->db->delete('ficha_tecnica');
    return $this->db->affected_rows();

  }

 public function eliminar_cab_det($id,$empresa){
   $this->db->where("correlativo", $id);
   $this->db->where("empresa", $empresa);
   $this->db->delete('ficha_detalle');
   return $this->db->affected_rows();
 }

  public function eliminar_det($id){

    $this->db->where("idficha", $id);
    $this->db->delete('ficha_detalle');
    return $this->db->affected_rows();

  }


  public function eliminar_stock($id,$empresa){
    $this->db->where("empresa", $empresa);
    $this->db->where("correlativo", $id);
    $this->db->delete('stock');
    return $this->db->affected_rows();

  }


  public function stock($id){

    $this->db->where("ficha_detalle", $id);
    $this->db->delete('stock');
    return $this->db->affected_rows();

  }


  public function get_detalle_ficha($correlativo,$empresa){

  $this->db->select('a.imagen as imagen,fd.correlativo,fd.idficha,a.codigo_ss,fd.descripcion,fd.precio_ref,fd.fuente,fd.cantidad,fd.comentario,fd.estado,fd.img,a.descripcion as nom_img');
  $this->db->from('ficha_detalle fd');
  $this->db->join('articulos a', 'fd.img = a.idarticulos', 'left');
//  $this->db->join('ficha_tecnica ft', 'ft.correlativo = fd.correlativo','left');
  $this->db->where('fd.correlativo', $correlativo);
    $this->db->where('fd.empresa', $empresa);
  $query=$this->db->get();
  return $query->result();

  }
//---funcion para el crontab-----
  public function Actualizar_estado(){
$estado = '01';
$data = array('estado' => $estado );

  $this->db->where('tipo',2);
$this->db->where('estado !=', '02');
  $this->db->update('usuario', $data);
  if ($this->db->affected_rows()>0) {
    echo "1";
  }else {
    return 0;
  }

  }

  public function Actualizar_estado_noche(){
$estado = '03';
$data = array('estado' => $estado );

  $this->db->where('tipo',2);
  $this->db->where('estado !=', '02');
  $this->db->update('usuario', $data);
  if ($this->db->affected_rows()>0) {
    echo "1";
  }else {
    return 0;
  }

  }
//-------fin-------


  public function update_detalle_ficha($id_detalle,$descripcion,$fuente,$precio_ref,$correlativo2,$cantidad,$comentario,$img){

    $data = array(
      'descripcion' => $descripcion,
      'cantidad' => $cantidad,
      'precio_ref' => $precio_ref,
      'fuente' => $fuente,
      'comentario' => $comentario,
      'img' => $img
                  );
                  $this->db->where('idficha', $id_detalle);
                  $this->db->update('ficha_detalle',$data);
                  if ($this->db->affected_rows()>0) {
                    echo "1";
                  }else {
                    return 0;
                  }
  }





  public function recibe_datos($id,$empresa){

  $query = $this->db->query("SELECT ft.centro_costo,a.descripcion as producto,a.codigo_ss,fd.correlativo,fd.descripcion as d_tecnica,fd.cantidad,fd.precio_ref,fd.comentario from ficha_detalle as fd
inner join ficha_tecnica as ft on ft.correlativo=fd.correlativo
inner join articulos as a on fd.img=a.idarticulos where fd.correlativo='".$id."' and ft.empresa='".$empresa."' and fd.empresa='".$empresa."'");
return $query->result();
  }







}
