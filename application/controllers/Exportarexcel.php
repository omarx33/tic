<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportarexcel extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
$this->load->model(array('Mficha_tecnica'));



  }

  function index()
  {

  }
  public function exportar_excel(){

  $this->load->library('excel');
     $empresa=$this->input->get('empresa');
     $id=$this->input->get('id');

     $articulos=$this->Mficha_tecnica->recibe_datos($id,$empresa);

     $this->excel->getActiveSheet()->setCellValue('A1','CodigoProducto');
     $this->excel->getActiveSheet()->setCellValue('B1','DescripcionProducto');
     $this->excel->getActiveSheet()->setCellValue('C1','CantidadProducto');
     $this->excel->getActiveSheet()->setCellValue('D1','CentroCosto');
     $this->excel->getActiveSheet()->setCellValue('E1','GlosaDetalle');
   $this->excel->getActiveSheet()->setCellValue('F1','NumeroMaquina');
   $this->excel->getActiveSheet()->setCellValue('G1','OrdenFabricacion');

     $fila = "2";
     foreach ($articulos as $key) {
     $this->excel->getActiveSheet()->setCellValue('A'.$fila,$key->codigo_ss);
     $this->excel->getActiveSheet()->setCellValue('B'.$fila,$key->producto);
     $this->excel->getActiveSheet()->setCellValue('C'.$fila,$key->cantidad);
     $this->excel->getActiveSheet()->setCellValue('D'.$fila,str_pad($key->centro_costo,6,"0",STR_PAD_LEFT));
     $this->excel->getActiveSheet()->setCellValue('E'.$fila,$key->d_tecnica);
    $this->excel->getActiveSheet()->setCellValue('F'.$fila,' ');
    $this->excel->getActiveSheet()->setCellValue('G'.$fila,' ');
     $fila++;
     }



     $this->excel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
     $this->excel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
     $this->excel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
     $this->excel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
     $this->excel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);

     $filename='Ficha.xls'; //save our workbook as this file name

     header('Content-Type: application/vnd.ms-excel'); //mime type
     header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
     header('Cache-Control: max-age=0'); //no cache

     //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
     //if you want to save it as .XLSX Excel 2007 format
     $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
     //force user to download the Excel file without writing it to server's HD
     $objWriter->save('php://output');

  }





}
