<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class exportar extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {

  }

  public function exportar(){
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('layouts/vInicio');
    $this->load->view('layouts/footer');
  }

}
