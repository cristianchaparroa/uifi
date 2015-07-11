'use strict';


app.factory('GruposService',['$http',function($http){

  function GruposService(){
    this.data = undefined;
  }

  /**
   * Consume el servicio para obtener la lista de grupos en el sistema,
   *
   * @return promise
  */
  GruposService.prototype.serviceListar = function(){
    var promise = $http.get( Routing.generate('app_list_grupos') );
    var self = this;
    promise.then(function(data){
        self.data = data;
        return self.data;
    });
    return promise;
  };
  /**
   * Procesa la respuesta del servicio.
  */
  GruposService.prototype.listarGrupos = function( ){
      var grupos = [];
      for( var i=0; i<this.data.data.length; i++){
         var grupo  =  this.data.data[i];
         var grupoObject = JSON.parse(grupo);
         grupos.push(grupoObject);
      }
      return grupos;
  };

  return GruposService;
}]);
