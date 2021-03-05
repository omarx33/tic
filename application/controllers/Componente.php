 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Componente extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
      $this->load->model(array('Mcomponente'));
  }

  function index()
  {

  }


  public function getall(){
      $resultado=$this->Mcomponente->getcomponente();
      echo json_encode($resultado);
  }



  public function save(){
     $accion         = $this->input->post('txtAccion');
     $id             = $this->input->post('id');
     $nombre         = $this->input->post('nombre');

    $estado='';
    if($this->input->post('estado')=='on'){
      $estado="01";
    }
    if($this->input->post('estado')==''){
      $estado="00";
    }
  //  echo $estado;
//-------------------

    if (strlen($nombre)>0) {

              if($accion=='nuevo'){
                  echo $this->Mcomponente->save($nombre,$estado);
             }elseif ($accion=='editar') {
                  echo $this->Mcomponente->update($id,$nombre,$estado);
              //    echo "actualizar";
             }else {
               echo "0";
             }

    }else {
        echo "3";
    }

//-------------------


  }
public function get_codigoequipo(){
  $empresa=$this->input->post('empresa');
  $query3=$this->db->query("SELECT abrevia,correlativo FROM correlativo_componente where idcomponente=9 and empresa='".$empresa."'");
  if ($query3->num_rows()>0) {
    echo $query3->row('abrevia').str_pad($query3->row('correlativo'), 2, "0", STR_PAD_LEFT);
  } else {
    echo "";
  }


}





public function eliminar_equipos_det(){
 $id = $this->input->post('id');

$nafectados = $this->Mcomponente->eliminar_equipos_det($id);
if ($nafectados >0) {
  echo "se elimino: ".$nafectados." componente";
}else {
  echo "no se eliminaron: ".$nafectados." componente";
}

}




public function get_detalle_equipo($tipo,$id){


  $query3=$this->db->query("SELECT correlativo FROM componente where descripcion='EQUIPO'");
      $data['codigo']='EQUIPO'.str_pad($query3->row('correlativo'), 2, "0", STR_PAD_LEFT);
  if ($tipo=='editar') {
    $data['codigo']=$id;
    $query1=$this->db->query("SELECT *,(select CONCAT(nombres,' ',apellidos) from usuario where idusuario=t1.usuario) as'nom_usuario',(select descripcion from empresa where idempresa=t1.empresa) as'nom_empresa' FROM equipo_tic t1 where t1.docentry='".$id."'");
    $data['cabecera']=$query1->row();
    $query2=$this->db->query("SELECT t1.*, (select descripcion from stock where codigo_contable=t1.codigo_contable) as 'desc_tecnica',(select serie from stock where codigo_contable=t1.codigo_contable) as 'serie' FROM equipo_detalle t1 where t1.estado=1 and	t1.equipoid='".$id."'");
    $data['detalle']=$query2->result();
    $query5=$this->db->query("SELECT * FROM stock where cantidad>0 and empresa=".$query1->row('empresa')."");
    $data['componentes']=$query5->result();
  } else {

    $query4=$this->db->query("SELECT * FROM empresa");
    $data['empresas']=$query4->result();
  }



  /*$query5=$this->db->query("SELECT * FROM usuario where estado='01'");
  $data['usuario']=$query->result();*/
  $data['tipo']=$tipo;
  if ($tipo=='editar') {
  $this->load->view('secciones/procesos/detalle_equipo',$data);
  }else {
    $this->load->view('secciones/procesos/nuevo_equipo',$data);
  }



}

public function get_stock(){
  $empresa=$this->input->post('empresa');
    $query5=$this->db->query("SELECT * FROM stock where cantidad>0 ");
    echo json_encode($query5->result());
}
public function get_descripcion_stock(){
  $idcomponente=$this->input->post('idcomponente');
    $query5=$this->db->query("SELECT descripcion,serie FROM stock where cantidad>0 and idstock=".$idcomponente."");
    echo json_encode($query5->row());
}

public function save_equipo(){
  if ($this->input->post('empresa')==2) {
      $equipo['nombre_equipo']='CD'.$this->input->post('codigo_equipo');
  } elseif ($this->input->post('empresa')==3) {
      $equipo['nombre_equipo']='RD'.$this->input->post('codigo_equipo');
  } elseif ($this->input->post('empresa')==4) {
      $equipo['nombre_equipo']='HL'.$this->input->post('codigo_equipo');
  }


  $equipo['empresa']=$this->input->post('empresa');
  $equipo['usuario']='';
  $equipo['estado']=1;
  $equipo['ubicacion']='';
  $equipo['observaciones']=$this->input->post('observaciones');
  $equipo['ultima_asignación']='';

  $detalle=json_decode($this->input->post('tbldetalle'));

  echo ($this->Mcomponente->save_equipo($equipo,$detalle));

}
public function agregar_componente(){

$componente=$this->input->post('idcomponente');
$equipo=$this->input->post('equipo')  ;

$equipoinfo=$this->db->query('select*from equipo_tic where docentry='.$equipo);
$detalleequipo=$this->db->query('select*from equipo_detalle where codigo_contable="'.$componente.'" and equipoid='.$equipo);
if ($detalleequipo->num_rows()>0) {
  $this->db->set('estado',1);
  $this->db->where('codigo_contable',$componente);
  $this->db->where('equipoid',$equipo);
  $this->db->update('equipo_detalle');
} else {
  $data = array('equipoid' => $equipo,
                'codigo_contable'=>$componente,
                'estado'=>1,
                'fecha_asignacion'=>date('d-m-Y'));
  $this->db->insert('equipo_detalle',$data);
}

$serie=$this->db->query("select*from stock where codigo_contable='".$componente."'");
$movimiento = array('codigo_contable' => $componente,
                    'serie' => $serie->row('serie'),
                    'codigo'=>$serie->row('codigo'),
                    'tipo_mov'=>'S',
                    'docref'=>'',
                    'observaciones'=>'Armado de Equipo:'.$equipoinfo->row('nombre_equipo'));
$this->db->insert('movtic',$movimiento);

$this->db->set('cantidad','cantidad-1',FALSE);
$this->db->where('codigo_contable',$componente);
$this->db->update('stock');
/*
$this->db->set('correlativo','correlativo+1',FALSE);
$this->db->where('idcomponente',9);
$this->db->where('empresa',$equipoinfo->row('empresa'));
$this->db->update('correlativo_componente');*/

echo "Se agregó al equipo";
}


public function update_equipo(){

  $equipoid=$this->input->post('docentry_equipo');

  //$equipo['observaciones']=$this->input->post('observaciones');
  $this->db->set('observaciones',$this->input->post('observaciones'));
  $this->db->where('docentry',$equipoid);
  $this->db->update('equipo_tic');
  echo $this->db->affected_rows();
}
//-------------------------------------------------------------
public function movimientos(){
  $periodo=$this->input->post('periodo');
  $empresa=$this->input->post('empresa');
//$empresa = '3';

  $fechainicial=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,0,10))));
  $fechafinal=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,-10))));
     $data['lista']=$this->Mcomponente->getlistamov($fechainicial,$fechafinal,$empresa);
   $this->load->view('secciones/consultas/movimientos', $data);

}


public function movimientos_oc(){
  $periodo=$this->input->post('periodo');
  $empresa=$this->input->post('empresa');
//$empresa = '3';

  $fechainicial=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,0,10))));
  $fechafinal=date('Y-m-d',strtotime(str_replace('/','-',substr($periodo,-10))));
     $data['lista']=$this->Mcomponente->getlistamov_oc($fechainicial,$fechafinal,$empresa);
   $this->load->view('secciones/consultas/movimientos_oc', $data);

}

public function get_asignaciones($empresa){
  $query=$this->db->query('SELECT t1.*,(select concat(nombres," ",apellidos) from usuario where idusuario=t1.usuario) "nom_usuario", (select nombre_equipo from equipo_tic where docentry=t1.equipo) "nom_equipo" ,
   (select descripcion from area where idarea=t1.area) "nom_area"  FROM
  asignacion_equipo t1 where t1.estado=1 and t1.empresa="'.$empresa.'" order by nom_equipo ');
  $data['asignaciones']=$query->result();
 $this->load->view('secciones/procesos/asignacion_equipo', $data);

}
public function get_equipo(){
  $empresa=$this->input->post('empresa');
  $query=$this->db->query('SELECT * FROM equipo_tic where estado=1 and empresa="'.$empresa.'"');

  echo json_encode($query->result());
}
public function descripcion_equipo(){
  $equipo=$this->input->post('equipo');
  $query=$this->db->query("SELECT t1.*,(select descripcion from componente where idcomponente=t1.tipo_componente) as 'nom_componente',
  (select descripcion as des_art from articulos where codigo_ss=t1.codigo) as des_art
   FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and t1.tipo_componente not in(5,6,7,8,4) and t0.equipoid=".$equipo);
  $dd=0;
  $ram=0;
  $video=0;
  $query2=$this->db->query("SELECT t1.*,(select t2.descripcion from componente t2 where idcomponente=t1.tipo_componente) as 'nom_componente',
  (select descripcion as des_art from articulos where codigo_ss=t1.codigo) as des_art
   FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and (t1.tipo_componente=5 or t1.tipo_componente=6) and t0.equipoid=".$equipo);
  $query3=$this->db->query("SELECT t1.*,(select t2.descripcion from componente t2 where idcomponente=t1.tipo_componente) as 'nom_componente',
  (select descripcion as des_art from articulos where codigo_ss=t1.codigo) as des_art
   FROM stock t1 inner join equipo_detalle t0 on t0.codigo_contable=t1.codigo_contable WHERE t0.estado=1 and t1.tipo_componente in(7,8,4) and t0.equipoid=".$equipo);
  $especificaciones=json_decode($this->Mcomponente->especificaciones($equipo));
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
  $data['codigo']=$query2->row('codigo');
    $data['des_art']=$query2->row('des_art');
        $data['serie']=$query2->row('serie');
    $data['codigo_contable']=$query2->row('codigo_contable');
$utf8carga[]=$data;
  foreach ($query->result() as $key) {
    $data['componente']=$key->nom_componente;
    $data['descripcion']=$key->descripcion;
    $data['ccontable']=$key->codigo_contable;
    $data['codigo']=$key->codigo;
    $data['des_art']=$key->des_art;
      $data['serie']=$key->serie;
    $data['codigo_contable']=$key->codigo_contable;
        $utf8carga[]=$data;
  }

echo json_encode($utf8carga);
}

public function generar_cargo_asignacion(){
  $data = array('cargo_asignacion' => $this->input->post('cargo_asignacion'),
                'usuario' => $this->input->post('usuario'),
                'equipo' => $this->input->post('equipo_asignado'),
                'empresa' => $this->input->post('empresa'),
                'area' => $this->input->post('area'),
                'tipo' => $this->input->post('tipo'),
                'estado' =>1,
                'fecha_asignacion'=>date('Y-m-d H:i:s')
              );

  $this->db->insert('asignacion_equipo',$data);

  $this->db->set('estado',0);
  $this->db->set('usuario',$this->input->post('usuario'));
  $this->db->set('ubicacion',$this->input->post('area'));
  $this->db->set('ultima_asignación',date('Y-m-d H:i:s'));
  $this->db->where('docentry',$this->input->post('equipo_asignado'));
  $this->db->update('equipo_tic');


  if ($this->input->post('empresa')=='2') {
    $empresa='CA CODRISE';
  }elseif ($this->input->post('empresa')=='3') {
    $empresa='CA ROCKDRILL';
  }elseif ($this->input->post('empresa')=='4') {
    $empresa='CA HELIX';
  }


  $this->db->set('correlativo','correlativo+1',FALSE);
  $this->db->where('tipo',$empresa);
  $this->db->update('correlativo');
  if ($this->db->affected_rows()>0) {
    echo "1";
  }else {
    echo "0";
  }
}
public function devolucion_equipo(){
  $this->db->set('estado',1);
  $this->db->set('usuario',0);
  $this->db->set('ubicacion',0);
  $this->db->where('docentry',$this->input->post('equipo'));
  $this->db->update('equipo_tic');

  $this->db->set('estado',0);
  $this->db->set('fecha_devolucion',date('Y-m-d H:i:s'));
    $this->db->where('docentry',$this->input->post('cargo'));
      $this->db->where('equipo',$this->input->post('equipo'));
    $this->db->update('asignacion_equipo');
    if ($this->db->affected_rows()>0) {
      echo "1";
    }else {
      echo "0";
    }
}

public function get_asignacion_equipo(){
  $cargo=$this->input->post('cargo');
  $query=$this->db->query('SELECT t1.*,(select concat(nombres," ",apellidos) from usuario where idusuario=t1.usuario) "nom_usuario", (select nombre_equipo from equipo_tic where docentry=t1.equipo) "nom_equipo" , (select descripcion from area where idarea=t1.area) "nom_area"  FROM asignacion_equipo t1 where t1.docentry="'.$cargo.'"');
  echo json_encode($query->row());
}


}
