<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RRHH extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Mcorreo'));
  }

  function notificacion_correo()
  {
    $datetime=date("d-m-Y H:i", strtotime($this->input->post('datetime')));
    $cierre_mes=date('d-m-Y',strtotime($this->input->post('cierre_mes')));
    $horas_extra=date('d-m-Y',strtotime($this->input->post('horas_extra')));
    $recategorizacion=date('d-m-Y',strtotime($this->input->post('recategorizacion')));
    $bono=date('d-m-Y',strtotime($this->input->post('bono')));

                   $correo['destino']='william.lopez@rockdrillgroup.com';
                   $correo['remitente']='jose.adrian@rockdrillgroup.com';
                   $correo['asunto']='ENVIO TAREO';
                   $correo['cuerpo']='Estimados administradores, reciba mis cordiales saludos: <br>
                   <br>-	La fecha de entrega del Tareo para el mes sera el dia <b>'.$datetime.'</b>. <br>
                   <br>-	En caso que tenga   Horas extras sera  contabilizado hasta <b>'.$horas_extra.'</b>, con su respectivo informe. <br>
                   <br>-	El informe debera ser de todo el personal incluye Perforistas, y ayudantes,  en caso de tener HORAS EXTRAS. <br>
                   <br>-	Dias Trabajados sera proyectado hasta el  <b>'.$cierre_mes.'</b>, en caso de las personal que se hayan quedado en sus dias libres como dias apoyo.
                   <br>
                   <br>-	En caso que tengan recategorizaciones,  deben de haber enviado, hasta <b>'.$recategorizacion.'</b>.
                   <br>
                   <br>-	Los tareos deben ser enviados  con las  Firmas del Residente.
                   <br>
                   <br>-	El envio de   cuadro  de bono  a Gerencia de Operaciones sera el  dia  <b>'.$bono.'</b> a la primera hora.<br>
                   <br>-	Willy: entregara los Bonos aprobados a RR.HH. Con  Firma de Gerencia de Operaciones el siguiente dia laborable en las primeras horas. <br>
                  <br>   Gracias,<br>

                   <b>Maximina Vega Loli</b><br>
                   <b>Responsable de Recursos Humanos</b>';

                   $this->Mcorreo->enviar_correo($correo);
  }

}
