app.controller('GruposController',['$scope','GruposService',
  function($scope, GruposService){
      $scope.title ='Grupos de Investigiación';

      /**
       * Constructor del Controlador
       */
      $service.inicializar = function (){
        $service = new GruposService();
        $promise = $service.serviceListar();
        $promise.then(function(){
          $scope.grupos  = $service.listarGrupos();
        });
      };

      $service.inicializar();

  }
]);
