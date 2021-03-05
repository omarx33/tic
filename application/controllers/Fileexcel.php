<?php

defined('BASEPATH') OR exit('No direct script access allowed');

  class Fileexcel extends CI_Controller{

    public function __construct()
    {
      parent::__construct();
    $this->load->model(array('Mtareo','Mpersonal'));
    }


    public function tareo_excel($periodo){

          $this->load->library('excel');
       $contratonom=$this->session->userdata('alm_nombre');
        $this->db->select('fecha_inicio');
        $this->db->from('periodo_tareo');
        $this->db->where('contrato',$this->session->userdata('alm_id'));
        $this->db->where('periodo_tareo',$periodo);
        $this->db->limit(1);
        $query=$this->db->get();
        $inicio=$query->row('fecha_inicio');
        $dateinicio=date('Y-m-d',strtotime($inicio));
        $inicio=$inicio;


        $this->db->select('fecha_fin');
        $this->db->from('periodo_tareo');
        $this->db->where('contrato',$this->session->userdata('alm_id'));
        $this->db->where('periodo_tareo',$periodo);
        $this->db->limit(1);
        $query2=$this->db->get();
        $fin=$query2->row('fecha_fin');
        $datefin=date('Y-m-d',strtotime($fin));

        $dateinicio= new DateTime($dateinicio);
        $datefin = new DateTime($datefin);

        $diff=$dateinicio->diff($datefin);
        $dias=$diff->days;
                $numperiodo=substr($periodo, -2);
        $contrato=$this->session->userdata('alm_id');
        $dia29=$this->db->query("SELECT count(dia29) FROM tareo_mensual".$numperiodo." WHERE `contrato` = '".$contrato."' AND `periodo` = '".$periodo."'")->result();

        $dia30=$this->db->query("SELECT count(dia30) FROM tareo_mensual".$numperiodo." WHERE `contrato` = '".$contrato."' AND `periodo` = '".$periodo."'")->result();

        $dia31=$this->db->query("SELECT count(dia31) FROM tareo_mensual".$numperiodo." WHERE `contrato` = '".$contrato."' AND `periodo` = '".$periodo."'")->result();


                  $dateant=date('Y-m-d',strtotime($periodo));
                  $periodoanterior = date('Y-m',strtotime($dateant."-1 month"));

        //////////////////////////////////////////////////

        $this->db->select('periodo_tareo');
        $this->db->from('periodo_tareo');
        $this->db->where('periodo_tareo',$periodoanterior);
        $this->db->where('contrato',$contrato);
        $validar=$this->db->get();

        if($validar->num_rows()<1){
          $personas=$this->Mtareo->consultar_tareo_excelmes($periodo);
          $this->excel->setActiveSheetIndex(0);
       	        $this->excel->getActiveSheet()->setTitle('Tareo - '.$contratonom.'');
       	         $this->excel->getActiveSheet()->setCellValue('A1', 'Tareo Mensual '.$periodo.' - '.$contratonom.' ');
       	          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
       	        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
       	         $this->excel->getActiveSheet()->mergeCells('A1:AP2');
                 $estilo = array(
                    'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                  );
                $color = array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF0000')
                        )
                    );
                $this->excel->getActiveSheet()->setCellValue('F3',$periodo);
                $this->excel->getActiveSheet()->mergeCells('F3:AJ3');
                 $this->excel->getActiveSheet()->setCellValue('A4','N°');
                 $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
                 $this->excel->getActiveSheet()->getStyle("A4")->applyFromArray($estilo);
                 //$this->excel->getActiveSheet()->getStyle('A4')->applyFromArray($color);
                 $this->excel->getActiveSheet()->setCellValue('B4','CODIGO');
                 $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
                 $this->excel->getActiveSheet()->getStyle("B4")->applyFromArray($estilo);
                 $this->excel->getActiveSheet()->getStyle('B4')->getFill()->getStartColor()->setRGB('FF0000');
                 $this->excel->getActiveSheet()->setCellValue('C4','NOMBRES');
                 $this->excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
                 $this->excel->getActiveSheet()->getStyle("C4")->applyFromArray($estilo);
                 $this->excel->getActiveSheet()->getStyle('C4')->getFill()->getStartColor()->setRGB('FF0000');
                 $this->excel->getActiveSheet()->setCellValue('D4','CARGO');
                 $this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
                 $this->excel->getActiveSheet()->getStyle("D4")->applyFromArray($estilo);
                 $this->excel->getActiveSheet()->getStyle('D4')->getFill()->getStartColor()->setRGB('FF0000');
                 $this->excel->getActiveSheet()->setCellValue('E4','TIPO');
                 $this->excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
                 $this->excel->getActiveSheet()->getStyle("E4")->applyFromArray($estilo);
                 $this->excel->getActiveSheet()->getStyle('E4')->getFill()->getStartColor()->setRGB('FF0000');

                 $column = 'F';

                 for ($i=0; $i<$dias+1; $i++) {
                     $date = date($inicio);
                      //Incrementando 2 dias
                     $mod_date = strtotime($date."+".$i." days");

                 $this->excel->getActiveSheet()->setCellValue($column . '4', date("d",$mod_date));
                 $this->excel->getActiveSheet()->getStyle($column . '4')->getFont()->setBold(true);
                 $this->excel->getActiveSheet()->getStyle($column ."4")->applyFromArray($estilo);
                 $column++;


      }
              $this->excel->getActiveSheet()->setCellValue('AK4', 'DT');
              $this->excel->getActiveSheet()->getStyle('AK4')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->setCellValue('AL4', 'DL');
              $this->excel->getActiveSheet()->getStyle('AL4')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->setCellValue('AM4', 'V');
              $this->excel->getActiveSheet()->getStyle('AM4')->getFont()->setBold(true);
      $fila=5;
      $item=1;
      foreach ($personas as $key) {
        $this->excel->getActiveSheet()->setCellValue('A'.$fila,$item);
        $this->excel->getActiveSheet()->setCellValue('B'.$fila,$key->codigo_personal );
        $this->excel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($estilo);
        $this->excel->getActiveSheet()->setCellValue('C'.$fila,$key->trabajador );
        $this->excel->getActiveSheet()->setCellValue('D'.$fila,$key->cargo_personal );
        $this->excel->getActiveSheet()->setCellValue('E'.$fila,$key->desc_tipo_trabajador );
        if ($key->dia1=='') {
          $this->excel->getActiveSheet()->setCellValue('F'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('F'.$fila,$key->dia1);
        }
        if ($key->dia2=='') {
          $this->excel->getActiveSheet()->setCellValue('G'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('G'.$fila,$key->dia2);
        }
        if ($key->dia3=='') {
          $this->excel->getActiveSheet()->setCellValue('H'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('H'.$fila,$key->dia3);
        }
        if ($key->dia4=='') {
          $this->excel->getActiveSheet()->setCellValue('I'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('I'.$fila,$key->dia4);
        }
        if ($key->dia5=='') {
          $this->excel->getActiveSheet()->setCellValue('J'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('J'.$fila,$key->dia5);
        }
        if ($key->dia6=='') {
          $this->excel->getActiveSheet()->setCellValue('K'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('K'.$fila,$key->dia6);
        }
        if ($key->dia7=='') {
          $this->excel->getActiveSheet()->setCellValue('L'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('L'.$fila,$key->dia7);
        }
        if ($key->dia8=='') {
          $this->excel->getActiveSheet()->setCellValue('M'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('M'.$fila,$key->dia8);
        }
        if ($key->dia9=='') {
          $this->excel->getActiveSheet()->setCellValue('N'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('N'.$fila,$key->dia9);
        }
        if ($key->dia10=='') {
          $this->excel->getActiveSheet()->setCellValue('O'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('O'.$fila,$key->dia10);
        }
        if ($key->dia11=='') {
          $this->excel->getActiveSheet()->setCellValue('P'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('P'.$fila,$key->dia11);
        }
        if ($key->dia12=='') {
          $this->excel->getActiveSheet()->setCellValue('Q'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('Q'.$fila,$key->dia12);
        }
        if ($key->dia13=='') {
          $this->excel->getActiveSheet()->setCellValue('R'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('R'.$fila,$key->dia13);
        }
        if ($key->dia14=='') {
          $this->excel->getActiveSheet()->setCellValue('S'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('S'.$fila,$key->dia14);
        }
        if ($key->dia15=='') {
          $this->excel->getActiveSheet()->setCellValue('T'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('T'.$fila,$key->dia15);
        }
        if ($key->dia16=='') {
          $this->excel->getActiveSheet()->setCellValue('U'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('U'.$fila,$key->dia16);
        }
        if ($key->dia17=='') {
          $this->excel->getActiveSheet()->setCellValue('V'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('V'.$fila,$key->dia17);
        }
        if ($key->dia18=='') {
          $this->excel->getActiveSheet()->setCellValue('W'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('W'.$fila,$key->dia18);
        }
        if ($key->dia19=='') {
          $this->excel->getActiveSheet()->setCellValue('X'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('X'.$fila,$key->dia19);
        }
        if ($key->dia20=='') {
          $this->excel->getActiveSheet()->setCellValue('Y'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('Y'.$fila,$key->dia20);
        }
        if ($key->dia21=='') {
          $this->excel->getActiveSheet()->setCellValue('Z'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('Z'.$fila,$key->dia21);
        }
        if ($key->dia22=='') {
          $this->excel->getActiveSheet()->setCellValue('AA'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AA'.$fila,$key->dia22);
        }
        if ($key->dia23=='') {
          $this->excel->getActiveSheet()->setCellValue('AB'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AB'.$fila,$key->dia23);
        }
        if ($key->dia24=='') {
          $this->excel->getActiveSheet()->setCellValue('AC'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AC'.$fila,$key->dia24);
        }
        if ($key->dia25=='') {
          $this->excel->getActiveSheet()->setCellValue('AD'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AD'.$fila,$key->dia25);
        }
        if ($key->dia26=='') {
          $this->excel->getActiveSheet()->setCellValue('AE'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AE'.$fila,$key->dia26);
        }
        if ($key->dia27=='') {
          $this->excel->getActiveSheet()->setCellValue('AF'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AF'.$fila,$key->dia27);
        }
        if ($key->dia28=='') {
          $this->excel->getActiveSheet()->setCellValue('AG'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('AG'.$fila,$key->dia28);
        }
        if ($dia29!='0' or $dia29!=''){
        /*  if ($key->dia29=='') {
            $this->excel->getActiveSheet()->setCellValue('AH'.$fila,'T' );
          }else {*/
            $this->excel->getActiveSheet()->setCellValue('AH'.$fila,$key->dia29);
        /*  }*/
        }else {
          $this->excel->getActiveSheet()->setCellValue('AH'.$fila,$key->dia29);
        }
        if ($dia30!='0' or $dia30!=''){
        /*  if ($key->dia30=='') {
            $this->excel->getActiveSheet()->setCellValue('AI'.$fila,'T' );
          }else {*/
            $this->excel->getActiveSheet()->setCellValue('AI'.$fila,$key->dia30);
          }
      /*  }*/else {
          $this->excel->getActiveSheet()->setCellValue('AI'.$fila,$key->dia30);
        }
        if ($dia31!='0' or $dia31!=''){
        /* if ($key->dia31=='') {
            $this->excel->getActiveSheet()->setCellValue('AJ'.$fila,'T' );
          }else {*/
            $this->excel->getActiveSheet()->setCellValue('AJ'.$fila,$key->dia31);
        /*  }*/
        }else {
          $this->excel->getActiveSheet()->setCellValue('AJ'.$fila,$key->dia31);
        }

        $this->excel->getActiveSheet()->setCellValue('AK'.$fila,'=COUNTIF(F'.$fila.':AJ'.$fila.',"T")');
        $this->excel->getActiveSheet()->setCellValue('AL'.$fila,'=COUNTIF(F'.$fila.':AJ'.$fila.',"DL")');
        $this->excel->getActiveSheet()->setCellValue('AM'.$fila,'=COUNTIF(F'.$fila.':AJ'.$fila.',"V")');
        $item++;
        $fila++;
      }

  $this->excel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('U')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('V')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('W')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('X')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('Y')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('Z')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AA')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AB')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AC')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AD')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AE')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AF')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AG')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AH')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AI')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AJ')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AK')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AL')->setAutoSize(true);
  $this->excel->setActiveSheetIndex(0)->getColumnDimension('AM')->setAutoSize(true);


      ob_end_clean();
      $filename='Tareo Mensual '.$periodo.' - '.$contratonom.'.xls';
      //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache

      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
  }

        else {
          ///////////////////////////////////////////////////////////////////////////////





                  $this->db->select('fecha_inicio');
                  $this->db->from('periodo_tareo');
                  $this->db->where('contrato',$this->session->userdata('alm_id'));
                  $this->db->where('periodo_tareo',$periodoanterior);
                  $this->db->limit(1);
                  $query3=$this->db->get();
                  $inicioant=$query3->row('fecha_inicio');
                  $dateinicioant=date('Y-m-d',strtotime($inicioant));

                  $this->db->select('fecha_fin');
                  $this->db->from('periodo_tareo');
                  $this->db->where('contrato',$this->session->userdata('alm_id'));
                  $this->db->where('periodo_tareo',$periodoanterior);
                  $this->db->limit(1);
                  $query4=$this->db->get();
                  $finant=$query4->row('fecha_fin');
                  $datefinant=date('Y-m-d',strtotime($finant));

                  $dateinicioant= new DateTime($dateinicioant);
                  $datefinant = new DateTime($datefinant);

                  $diffant=$dateinicioant->diff($datefinant);
                  $diasant=$diffant->days;

                  $anterior=$numperiodo-1;
                  $numanterior=str_pad($anterior, 2, "0", STR_PAD_LEFT);

                  $contrato=$this->session->userdata('alm_id');
                  $dia29ant=$this->db->query("SELECT count(dia29) FROM tareo_mensual".$numanterior." WHERE `contrato` = '".$contrato."' AND `periodo` = '".$periodoanterior."'")->result();

                  $dia30ant=$this->db->query("SELECT count(dia30) FROM tareo_mensual".$numanterior." WHERE `contrato` = '".$contrato."' AND `periodo` = '".$periodoanterior."'")->result();

                  $dia31ant=$this->db->query("SELECT count(dia31) FROM tareo_mensual".$numanterior." WHERE `contrato` = '".$contrato."' AND `periodo` = '".$periodoanterior."'")->result();


        $personas=$this->Mtareo->consultar_tareo_excel($periodo);

        //////////////////////////////////////////////
        $this->excel->setActiveSheetIndex(0);
     	        $this->excel->getActiveSheet()->setTitle('Tareo - '.$contratonom.'');
     	         $this->excel->getActiveSheet()->setCellValue('A1', 'Tareo Mensual '.$periodo.' - '.$contratonom.' ');
     	          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
     	        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
     	         $this->excel->getActiveSheet()->mergeCells('A1:AP2');
               $estilo = array(
                  'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  )
                );
              $color = array(
                      'fill' => array(
                          'type' => PHPExcel_Style_Fill::FILL_SOLID,
                          'color' => array('rgb' => 'FF0000')
                      )
                  );
                  $this->excel->getActiveSheet()->setCellValue('F3',$periodo);
                  $this->excel->getActiveSheet()->mergeCells('F3:AJ3');
                  $this->excel->getActiveSheet()->setCellValue('AK3',$periodo);
                  $this->excel->getActiveSheet()->mergeCells('AK3:BO3');
               $this->excel->getActiveSheet()->setCellValue('A4','N°');
               $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getStyle("A4")->applyFromArray($estilo);
               //$this->excel->getActiveSheet()->getStyle('A4')->applyFromArray($color);
               $this->excel->getActiveSheet()->setCellValue('B4','CODIGO');
               $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getStyle("B4")->applyFromArray($estilo);
               $this->excel->getActiveSheet()->getStyle('B4')->getFill()->getStartColor()->setRGB('FF0000');
               $this->excel->getActiveSheet()->setCellValue('C4','NOMBRES');
               $this->excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getStyle("C4")->applyFromArray($estilo);
               $this->excel->getActiveSheet()->getStyle('C4')->getFill()->getStartColor()->setRGB('FF0000');
               $this->excel->getActiveSheet()->setCellValue('D4','CARGO');
               $this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getStyle("D4")->applyFromArray($estilo);
               $this->excel->getActiveSheet()->getStyle('D4')->getFill()->getStartColor()->setRGB('FF0000');
               $this->excel->getActiveSheet()->setCellValue('E4','TIPO');
               $this->excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getStyle("E4")->applyFromArray($estilo);
               $this->excel->getActiveSheet()->getStyle('E4')->getFill()->getStartColor()->setRGB('FF0000');

               $column = 'F';

               for ($i=0; $i<$diasant+1; $i++) {
                   $dateant = date($inicioant);
                    //Incrementando 2 dias
                   $mod_dateant = strtotime($dateant."+".$i." days");

               $this->excel->getActiveSheet()->setCellValue($column . '4', date("d",$mod_dateant));
               $this->excel->getActiveSheet()->getStyle($column . '4')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getStyle($column ."4")->applyFromArray($estilo);
               $column++;


    }
    $columnB = 'Ak';

    for ($i=0; $i<$dias+1; $i++) {
        $date = date($inicio);
         //Incrementando 2 dias
        $mod_date = strtotime($date."+".$i." days");

    $this->excel->getActiveSheet()->setCellValue($columnB . '4', date("d",$mod_date));
    $this->excel->getActiveSheet()->getStyle($columnB . '4')->getFont()->setBold(true);
    $this->excel->getActiveSheet()->getStyle($columnB ."4")->applyFromArray($estilo);
    $columnB++;


}

            $this->excel->getActiveSheet()->setCellValue('BP4', 'DT');
            $this->excel->getActiveSheet()->getStyle('BP4')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->setCellValue('BQ4', 'DL');
            $this->excel->getActiveSheet()->getStyle('BQ4')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->setCellValue('BR4', 'V');
            $this->excel->getActiveSheet()->getStyle('BR4')->getFont()->setBold(true);
    $fila=5;
    $item=1;
    foreach ($personas as $key) {
      $this->excel->getActiveSheet()->setCellValue('A'.$fila,$item);
      $this->excel->getActiveSheet()->setCellValue('B'.$fila,$key->codigo_personal );
      $this->excel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($estilo);
      $this->excel->getActiveSheet()->setCellValue('C'.$fila,$key->trabajador );
      $this->excel->getActiveSheet()->setCellValue('D'.$fila,$key->cargo_personal );
      $this->excel->getActiveSheet()->setCellValue('E'.$fila,$key->desc_tipo_trabajador );
      if ($key->dia1=='') {
        $this->excel->getActiveSheet()->setCellValue('F'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('F'.$fila,$key->dia1);
      }
      if ($key->dia2=='') {
        $this->excel->getActiveSheet()->setCellValue('G'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('G'.$fila,$key->dia2);
      }
      if ($key->dia3=='') {
        $this->excel->getActiveSheet()->setCellValue('H'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('H'.$fila,$key->dia3);
      }
      if ($key->dia4=='') {
        $this->excel->getActiveSheet()->setCellValue('I'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('I'.$fila,$key->dia4);
      }
      if ($key->dia5=='') {
        $this->excel->getActiveSheet()->setCellValue('J'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('J'.$fila,$key->dia5);
      }
      if ($key->dia6=='') {
        $this->excel->getActiveSheet()->setCellValue('K'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('K'.$fila,$key->dia6);
      }
      if ($key->dia7=='') {
        $this->excel->getActiveSheet()->setCellValue('L'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('L'.$fila,$key->dia7);
      }
      if ($key->dia8=='') {
        $this->excel->getActiveSheet()->setCellValue('M'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('M'.$fila,$key->dia8);
      }
      if ($key->dia9=='') {
        $this->excel->getActiveSheet()->setCellValue('N'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('N'.$fila,$key->dia9);
      }
      if ($key->dia10=='') {
        $this->excel->getActiveSheet()->setCellValue('O'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('O'.$fila,$key->dia10);
      }
      if ($key->dia11=='') {
        $this->excel->getActiveSheet()->setCellValue('P'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('P'.$fila,$key->dia11);
      }
      if ($key->dia12=='') {
        $this->excel->getActiveSheet()->setCellValue('Q'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('Q'.$fila,$key->dia12);
      }
      if ($key->dia13=='') {
        $this->excel->getActiveSheet()->setCellValue('R'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('R'.$fila,$key->dia13);
      }
      if ($key->dia14=='') {
        $this->excel->getActiveSheet()->setCellValue('S'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('S'.$fila,$key->dia14);
      }
      if ($key->dia15=='') {
        $this->excel->getActiveSheet()->setCellValue('T'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('T'.$fila,$key->dia15);
      }
      if ($key->dia16=='') {
        $this->excel->getActiveSheet()->setCellValue('U'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('U'.$fila,$key->dia16);
      }
      if ($key->dia17=='') {
        $this->excel->getActiveSheet()->setCellValue('V'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('V'.$fila,$key->dia17);
      }
      if ($key->dia18=='') {
        $this->excel->getActiveSheet()->setCellValue('W'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('W'.$fila,$key->dia18);
      }
      if ($key->dia19=='') {
        $this->excel->getActiveSheet()->setCellValue('X'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('X'.$fila,$key->dia19);
      }
      if ($key->dia20=='') {
        $this->excel->getActiveSheet()->setCellValue('Y'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('Y'.$fila,$key->dia20);
      }
      if ($key->dia21=='') {
        $this->excel->getActiveSheet()->setCellValue('Z'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('Z'.$fila,$key->dia21);
      }
      if ($key->dia22=='') {
        $this->excel->getActiveSheet()->setCellValue('AA'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AA'.$fila,$key->dia22);
      }
      if ($key->dia23=='') {
        $this->excel->getActiveSheet()->setCellValue('AB'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AB'.$fila,$key->dia23);
      }
      if ($key->dia24=='') {
        $this->excel->getActiveSheet()->setCellValue('AC'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AC'.$fila,$key->dia24);
      }
      if ($key->dia25=='') {
        $this->excel->getActiveSheet()->setCellValue('AD'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AD'.$fila,$key->dia25);
      }
      if ($key->dia26=='') {
        $this->excel->getActiveSheet()->setCellValue('AE'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AE'.$fila,$key->dia26);
      }
      if ($key->dia27=='') {
        $this->excel->getActiveSheet()->setCellValue('AF'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AF'.$fila,$key->dia27);
      }
      if ($key->dia28=='') {
        $this->excel->getActiveSheet()->setCellValue('AG'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AG'.$fila,$key->dia28);
      }
      if ($dia29ant!='0' or $dia29ant!=''){
      /*  if ($key->dia29=='') {
          $this->excel->getActiveSheet()->setCellValue('AH'.$fila,'T' );
        }else {*/
          $this->excel->getActiveSheet()->setCellValue('AH'.$fila,$key->dia29);
      /*  }*/
      }else {
        $this->excel->getActiveSheet()->setCellValue('AH'.$fila,$key->dia29);
      }
      if ($dia30ant!='0' or $dia30ant!=''){
      /*  if ($key->dia30=='') {
          $this->excel->getActiveSheet()->setCellValue('AI'.$fila,'T' );
        }else {*/
          $this->excel->getActiveSheet()->setCellValue('AI'.$fila,$key->dia30);
        }
    /*  }*/else {
        $this->excel->getActiveSheet()->setCellValue('AI'.$fila,$key->dia30);
      }
      if ($dia31ant!='0' or $dia31ant!=''){
      /* if ($key->dia31=='') {
          $this->excel->getActiveSheet()->setCellValue('AJ'.$fila,'T' );
        }else {*/
          $this->excel->getActiveSheet()->setCellValue('AJ'.$fila,$key->dia31);
      /*  }*/
      }else {
        $this->excel->getActiveSheet()->setCellValue('AJ'.$fila,$key->dia31);
      }
      if ($key->diaactual1=='') {
        $this->excel->getActiveSheet()->setCellValue('AK'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AK'.$fila,$key->diaactual1);
      }
      if ($key->diaactual2=='') {
        $this->excel->getActiveSheet()->setCellValue('AL'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AL'.$fila,$key->diaactual2);
      }
      if ($key->diaactual3=='') {
        $this->excel->getActiveSheet()->setCellValue('AM'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AM'.$fila,$key->diaactual3);
      }
      if ($key->diaactual4=='') {
        $this->excel->getActiveSheet()->setCellValue('AN'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AN'.$fila,$key->diaactual4);
      }
      if ($key->diaactual5=='') {
        $this->excel->getActiveSheet()->setCellValue('AO'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AO'.$fila,$key->diaactual5);
      }
      if ($key->diaactual6=='') {
        $this->excel->getActiveSheet()->setCellValue('AP'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AP'.$fila,$key->diaactual6);
      }
      if ($key->diaactual7=='') {
        $this->excel->getActiveSheet()->setCellValue('AQ'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AQ'.$fila,$key->diaactual7);
      }
      if ($key->diaactual8=='') {
        $this->excel->getActiveSheet()->setCellValue('AR'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AR'.$fila,$key->diaactual8);
      }
      if ($key->diaactual9=='') {
        $this->excel->getActiveSheet()->setCellValue('AS'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AS'.$fila,$key->diaactual9);
      }
      if ($key->diaactual10=='') {
        $this->excel->getActiveSheet()->setCellValue('AT'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AT'.$fila,$key->diaactual10);
      }
      if ($key->diaactual11=='') {
        $this->excel->getActiveSheet()->setCellValue('AU'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AU'.$fila,$key->diaactual11);
      }
      if ($key->diaactual12=='') {
        $this->excel->getActiveSheet()->setCellValue('AV'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AV'.$fila,$key->diaactual12);
      }
      if ($key->diaactual13=='') {
        $this->excel->getActiveSheet()->setCellValue('AW'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AW'.$fila,$key->diaactual13);
      }
      if ($key->diaactual14=='') {
        $this->excel->getActiveSheet()->setCellValue('AX'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AX'.$fila,$key->diaactual14);
      }
      if ($key->diaactual15=='') {
        $this->excel->getActiveSheet()->setCellValue('AY'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AY'.$fila,$key->diaactual15);
      }
      if ($key->diaactual16=='') {
        $this->excel->getActiveSheet()->setCellValue('AZ'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('AZ'.$fila,$key->diaactual16);
      }
      if ($key->diaactual17=='') {
        $this->excel->getActiveSheet()->setCellValue('BA'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BA'.$fila,$key->diaactual17);
      }
      if ($key->diaactual18=='') {
        $this->excel->getActiveSheet()->setCellValue('BB'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BB'.$fila,$key->diaactual18);
      }
      if ($key->diaactual19=='') {
        $this->excel->getActiveSheet()->setCellValue('BC'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BC'.$fila,$key->diaactual19);
      }
      if ($key->diaactual20=='') {
        $this->excel->getActiveSheet()->setCellValue('BD'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BD'.$fila,$key->diaactual20);
      }
      if ($key->diaactual21=='') {
        $this->excel->getActiveSheet()->setCellValue('BE'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BE'.$fila,$key->diaactual21);
      }
      if ($key->diaactual22=='') {
        $this->excel->getActiveSheet()->setCellValue('BF'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BF'.$fila,$key->diaactual22);
      }
      if ($key->diaactual23=='') {
        $this->excel->getActiveSheet()->setCellValue('BG'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BG'.$fila,$key->diaactual23);
      }
      if ($key->diaactual24=='') {
        $this->excel->getActiveSheet()->setCellValue('BH'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BH'.$fila,$key->diaactual24);
      }
      if ($key->diaactual25=='') {
        $this->excel->getActiveSheet()->setCellValue('BI'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BI'.$fila,$key->diaactual25);
      }
      if ($key->diaactual26=='') {
        $this->excel->getActiveSheet()->setCellValue('BJ'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BJ'.$fila,$key->diaactual26);
      }
      if ($key->diaactual27=='') {
        $this->excel->getActiveSheet()->setCellValue('BK'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BK'.$fila,$key->diaactual27);
      }
      if ($key->diaactual28=='') {
        $this->excel->getActiveSheet()->setCellValue('BL'.$fila,'T' );
      }else {
        $this->excel->getActiveSheet()->setCellValue('BL'.$fila,$key->diaactual28);
      }
      if ($dia29!='0'){
        if ($key->diaactual29=='') {
          $this->excel->getActiveSheet()->setCellValue('BM'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('BM'.$fila,$key->diaactual29);
        }
      }else {
        $this->excel->getActiveSheet()->setCellValue('BM'.$fila,$key->diaactual29);
      }
      if ($dia30!='0'){
        if ($key->diaactual30=='') {
          $this->excel->getActiveSheet()->setCellValue('BN'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('BN'.$fila,$key->diaactual30);
        }
      }else {
        $this->excel->getActiveSheet()->setCellValue('BN'.$fila,$key->diaactual30);
      }
      if ($dia31!='0'){
        if ($key->diaactual31=='') {
          $this->excel->getActiveSheet()->setCellValue('BO'.$fila,'T' );
        }else {
          $this->excel->getActiveSheet()->setCellValue('BO'.$fila,$key->diaactual31);
        }
      }else {
        $this->excel->getActiveSheet()->setCellValue('BO'.$fila,$key->diaactual31);
      }
      $this->excel->getActiveSheet()->setCellValue('BP'.$fila,'=COUNTIF(AK'.$fila.':BO'.$fila.',"T")');
      $this->excel->getActiveSheet()->setCellValue('BQ'.$fila,'=COUNTIF(AK'.$fila.':BO'.$fila.',"DL")');
      $this->excel->getActiveSheet()->setCellValue('BR'.$fila,'=COUNTIF(AK'.$fila.':BO'.$fila.',"V")');
      $item++;
      $fila++;
    }

$this->excel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('Q')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('R')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('S')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('T')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('U')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('V')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('W')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('X')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('Y')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('Z')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AA')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AB')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AC')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AD')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AE')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AF')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AG')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AH')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AI')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AJ')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AK')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AL')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AM')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AN')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AO')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AP')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AQ')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AR')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AS')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AT')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AU')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AV')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AW')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AX')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AY')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('AZ')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BA')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BB')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BC')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BD')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BE')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BF')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BG')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BH')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BI')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BJ')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BK')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BL')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BM')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BN')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BO')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BP')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BQ')->setAutoSize(true);
$this->excel->setActiveSheetIndex(0)->getColumnDimension('BR')->setAutoSize(true);

    ob_end_clean();
    $filename='Tareo Mensual '.$periodo.' - '.$contratonom.'.xls';
    //save our workbook as this file name
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

public function plantilla($periodo){
  $this->load->library('excel');

  $personal=$this->Mtareo->plantilla_starsoft($periodo);
$contratonom=$this->session->userdata('alm_nombre');
  $this->excel->setActiveSheetIndex(0);
      $this->excel->getActiveSheet()->setTitle('plantilla - '.$contratonom.'');
      $this->excel->getActiveSheet()->setCellValue('A1', 'CODTRAB');
      $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('B1', 'NOMBRES');
      $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('C1', 'CCOSTO');
      $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('D1', 'DDESMED');
      $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('E1', 'DIASREIN');
      $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('F1', 'DIASSUBS');
      $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('G1', 'DIASTRAB');
      $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('H1', 'DIASVAC');
      $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('I1', 'DSUBENF');
      $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('J1', 'FALTAS');
      $this->excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('K1', 'HE100');
      $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('L1', 'HE25');
      $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('M1', 'HE35');
      $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
      $this->excel->getActiveSheet()->setCellValue('N1', 'HORASTRA');
      $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
      $fila=2;
      foreach ($personal as $key) {
        $this->excel->getActiveSheet()->setCellValue('A'.$fila, $key->codigo_personal);
        $this->excel->getActiveSheet()->setCellValue('B'.$fila, $key->trabajador);
        $this->excel->getActiveSheet()->setCellValue('E'.$fila, $key->dia_apoyo+substr_count($key->trabajados,'I'));
        $this->excel->getActiveSheet()->setCellValue('G'.$fila, substr_count(str_replace('PT','X',$key->trabajados),'T'));
        $this->excel->getActiveSheet()->setCellValue('L'.$fila, $key->hora_extra);

        $fila++;
        }
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
      $this->excel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
      ob_end_clean();
      $filename='plantilla '.$periodo.' - '.$contratonom.'.xls';
      //save our workbook as this file name
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
