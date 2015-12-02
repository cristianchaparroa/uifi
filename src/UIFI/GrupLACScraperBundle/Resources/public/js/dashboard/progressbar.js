'use strict';
/**
 * @file
 * @author: Cristian Camilo Chaparro Africano.
*/

var isInProgress = false;
var handlerCheckProgress;
var handlerGetInformation;
var porcentaje = 0;
var   $progressBar;

$(function(){
  jQuery.support.cors = true;
  $progressBar = $('.progress .progress-bar');
  $('.progress').hide();
  $( '.log-success' ).hide();
  $( '.log-fail' ).hide();

  $('#cancelar-proceso').prop('disabled',true);
  /**
   * se inicia el proceso de importación de información del gruplac.
  */
  $( '#button-getInformacion' ).bind('click',function(event)
  {

      var $codes = [];
      $.each( $('input[name="btSelectItem"]:checkbox:checked').closest("td").siblings("td") ,function(){
        if( $(this).attr('class') ==='id' ) {
          $codes.push( $(this).text() );
        }
      });

      if( $codes.length >0 ) {
          var data = { 'codes': $codes };
          $('#cancelar-proceso').prop('disabled',false);
          porcentaje = 0;
          $( '.log-success' ).hide();
          $('.progress').show();
          var baseUrl= location.protocol + "//" + location.host;
          var url = baseUrl +  Routing.generate('dasboard_get_informacion');

          handlerCheckProgress = setInterval(function(){
            $progressBar.attr('data-transitiongoal', porcentaje ).progressbar({display_text: 'center'});
            if(porcentaje!=90){
              porcentaje++;
            }

          },1000);

          handlerGetInformation = $.ajax({
            url: url,
            async: true,
            crossDomain: true,
            data:data,
            method:'POST',
            success: function(data) {
              console.log(data);
              $progressBar.attr('data-transitiongoal', '100').progressbar({display_text: 'center'});

              $( '.log-success' ).show();
              $( '.message').remove();
              $( '.log-success' ).append('<p class="message">El proceso ha terminado satisfactoriamente</p>');
            }, error: function(xhr, status, error) {
              console.log( JSON.stringify(xhr) ) ;
              console.log( JSON.stringify(status) ) ;
              console.log( JSON.stringify(error) ) ;

              $( '.log-fail' ).show();
              $( '.messageFail').remove();
              $( '.log-fail' ).append('<p class="messageFail">El proceso Fallo</p>');
            }
          }).always(function() {
              $progressBar.attr('data-transitiongoal', '100').progressbar({display_text: 'center'});
              clearInterval(handlerCheckProgress);
              handlerCheckProgress = null;
              setTimeout(function(){
                $('.progress').hide();
              },4000);

          });//end ajax
      }
      event.preventDefault();
      event.stopPropagation();
  });//end bind


  $('#cancelar-proceso').bind('click',function(){
    if( handlerGetInformation!=undefined){
      handlerGetInformation.abort();
      $( '.log-fail' ).show();
      $( '.messageFail').remove();
      $( '.log-fail' ).append('<p class="messageFail">El proceso se cancelo,La información pudo haber quedado incompleta.</p>');

      setTimeout(function(){
        $('.log-fail').hide();
      },6000);
    }
  });//end bind cancelar-proceso
});
