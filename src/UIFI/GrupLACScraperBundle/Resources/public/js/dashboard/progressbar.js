/**
 * @file
 * @author: Cristian Camilo Chaparro Africano.
*/

var isInProgress = false;
var handlerCheckProgress;
var porcentaje = 0;
var   $progressBar;

$(function(){
  jQuery.support.cors = true;
  $progressBar = $('.progress .progress-bar');
  $('.progress').hide();

  $( '.log-success' ).hide();
  /**
   * se inicia el proceso de importación de información del gruplac.
  */
  $( '#button-getInformacion' ).bind('click',function(event)
  {
      porcentaje = 0;
      $( '.log-success' ).hide();
      $('.progress').show();
      var baseUrl= location.protocol + "//" + location.host;
      var url = baseUrl +  Routing.generate('dasboard_get_informacion');

      handlerCheckProgress = setInterval(function(){
        $progressBar.attr('data-transitiongoal', porcentaje ).progressbar({display_text: 'center'});
        if(porcentaje!=99){
          porcentaje++;
        }


        var base_url= location.protocol + "//" + location.host;
        var urlProgress = base_url +  Routing.generate('dasboard_get_progress');

        // console.log(urlProgress);
        // $.ajax({
        //   url: urlProgress,
        //   success: function(data)
        //   {
        //     console.log("procentaje"+data.porcentaje);
        //     porcentaje = data.porcentaje;
        //   },
        //   error: function(xhr, status, error)
        //   {
        //     console.log("error-checkprogress");
        //   }
        // });
      },1000);

      $.ajax({
        url: url,
        async: true,
        crossDomain: true,
        success: function(data)
        {
          console.log(data);
          $progressBar.attr('data-transitiongoal', '100').progressbar({display_text: 'center'});

          $( '.log-success' ).show();
          $( '.message').remove();
          $( '.log-success' ).append('<p class="message">El proceso ha terminado satisfactoriamente</p>');
        },
        error: function(xhr, status, error)
        {
          console.log( JSON.stringify(xhr) ) ;
          console.log( JSON.stringify(status) ) ;
          console.log( JSON.stringify(error) ) ;
        }
      }).always(function()
      {
          $progressBar.attr('data-transitiongoal', '100').progressbar({display_text: 'center'});
          clearInterval(handlerCheckProgress);
          handlerCheckProgress = null;
          setTimeout(function(){
            $('.progress').hide();
          },4000);

      });//end ajax

      event.preventDefault();
      event.stopPropagation();
  });//end bind
});
