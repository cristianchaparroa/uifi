/**
 * @file
 * @author: Cristian Camilo Chaparro Africano.
*/

var isInProgress = false;
var handlerCheckProgress;
var porcentaje = 0;
var   $progressBar;

$(function(){
  $progressBar = $('.progress .progress-bar');
  $('.progress').hide();

  $( '.log-success' ).hide();
  /**
   * se inicia el proceso de importación de información del gruplac.
  */
  $( '#button-getInformacion' ).bind('click',function()
  {
      $('.progress').show();
      var baseUrl= location.protocol + "//" + location.host;
      var url = baseUrl +  Routing.generate('dasboard_get_informacion');

      $.ajax({
        url: url,
        success: function(data)
        {
          console.log(data);
          $progressBar.attr('data-transitiongoal', '100').progressbar({display_text: 'center'});
        },
        error: function(xhr, status, error)
        {
          console.log("error");
        }
      }).always(function() {
        $('.progress').hide();
      });//end ajax

      setInterval(function(){
        $progressBar.attr('data-transitiongoal', porcentaje ).progressbar({display_text: 'center'});
        porcentaje++;

        var base_url= location.protocol + "//" + location.host;
        var urlProgress = base_url +  Routing.generate('dasboard_get_progress');

        console.log(urlProgress);
        $.ajax({
          url: urlProgress,
          success: function(data)
          {
            console.log(data);
            porcentaje = data.porcentaje; 
          },
          error: function(xhr, status, error)
          {
            console.log("error-checkprogress");
          }
        });
      },1000);
  });//end bind
});
