
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                DASHBOARD

                </h1>
            </section>
            <!-- Main content -->
            <section class="content">

<div class="row">
  <div class="col-lg-4 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?php echo $rock; ?></h3>
          <p>ROCKDRILL</p>
        </div>
        <div class="icon">
        <i class="fas fa-laptop"></i>

        </div>
        <a href="#" class="small-box-footer">Equipo asignado</i></a>
      </div>
    </div>

    <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $cod ?><sup style="font-size: 20px"></sup></h3>

              <p>CODRISE</p>
            </div>
            <div class="icon">
    <i class="fas fa-file-alt"></i>
            </div>
            <a href="<?php echo base_url() ?>Contrato/maquinas" class="small-box-footer">Equipo asignado</i></a>
          </div>
        </div>


        <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                  <h3><?php echo $hel ?><sup style="font-size: 20px"></sup></h3>

                  <p>HELIX</p>
                </div>
                <div class="icon">
                  <i class="fas fa-people-carry"></i>
                </div>
                <a href="<?php echo base_url() ?>Contrato/maquinas" class="small-box-footer">Equipo asignado</i></a>
              </div>
            </div>

</div>
<!-- ssssssssssssssssss -->


<div class="row">
  <div class="col-lg-4 col-xs-3">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?php echo $rock_dis; ?></h3>
          <p>ROCKDRILL</p>
        </div>
        <div class="icon">
        <i class="fas fa-truck"></i>

        </div>
        <a href="#" class="small-box-footer">Equipo disponible</i></a>
      </div>
    </div>

    <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $cod_dis ?><sup style="font-size: 20px"></sup></h3>

              <p>CODRISE</p>
            </div>
            <div class="icon">
              <i class="fas fa-truck-loading"></i>
            </div>
            <a href="<?php echo base_url() ?>Contrato/maquinas" class="small-box-footer">Equipo disponible</i></a>
          </div>
        </div>


        <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                  <h3><?php echo $hel_dis ?><sup style="font-size: 20px"></sup></h3>

                  <p>HELIX</p>
                </div>
                <div class="icon">
              <i class="fas fa-list-ol"></i>
                </div>
                <a href="<?php echo base_url() ?>Contrato/maquinas" class="small-box-footer">Equipo disponible</i></a>
              </div>
            </div>

</div>


<div class="row">
  <div class="col-md-9">
    <figure class="highcharts-figure">
        <div id="container"></div>

  </div>



  <div style="margin-top: 100px;" class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php
$valor =$cant_cod+$cant_rock+$cant_hel;
            echo "$ ".number_format($valor,2,".",",") ?><sup style="font-size: 20px"></sup></h3>

            <p>TOTAL EN DOLARES</p>
          </div>
          <div class="icon">
        <i class="fas fa-usd"></i>
          </div>
          <a href="<?php echo base_url() ?>Contrato/maquinas" class="small-box-footer">Total general reporte del mes</i></a>
        </div>
      </div>

</div>


            </section>



        </div>
        <!-- /.content-wrapper -->





        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>


<script>
$(document).ready(function () {
//alert("s");
});


// Create the chart
Highcharts.chart('container', {
  chart: {
      type: 'column'
  },
  title: {
      text: 'INVERSIÓN DEL MES POR EMPRESA'
  },
  subtitle: {
      text: 'Reporte'
  },
  accessibility: {
      announceNewData: {
          enabled: true
      }
  },
  xAxis: {
      type: 'category'
  },
  yAxis: {
      title: {
          text: 'Total '
      }

  },
  legend: {
      enabled: false
  },
  plotOptions: {
      series: {
          borderWidth: 0,
          dataLabels: {
              enabled: true,
              format: '$. {point.y:.1f}'
          }
      }
  },

  tooltip: {
      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$.{point.y:.2f}</b> total<br/>'
  },

  series: [
      {
          name: "Total",
          colorByPoint: true,
          data: [
              {
                  name: "CODRISE",
              y: <?php echo $cant_cod ?>
              },
              {
                  name: "ROCKDRILL",
                    y: <?php echo $cant_rock ?>
              },
              {
                  name: "HELIX",
                y: <?php echo $cant_hel ?>
              }

          ]
      }
  ]
});
</script>
