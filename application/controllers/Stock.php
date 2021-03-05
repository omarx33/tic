<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model(array('Mstock'));

  }

  function index()
  {

  }


  public function stock(){
    $empresa=$this->input->post('empresa');

  $data['lista']=$this->Mstock->getstock($empresa);
  $this->load->view('secciones/consultas/stock', $data);

  }

}
