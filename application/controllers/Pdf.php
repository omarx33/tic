<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->library('session');
  $this->load->library('Pdf');
  $this->load->model(array('Mdocumento'));

  }

  function index()
  {

  }

  public function pFicha_tecnica(){
    $empresa=$this->input->post('empresa');
    $id=$this->input->post('id');
  $paper_size = array(0,0,0,-1);
  $data['cabecera']=$this->Mdocumento->get_cabecera($id);


  $html_content = $this->load->view('pdf/ficha_tecnica', $data,TRUE);

      $this->pdf->set_paper($paper_size);
      $this->pdf->set_paper('A4','letter');
      ini_set("memory_limit","10000M");
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("tecnica.pdf", array("Attachment"=>0)); // asigna el nombre al archivo



  }


}
