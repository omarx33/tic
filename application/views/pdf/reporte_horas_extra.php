<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de días de apoyo</title>
  </head>
  <body>

    <div class="row">
      <div class="col-md-2">

      </div>
      <div class="col-md-2">
        <img src="<?php echo base_url() ?>assets/img/logo-grande.png" alt="" width='90px'>
      </div>
      <div class="col-md-4">
        <center><b>INFORME HORAS EXTRA <?php echo $periodo ?> </b></center>
      </div>
      <div class="col-md-4">

      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <table>
      <tr>
        <td style="border: 0;">A:</td>
        <td style="border: 0;">Gerencia de Operaciones</td>
      </tr>
      <tr>
        <td style="border: 0;">CC:</td>
        <td style="border: 0;">Gestion Humana</td>
      </tr>
      <tr>
        <td style="border: 0;">CC:</td>
        <td style="border: 0;">Planeamiento</td>
      </tr>
      <tr>
        <td style="border: 0;">CC:</td>
        <td style="border: 0;">Asistentes de Operaciones</td>
      </tr>
    </table>
    <br>
    <br>
    <br>

    <table>
      <tr>
        <td style="border: 0;">De:</td>
        <td style="border: 0;"><?php echo $this->session->nombre." ".$this->session->apepat ?></td>
      </tr>
      <tr>
        <td style="border: 0;">Cargo:</td>
        <td style="border: 0;"><?php echo $this->session->user_cargo." ".$this->session->alm_nombre ?> </td>
      </tr>
      <tr>
        <td style="border: 0;">Fecha:</td>
        <td style="border: 0;"><?php echo $fecha_inicio ?></td>
      </tr>

      <tr>
        <td style="border: 0;">Asunto:</td>
        <td style="border: 0;">Informe de Horas Extras</td>
      </tr>
    </table>
    <br>
    <p>Por medio del presente me dirijo a Ud. Para saludarlo muy cordialmente y a la vez comunicarle las horas extras del personal</p>
    <center><b>_______________________________________________________________________________________</b></center><br><br>
    <style media="screen">
    table {
       width: 100%;
       border-collapse: collapse;
    }
    th, td {
      font-size: 10pt;

       border: 1px solid #000;


       caption-side: bottom;
    }

    </style>
    <table class="tabla">
      <thead>
        <tr>
          <th style=" text-align: center;"><b>Item</b></th>
          <th style=" text-align: center;"><b>Apellidos y Nombre</b> </th>
          <th style=" text-align: center;"><b>Cargo</b> </th>
          <th style=" text-align: center;"><b>Fecha de Apoyo</b> </th>
          <th style=" text-align: center;"><b>Total de Horas</b> </th>
          <th style=" text-align: center;"><b>Motivo de dias de apoyo</b> </th>
        </tr>
      </thead>
      <tbody>
        <?php $item=1; foreach ($info as $key): ?>
          <tr>
            <td><center><?php echo $item ?></center></td>
            <td><?php echo $key->apepat_personal.' '.$key->apemat_personal.', '.$key->nombre_personal ?></td>
            <td><?php echo $key->cargo_personal ?></td>
            <td><?php echo str_replace(',','<br>-',$key->fecha) ?></td>
            <td><center><?php echo $key->horas ?></center></td>
            <td><?php echo str_replace(',','<br>-',$key->motivo) ?></td>
          </tr>
        <?php $item++; endforeach; ?>
      </tbody>
    </table>
  </body>
</html>
