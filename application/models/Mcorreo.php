<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcorreo extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->library('email');
  }

  public function enviar_correo($correo){

            $config['protocol'] = 'smtp';
              //$config["smtp_host"] = 'mail.disad.pe';
              //$config["smtp_host"] = 'mail.rockdrillgroup.com';
              $config["smtp_host"] = 'ssl://smtp.gmail.com';
             //Nuestro usuario
              //$config["smtp_user"] = 'aplicaciones@disad.pe';
                $config["smtp_user"] = 'aplicaciones.rovheco@gmail.com';
             //Nuestra contraseña
              //$config["smtp_pass"] = 'AplRock452';
                $config["smtp_pass"] = 'local258';
             //El puerto que utilizará el servidor smtp
              $config["smtp_port"] = '465';
              //$config['smtp_crypto'] = 'tls';
             //El juego de caracteres a utilizar
              $config['charset'] = 'iso-8859-1';

             //Permitimos que se puedan cortar palabras
              $config['wordwrap'] = TRUE;
              $config['smtp_timeout'] = '25';
             //El email debe ser valido
             $config['validate'] = true;

             $this->email->initialize($config);
              $this->email->set_newline("\r\n");
             $this->email->from('aprobacion@rockdrillgroup.com');
             $this->email->to($correo['destino']);
             $this->email->subject($correo['asunto']);
             $this->email->cc($correo['remitente']);
             $this->email->message(utf8_encode($correo['cuerpo']));
          $this->email->set_mailtype('html');
            if($this->email->send()){
              return 'enviado';
            }
              else{
                echo $this->email->print_debugger();
              }
  }

  public function nuevo_almacen($almacen){
    return "Nuevo almacen aperturado".$almacen;
  }

}
