var app = angular.module('uifi',['ui.router']);

app.config(['$stateProvider','$interpolateProvider',
  function($stateProvider,$interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');

    $stateProvider.state('grupos', {
        url: '/grupos',
        templateUrl: Routing.generate('app_grupos_index'),
        controller : 'GruposController'
    });
}]);
