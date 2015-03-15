/**
 * @file
 * @author: Cristian Camilo Chaparro Africano.
*/

var isInProgress = false;

$(function(){
  $('#dashboard').disable=true;
  $( '.log-error' ).hide();
  $( '.log-success' ).hide();
  /**
   * se inicia el proceso de importación de información del gruplac.
  */
  $( '#button-getInformacion' ).bind('click',function(){
      var baseUrl= location.protocol + "//" + location.host;
      var url = baseUrl +  Routing.generate('dasboard_get_informacion');

      // $.ajax({
      //   url: url,
      //   success: function(data)
      //   {
      //      if(data.success){
      //        $( '.log-success' ).show();
      //        $('.log-success').append( 'El proceso ha terminado exitosamente' );
      //      }
      //      else{
      //         $( '.log-error' ).show();
      //         $('.log-error').append( 'No se ha podido importar la información correctamente' );
      //      }
      //   },
      //   error: function(xhr, status, error)
      //   {
      //     console.log("error");
      //   }
      // });//end ajax

  });//end bind
});
