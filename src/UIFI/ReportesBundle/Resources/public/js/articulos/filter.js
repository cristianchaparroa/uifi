$(function()
{
  $("#uifi_reportes_articulo_grupo option[value='']").remove();
  $grupos = $("#uifi_reportes_articulo_grupo");
  $grupos.append($('<option>',{value: '',text: 'Seleccione...',selected: true,}));

  $('#submit-filter').bind('click',function(){

    var baseUrl= location.protocol + "//" + location.host;
    var url = baseUrl +  Routing.generate('reportes_articulos_filtro');

    $.ajax({
      url: url,
      async: true,
      crossDomain: true,
      success: function(data)
      {
      },
      error: function(xhr, status, error)
      {
        console.log( JSON.stringify(xhr) ) ;
        console.log( JSON.stringify(status) ) ;
        console.log( JSON.stringify(error) ) ;
      }
    }).always(function(){});


  });
});
