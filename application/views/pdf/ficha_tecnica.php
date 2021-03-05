<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ficha técnica Nro: <?php echo str_pad($cabecera->correlativo, 7, "0", STR_PAD_LEFT) ?></title>

    <style media="screen">
    table{
      width: 100%;
    }
    .titulo{

  padding-top: -5px;

   padding-bottom: 20px;
   padding-left: 20%;
    }
    .tdtable{
     padding-left: 32%;

    }

    .table-detalle
    {
    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    font-size:12px;
    width: 710px;
    text-align: center;
          border: 1px solid black;

    }
    .table-detalle2
    {

    font-size:12px;

    text-align: center;
    border: 1px solid black;

    }
    .td_th_det{
      width: 100px;
      background-color: #938B8A;
border-right:  1px solid black;
    }
    .td_det{
border: 1px solid black;
width: 100px;

    }
    .td_det2{
border: 1px solid black;
width: 100px;


    }
    .td_th_det2{

      background-color: #938B8A;
      border-right:  1px solid black;
      border-left:   1px solid black;
    }
    .td_th_det3{

      border-right:  1px solid black;
      border-left:   1px solid black;

    }

</style>

  </head>
  <body>



 <div class="pull-right">
   <?php if ($cabecera->empresa == "4"): ?>
       <h5 style="padding: 10px"><img src="<?php echo base_url() ?>assets/img/helix.png" alt="200px" width="180px">  <a style="float: right; padding-top: 15px;">Área de TIC</a> </h5>

<?php elseif($cabecera->empresa == "2"): ?>
             <h5 style="padding: 10px"><img src="<?php echo base_url() ?>assets/img/codrise.png" alt="200px" width="180px">  <a style="float: right; padding-top: 15px;">Área de TIC</a> </h5>
     <?php else: ?>
       <h5 style="padding: 10px"><img src="<?php echo base_url() ?>assets/img/rocklogo.png" alt="200px" width="180px">  <a style="float: right; padding-top: 15px;">Área de TIC</a> </h5>
   <?php endif; ?>

 </div>

<div class="titulo">


<H3>FICHA TECNICA DE ACCESORIO DE REPUESTOS</H3>
<h3  class="tdtable"><?php echo "N° ".str_pad($cabecera->correlativo, 7, "0", STR_PAD_LEFT); ?></h3>
</div>
<table class="table-detalle" cellspacing="0">
  <thead>
    <tr>
    <th  class="td_th_det" >USUARIO DE TIC</th>
    <th class="td_th_det"  >FECHA</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="td_det"><?php echo $cabecera->usuario_tic ?></td>
      <td class="td_det"><?php echo $cabecera->fecha_creacion ?></td>
    </tr>
  </tbody>
</table>
<br>
<table  class="table-detalle" cellspacing="0">
  <thead>
  <tr>
  <th class="td_th_det" style="">ÁREA SOLICITANTE</th>
  <th class="td_th_det" style="">SOLICITANTE</th>
  </tr>
  </thead>
  <tbody>
    <tr>
      <td class="td_det"><?php echo $cabecera->descripcion ?></td>
        <td class="td_det"><?php echo $cabecera->fullname_solicitante; ?></td>
    </tr>
  </tbody>
</table>
<br>
<!-- detalles -->

<table border="0"  class="table-detalle" cellspacing="0" width='100%'>
  <thead>
    <tr>
      <th class="td_th_det2" >PRODUCTO</th>
        <th class="td_th_det2">CANTIDAD</th>
        <th class="td_th_det2">UND MED</th>
        <th class="td_th_det2">DESCRIPCIÓN TÉCNICA</th>
        <th class="td_th_det2">COMENTARIO</th>

    </tr>

  </thead>
  <tbody>
    <?php foreach ($detalle as $key => $value): ?>

      <tr>
          <td class="td_det" style="font-size:8pt"><?php echo $value->nom_img." PRECIO REFERENCIAL: S/".$value->precio_ref?></td>
          <td class="td_det" style="font-size:8pt"> <?php echo $value->cantidad; ?></td>
          <td class="td_det" style="font-size:8pt">UND</td>
          <td class="td_det" style="font-size:8pt"> <?php echo $value->descripcion; ?></td>
          <td class="td_det" style="font-size:8pt"> <?php echo $value->comentario; ?></td>

      </tr>
      <tr>
        <th colspan="5" style="font-size:7.5pt">FUENTE: <?php echo $value->fuente ?></th>
      </tr>
      <tr>
        <th class="td_th_det" colspan="5" >IMAGEN REFERENCIAL</th>
      </tr>
      <tr>
        <td  class="td_det"   colspan="5">
     <img src="<?php echo base_url(); ?>assets/img/articulos/articulos_img/<?php echo $value->imagen; ?>"  width="100px">
     </td>
      </tr>

    <?php endforeach; ?>

  </tbody>


</table>

<!-- fin detalle -->



  </body>
</html>
