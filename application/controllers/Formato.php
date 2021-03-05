<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formato extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
        $this->load->model('Mformato');
        $this->load->library('Email');
  }

  function index()
  {

  }
  public function correlativo_formato(){
    $tipo=$this->input->post('tipo');
    $contrato=$this->session->userdata('alm_id');
    $año=date('Y');

    if ($tipo==1) {
      $query=$this->db->query('SELECT num_formato FROM SOL_CAB WHERE estado=9 and num_formato!="" and contrato="'.$contrato.'" and num_formato not in (select num_formato from LER_CAB where contrato="'.$contrato.'")');
      if ($query->num_rows()>0) {
        echo json_encode($query->result());
      } else {
        echo 0;
      }

  } else {
      $query=$this->db->query('SELECT correlativo FROM correlativo_formato WHERE formato="'.$this->input->post('tipo').'" and contratoid ="'.$contrato.'"');
      $correlativo=$query->row('correlativo');
      $cc=substr($this->session->userdata('alm_cc'),-3);
    echo $año.$cc.'-'.str_pad($correlativo, 3, "0", STR_PAD_LEFT);
    }


  }
  public function save_sol(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $cabecera['fecha_registro']=date('Y-m-d H:i:s');
    $cabecera['contrato']=$this->session->userdata('alm_id');
    $cabecera['solicitante']=$this->input->post('solicitante');

    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');

    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
      $cabecera['rango_fecha']=$this->input->post('delfecha').'-'.$this->input->post('alfecha');
    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    $cabecera['moneda']=$this->input->post('moneda');
    if ($this->input->post('tipo_titular')=='mismo') {
      $cabecera['titular_nom']=$this->input->post('tipo_titular');
    }else {
      $cabecera['titular_nom']=$this->input->post('titular_nom');
    }
    if ($this->input->post('banco')=='bcp' or $this->input->post('banco')=='scotiabank') {
      $cabecera['banco']=$this->input->post('banco');
    }else {
      $cabecera['banco']=$this->input->post('otro_banco');
    }
    $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    $cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['reseña']=$this->input->post('reseña');
    $cabecera['estado']=1;

    $this->Mformato->save_sol($cabecera,$detalle);
    $data['estado']=1;
    $data['formato']=$this->Mformato->get_sol('consulta');

    $mensaje=$this->load->view('correo/sol_entrega',$data,TRUE);
    $querydestino=$this->db->query("SELECT correo FROM usuario where usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=39 )");
    $destino=$querydestino->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Formato de Solicitud de Entrega a Rendir para aprobar');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }
  }

  public function save_sol_lima(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $cabecera['fecha_registro']=date('Y-m-d H:i:s');
    $cabecera['contrato']=$this->session->userdata('alm_id');
    if ($this->input->post('tipo_titular')=='mismo') {
      $cabecera['solicitante']=$this->input->post('tipo_titular');
    }else {
      $cabecera['solicitante']=$this->input->post('titular_nom');
    }
    if ($this->session->userdata('rol_id')==48) {
    $cabecera['gerencia']=$this->input->post('gerencia');
    }
    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');
    $cabecera['centro_costo']=$this->session->userdata('user_cc');
    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
      $cabecera['rango_fecha']=$this->input->post('delfecha').'-'.$this->input->post('alfecha');
    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    $cabecera['moneda']=$this->input->post('moneda');
    if ($this->input->post('tipo_titular')=='mismo') {
      $cabecera['titular_nom']=$this->input->post('tipo_titular');
    }else {
      $cabecera['titular_nom']=$this->input->post('titular_nom');
    }
    if ($this->input->post('banco')=='bcp' or $this->input->post('banco')=='scotiabank') {
      $cabecera['banco']=$this->input->post('banco');
    }else {
      $cabecera['banco']=$this->input->post('otro_banco');
    }
    $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    $cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['reseña']=$this->input->post('reseña');
    $cabecera['estado']=1;

    $this->Mformato->save_sol_lima($cabecera,$detalle);




    if ($this->session->userdata('rol_id')==47) {
    $data['estado']=1;
      $querydestino=$this->db->query("SELECT correo FROM usuario where centro_costo='".$this->session->userdata("user_cc")."' and usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=48 )");
    } elseif ($this->session->userdata('rol_id')==48) {
    $data['estado']=10;
      $querydestino=$this->db->query("SELECT correo FROM usuario where documento='".$this->input->post("gerencia")."' ");
    }elseif ($this->session->userdata('rol_id')==49) {
    $data['estado']=11;
      $querydestino=$this->db->query("SELECT correo_cc as 'correo' FROM estado_formato where docentry='5'");
    }
    $data['formato']=$this->Mformato->get_sol('consulta');
    $destino=$querydestino->row('correo');
        $mensaje=$this->load->view('correo/sol_entrega',$data,TRUE);
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Formato de Solicitud de Entrega a Rendir para aprobar');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }
  }

  public function update_sol(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    //$cabecera['fecha_registro']=date('Y-m-d H:i:s');
  //  $cabecera['contrato']=$this->session->userdata('alm_id');
    $querycontrato=$this->db->query('SELECT contrato FROM SOL_CAB where num_formato like "'.$cabecera['num_formato'].'"')->row('contrato');
    if ($querycontrato==204) {
      if ($this->input->post('tipo_titular')=='mismo') {
        $cabecera['solicitante']=$this->input->post('tipo_titular');
      }else {
        $cabecera['solicitante']=$this->input->post('titular_nom');
      }
    }else {
    $cabecera['solicitante']=$this->input->post('solicitante');
    }


    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');

    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
      $cabecera['rango_fecha']=$this->input->post('delfecha').'-'.$this->input->post('alfecha');

    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    $cabecera['moneda']=$this->input->post('moneda');
    if ($this->input->post('tipo_titular')=='mismo') {
      $cabecera['titular_nom']=$this->input->post('tipo_titular');
    }else {
      $cabecera['titular_nom']=$this->input->post('titular_nom');
    }
    if ($this->input->post('banco')=='bcp' or $this->input->post('banco')=='scotiabank') {
      $cabecera['banco']=$this->input->post('banco');
    }else {
      $cabecera['banco']=$this->input->post('otro_banco');
    }
    $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    //$cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['reseña']=$this->input->post('reseña');
    //$cabecera['estado']=1;

    echo $this->Mformato->update_sol($this->input->post('ler_cab'),$cabecera,$detalle);
  }
  public function save_ler(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $cabecera['fecha_registro']=date('Y-m-d H:i:s');
    $cabecera['contrato']=$this->session->userdata('alm_id');
    $cabecera['solicitante']=$this->input->post('solicitante');
    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');

    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
    }elseif ($this->input->post('motivo')=='2') {
      $cabecera['motivo']='A RENDIR CUENTA';
    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    $cabecera['moneda']=$this->input->post('moneda');
    $cabecera['banco']=$this->input->post('banco');

    //$cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    $cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['estado']=1;
    $cabecera['observaciones']=$this->input->post('observaciones');

    $this->Mformato->save_ler($cabecera,$detalle);
    $data['estado']=1;
    $data['formato']=$this->Mformato->get_ler('consulta');

    $mensaje=$this->load->view('correo/liquidacion_entrega',$data,TRUE);
    $querydestino=$this->db->query("SELECT correo FROM usuario where usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=39 )");
    $destino=$querydestino->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Formato de Liquidación de Entrega a Rendir para aprobar');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }
  }
  public function save_ler_lima(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $cabecera['fecha_registro']=date('Y-m-d H:i:s');
    $cabecera['contrato']=$this->session->userdata('alm_id');
    $cabecera['solicitante']=$this->input->post('solicitante');
    if ($this->session->userdata('rol_id')==48) {
    $cabecera['gerencia']=$this->input->post('gerencia');
    }
    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');
    $cabecera['centro_costo']=$this->session->userdata('user_cc');
    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
    }elseif ($this->input->post('motivo')=='2') {
      $cabecera['motivo']='A RENDIR CUENTA';
    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    $cabecera['moneda']=$this->input->post('moneda');
    $cabecera['banco']=$this->input->post('banco');

    //$cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    $cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['estado']=1;
    $cabecera['observaciones']=$this->input->post('observaciones');

    $this->Mformato->save_ler_lima($cabecera,$detalle);

    if ($this->session->userdata('rol_id')==47) {
    $data['estado']=1;
      $querydestino=$this->db->query("SELECT correo FROM usuario where centro_costo='".$this->session->userdata("user_cc")."' and usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=48 )");
    } elseif ($this->session->userdata('rol_id')==48) {
    $data['estado']=10;
      $querydestino=$this->db->query("SELECT correo FROM usuario where documento='".$this->input->post("gerencia")."' ");
    }elseif ($this->session->userdata('rol_id')==49) {
    $data['estado']=11;
      $querydestino=$this->db->query("SELECT correo_cc as 'correo' FROM estado_formato where docentry='7'");
    }
    $data['formato']=$this->Mformato->get_ler('consulta');
        $mensaje=$this->load->view('correo/liquidacion_entrega',$data,TRUE);
    $destino=$querydestino->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Formato de Liquidación de Entrega a Rendir para aprobar');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }
  }
  public function update_ler(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $querycontrato=$this->db->query('SELECT contrato FROM LER_CAB where num_formato like "'.$cabecera['num_formato'].'"')->row('contrato');
    if ($querycontrato==204) {
      $cabecera['solicitante']=$this->input->post('solicitanteid');
      if ($this->session->userdata('rol_id')==48) {
      $cabecera['gerencia']=$this->input->post('gerencia');
      }
    }else {
    $cabecera['solicitante']=$this->input->post('solicitante');
    }
    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');

    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
    }elseif ($this->input->post('motivo')=='2') {
      $cabecera['motivo']='A RENDIR CUENTA';
    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    $cabecera['moneda']=$this->input->post('moneda');
    $cabecera['banco']=$this->input->post('banco');

  //  $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    //$cabecera['usuario']=$this->session->userdata('user_id');
  //$cabecera['estado']=1;
    $cabecera['observaciones']=$this->input->post('observaciones');
    echo $this->Mformato->update_ler($this->input->post('ler_cab'),$cabecera,$detalle);

  }

  public function eliminar_formato(){
    $this->db->where('docentry',$this->input->post('id'));
    $this->db->set('estado',0);
    if ($this->input->post('tipo')==1) {
          $this->db->update('LER_CAB');
    } elseif ($this->input->post('tipo')==2) {
          $this->db->update('FF_CAB');
    }elseif ($this->input->post('tipo')==4) {
          $this->db->update('SOL_CAB');
    }elseif ($this->input->post('tipo')==3) {
        $this->db->update('SOLSER_CAB');
    }


    if ($this->db->affected_rows()>0) {
      echo "eliminado";
    }
  }

  public function save_ff(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $cabecera['fecha_registro']=date('Y-m-d H:i:s');
    $cabecera['contrato']=$this->session->userdata('alm_id');
    $cabecera['solicitante']=$this->input->post('solicitante');

    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');

    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    $cabecera['monto_asignado']=$this->input->post('monto_asignado');
    if ($this->input->post('banco')=='bcp' or $this->input->post('banco')=='scotiabank') {
      $cabecera['banco']=$this->input->post('banco');
    }else {
      $cabecera['banco']=$this->input->post('otro_banco');
    }
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    $cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['estado']=1;
    $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
    $this->Mformato->save_ff($cabecera,$detalle);
    $data['estado']=1;
    $data['formato']=$this->Mformato->get_ff('consulta');

    $mensaje=$this->load->view('correo/liquidacion_fondo',$data,TRUE);
    $querydestino=$this->db->query("SELECT correo FROM usuario where usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=39 )");
    $destino=$querydestino->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Formato de Liquidación de Fondo Fijo para aprobar');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }

  }
  public function save_ff_lima(){

  $detalle=json_decode($this->input->post('tbldetalle'));
  $cabecera['num_formato']=$this->input->post('numeracion');
  $cabecera['fecha_liquidacion']=$this->input->post('fecha');
  $cabecera['fecha_registro']=date('Y-m-d H:i:s');
  $cabecera['contrato']=$this->session->userdata('alm_id');
  $cabecera['solicitante']=$this->input->post('solicitante');
  if ($this->session->userdata('rol_id')==48) {
  $cabecera['gerencia']=$this->input->post('gerencia');
  }
  $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');
  $cabecera['centro_costo']=$this->session->userdata('user_cc');
  $cabecera['dni_solicitante']=$query_solicitante->row('dni');
  $cabecera['area_solicitante']=$query_solicitante->row('area');
  $cabecera['monto_asignado']=$this->input->post('monto_asignado');
  if ($this->input->post('banco')=='bcp' or $this->input->post('banco')=='scotiabank') {
    $cabecera['banco']=$this->input->post('banco');
  }else {
    $cabecera['banco']=$this->input->post('otro_banco');
  }
  $cabecera['cta_bancaria']=$this->input->post('cuenta');
  $cabecera['usuario']=$this->session->userdata('user_id');
  $cabecera['estado']=1;
  $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');
  $this->Mformato->save_ff_lima($cabecera,$detalle);


  if ($this->session->userdata('rol_id')==47) {
  $data['estado']=1;
    $querydestino=$this->db->query("SELECT correo FROM usuario where centro_costo='".$this->session->userdata("user_cc")."' and usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=48 )");
  } elseif ($this->session->userdata('rol_id')==48) {
  $data['estado']=10;
    $querydestino=$this->db->query("SELECT correo FROM usuario where documento='".$this->input->post("gerencia")."' ");
  }elseif ($this->session->userdata('rol_id')==49) {
  $data['estado']=11;
    $querydestino=$this->db->query("SELECT correo_cc as 'correo' FROM estado_formato where docentry='7'");
  }
  $data['formato']=$this->Mformato->get_ff('consulta');

  $mensaje=$this->load->view('correo/liquidacion_fondo',$data,TRUE);
  $destino=$querydestino->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Liquidación de Fondo Fijo para aprobar');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}

  public function update_ff(){

    $detalle=json_decode($this->input->post('tbldetalle'));
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_liquidacion']=$this->input->post('fecha');
    $querycontrato=$this->db->query('SELECT contrato FROM LER_CAB where num_formato like "'.$cabecera['num_formato'].'"')->row('contrato');
    if ($querycontrato==204) {
      $cabecera['solicitante']=$this->input->post('solicitanteid');
      if ($this->session->userdata('rol_id')==48) {
      $cabecera['gerencia']=$this->input->post('gerencia');
      }
    }else {
    $cabecera['solicitante']=$this->input->post('solicitante');
    }

    $query_solicitante=$this->db->query('SELECT * FROM solicitantes where idsolicitante = "'.$this->input->post('solicitante').'"');

    $cabecera['dni_solicitante']=$query_solicitante->row('dni');
    $cabecera['area_solicitante']=$query_solicitante->row('area');
    if ($this->input->post('motivo')=='1') {
      $cabecera['motivo']='GASTOS DE VIAJE';
    }elseif ($this->input->post('motivo')=='2') {
      $cabecera['motivo']='A RENDIR CUENTA';
    }elseif ($this->input->post('motivo')=='3') {
      $cabecera['motivo']=$this->input->post('rendir_otro');
    }
    if ($this->input->post('banco')=='bcp' or $this->input->post('banco')=='scotiabank') {
      $cabecera['banco']=$this->input->post('banco');
    }else {
      $cabecera['banco']=$this->input->post('otro_banco');
    }
    $cabecera['cta_bancaria']=$this->input->post('cuenta');
    $cabecera['tipo_cuenta_bca']=$this->input->post('tipo_cuenta_bca');

    //$cabecera['usuario']=$this->session->userdata('user_id');
  //  $cabecera['estado']=1;

    echo $this->Mformato->update_ff($this->input->post('ler_cab'),$cabecera,$detalle);
  }
  public function save_solser(){
    $cabecera['num_formato']=$this->input->post('numeracion');
    $cabecera['fecha_registro']=date('Y-m-d');
    $cabecera['contrato']=$this->session->userdata('alm_id');
    $cabecera['usuario']=$this->session->userdata('user_id');
    $cabecera['estado']=1;
    $cabecera['status_contrato']='';
    $cabecera['tipo_servicio']=$this->input->post('tipo_servicio');
    $cabecera['fecha_inicio']=date('Y-m-d',strtotime(str_replace('/','-',substr($this->input->post('fecha'),0,10))));
    $cabecera['fecha_fin']=date('Y-m-d',strtotime(str_replace('/','-',substr($this->input->post('fecha'),-10))));
    $cabecera['tipo_contrato']=$this->input->post('tipo_contrato');
    $cabecera['tipo_pago']=$this->input->post('pago');
    $cabecera['comp_pago']=$this->input->post('comp_pago');
    $cabecera['codigo_prov']=$this->input->post('codigo_prov');
    $cabecera['desc_prov']=$this->input->post('desc_prov');
    $cabecera['direccion_prov']=$this->input->post('direccion_prov');
    $cabecera['contacto_prov']=$this->input->post('contacto_prov');
    $cabecera['email_prov']=$this->input->post('email_prov');
    $cabecera['telefono_prov']=$this->input->post('telefono_prov');
    $cabecera['banco_prov']=$this->input->post('banco_prov');
    $cabecera['cuenta_prov']=$this->input->post('cuenta_prov');
    $cabecera['consulta_igv']=$this->input->post('IGV');
    $cabecera['observaciones']=$this->input->post('observaciones');
    $cabecera['detalle']=($this->input->post('tbldetalle'));
    $cabecera['detalle_add']=($this->input->post('detalle_ad'));
    $cabecera['numero_contrato']='';
    $cabecera['fecha_envio_contrato']='';
    $cabecera['termino_contrato']='';
    $this->db->insert('SOLSER_CAB',$cabecera);

    $firma = array('num_formato' => $cabecera['num_formato'],
                   'tipo_formato'=>3,
                   'firma_solicitante'=>$this->session->userdata('documento'),
                   'contrato'=>$this->session->userdata('alm_id'),
                   'fecha_solicitante'=>date("Y-m-d H:i:s"));

                   $this->db->insert('firmas_formato',$firma);

          $this->db->set('correlativo','correlativo+1',FALSE);
          $this->db->where('contratoid',$cabecera['contrato']);
          $this->db->where('formato', 3);
          $this->db->update('correlativo_formato');
          $data['estado']=1;
          $data['formato']=$this->Mformato->get_solser('consulta');

          $mensaje=$this->load->view('correo/sol_servicios',$data,TRUE);
          $querydestino=$this->db->query("SELECT correo FROM usuario where usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=39 )");
          $destino=$querydestino->row('correo');
            $config['protocol'] = 'smtp';
            $config["smtp_host"] = 'ssl://smtp.gmail.com';
            $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
            $config["smtp_pass"] = 'local258';
            $config["smtp_port"] = '465';
            $config['charset'] = 'UTF-8';
            $config['wordwrap'] = TRUE;
            $config['smtp_timeout'] = '25';
            $config['validate'] = true;
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('aplicaciones@rockdrillgroup.com');
            $this->email->to($destino);
            $this->email->subject('Formato de Solicitud de Servicio para aprobar');
            $this->email->cc('');
            $this->email->message($mensaje);
            $this->email->set_mailtype('html');
            $this->email->attach('');
              if($this->email->send()){
                       return 'enviado';
                     }
                       else{
                         echo $this->email->print_debugger();
                       }

  }
  public function update_solser(){
    $cabecera['num_formato']=$this->input->post('numeracion');
  //  $cabecera['fecha_registro']=date('Y-m-d');
  //  $cabecera['contrato']=$this->session->userdata('alm_id');
    //$cabecera['usuario']=$this->session->userdata('user_id');
    //$cabecera['estado']=1;
    $cabecera['status_contrato']=$this->input->post('status');
    $cabecera['tipo_servicio']=$this->input->post('tipo_servicio');
    $cabecera['fecha_inicio']=date('Y-m-d',strtotime($this->input->post('delfecha')));
    $cabecera['fecha_fin']=date('Y-m-d',strtotime($this->input->post('alfecha')));
    $cabecera['tipo_contrato']=$this->input->post('tipo_contrato');
    $cabecera['tipo_pago']=$this->input->post('pago');
    $cabecera['comp_pago']=$this->input->post('comp_pago');
    $cabecera['codigo_prov']=$this->input->post('codigo_prov');
    $cabecera['desc_prov']=$this->input->post('desc_prov');
    $cabecera['direccion_prov']=$this->input->post('direccion_prov');
    $cabecera['contacto_prov']=$this->input->post('contacto_prov');
    $cabecera['email_prov']=$this->input->post('email_prov');
    $cabecera['telefono_prov']=$this->input->post('telefono_prov');
    $cabecera['banco_prov']=$this->input->post('banco_prov');
    $cabecera['cuenta_prov']=$this->input->post('cuenta_prov');
    $cabecera['consulta_igv']=$this->input->post('IGV');
    $cabecera['observaciones']=$this->input->post('observaciones');
    $cabecera['detalle']=($this->input->post('tbldetalle'));
    $cabecera['detalle_add']=($this->input->post('detalle_ad'));
    $cabecera['numero_contrato']=$this->input->post('numero_contrato');
    $cabecera['fecha_envio_contrato']=$this->input->post('fecha_envio');
    $cabecera['termino_contrato']=$this->input->post('termino_contrato');
    $documento=$cabecera["num_formato"];

    $this->db->where('num_formato',$cabecera['num_formato']);
    $this->db->update('SOLSER_CAB',$cabecera);
    echo 1;

  }
  public function get_sol($tipo){
    echo json_encode($this->Mformato->get_sol($tipo));
  }
  public function get_ler($tipo){
    echo json_encode($this->Mformato->get_ler($tipo));
  }
  public function get_solser($tipo){
    echo json_encode($this->Mformato->get_solser($tipo));
  }
  public function get_ff($tipo){
    echo json_encode($this->Mformato->get_ff($tipo));
  }
  public function consultar_entrega_rendir(){
    $this->load->view('secciones/consultas/entrega_rendir');
  }
  public function consultar_fondo_fijo(){
    $this->load->view('secciones/consultas/fondo_fijo');
  }
  public function consultar_solicitud_entrega(){
    $this->load->view('secciones/consultas/solicitud_entrega');
  }
  public function consultar_solicitud_servicios(){
    $this->load->view('secciones/consultas/solicitud_servicios');
  }
  public function get_cabecera_ler(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_cabecera_ler($documento));
  }
  public function get_cabecera_sol(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_cabecera_sol($documento));
  }
  public function get_cabecera_solser(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_cabecera_solser($documento));
  }
  public function detalle_solser(){
        $documento=$this->input->post('id');
    $this->db->select('detalle');
    $this->db->from('SOLSER_CAB');
    //$this->db->where('contrato',$this->session->userdata('alm_id'));
    $this->db->where('num_formato',$documento);
    $detalle=$this->db->get()->row('detalle');

  //  echo (substr(substr($detalle,-1),1));
  echo $detalle;
  }
  public function detalleadd_solser(){
    $documento=$this->input->post('id');
$this->db->select('detalle_add');
$this->db->from('SOLSER_CAB');
//$this->db->where('contrato',$this->session->userdata('alm_id'));
$this->db->where('num_formato',$documento);
$detalle=$this->db->get()->row('detalle_add');

echo $detalle;
  }


  public function get_detalle_ler(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_detalle_ler($documento));
  }
  public function get_detalle_sol(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_detalle_sol($documento));
  }
  public function get_cabecera_ff(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_cabecera_ff($documento));
  }

  public function get_detalle_ff(){
    $documento=$this->input->post('id');
    echo json_encode($this->Mformato->get_detalle_ff($documento));
  }
  public function consultar_editable_solicitud_entr(){
  $documento=$this->input->post('id');
  $condicion2=$this->db->query('SELECT * FROM LER_CAB WHERE num_formato="'.$documento.'"');
  if ($condicion2->num_rows()<1) {
  $condicion=$this->db->query('SELECT estado FROM SOL_CAB WHERE num_formato="'.$documento.'"');
  if ($this->session->userdata('rol_id')==38 or $this->session->userdata('rol_id')==36 or $this->session->userdata('rol_id')==47) {//solicitante
    if ($condicion->row('estado')==1) {
      echo "si";
    }else {
      echo "no";
    }
  }
  elseif ($this->session->userdata('rol_id')==39 or $this->session->userdata('rol_id')==36 or $this->session->userdata('rol_id')==48) {//residente
    if ($condicion->row('estado')==1) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==40 or $this->session->userdata('rol_id')==36) {//operaciones
    if ($condicion->row('estado')==2) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==41 or $this->session->userdata('rol_id')==36) {//gere.operaciones
    if ($condicion->row('estado')==3) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==49) {//gerencia
    if ($condicion->row('estado')==10) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==42 or $this->session->userdata('rol_id')==36) {//finanzas
    if ($condicion->row('estado')==4) {

      echo "no";
    }
  }
  }else {
    echo "no";
  }
}
  public function consultar_editable_fondo_fijo(){
    $documento=$this->input->post('id');

    $condicion=$this->db->query('SELECT estado FROM FF_CAB WHERE num_formato="'.$documento.'"');
    if ($this->session->userdata('rol_id')==38 or $this->session->userdata('rol_id')==47) {
      if ($condicion->row('estado')==1) {
        echo "si";
      }else {
        echo "no";
      }
    }
    elseif ($this->session->userdata('rol_id')==39  or $this->session->userdata('rol_id')==48) {
      if ($condicion->row('estado')==1) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==40 ) {
      if ($condicion->row('estado')==2) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==41 ) {
      if ($condicion->row('estado')==3) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==43 ) {
      if ($condicion->row('estado')==4) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==44 or $this->session->userdata('rol_id')==42 )  {
      if ($condicion->row('estado')==7) {

        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==49) {//gerencia
      if ($condicion->row('estado')==10) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ( $this->session->userdata('rol_id')==36) {//finanzas


        echo "si";

    }

  }
  public function consultar_editable_entrega(){
  $documento=$this->input->post('id');

  $condicion=$this->db->query('SELECT estado FROM LER_CAB WHERE num_formato="'.$documento.'"');
  if ($this->session->userdata('rol_id')==38  or $this->session->userdata('rol_id')==36  or $this->session->userdata('rol_id')==47) {
    if ($condicion->row('estado')==1) {
      echo "si";
    }else {
      echo "no";
    }
  }
  elseif ($this->session->userdata('rol_id')==39  or $this->session->userdata('rol_id')==36  or $this->session->userdata('rol_id')==48) {
    if ($condicion->row('estado')==1) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==40 ) {
    if ($condicion->row('estado')==2) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==41 ) {
    if ($condicion->row('estado')==3) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==49) {//gerencia
    if ($condicion->row('estado')==10) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==43 ) {
    if ($condicion->row('estado')==4 or $condicion->row('estado')==11) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($this->session->userdata('rol_id')==44 or $this->session->userdata('rol_id')==45 ) {
    if ($condicion->row('estado')==7) {

      echo "no";
    }
  }elseif ( $this->session->userdata('rol_id')==36) {//finanzas


      echo "si";

  }
}
  public function consultar_editable_sol_servicio(){
    $documento=$this->input->post('id');

    $condicion=$this->db->query('SELECT estado FROM SOLSER_CAB WHERE num_formato="'.$documento.'"');
    if ($this->session->userdata('rol_id')==38 or $this->session->userdata('rol_id')==36) {
      if ($condicion->row('estado')==1) {
        echo "si";
      }else {
        echo "no";
      }
    }
    elseif ($this->session->userdata('rol_id')==39 or $this->session->userdata('rol_id')==36) {
      if ($condicion->row('estado')==1) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==40 or $this->session->userdata('rol_id')==36) {
      if ($condicion->row('estado')==1 or $condicion->row('estado')==3) {
        echo "si";
      }else {
        echo "no";
      }
    }elseif ($this->session->userdata('rol_id')==43 or $this->session->userdata('rol_id')==36) {
      if ($condicion->row('estado')==3) {
        echo "si";
      }else {
        echo "no";
      }
    }
  }
  public function fondofijo_finanzas(){
    $contrato=$this->input->post('contrato');
    $fondofijo=$this->db->query("SELECT num_formato FROM FF_CAB where estado=5 and contrato='".$contrato."'");
    echo json_encode($fondofijo->result());
  }

  public function fondo_asignado(){
    $documento=$this->input->post('id');

    $usuario=$this->db->query('SELECT usuario FROM FF_CAB where num_formato="'.$documento.'"');
    if ( $usuario->num_rows()>0) {
    $usuario_soli=$usuario->row('usuario');
    }else {
    $usuario_soli=$this->session->userdata('user_id');
    }
    $fondo=$this->db->query("SELECT fondo_asignado FROM usuario WHERE usuarioid like '".$usuario_soli."'");
    echo $fondo->row('fondo_asignado');
  }
  public function get_encargados_fondofijo($lugar){
    if ($lugar=='contrato') {
      $query=$this->db->query('SELECT t0.usuarioid,concat(t0.nombre," ",t0.apepat," ",t0.apemat) "fullname" ,t0.documento,t0.fondo_asignado,(SELECT nombre from contrato where contratoid=t1.contratoid) "contrato",t1.contratoid FROM usuario t0 inner join acceso_almacen t1 on t0.usuarioid=t1.usuarioid and t1.rolid=38');
    } else {
      $query=$this->db->query('SELECT distinct t0.usuarioid,concat(t0.nombre," ",t0.apepat," ",t0.apemat) "fullname" ,t0.documento,t0.fondo_asignado,(SELECT nombre from contrato where contratoid=t1.contratoid) "contrato",t1.contratoid FROM usuario t0 inner join acceso_almacen t1 on t0.usuarioid=t1.usuarioid and t1.rolid in ("47","48","49")');
    }

    ECHO json_encode($query->result());
  }
  public function reposicion_fondofijo(){
    $tipo=$this->input->post('tipo');
    $usuario=$this->input->post('usuario');
    $fecha=$this->input->post('fecha');
    $monto=$this->input->post('monto_asignado');
    $fondofijo=$this->input->post('monto_total');
    $contrato=$this->input->post('contrato');
    $num_formato=$this->input->post('fondo_fijo');
    $reposicion= array('usuario' => $usuario,
                       'contrato' => $contrato,
                       'fecha' => $fecha,
                       'fondo_fijo'=>$num_formato,
                       'monto' =>$monto);
                        $this->db->insert('reposicion_ff',$reposicion);

            if ($fondofijo!="Asignacion") {
              $this->db->set('estado',9);
              $this->db->where('num_formato',$num_formato);
              $this->db->update('FF_CAB');
            }
            if ($tipo=='asignacion') {
                       $this->db->set('fondo_fijo',$fondofijo);
            }
                       $this->db->set('fondo_asignado',$fondofijo);
                       $this->db->where('usuarioid',$usuario);
                       $this->db->update('usuario');

                       $mensaje="Se ha generado el deposito del Fondo Fijo Asignado.";
                       $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM FF_CAB where num_formato='".$num_formato."')");
                       $destino=$queryusuario->row('correo');
                         $config['protocol'] = 'smtp';
                         $config["smtp_host"] = 'ssl://smtp.gmail.com';
                         $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
                         $config["smtp_pass"] = 'local258';
                         $config["smtp_port"] = '465';
                         $config['charset'] = 'UTF-8';
                         $config['wordwrap'] = TRUE;
                         $config['smtp_timeout'] = '25';
                         $config['validate'] = true;
                         $this->email->initialize($config);
                         $this->email->set_newline("\r\n");
                         $this->email->from('aplicaciones@rockdrillgroup.com');
                         $this->email->to($destino);
                         $this->email->subject('Depósito de Fondo Fijo');
                         $this->email->cc('');
                         $this->email->message($mensaje);
                         $this->email->set_mailtype('html');
                         $this->email->attach('');
                           if($this->email->send()){
                                    return 'enviado';
                                  }
                                    else{
                                      echo $this->email->print_debugger();
                                    }
    echo "efectuado";
  }

  public function save_files(){
      $tipo=$this->input->post('tipo_formato');
      $documento=$this->input->post('num_formato');

    $carpeta = "./assets/contratos/".$tipo."/".$documento."";
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    $config = [
      "upload_path" => $carpeta,
      'allowed_types' => "gif|jpg|png|pdf|doc|docx|xlsx"
    ];
    $this->load->library("upload",$config);

    if ($this->upload->do_upload('archivo')) {

    $data = $this->upload->data();

    $archivo= array('documento'=>$documento,
                    'formato'=>$tipo,
                    'archivos'=>$data['file_name'],
                    'ruta'=>$carpeta);
                    $this->db->insert('adjunto_formato',$archivo);
    $msg='se subio correctamente el documento';
    }else{

      $msg=$this->upload->display_errors();
    }
    echo $msg;



}
public function get_files(){
  $documento=$this->input->post('id');
  $tipo=$this->input->post('tipo');
  $query=$this->db->query('SELECT * FROM adjunto_formato WHERE documento="'.$documento.'" and formato="'.$tipo.'"');
  echo json_encode($query->result());
}
public function eliminar_files(){
  $documento=$this->input->post('id');
  $archivo=$this->input->post('archivo');
  $ruta=$this->input->post('ruta');
  $tipo=$this->input->post('tipo');

  $this->db->where('documento',$documento);
  $this->db->where('formato',$tipo);
  $this->db->where('ruta',$ruta);
  $this->db->where('archivos',$archivo);
  $this->db->delete('adjunto_formato');
unlink($ruta."/".$archivo);
  echo 'Se eliminó el archivo';
}

public function aprobar_entrega_rendir($documento){
if ($this->session->userdata('rol_id')==39) {
  $data['estado']=2;
  $estadocorreo=3;
  $this->db->set('estado',2);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

  $this->db->set('firma_residente',$this->session->userdata('documento'));
  $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
  $this->db->where('num_formato',$documento);
  $this->db->where('tipo_formato',1);
  $this->db->update('firmas_formato');
}elseif ($this->session->userdata('rol_id')==41 or $this->session->userdata('rol_id')==49) {
    $data['estado']=4;
    $estadocorreo=7;
  $this->db->set('estado',4);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

  $this->db->set('firma_ger_operaciones',$this->session->userdata('documento'));
  $this->db->set('fecha_ger_operaciones',date("Y-m-d H:i:s"));
  $this->db->where('num_formato',$documento);
  $this->db->where('tipo_formato',1);
  $this->db->update('firmas_formato');
}elseif ($this->session->userdata('rol_id')==40) {
    $data['estado']=3;
    $estadocorreo=4;
  $this->db->set('estado',3);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

  $this->db->set('firma_operaciones',$this->session->userdata('documento'));
  $this->db->set('fecha_operaciones',date("Y-m-d H:i:s"));
  $this->db->where('num_formato',$documento);
  $this->db->where('tipo_formato',1);
  $this->db->update('firmas_formato');
}elseif ($this->session->userdata('rol_id')==43) {
    $data['estado']=7;
    $estadocorreo=5;
  $this->db->set('estado',7);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

  $this->db->set('firma_contabilidad',$this->session->userdata('documento'));
  $this->db->set('fecha_contabilidad',date("Y-m-d H:i:s"));
  $this->db->where('num_formato',$documento);
  $this->db->where('tipo_formato',1);
  $this->db->update('firmas_formato');
}elseif ($this->session->userdata('rol_id')==42) {
    $data['estado']=5;
    $estadocorreo='';
  $this->db->set('estado',5);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

  $this->db->set('firma_ger_administrativa',$this->session->userdata('documento'));
  $this->db->set('fecha_ger_administrativa',date("Y-m-d H:i:s"));
  $this->db->where('num_formato',$documento);
  $this->db->where('tipo_formato',1);
  $this->db->update('firmas_formato');

  $mensaje="El Formato de Liquidación de Entrega a Rendir N°".$documento." ha sido aprobado por todas las áreas involucradas";
  $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM LER_CAB where num_formato='".$documento."')");
  $destino=$queryusuario->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Confirmación de Aprobación del Formato de Liquidación de Entrega a Rendir N°'.$documento.' !!');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}

$data['formato']=$this->Mformato->get_ler('consulta');

$mensaje=$this->load->view('correo/liquidacion_entrega',$data,TRUE);
$querydestino=$this->db->query("SELECT correo_cc FROM estado_formato where docentry='".$estadocorreo."'");
$destino=$querydestino->row('correo_cc');
  $config['protocol'] = 'smtp';
  $config["smtp_host"] = 'ssl://smtp.gmail.com';
  $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
  $config["smtp_pass"] = 'local258';
  $config["smtp_port"] = '465';
  $config['charset'] = 'UTF-8';
  $config['wordwrap'] = TRUE;
  $config['smtp_timeout'] = '25';
  $config['validate'] = true;
  $this->email->initialize($config);
  $this->email->set_newline("\r\n");
  $this->email->from('aplicaciones@rockdrillgroup.com');
  $this->email->to($destino);
  $this->email->subject('Formato de Liquidación de Entrega a Rendir para aprobar');
  $this->email->cc('');
  $this->email->message($mensaje);
  $this->email->set_mailtype('html');
  $this->email->attach('');
    if($this->email->send()){
             return 'enviado';
           }
             else{
               echo $this->email->print_debugger();
             }
}
public function aprobar_entrega_lima(){
  $documento=$this->input->post('documento');
  $gerencia=$this->input->post('gerencia');
  if ($this->session->userdata('rol_id')==48) {
    /*$data['estado']=2;
    $estadocorreo=3;*/
    $this->db->set('estado',10);
    $this->db->set('gerencia',$gerencia);
    $this->db->where('num_formato',$documento);
    $this->db->update('LER_CAB');

    $this->db->set('firma_residente',$this->session->userdata('documento'));
    $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',1);
    $this->db->update('firmas_formato');
  }

      if ($this->session->userdata('rol_id')==47) {
      $data['estado']=1;
        $querydestino=$this->db->query("SELECT correo FROM usuario where centro_costo='".$this->session->userdata("user_cc")."' and usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=48 )");
      } elseif ($this->session->userdata('rol_id')==48) {
      $data['estado']=10;
        $querydestino=$this->db->query("SELECT correo FROM usuario where documento='".$this->input->post("gerencia")."' ");
      }elseif ($this->session->userdata('rol_id')==49) {
      $data['estado']=11;
        $querydestino=$this->db->query("SELECT correo_cc as 'correo' FROM estado_formato where docentry='7'");
      }
      $data['formato']=$this->Mformato->get_ler('consulta');
          $mensaje=$this->load->view('correo/liquidacion_entrega',$data,TRUE);
      $destino=$querydestino->row('correo');
        $config['protocol'] = 'smtp';
        $config["smtp_host"] = 'ssl://smtp.gmail.com';
        $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
        $config["smtp_pass"] = 'local258';
        $config["smtp_port"] = '465';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        $config['smtp_timeout'] = '25';
        $config['validate'] = true;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('aplicaciones@rockdrillgroup.com');
        $this->email->to($destino);
        $this->email->subject('Formato de Liquidación de Entrega a Rendir para aprobar');
        $this->email->cc('');
        $this->email->message($mensaje);
        $this->email->set_mailtype('html');
        $this->email->attach('');
          if($this->email->send()){
                   return 'enviado';
                 }
                   else{
                     echo $this->email->print_debugger();
                   }
}
public function rechazar_entrega_rendir($documento){
if ($this->session->userdata('rol_id')==39) {
  $this->db->set('estado',0);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

}elseif ($this->session->userdata('rol_id')==41) {
  $this->db->set('estado',0);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

}elseif ($this->session->userdata('rol_id')==40) {
  $this->db->set('estado',0);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

}elseif ($this->session->userdata('rol_id')==43) {
  $this->db->set('estado',0);
  $this->db->where('num_formato',$documento);
  $this->db->update('LER_CAB');

}
$mensaje="El Formato de Liquidación de Entrega a Rendir N°".$documento." ha sido rechazado por ".$this->session->userdata('nombre')." ".$this->session->userdata('apepat');
$queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM LER_CAB where num_formato='".$documento."')");
$destino=$queryusuario->row('correo');
  $config['protocol'] = 'smtp';
  $config["smtp_host"] = 'ssl://smtp.gmail.com';
  $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
  $config["smtp_pass"] = 'local258';
  $config["smtp_port"] = '465';
  $config['charset'] = 'UTF-8';
  $config['wordwrap'] = TRUE;
  $config['smtp_timeout'] = '25';
  $config['validate'] = true;
  $this->email->initialize($config);
  $this->email->set_newline("\r\n");
  $this->email->from('aplicaciones@rockdrillgroup.com');
  $this->email->to($destino);
  $this->email->subject('Formato de Liquidación de Entrega a Rendir RECHAZADA!!');
  $this->email->cc('');
  $this->email->message($mensaje);
  $this->email->set_mailtype('html');
  $this->email->attach('');
    if($this->email->send()){
             return 'enviado';
           }
             else{
               echo $this->email->print_debugger();
             }
}

public function aprobar_solicitud_entrega($documento){
  if ($this->session->userdata('rol_id')==39) {
    $data['estado']=2;
    $estadocorreo=3;
    $this->db->set('estado',2);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

    $this->db->set('firma_residente',$this->session->userdata('documento'));
    $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',4);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==40) {
    $data['estado']=3;
    $estadocorreo=4;
    $this->db->set('estado',3);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

    $this->db->set('firma_operaciones',$this->session->userdata('documento'));
    $this->db->set('fecha_operaciones',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',4);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==41 or $this->session->userdata('rol_id')==49) {
    $data['estado']=4;
    $estadocorreo=5;
    $this->db->set('estado',4);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

    $this->db->set('firma_ger_operaciones',$this->session->userdata('documento'));
    $this->db->set('fecha_ger_operaciones',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',4);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==42) {
    $data['estado']=5;
    $estadocorreo='';
    $this->db->set('estado',5);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

    $this->db->set('firma_finanzas',$this->session->userdata('documento'));
    $this->db->set('fecha_finanzas',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',4);
    $this->db->update('firmas_formato');

    $mensaje="El Formato de Solicitud de Entrega a Rendir N°".$documento." ha sido aprobado por todas las áreas involucradas";
    $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM SOL_CAB where num_formato='".$documento."')");
    $destino=$queryusuario->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Confirmación de Aprobación del Formato de Solicitud de Entrega a Rendir N°'.$documento.' !!');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }
  }

  $data['formato']=$this->Mformato->get_sol('consulta');

  $mensaje=$this->load->view('correo/sol_entrega',$data,TRUE);
  $querydestino=$this->db->query("SELECT correo_cc FROM estado_formato where docentry='".$estadocorreo."'");
  $destino=$querydestino->row('correo_cc');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Solicitud de Entrega a Rendir para aprobar');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}
public function aprobar_solicitud_entrega_lima(){
  $documento=$this->input->post('documento');
  $gerencia=$this->input->post('gerencia');
  if ($this->session->userdata('rol_id')==48) {
    /*$data['estado']=2;
    $estadocorreo=3;*/
    $this->db->set('estado',10);
    $this->db->set('gerencia',$gerencia);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

    $this->db->set('firma_residente',$this->session->userdata('documento'));
    $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',4);
    $this->db->update('firmas_formato');
  }
  if ($this->session->userdata('rol_id')==47) {
  $data['estado']=1;
    $querydestino=$this->db->query("SELECT correo FROM usuario where centro_costo='".$this->session->userdata("user_cc")."' and usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=48 )");
  } elseif ($this->session->userdata('rol_id')==48) {
  $data['estado']=10;
    $querydestino=$this->db->query("SELECT correo FROM usuario where documento='".$this->input->post("gerencia")."' ");
  }elseif ($this->session->userdata('rol_id')==49) {
  $data['estado']=11;
    $querydestino=$this->db->query("SELECT correo_cc as 'correo' FROM estado_formato where docentry='7'");
  }
  $data['formato']=$this->Mformato->get_sol('consulta');
      $mensaje=$this->load->view('correo/liquidacion_entrega',$data,TRUE);
  $destino=$querydestino->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Liquidación de Entrega a Rendir para aprobar');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}

public function rechazar_solicitud_entrega($documento){
  if ($this->session->userdata('rol_id')==39) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

  }elseif ($this->session->userdata('rol_id')==41) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');

  }

  $mensaje="El Formato de Solicitud de Entrega a Rendir N°".$documento." ha sido rechazado por ".$this->session->userdata('nombre')." ".$this->session->userdata('apepat');
  $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM SOL_CAB where num_formato='".$documento."')");
  $destino=$queryusuario->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Solicitud de Entrega a Rendir RECHAZADA!!');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}

public function pagar_solicitud_entrega($documento){

  $tipo=$this->input->post('tipo_formato');
  //$documento=$this->input->post('num_formato');
  $motivo=$this->input->post('motivo');
$carpeta = "./assets/contratos/".$tipo."/".$documento."";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
$config = [
  "upload_path" => $carpeta,
  'allowed_types' => "gif|jpg|png|pdf|doc|docx"
];
$this->load->library("upload",$config);

if ($this->upload->do_upload('archivo')) {

$data = $this->upload->data();

$archivo= array('documento'=>$documento,
                'formato'=>$tipo,
                'archivos'=>$data['file_name'],
                'ruta'=>$carpeta);
                $this->db->insert('adjunto_formato',$archivo);
$msg='se subio correctamente el documento';
}else{

  $msg=$this->upload->display_errors();
}

  if ($this->session->userdata('rol_id')==42) {
    $this->db->set('estado',9);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOL_CAB');
  }

  $mensaje="Se ha generado el depósito bancario del Formato de Solicitud de Entrega a Rendir N°".$documento.".<br>".$motivo;
  $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM SOL_CAB where num_formato='".$documento."')");
  $destino=$queryusuario->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Confirmación de pago del Formato de Solicitud de Entrega a Rendir N°'.$documento.' !!');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach($carpeta."/".$data['file_name']);
      if($this->email->send()){
               return 'enviado';

             }
               else{
                 echo $this->email->print_debugger();
               }

                              unlink($carpeta."/".$data['file_name']);
}

public function aprobar_fondo_fijo($documento){
  if ($this->session->userdata('rol_id')==39) {
    $data['estado']=2;
    $estadocorreo=3;
    $this->db->set('estado',2);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

    $this->db->set('firma_residente',$this->session->userdata('documento'));
    $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',2);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==41 or $this->session->userdata('rol_id')==49) {
    $data['estado']=4;
    $estadocorreo=7;
    $this->db->set('estado',4);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

    $this->db->set('firma_ger_operaciones',$this->session->userdata('documento'));
    $this->db->set('fecha_ger_operaciones',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',2);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==40) {
    $data['estado']=3;
    $estadocorreo=4;
    $this->db->set('estado',3);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

    $this->db->set('firma_operaciones',$this->session->userdata('documento'));
    $this->db->set('fecha_operaciones',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',2);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==43) {
    $data['estado']=7;
    $estadocorreo=5;
    $this->db->set('estado',7);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

    $this->db->set('firma_contabilidad',$this->session->userdata('documento'));
    $this->db->set('fecha_contabilidad',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',2);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==42) {
    $data['estado']=5;
    $estadocorreo='';
    $this->db->set('estado',5);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

    $this->db->set('firma_finanzas',$this->session->userdata('documento'));
    $this->db->set('fecha_finanzas',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',2);
    $this->db->update('firmas_formato');

    $mensaje="El Formato de Liquidación de Fondo Fijo N°".$documento." ha sido aprobado por todas las áreas involucradas";
    $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM FF_CAB where num_formato='".$documento."')");
    $destino=$queryusuario->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Confirmación de Aprobación del Formato de Liquidación de Fondo Fijo N°'.$documento.' !!');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }
  }

  $data['formato']=$this->Mformato->get_ff('consulta');

  $mensaje=$this->load->view('correo/liquidacion_fondo',$data,TRUE);
  $querydestino=$this->db->query("SELECT correo_cc FROM estado_formato where docentry='".$estadocorreo."'");
  $destino=$querydestino->row('correo_cc');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Liquidación de Fondo Fijo para aprobar');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}
public function aprobar_fondo_fijo_lima(){
  $documento=$this->input->post('documento');
  $gerencia=$this->input->post('gerencia');
  if ($this->session->userdata('rol_id')==48) {
    /*$data['estado']=2;
    $estadocorreo=3;*/
    $this->db->set('estado',10);
    $this->db->set('gerencia',$gerencia);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

    $this->db->set('firma_residente',$this->session->userdata('documento'));
    $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',2);
    $this->db->update('firmas_formato');
  }
  if ($this->session->userdata('rol_id')==47) {
  $data['estado']=1;
    $querydestino=$this->db->query("SELECT correo FROM usuario where centro_costo='".$this->session->userdata("user_cc")."' and usuarioid in(select usuarioid from acceso_almacen where contratoid='".$this->session->userdata("alm_id")."' and rolid=48 )");
  } elseif ($this->session->userdata('rol_id')==48) {
  $data['estado']=10;
    $querydestino=$this->db->query("SELECT correo FROM usuario where documento='".$this->input->post("gerencia")."' ");
  }elseif ($this->session->userdata('rol_id')==49) {
  $data['estado']=11;
    $querydestino=$this->db->query("SELECT correo_cc as 'correo' FROM estado_formato where docentry='7'");
  }
  $data['formato']=$this->Mformato->get_ff('consulta');

  $mensaje=$this->load->view('correo/liquidacion_fondo',$data,TRUE);
  $destino=$querydestino->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Liquidación de Fondo Fijo para aprobar');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}
public function rechazar_fondo_fijo($documento){
  if ($this->session->userdata('rol_id')==39) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');


  }elseif ($this->session->userdata('rol_id')==41) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

  }elseif ($this->session->userdata('rol_id')==40) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

  }elseif ($this->session->userdata('rol_id')==43) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('FF_CAB');

  }

  $fondoareponer=$this->db->query('SELECT SUM(t1.importe) AS "importe" FROM FF_CAB t0 inner join FF_DET t1 on t0.docentry=t1.ler_cab where t0.num_formato="'.$documento.'" GROUP BY t1.ler_cab')->row('importe');
  $usuarioff=$this->db->query("SELECT usuario FROM FF_CAB where num_formato='".$documento."'")->row('usuario');
  $fondofijo=$this->db->query("SELECT fondo_asignado FROM usuario where usuarioid='".$usuarioff."'")->row('fondo_asignado');
  $nuevo_fondo=$fondofijo+$fondoareponer;

  $this->db->set('fondo_asignado',$nuevo_fondo);
  $this->db->where('usuarioid',$usuarioff);
  $this->db->update('usuario');

  $mensaje="El Formato de Liquidación de Fondo Fijo N°".$documento." ha sido rechazado por ".$this->session->userdata('nombre')." ".$this->session->userdata('apepat');
  $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM FF_CAB where num_formato='".$documento."')");
  $destino=$queryusuario->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Liquidación de Fondo Fijo RECHAZADA!!');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }

}
public function aprobar_solicitud_servicios($documento){
  if ($this->session->userdata('rol_id')==39) {
    $data['estado']=2;
    $estadocorreo=3;
    $this->db->set('estado',2);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOLSER_CAB');

    $this->db->set('firma_residente',$this->session->userdata('documento'));
    $this->db->set('fecha_residente',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',3);
    $this->db->update('firmas_formato');
  }elseif ($this->session->userdata('rol_id')==40) {
    $data['estado']=3;
    $estadocorreo=7;
    $this->db->set('estado',3);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOLSER_CAB');

    $this->db->set('firma_operaciones',$this->session->userdata('documento'));
    $this->db->set('fecha_operaciones',date("Y-m-d H:i:s"));
    $this->db->where('num_formato',$documento);
    $this->db->where('tipo_formato',3);
    $this->db->update('firmas_formato');

    $mensaje="El Formato de Solicitud de Servicios N°".$documento." ha sido aprobado por todas las áreas involucradas";
    $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM FF_CAB where num_formato='".$documento."')");
    $destino=$queryusuario->row('correo');
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = 'ssl://smtp.gmail.com';
      $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
      $config["smtp_pass"] = 'local258';
      $config["smtp_port"] = '465';
      $config['charset'] = 'UTF-8';
      $config['wordwrap'] = TRUE;
      $config['smtp_timeout'] = '25';
      $config['validate'] = true;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from('aplicaciones@rockdrillgroup.com');
      $this->email->to($destino);
      $this->email->subject('Confirmación de Aprobación del Formato de Solicitud de Servicios N°'.$documento.' !!');
      $this->email->cc('');
      $this->email->message($mensaje);
      $this->email->set_mailtype('html');
      $this->email->attach('');
        if($this->email->send()){
                 return 'enviado';
               }
                 else{
                   echo $this->email->print_debugger();
                 }


  }

  $data['formato']=$this->Mformato->get_solser('consulta');

  $mensaje=$this->load->view('correo/sol_servicios',$data,TRUE);
  $querydestino=$this->db->query("SELECT correo_cc FROM estado_formato where docentry='".$estadocorreo."'");
  $destino=$querydestino->row('correo_cc');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Liquidación de Fondo Fijo para aprobar');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}
public function rechazar_solicitud_servicios($documento){
  if ($this->session->userdata('rol_id')==41) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOLSER_CAB');

  }elseif ($this->session->userdata('rol_id')==45) {
    $this->db->set('estado',0);
    $this->db->where('num_formato',$documento);
    $this->db->update('SOLSER_CAB');

  }
  $mensaje="El Formato de Solicitud de Servicio N°".$documento." ha sido rechazado por ".$this->session->userdata('nombre')." ".$this->session->userdata('apepat');
  $queryusuario=$this->db->query("SELECT correo FROM usuario where usuarioid=(SELECT usuario FROM SOLSER_CAB where num_formato='".$documento."')");
  $destino=$queryusuario->row('correo');
    $config['protocol'] = 'smtp';
    $config["smtp_host"] = 'ssl://smtp.gmail.com';
    $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
    $config["smtp_pass"] = 'local258';
    $config["smtp_port"] = '465';
    $config['charset'] = 'UTF-8';
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = '25';
    $config['validate'] = true;
    $this->email->initialize($config);
    $this->email->set_newline("\r\n");
    $this->email->from('aplicaciones@rockdrillgroup.com');
    $this->email->to($destino);
    $this->email->subject('Formato de Solicitud de Servicio RECHAZADA!!');
    $this->email->cc('');
    $this->email->message($mensaje);
    $this->email->set_mailtype('html');
    $this->email->attach('');
      if($this->email->send()){
               return 'enviado';
             }
               else{
                 echo $this->email->print_debugger();
               }
}
public function formatear_correlativo(){
  $this->db->set('correlativo',1);
  $this->db->update('correlativo_formato');
}

public function notificar_vencimiento(){
  $this->load->model('Mcorreo');
  $destino='william.lopez@rockdrillgroup.com';
    $remitente='william.lopez@codrise.com';

  $this->Mcorreo->enviar_notificacion($destino,$remitente);
  echo "hecho";
}
public function consultar_pago(){
  $id=$this->input->post('id');
  $tipo=$this->input->post('tipo');

  if ($tipo==1) {
    $condicion=$this->db->query('SELECT estado FROM LER_CAB where num_formato="'.$id.'"');
    if ($condicion->row('estado')==5) {
      echo "si";
    }else {
      echo "no";
    }
  }elseif ($tipo==2) {
    $condicion=$this->db->query('SELECT estado FROM FF_CAB where num_formato="'.$id.'"');
    if ($condicion->row('estado')==5) {
      echo "si";
    }else {
      echo "no";
    }
  } elseif ($tipo==4) {
    $condicion=$this->db->query('SELECT estado FROM SOL_CAB where num_formato="'.$id.'"');
    if ($condicion->row('estado')==5) {
      echo "si";
    }else {
      echo "no";
    }
  }
}
}
