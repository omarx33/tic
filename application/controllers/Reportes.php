<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->library('session');
  $this->load->library('Pdf');
  $this->load->model(array('Mdocumento','Mcomponente','Mreporte'));

  }

  function index()
  {

  }
  public function pFicha_tecnica(){
  $id = $_GET['correlativo'];
  $empresa = $_GET['empresa'];

  $paper_size = array(0,0,0,-1);
  $data['cabecera']=$this->Mdocumento->get_cabecera($id,$empresa);
  $data['detalle']=$this->Mdocumento->get_detalle($id,$empresa);

  $html_content = $this->load->view('pdf/ficha_tecnica', $data,TRUE);

      $this->pdf->set_paper($paper_size);
      $this->pdf->set_paper('A4','letter');
      ini_set("memory_limit","10000M");
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("tecnica.pdf", array("Attachment"=>0)); // asigna el nombre al archivo



  }

  public function planilla_movilidad($id){

  $paper_size = array(0,0,0,-1);
  $query=$this->db->query('select * from planilla_movilidad where docentry like "'.$id.'" ');
  $data['cabecera']=$query->row();
  $data['detalle']= $this->db->query('select *, (select concat(nombres," ",apellidos) from usuario where idusuario=t1.usuario) as usuario_nom from planilla_gastos t1 where t1.planilla like "'.$id.'"')->result();

  $html_content = $this->load->view('pdf/planilla_movilidad', $data,TRUE);

      $this->pdf->set_paper($paper_size);
      $this->pdf->set_paper('A4','landscape');
      ini_set("memory_limit","10000M");
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("tecnica.pdf", array("Attachment"=>0)); // asigna el nombre al archivo



  }


  public function cargo_asignacion($id){
$query1=$this->db->query('SELECT t1.*,(select concat(nombres," ",apellidos) from usuario where idusuario=t1.usuario) "nom_usuario",(select cargo from usuario where idusuario=t1.usuario) "cargo_usuario", (select razon_social from empresa where idempresa=t1.empresa) "razon_social"
, (select ruc_empresa from empresa where idempresa=t1.empresa) "ruc", (select nombre_equipo from equipo_tic where docentry=t1.equipo) "nom_equipo" , (select descripcion from area where idarea=t1.area) "nom_area"  FROM asignacion_equipo t1 where t1.docentry="'.$id.'"');
$datos['cabecera']=$query1->row();

$query=$this->db->query("SELECT t1.*,(select descripcion from componente where idcomponente=t1.tipo_componente) as 'nom_componente' FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and t1.tipo_componente not in(5,6,7,8,4) and t0.equipoid=".$query1->row('equipo'));
$dd=0;
$ram=0;
$video=0;
$query2=$this->db->query("SELECT t1.*,(select t2.descripcion from componente t2 where idcomponente=t1.tipo_componente) as 'nom_componente' FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and (t1.tipo_componente=5 or t1.tipo_componente=6) and t0.equipoid=".$query1->row('equipo'));
$query3=$this->db->query("SELECT t1.*,(select t2.descripcion from componente t2 where idcomponente=t1.tipo_componente) as 'nom_componente' FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and t1.tipo_componente in(7,8,4) and t0.equipoid=".$query1->row('equipo'));
$especificaciones=json_decode($this->Mcomponente->especificaciones($query1->row('equipo')));
foreach ($especificaciones as $key2) {
  $dd=$dd+$key2->capac_dd;
  if ($query3->row('tipo_componente')==7) {
    $dd=$dd+$query3->row('capacidad');
  }
  $ram=$ram+$key2->capac_mr;
  if ($query3->row('tipo_componente')==4) {
    $ram=$ram+$query3->row('capacidad');
  }
  $video=$video+$key2->capac_tj;
  if ($query3->row('tipo_componente')==8) {
    $video=$video+$query3->row('capacidad');
  }

}
$data['componente']=$query2->row('nom_componente');
$data['descripcion']=$query2->row('descripcion').'/RAM: '.$ram.'GB/DD: '.$dd.'GB/VIDEO: '.$video.'GB';
$data['ccontable']=$query2->row('codigo_contable');
$utf8carga[]=$data;
foreach ($query->result() as $key) {
  $data['componente']=$key->nom_componente;
  $data['descripcion']=$key->descripcion;
  $data['ccontable']=$key->codigo_contable;
      $utf8carga[]=$data;
}
$datos['detalle']=$utf8carga;
  $paper_size = array(0,0,0,-1);
  $html_content = $this->load->view('pdf/cargo_asignacion',$datos,TRUE);

      $this->pdf->set_paper($paper_size);
      $this->pdf->set_paper('A4','letter');
      ini_set("memory_limit","10000M");
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("tecnica.pdf", array("Attachment"=>0)); // asigna el nombre al archivo

  }

  public function cargo_traslado($id){
$query1=$this->db->query('SELECT t1.*,(select concat(nombres," ",apellidos) from usuario where idusuario=t1.usuario) "nom_usuario",(select cargo from usuario where idusuario=t1.usuario) "cargo_usuario", (select razon_social from empresa where idempresa=t1.empresa) "razon_social"
, (select correo_corporativo from empresa where idempresa=t1.empresa) "correo",(select ruc_empresa from empresa where idempresa=t1.empresa) "ruc", (select nombre_equipo from equipo_tic where docentry=t1.equipo) "nom_equipo" , (select descripcion from area where idarea=t1.area) "nom_area"  FROM asignacion_equipo t1 where t1.docentry="'.$id.'"');
$datos['cabecera']=$query1->row();

$query=$this->db->query("SELECT t1.*,(select descripcion from componente where idcomponente=t1.tipo_componente) as 'nom_componente' FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and t1.tipo_componente not in(5,6,7,8,4) and t0.equipoid=".$query1->row('equipo'));
$dd=0;
$ram=0;
$video=0;
$query2=$this->db->query("SELECT t1.*,(select t2.descripcion from componente t2 where idcomponente=t1.tipo_componente) as 'nom_componente' FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and (t1.tipo_componente=5 or t1.tipo_componente=6) and t0.equipoid=".$query1->row('equipo'));
$query3=$this->db->query("SELECT t1.*,(select t2.descripcion from componente t2 where idcomponente=t1.tipo_componente) as 'nom_componente' FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and t1.tipo_componente in(7,8,4) and t0.equipoid=".$query1->row('equipo'));
$especificaciones=json_decode($this->Mcomponente->especificaciones($query1->row('equipo')));
foreach ($especificaciones as $key2) {
  $dd=$dd+$key2->capac_dd;
  if ($query3->row('tipo_componente')==7) {
    $dd=$dd+$query3->row('capacidad');
  }
  $ram=$ram+$key2->capac_mr;
  if ($query3->row('tipo_componente')==4) {
    $ram=$ram+$query3->row('capacidad');
  }
  $video=$video+$key2->capac_tj;
  if ($query3->row('tipo_componente')==8) {
    $video=$video+$query3->row('capacidad');
  }

}
$data['componente']=$query2->row('nom_componente');
$data['descripcion']=$query2->row('descripcion').'/RAM: '.$ram.'GB/DD: '.$dd.'GB/VIDEO: '.$video.'GB';
$data['ccontable']=$query2->row('codigo_contable');
$utf8carga[]=$data;
foreach ($query->result() as $key) {
  $data['componente']=$key->nom_componente;
  $data['descripcion']=$key->descripcion;
  $data['ccontable']=$key->codigo_contable;
      $utf8carga[]=$data;
}
$datos['detalle']=$utf8carga;
  $paper_size = array(0,0,0,-1);
  $html_content = $this->load->view('pdf/cargo_traslado',$datos,TRUE);

      $this->pdf->set_paper($paper_size);
      $this->pdf->set_paper('A4','letter');
      ini_set("memory_limit","10000M");
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("tecnica.pdf", array("Attachment"=>0)); // asigna el nombre al archivo

  }


  public function tbl_csm_empresa(){
    $mes = $this->input->post('mes');
    $anio = $this->input->post('anio');
    $empresa = $this->input->post('empresa');

    $data = array(
      'csm_empresa' => $this->Mreporte->consumoEmpresa($mes, $anio, $empresa),
      'csm_empresa_sqlServer' => $this->Mreporte->consumoEmpresaSQLServer($mes, $anio, $empresa),
    );
    $this->load->view('reporte/tabla/tabla_consumo_empresa', $data);
  }

  public function tbl_csm_area(){
    $mes = $this->input->post('mes');
    $anio = $this->input->post('anio');
    $empresa = $this->input->post('empresa');
    $area = $this->input->post('area');

    $data = array(
      'csm_area' => $this->Mreporte->consumoArea($mes, $anio, $empresa, $area),
      'csm_area_sqlServer' => $this->Mreporte->consumoAreaSQLServer($mes, $anio, $empresa, $area),
    );
    $this->load->view('reporte/tabla/tabla_consumo_area', $data);
  }
}
