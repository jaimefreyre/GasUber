//Variable Global
 var vzxc = '../MDIA/uservacio.png';

/*Interceptores $http angularjs
// Definición de la factoría
app.factory('myHttpInterceptor', function($q, dependency1, dependency2) {
    return {
            // optional method
        'request': function(config) {
            // do something on success
            return config;
        },
        // optional method
        'requestError': function(rejection) {
            // do something on error
            if (canRecover(rejection)) {
                return responseOrNewPromise
            }
        return $q.reject(rejection);
        },
        // optional method
        'response': function(response) {
            // do something on success
            return response;
        },
        // optional method
        'responseError': function(rejection) {
            // do something on error
            if (canRecover(rejection)) {
                return responseOrNewPromise
            }
            return $q.reject(rejection);
        }
    };
});
*/

//Angular App Module 
var APLICACION = angular.module('gasUber', []);
//Servicio de WebApp
APLICACION.factory('ConexionPolling', function($http, $timeout) {
  
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

APLICACION.directive('mediaInput', [function ($http) {
    return {
        //template: "<div><input id='inputFile' type='file' accept='image/*'/><button ng-click='uploadFile(tipo, usuario)'>{{tituloBoton}}</button></div>",
        templateUrl: 'skin/inputMedia.html',
        replace: true,
        transclude: true,
        restrict: 'E',
        scope: {tipo: "=", sesion: "=", usuario: "@", predeterminada: "@"},
        controller: function($scope, $http, $rootScope){
            if($scope.tipo == 'integrado'){
                $('#etiqueta').hide();
            }
            else{
                $('#boton').hide();
            }
                
            $scope.leerUp = function(result){
                jQuery('#visor').attr("src", "/aa.jpg");
                jQuery('#visor').attr("src",result.data);
                $scope.sesion = result.data;
                //$rootScope.$digest();
            }

            jQuery('#inputFile').change(function(e) {
                $scope.uploadFile('tio', 'usuario');               
                
            });
            
            $scope.uploadFile = function(tipo, usuario){
              // Obteniendo el elemento input
              let input = jQuery("#inputFile");
              // Obteniendo el nombre del fichero
              let fileName = input.val();
              // Obteniendo el contenido del fichero
              let file = input[0].files[0];

                let fd = new FormData();
                fd.append('file', file);
                //fd.append('filetype', 'jpg');
                //fd.append('publishParameters', getRequestParams());
                fd.append('f', 'json');

                let url = 'http://apptablets0km.com/Backs/MAPS_API/API/SUBEMEDIA.php?tipo='+tipo+'&usuario='+usuario;
                let req = {
                 method: 'POST',
                 url: url,
                 transformRequest: angular.identity,
                 headers: {'Content-Type': undefined},
                 data: fd
                }

                $http(req).then(
                    function(result){
                        console.log(result);
                        $scope.leerUp(result);
                        //$rootScope.$digest();
                    },
                    function(error){console.log(error)}
                );
            }

             function getRequestParams() {
                var params = {
                    'name': name,
                    'locationType': "none",
                    'layerInfo': {fields:[{
                        "name" : "street",
                        "type" : "esriFieldTypeString",
                        "alias" : "Street",
                        "nullable" : false,
                        "editable" : true,
                        "domain" : null
                    }]}
                };
                
                return JSON.stringify(params);
            }
        
        },
        link: function(scope, element, $http) {}
    }
}])

APLICACION.directive('bToneras', [function () {
    return {
        templateUrl: 'skin/btnera.html',
        replace: true,
        restrict: 'E',
        scope: {
            nombre: "@", //variables de alcance($scope) o por valor
            edad: "=", //usado para hacer uso de data-binding(datos entre vista controlador) o por referencia
            link: "@",
            show: "&" //útiles para llamar a funciones
        },
        controller: function($scope, ConexionPolling) {
            console.log("actua bToneras")
        },
        link: function (scope, iElement, iAttrs) {
            
        }
    };
}])

//Directiva de Mapa GoogleMaps
APLICACION.directive('mapaDist', [function () {
    return {
        templateUrl: 'skin/mapaDistribuidor.html',
        replace: true,
        restrict: 'E',
        //require: "^?b-toneras",
        scope: {sesion:"="},
        controller: function($scope, ConexionPolling) {
            $scope.vacio = vzxc;
            $scope.ofertasBase = {};
            $scope.estiloMapa = {};
            
            $scope.map = {};
            $scope.marcadores = [];
            console.log($scope.sesion)
            //Crea el Objeto de opciones para el mapa
            var mapOptions = {
                zoom: 13,
                center: new google.maps.LatLng(-0.225219,-78.5248),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                //styles: $scope.estiloMapa,
                fullscreenControl: false,
                //scrollwheel: false,
                panControl: false,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                overviewMapControl: false
            };
            
            //invocaciones
            //Invoca el mapa en un elemento HTML de Marcado a tra
            $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
            //Invoca el objeto de info-window
            $scope.infoWindow = new google.maps.InfoWindow()
            //Invoca la capa de tafico
            $scope.trafficLayer = new google.maps.TrafficLayer();
            $scope.showTraffic =  function(map){
                $scope.trafficLayer.setMap(map);
            };


            //conexiones al servidor
            ConexionPolling.dPts('js/puntos.json').then(
                    function(data){
                        $scope.ofertasBase = data.data;
                    }, 
                    function(error){console.log(error)}
            );
            ConexionPolling.estiloJSON().then(
                    function(data){
                        $scope.estiloMapa = data.data;
                        var styledMapType = new google.maps.StyledMapType( $scope.estiloMapa, {name: 'Styled Map'});
                        $scope.map.mapTypes.set('styled_map', styledMapType);
                        $scope.stylosdemapas('styled_map');
                    }, 
                    function(error){console.log(error)}
            );


            //funcion que modifica estilos del mapa
            $scope.stylosdemapas = function(tipo) {
                $scope.map.setMapTypeId(tipo);
            };

            //$scope.$watch('estiloMapa', $scope.stylosdemapas());
            $scope.$watch('ofertasBase ', function() {
                $scope.cargarMapa();
            });

            $scope.infouser = function(){
                jQuery('.infoUsuario').toggle();
            }

            //Funcion que carga datos al mapa
            $scope.cargarMapa = function(){
                $scope.resetMapa($scope.marcadores);
                console.log($scope.ofertasBase);
                angular.forEach($scope.ofertasBase, function(val, key){
                    let marca = $scope.nMark(val, $scope.infoWindow, $scope.imageIcono);
                    $scope.marcadores.push(marca);
                    marca.setMap($scope.map);
                });
                console.log($scope.marcadores);
            };



            $scope.imageIcono = {
                url: '../MDIA/GR2.png', //ruta de la imagen
                //size: new google.maps.Size(40, 40), //tamaño de la imagen
                origin: new google.maps.Point(0,0), //origen de la iamgen
                //el ancla de la imagen, el punto donde esta marcando, en nuestro caso el centro inferior.
                anchor: new google.maps.Point(20, 20) 
             };

            //Funcion que crea un nuevo marcador en el mapa y devuelve el objeto para su utilizacion en un array o pila
            $scope.nMark = function(obj_marcador, infoWindow, imageIcono){
                //marcador sobre el mapa
                var marcador = new google.maps.Marker({
                    position: new google.maps.LatLng(obj_marcador.direccion.lat, obj_marcador.direccion.long),
                    title: obj_marcador.cliente.nombre,
                    animation: google.maps.Animation.BOUNCE,
                    draggable: true,
                    identificador: obj_marcador.id,
                    icon: imageIcono
                });
                google.maps.event.addListener(marcador, 'click', function(){
                    $scope.abrirmarcador($scope.map, infoWindow, marcador, obj_marcador);                    
                });
                return marcador;
            }

            //Funcion que abre un InfoSet del marcador
            $scope.abrirmarcador = function(mapa, info, marcador, oferta){
                let botonera = '<div class="btn-group b-toneras" role="group" aria-label="Basic example">'+
                                    '<button type="button" class="btn btn-info">'+
                                        '<i class="fas fa-info-circle"></i>'+
                                    '</button>'+
                                    '<button type="button" class="btn btn-success">'+
                                        '<i class="fas fa-check-circle"></i>'+
                                    '</button>'+
                                    '<button type="button" class="btn btn-danger">'+
                                        '<i class="fas fa-times-circle"></i>'+
                                    '</button>'+
                                '</div>';

                marcador.content = '<div class="infoWindowContent"> -' + oferta.direccion.fisico + '<br>' + oferta.producto.tipo + '</div>';
                info.setContent('<h2>' + marcador.title + '</h2>' + marcador.content  + '<p class="precio_oferta">$' +  oferta.producto.precio  + '</p>' + botonera);
                //info.setContent();
                info.open(mapa, marcador);
                mapa.setCenter(marcador.getPosition());
                //mapa.setZoom(17);
            }

            //funcion que resetea el mapa a 0
            $scope.resetMapa = function(objMarcas){
                for (var i = 0; i < objMarcas.length; i++) {
                    objMarcas[i].setMap(null);
                }
            };

            

        },
        compile: function compile() {
            return function postLink(scope) {}
        },
        link: function postLink(scope) {

        }
    };
}])

APLICACION.directive('panelClientes', [function () {
    return {
        templateUrl: 'skin/clientes.html',
        replace: true,
        restrict: 'E',
        scope: {
            sesion: "=" //variables de alcance($scope) o por valor
            //edad: "=", //usado para hacer uso de data-binding(datos entre vista controlador) o por referencia
            //link: "@",
            //show: "&" //útiles para llamar a funciones
        },
        controller: function($scope, ConexionPolling) {
            console.log($scope.sesion);

            ConexionPolling.estiloJSON().then(
                    function(data){
                        $scope.estiloMapa = data.data;
                        var styledMapType = new google.maps.StyledMapType( $scope.estiloMapa, {name: 'Styled Map'});
                        $scope.map.mapTypes.set('styled_map', styledMapType);
                        $scope.stylosdemapas('styled_map');
                    }, 
                    function(error){console.log(error)}
            );
            //funcion que modifica estilos del mapa
            $scope.stylosdemapas = function(tipo) {
                $scope.map.setMapTypeId(tipo);
            };


            //Crea el Objeto de opciones para el mapa
            var mapOptions = {
                zoom: 13,
                center: new google.maps.LatLng(-0.225219,-78.5248),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: $scope.estiloMapa,
                fullscreenControl: false,
                //scrollwheel: false,
                panControl: false,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                overviewMapControl: false
            };
            
            //invocaciones
            //Invoca el mapa en un elemento HTML de Marcado a tra
            $scope.map = new google.maps.Map(document.getElementById('mapacliente'), mapOptions);
            //Invoca el objeto de info-window
            $scope.infoWindow = new google.maps.InfoWindow()
            //Invoca la capa de tafico
            $scope.trafficLayer = new google.maps.TrafficLayer();
          

            //Funcion que crea un nuevo marcador en el mapa y devuelve el objeto para su utilizacion en un array o pila
            $scope.nMark = function(position){
                //marcador sobre el mapa
                var marcador = new google.maps.Marker({
                    position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                    title: 'Im, Yo en español',
                    animation: google.maps.Animation.BOUNCE,
                    draggable: true,
                    identificador: 'Seguimiento',
                    //icon: imageIcono
                });
                google.maps.event.addListener(marcador, 'click', function(){
                    //$scope.abrirmarcador($scope.map, infoWindow, marcador, obj_marcador);                    
                });
                return marcador;
            }

            if (navigator.geolocation){
                // Código de la aplicación
                $scope.seguimiento = 'none';
                var watch_id = navigator.geolocation.watchPosition(
                    function(objPosition){
                        console.log(objPosition);
                        alert(objPosition.coords.latitude);
                        if ($scope.seguimiento != 'none'){
                            $scope.seguimiento.setMap(null);
                        }
                        $scope.seguimiento = $scope.nMark(objPosition);
                        $scope.seguimiento.setMap($scope.map);
                        $scope.map.setCenter($scope.seguimiento.getPosition());
                    }, 
                    function(objPositionError){
                        console.log(objPositionError);
                        // Procesar errores
                    },
                    {enableHighAccuracy: true, maximumAge: 75000,timeout: 15000}
                );
            }
            else{
                alert("el navegador no soporta Geolocalizacion javascript");
            }


            


        },
        link: function (scope, iElement, iAttrs) {
            
        }
    };
}])

//Controlador Distribuidor
APLICACION.controller('MapCtrl', function ($scope, $http) {
    $scope.sesion = {};
    $scope.sesion.ID = 1;
    $scope.sesion.FOTO = 'http://apptablets0km.com/Backs/MAPS_API/MDIA/uservacio.png';
    $scope.sesion.NOMBRE = 'Juan Gutierrz';
    $scope.sesion.USUARIO = 'JGutierrz';
    $scope.sesion.EDAD = 28;
    $scope.sesion.TELEFONO = '02202-494088';
    $scope.sesion.EMAIL = 'JGutierrz@gmail.com';
    $scope.sesion.REPUTACION = 4.3;
    $scope.sesion.DIRECCION = {};
    $scope.sesion.DIRECCION.nombre = 'Juan Manuel Abal Medina 5543';
    $scope.sesion.DIRECCION.lat = -45.88543;
    $scope.sesion.DIRECCION.long = 78.66985;
    $scope.sesion.GEO = {};
    $scope.sesion.GEO.lat = -45.88543;
    $scope.sesion.GEO.long = 78.66985;
});