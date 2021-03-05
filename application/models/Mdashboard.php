<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdashboard extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  public function equipo_rock(){
    $valor = 3;
  $this->db->select('estado');
  $this->db->from('equipo_tic');
  $this->db->where("empresa", $valor);
    $this->db->where("estado", 0);
  $query=$this->db->get();
return $query->num_rows();

  }

  public function equipo_cod(){
    $valor = 2;
  $this->db->select('estado');
  $this->db->from('equipo_tic');
  $this->db->where("empresa", $valor);
    $this->db->where("estado", 0);
  $query=$this->db->get();
return $query->num_rows();

  }
  public function equipo_hel(){
    $valor = 4;
  $this->db->select('estado');
  $this->db->from('equipo_tic');
  $this->db->where("empresa", $valor);
    $this->db->where("estado", 0);
  $query=$this->db->get();
return $query->num_rows();

  }




  public function equipo_rock_dis(){
    $valor = 3;
  $this->db->select('estado');
  $this->db->from('equipo_tic');
  $this->db->where("empresa", $valor);
      $this->db->where("estado", 1);
  $query=$this->db->get();
return $query->num_rows();

  }

  public function equipo_cod_dis(){
    $valor = 2;
  $this->db->select('estado');
  $this->db->from('equipo_tic');
  $this->db->where("empresa", $valor);
      $this->db->where("estado", 1);
  $query=$this->db->get();
return $query->num_rows();

  }
  public function equipo_hel_dis(){
    $valor = 4;
  $this->db->select('estado');
  $this->db->from('equipo_tic');
  $this->db->where("empresa", $valor);
      $this->db->where("estado", 1);
  $query=$this->db->get();
return $query->num_rows();

  }







          public function consulta_cod(){
           $empresa = '2';
           $anio = date("Y");
           $mes = date("m");


           $this->db->select('ft.nro_requerimiento,fd.img,a.codigo_ss,ft.fecha_creacion');
           $this->db->from('stock s');
           $this->db->join('articulos a', 's.codigo = a.codigo_ss');
           $this->db->join('ficha_detalle fd', 's.correlativo = fd.correlativo and s.empresa= fd.empresa and a.idarticulos = fd.img');
           $this->db->join('ficha_tecnica ft', 'ft.correlativo = fd.correlativo and ft.empresa= fd.empresa');
           $this->db->where('s.empresa', $empresa);
           $this->db->where('nro_requerimiento !=', 100);
             $this->db->where('nro_requerimiento !=', 0);
           $this->db->where('year(s.fecha_creacion)', $anio);
           $this->db->where('month(s.fecha_creacion)', $mes);
           $this->db->where('fd.cantidad = fd.cantidad_recibida');
            $query=$this->db->get();

            return $query->result();

          }



                    public function consulta_rock(){
                     $empresa = '3';
                     $anio = date("Y");
                     $mes = date("m");

                      $this->db->select('ft.nro_requerimiento,fd.img,a.codigo_ss,ft.fecha_creacion');
                      $this->db->from('stock s');
                      $this->db->join('articulos a', 's.codigo = a.codigo_ss');
                      $this->db->join('ficha_detalle fd', 's.correlativo = fd.correlativo and s.empresa= fd.empresa and a.idarticulos = fd.img');
                      $this->db->join('ficha_tecnica ft', 'ft.correlativo = fd.correlativo and ft.empresa= fd.empresa');
                      $this->db->where('s.empresa', $empresa);
                      $this->db->where('nro_requerimiento !=', 100);
                        $this->db->where('nro_requerimiento !=', 0);
                      $this->db->where('year(s.fecha_creacion)', $anio);
                      $this->db->where('month(s.fecha_creacion)', $mes);
                      $this->db->where('fd.cantidad = fd.cantidad_recibida');

                      $query=$this->db->get();

                      return $query->result();

                    }



                              public function consulta_hel(){
                               $empresa = '4';
                               $anio = date("Y");
                               $mes = date("m");

//                       $result =  $this->db->query('SELECT ft.nro_requerimiento,fd.img,a.codigo_ss,ft.fecha_creacion from ficha_tecnica ft
// join ficha_detalle fd on ft.correlativo = fd.correlativo
// join articulos a on a.idarticulos =  fd.img
// where ft.empresa = 4 and fd.empresa = 4 and year(ft.fecha_creacion) = 2020 and month(ft.fecha_creacion) = 02 and  fd.cantidad = fd.cantidad_recibida group by ft.nro_requerimiento,fd.img,a.codigo_ss,ft.fecha_creacion ');
//                                 return $result->result();

                              $this->db->select('ft.nro_requerimiento,fd.img,a.codigo_ss,ft.fecha_creacion');
                              $this->db->from('stock s');
                              $this->db->join('articulos a', 's.codigo = a.codigo_ss');
                              $this->db->join('ficha_detalle fd', 's.correlativo = fd.correlativo and s.empresa= fd.empresa and a.idarticulos = fd.img');
                              $this->db->join('ficha_tecnica ft', 'ft.correlativo = fd.correlativo and ft.empresa= fd.empresa');
                              $this->db->where('s.empresa', $empresa);
                              $this->db->where('nro_requerimiento !=', 100);
                                $this->db->where('nro_requerimiento !=', 0);
                              $this->db->where('year(s.fecha_creacion)', $anio);
                              $this->db->where('month(s.fecha_creacion)', $mes);
                              $this->db->where('fd.cantidad = fd.cantidad_recibida');
                              $this->db->group_by('ft.nro_requerimiento,fd.img,a.codigo_ss,ft.fecha_creacion');

                              $query=$this->db->get();

                              return $query->result();

                              }




public function consulta_starsoft_cod($requerimiento,$codigo){
  $bdstarsoft=$this->load->database('starsoft',TRUE);

  $bdstarsoft->select("case
when OC_CCODMON = 'MN' then (OC_NTOTNET/OC_CANT)/OC_NTIPCAM
when OC_CCODMON = 'ME' then (OC_NTOTNET/OC_CANT)
end as valor");
  $bdstarsoft->from('010BDCOMUN.dbo.COMOVd_S c');
  $bdstarsoft->join('010BDCOMUN.dbo.COMOVc_S d', 'c.OC_CNUMORD=d.OC_CNUMORD');
  $bdstarsoft->where('OC_CNRODOCREF like ', '%'.$requerimiento.'%');
  $bdstarsoft->where('OC_CODSERVICIO', $codigo);
  //  $bdstarsoft->where('OC_CCODMON', 'ME');
        $query=$bdstarsoft->get();
      //  echo $bdstarsoft->last_query();
    //  return $bdstarsoft->result();
      return $query->row("valor");
}




public function consulta_starsoft_rock($requerimiento,$codigo){
  $bdstarsoft=$this->load->database('starsoft',TRUE);

  $bdstarsoft->select("case
when OC_CCODMON = 'MN' then (OC_NTOTNET/OC_CANT)/OC_NTIPCAM
when OC_CCODMON = 'ME' then (OC_NTOTNET/OC_CANT)
end as valor");
  $bdstarsoft->from('004BDCOMUN.dbo.COMOVd_S c');
  $bdstarsoft->join('004BDCOMUN.dbo.COMOVc_S d', 'c.OC_CNUMORD=d.OC_CNUMORD');
  $bdstarsoft->where('OC_CNRODOCREF like ', '%'.$requerimiento.'%');
  $bdstarsoft->where('OC_CODSERVICIO', $codigo);
  //  $bdstarsoft->where('OC_CCODMON', 'ME');
        $query=$bdstarsoft->get();
      //  echo $bdstarsoft->last_query();
    //  return $bdstarsoft->result();
      return $query->row("valor");
}


public function consulta_starsoft_hel($requerimiento,$codigo){
  $bdstarsoft=$this->load->database('starsoft',TRUE);

  $bdstarsoft->select("SUM(case
when OC_CCODMON = 'MN' then (OC_NTOTNET/OC_CANT)/OC_NTIPCAM
when OC_CCODMON = 'ME' then (OC_NTOTNET/OC_CANT)
end) as valor");
  $bdstarsoft->from('018BDCOMUN.dbo.COMOVd_S c');
  $bdstarsoft->join('018BDCOMUN.dbo.COMOVc_S d', 'c.OC_CNUMORD=d.OC_CNUMORD');
  $bdstarsoft->where('OC_CNRODOCREF like ', '%'.$requerimiento.'%');
  $bdstarsoft->where('OC_CODSERVICIO', $codigo);
  $bdstarsoft->group_by('OC_CODSERVICIO');

    $query=$bdstarsoft->get();
    return $query->row("valor");

// $query = $bdstarsoft->query("IF (".$requerimiento."=3460)
// BEGIN
// 	select (OC_NTOTNET/OC_CAN)T,OC_CCODMON,oc_ntipcam,case
// when OC_CCODMON = 'MN' then (OC_NTOTNET/OC_CANT)/OC_NTIPCAM
// when OC_CCODMON = 'ME' then (OC_NTOTNET/OC_CANT)
// end as valor
// 	from [018BDCOMUN].dbo.COMOVc_S c inner join [018BDCOMUN].dbo.COMOVd_S d on c.OC_CNUMORD=d.OC_CNUMORD
// 	where OC_CNRODOCREF LIKE '%".$requerimiento."%' AND OC_COMENTA = '".$codigo."'
// END
// ELSE
// BEGIN
// 	select (OC_NTOTNET/OC_CANT),OC_CCODMON,oc_ntipcam,case
// when OC_CCODMON = 'MN' then (OC_NTOTNET/OC_CANT)/OC_NTIPCAM
// when OC_CCODMON = 'ME' then (OC_NTOTNET/OC_CANT)
// end as valor
// 	from [018BDCOMUN].dbo.COMOVc_S c inner join [018BDCOMUN].dbo.COMOVd_S d on c.OC_CNUMORD=d.OC_CNUMORD
// 	where OC_CNRODOCREF LIKE '%".$requerimiento."%' AND OC_CODSERVICIO = '".$codigo."'
// END");
//
//
//
//       return $query->row("valor");
}


  /* -> Obtener todas las áreas */
  public function getAreas(){
    $this->db->where("estado","01");
    $this->db->select("a.idarea ,a.descripcion");
    $this->db->from("area a");
    $resultados = $this->db->get();
    return $resultados->result();
  }

  /* Obtener consumo por área */
  // public function csm_area(){
  //   $this->db->
  // }

}
