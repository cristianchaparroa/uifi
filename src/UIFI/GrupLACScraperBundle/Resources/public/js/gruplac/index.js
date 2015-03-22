/**
 *@file index.js
 *@author: Cristian Camilo Chaparro Africano.
*/

$(function(){
  /**
  * Its happening in the index view
  */
  $('#btn-agregar-gruplac').bind('click',function(){
    $('#gruplac').empty();
  });
  $('#crear-msuccess').hide();

  /**
   * ___________________________________________________________________________
   *
   * Its happening in the new view
  */

  $('#fail').hide();
  $( '#crear').prop('disabled', true);

  $('#gruplac').keypress(function(e){
    check();
  });//end keypress gruplac

  $('#gruplac').keyup(function(e){
    check();
  });
  $('#gruplac').donetyping(function(){
    check();
  });


  $('#crear').bind('click',function(event)
  {
    var baseUrl= location.protocol + "//" + location.host;
    var url = baseUrl +  Routing.generate('admin_configuration_gruplac_new');
    var data = { 'code':$('#gruplac').val()};
    console.log( JSON.stringify(data) ) ;
    $.ajax({
      url: url,
      async: true,
      crossDomain: true,
      method:'POST',
      data:data,
      success: function(data)
      {
        console.log( JSON.stringify(data) ) ;
        if( data.success===true){
          $('#gruplac').val( '');
          $('#agregarGruplacDialogo').modal('toggle');
          $('#crear-msuccess').show();
          $('#messageSuccess').remove();
          $('#crear-msuccess').append('<p id="messageSuccess">El gruplac se creo satisfactoriamente </p>');
        }
        else{
          $('#fail').show();
          $( '#messageFail').remove();
          $( '#fail' ).append('<p id="messageFail">No se ha podido crear el gruplac</p>');
        }
      },
      error: function(xhr, status, error)
      {
        console.log(JSON.stringify(xhr));
        console.log(JSON.stringify(status));
        console.log(JSON.stringify(error));
      }
    }).always(function(){});//end ajax
    event.preventDefault();
    event.stopPropagation();
  });

});

/**
 * ___________________________________________________________________________
 *
 * functions
*/

/**
* Función que se encarga de verificar si el código del gruplac ya esta registrado
* en el sistema.
*/
function check(){
  var $code = $('#gruplac').val();
  if( $.isNumeric($code)  ){
    $('#fail').hide();

     if( $code.length >= 13 )
     {
       $( '#crear').prop('disabled', false);
      var baseUrl= location.protocol + "//" + location.host;
      var url = baseUrl +  Routing.generate('admin_configuration_gruplac_check');
      var data = { 'code':$('#gruplac').val()};

      $.ajax({
        url: url,
        async: true,
        crossDomain: true,
        method:'POST',
        data:data,
        success: function(data)
        {
          console.log( JSON.stringify(data) ) ;
          if( data.success===true){
            $('#fail').show();
            $( '#messageFail').remove();
            $( '#fail' ).append('<p id="messageFail">El Gruplac con este código ya existe </p>');
            $( '#crear').prop('disabled', true);
          }
          else{
            $( '#crear').prop('disabled', false);
          }
        },
        error: function(xhr, status, error)
        {
        }
      }).always(function(){});//end ajax
    }
    else{
      $( '#crear').prop('disabled', true);
    }

  }
  else{
    $('#fail').show();
    $( '#messageFail').remove();
    $( '#fail' ).append('<p id="messageFail">El código consta de solo números</p>');
  }
}
