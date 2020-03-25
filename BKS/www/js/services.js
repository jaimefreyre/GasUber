angular.module('starter.services', [])
.factory('svc', function($http, $timeout) {
  
  let ofertasJson = function(direccion){
    return $http.get(direccion);
  };
  
  let estiloJson = function(){
    return $http.get('js/estilo.JSON');
  };

  return {
    dPts: ofertasJson,
    estiloJSON: estiloJson  
  };

});