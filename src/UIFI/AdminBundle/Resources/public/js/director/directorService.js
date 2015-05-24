$(function(){
  var $agregarUsuario = $('#btn-agregar-usuario');
  var $crearUsuario = $('#crear-submit');
  var $message = $( '#message' );
  var codigo = '';

  $agregarUsuario.prop('disabled',true);
  $crearUsuario.prop('disabled',true);
  $('#email').val('' );
  $message.hide();

  $table = $('#directores-table');
  $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
    $agregarUsuario.prop('disabled', !$table.bootstrapTable('getSelections').length);
  });

  /**
   * Desactivo todos los checkbox que tienen un usuario asignado.
  */
  $.each( $('input[name="btSelectItem"]'),function(){
    var desactivar = false;
     //verifico  cada elemento
     var checkbox = $(this);
     $.each( checkbox.closest("td").siblings("td") ,function(){
       if( $(this).attr('class') ==='usuario' ){
         var texto =  $(this).text();
         texto = texto.replace(/ +?/g, '');
         if( texto.search('@') !==-1 ){
           checkbox.prop('disabled',true);
         }
       }
     });
  });

  $agregarUsuario.click(function(event){
    $.each( $('input[name="btSelectItem"]:checkbox:checked').closest("td").siblings("td") ,function(){
      if( $(this).attr('class') ==='codigo' ){
         codigo  = $(this).text();
      }
    });
  });//end click agregarUsuario



  $('#email').donetyping(function(){
    checkIsEmail();
    validateEmail();
  });

  $crearUsuario.click(function(event){
    var baseUrl= location.protocol + "//" + location.host;
    var url = baseUrl +  Routing.generate('admin_director_crear');
    var $email = $('#email').val();
    var data = { 'codigo':codigo, 'email': $email };
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
        if( data.success ){
          $('#agregarUsuariocDialogo').modal('toggle');
          bootbox.alert("El usuario se ha creado exitosamente");
        }
        else{
          $('#agregarUsuariocDialogo').modal('toggle');
          bootbox.alert("El usuario NO se pudo crear");
        }
      },
      error: function(xhr, status, error)
      {
        console.log(JSON.stringify(xhr));
        console.log(JSON.stringify(status));
        console.log(JSON.stringify(error));
      }
    });

    event.preventDefault();
    event.stopPropagation();

  });//end click crear usuario.

  function checkIsEmail(){
    var $email = $('#email').val();
    $email = $email.replace(/ +?/g, '');
    if( IsEmail($email) ){
      $crearUsuario.prop('disabled',false);
      $message.hide();
    }
    else{
      $crearUsuario.prop('disabled',true);
      $('#mess').remove();
      $message.show();
      $message.append( '<p id="mess">No es un email valido</p>' );
    }
  }

  function validateEmail(){
    var $email = $('#email').val();
    $email = $email.replace(/ +?/g, '');

    var baseUrl= location.protocol + "//" + location.host;
    var url = baseUrl +  Routing.generate('admin_director_verificaremail');
    var data = { 'email': $email };

    $.ajax({
      url: url,
      async: false,
      crossDomain: true,
      method:'POST',
      data:data,
      success: function(data)
      {
        console.log( JSON.stringify(data) ) ;
        if( data.success ){
          $crearUsuario.prop('disabled',true);
          $('#mess').remove();
          $message.show();
          $message.append( '<p id="mess">Ya existe otro usuario registrado con este email</p>' );
        }
        else{
          $crearUsuario.prop('disabled',false);
          $message.hide();
        }
      },
      error: function(xhr, status, error)
      {
        console.log(JSON.stringify(xhr));
        console.log(JSON.stringify(status));
        console.log(JSON.stringify(error));
      }
    });
  }

});


function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
