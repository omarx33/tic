$(document).ready(function(){


  $('.datepicker').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Ultimos 7 Dias' : [moment().subtract(6, 'days'), moment()],
      'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
      'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Ultimo Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(6, 'days'),
    endDate  : moment(),
    locale: {
   format: 'DD/MM/YYYY'
      }
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('dd/mm/yyyy') + ' - ' + end.format('dd/mm/yyyy'))
  }
);


  });



  $('#empresa').on('change',function(e){
  tabla_movimientos($('#periodo').val(),$('#empresa').val());
  });
  $('#periodo').on('change',function(e){
  tabla_movimientos($('#periodo').val(),$('#empresa').val());
  });



  function tabla_movimientos(periodo,empresa){
    $.post(baseurl+"Componente/movimientos_oc/",
    {periodo:periodo,empresa:empresa},

    function(data){

     $("#tbl_consulta_mov").html(data);

    });
  }
