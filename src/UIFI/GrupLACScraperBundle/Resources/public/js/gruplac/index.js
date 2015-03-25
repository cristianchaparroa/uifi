/**
 * @file index.js
 * @author: Cristian Camilo Chaparro Africano.
*/

var $table = $('#gruplac-table');
var $remove = $('#remove');

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
      async: false,
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

          var entities= data.entities;
          updateTable(entities);
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




  $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
    $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
  });
  $remove.click(function ()
  {
      var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
        return row.id
      });
      
      $table.bootstrapTable('remove', {
        field: 'id',
        values: ids
      });

      $remove.prop('disabled', true);
  });


}); //jquery init

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
            showError('uifi.configuracion.gruplac.errorcodigo');
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
    showError('uifi.configuracion.gruplac.errorsolonumeros');
  }
}

/**
 * Función que muestra un mensaje de error bajo el codigo ingresado
 * por el usuario.
 *
 * @param error, pathID del error a renderizar.
*/
function showError(error){
  if( !$('#fail').is(":visible")){
    $('#fail').show();
    $( '#messageFail').remove();
    $( '#fail' ).append('<p id="messageFail">'+translate(error)+'</p>');
  }
}
/**
 * Función que se encarga de actualizar la tabla del gruplac.
 * @param entities, las nuevas entidades que se van a emplear para reemplazar el
 *   contenido de la tabla actual.
*/
function updateTable(entities){
  $rows =  $('#gruplac-table > tbody > tr');
  $rows.each(function(){
    $(this).remove();
  });
  $table = $('#gruplac-table');
//;
  $(entities).each(function(index){
    var entity = $(this)[0] ;
    var id =  entity['id'] ;
    var nombre = entity['nombre'];
    $row = '<tr data-index="'+index+'"> <td> <button id="btnDelete" href="">delete</button> </td><td>'+nombre+'</td></tr>';
    $table.append( $row );
  });
}
