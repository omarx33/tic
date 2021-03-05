<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Musuario');
    $this->load->model('Mcontrato');
    $this->load->model('Mperfil');
  }

  public function get(){
			$usuarios=$this->Musuario->get($this->session->userdata('rol_id'));

			echo json_encode($usuarios);
		}

//----

public function save(){
  $tipoaccion=$this->input->post('txtAccion');

  $datos['usuarioid']=$this->input->post('txtIdusuario');
  $datos['nombre']=$this->input->post('txtNombres');
  $datos['apepat']=$this->input->post('txtApepat');
  $datos['apemat']=$this->input->post('txtApemat');
  $datos['documento']=$this->input->post('txtDni');
  $datos['correo']=$this->input->post('txtCorreo');
  $datos['estado']=1;
  $datos['usuario']=$this->input->post('txtDni');
  $datos['cargo']=$this->input->post('txtCargo');
  $datos['clave']=$this->input->post('txtDni');
  $datos['fecha_creacion']=date('Y-m-d H:i:s');
  $datos['area']=$this->input->post('txtArea');
  $datos['rolid']=$this->input->post('cbotipo');
//echo   $usuarioid=$this->input->post('usuarioid');

        if($this->Musuario->validar($datos['documento'],$datos['usuarioid'])<1){

          if($tipoaccion=='nuevo'){





            //insertar a la tabla usuario
            $usuarioid_inserted=$this->Musuario->insertarUsuario($datos);
            if($usuarioid_inserted != 0){
              //si se inserta, insertamos sus accesos
              if($this->session->rol_id==1){
                $contratos=$this->Mcontrato->get(1);

                foreach ($contratos as $key) {
                  $resultado=$this->Musuario->insertarAccesos($usuarioid_inserted,$key->contratoid,$this->input->post('cbo_tipo_'.$key->contratoid));

                }
                //ECHO 'Nuevo usuario registrado '.$msg;
                ECHO 'Nuevo usuario registrado' ;
              }
              if($this->session->rol_id!=1){
                $this->Musuario->insertarAccesos($usuarioid_inserted,$this->session->alm_id,$this->input->post('cbotipo'));
              }
            }
            else{
              echo 'No se grabo correctamente';
            }


          }
          if($tipoaccion=='editar'){

            if($this->session->rol_id==1){

              $nuevos_datos = array('nombre' => $datos['nombre'],
                          'apepat' => $datos['apepat'],
                          'apemat' => $datos['apemat'],
                          'documento'=>$datos['documento'],
                          'correo' => $datos['correo'],
                          'estado' => 1,
                          'cargo'  => $datos['cargo']
                        );



              $this->Musuario->updateUsuario($nuevos_datos,$datos['usuarioid']);
              $contratos=$this->Mcontrato->get(1);

              foreach ($contratos as $key) {
                $resultado=$this->Musuario->updateaccesos($datos['usuarioid'],$this->input->post('cbo_tipo_'.$key->contratoid),$key->contratoid);

              }

            }
            if($this->session->rol_id==8){

              $nuevos_datos = array('nombre' => $datos['nombre'],
                          'apepat' => $datos['apepat'],
                          'apemat' => $datos['apemat'],
                          'documento'=>$datos['documento'],
                          'correo' => $datos['correo'],
                          'estado' => 1,
                          'cargo'  => $datos['cargo']
                        );

              $this->Musuario->updateUsuario($nuevos_datos,$datos['usuarioid']);
              $this->Musuario->updateaccesos($datos['usuarioid'],$this->input->post('cbotipo'),$this->session->alm_id);
            }
            echo $resultado;
          }

        }
        else{

          if ($tipoaccion='nuevo') {
            $this->db->select('usuarioid');
            $this->db->from('usuario_admin');
            $this->db->where('documento',$datos['documento']);
            $query=$this->db->get();
            $usuarioid=$query->row('usuarioid');
            $contratos=$this->Mcontrato->get(1);

            foreach ($contratos as $key) {
              $resultado=$this->Musuario->insertarAccesos($usuarioid,$key->contratoid,$this->input->post('cbo_tipo_'.$key->contratoid));
          }

            }
          echo 'Ya existe un usuario registrado con ese DNI';
        }

}

public function accesos(){
  $usuarioid=$this->input->post('usuarioid');
  $data['accesos']=$this->Musuario->getaccesos($usuarioid);
  $data['perfiles']=$this->Mperfil->getperfiles();
  $this->load->view('usuarios/grid_accesos',$data);
}
public function crear_planilla(){
  $correlativo=$this->input->post('correlativo');
  $fecha=$this->input->post('fecha');
  $docentry=$this->input->post('docentry');
    $data = array('correlativo' => $correlativo,
                  'fecha' => $fecha,
                  'estado' => 0);
  if ($docentry==0) {
    $this->db->insert('planilla_movilidad',$data);
  } else {
    $this->db->where('docentry',$docentry);
    $this->db->update('planilla_movilidad',$data);
  }

}
public function agregar_gasto(){
  $planilla=$this->input->post('planilla');
  $motivo=$this->input->post('motivo');
  $fecha=$this->input->post('fecha');
  $ppartida=$this->input->post('ppartida');
  $pllegada=$this->input->post('pllegada');
  $usuario=$this->input->post('usuario');
  $gasto=$this->input->post('gasto');
  $docentry=$this->input->post('docentryg');

  $data = array('planilla' => $planilla,
                'motivo' => $motivo,
                'punto_partida' => $ppartida,
                'punto_llegada' => $pllegada,
                'fecha' => $fecha,
                'gasto' => $gasto,
                'usuario' => $usuario);
  if ($docentry>0) {
    $this->db->where('docentry',$docentry);
    $this->db->update('planilla_gastos',$data);
  } else {
    $this->db->insert('planilla_gastos',$data);
  }

}
public function eliminar_gasto(){
  $docentry=$this->input->post('id');
  $this->db->where('docentry',$docentry);
  $this->db->delete('planilla_gastos');
}
public function cerrar_planilla(){
  $id=$this->input->post('id');
  $this->db->set('estado',1);
  $this->db->where('docentry',$id);
  $this->db->update('planilla_movilidad');
}

}
