'use strict';

/**
 * Funcion que se encarga de llamar a la funcion pertinente para
 * generar el archivo xsl
*/
function exportarProducto(nombreProducto) {
  var baseUrl= location.protocol + '//' + location.host;
  var url = baseUrl +  Routing.generate('productos_excel_'+nombreProducto);
  $.ajax({
      url: url,
      async: true,
      crossDomain: true,
      success: function(data) {
        console.log(data);
      },
      error: function(xhr, status, error) {
        console.error(xhr);
        console.error(status);
        console.error(error);
      }
  });
}


$(function(){
  $( '#exportar-articulos').bind('click',function(){
    exportarProducto('articulos');
  });

  $( '#exportar-capitulos-libro').bind('click',function(){
    exportarProducto('capitulos_libro');
  });

  $( '#exportar-libros').bind('click',function(){
    exportarProducto('libros');
  });

  $( '#exportar-proyectos-dirigidos').bind('click',function(){
    exportarProducto('proyectos_dirigidos');
  });

  $( '#exportar-software').bind('click',function(){
      exportarProducto('software');
  });

});
