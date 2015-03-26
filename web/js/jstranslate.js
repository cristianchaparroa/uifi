/**
 * Función que se encarga de ir al servidor y traer la traducción adecuada
 * basado en el locale del sistema.
 *
 * @param pathID, identificador del texto a traducir
*/
function getTranslation( pathID ){
    var baseUrl= location.protocol + "//" + location.host;
    var url = baseUrl +  Routing.generate('js_translate');
    console.log(url);
    var data = { 'path':pathID};

    var ret = {
      data: false,
      message: '',
      internalServerError: false,
    };
    $.ajax({
      url:url,
      type: "POST",
      data: data,
      async: false,
      crossDomain: true,
      success: function(data) {
        console.log(JSON.stringify(data));
        ret.data = data;
      },
      error: function(request, status, error)
      {},
    });
    return ret;
}
/**
 * Función de generar la traduccion de un id (pathID)
 *
 * @param pathID, identificador del texto a traducir
 * @return Cadena traducida si se encontro tradución en caso contrario se retorna
 * el pathID.
*/
function translate(pathID){
    var ret = getTranslation(pathID);
    var translation = ((ret!==false) ? ((ret.data.success) ? ret.data.translation : pathID) : pathdID);
    return translation;
}
