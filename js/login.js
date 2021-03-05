$('#ingreso').click(function(e){
  e.preventDefault();
$.ajax({

  type:"post",
  url:baseurl+"Login/logueo",
  data:$('#form-log').serialize(),
  success:function(data){
   if (data=='1') {
	//	alert(data);
     window.location=(baseurl+"Inicio");

   }else {
     $('#msg').html(data);
   }

  }
});

});
