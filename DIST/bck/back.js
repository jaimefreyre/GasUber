

//Angular App Module and Controller
angular.module('mapsApp', [])
.controller('MapCtrl', function ($scope, $http) {

    //DATA DEL SERVICIOS
    $scope.cities = [];
    let puntosMapa = $http({method:'GET', url:'js/puntos.json'});
    puntosMapa.then(
        function(data){
            $scope.cities = data.data;
        }, 
        function(error){
            console.log(error);
        }
    );



    //Crea el Objeto de opciones para el mapa
    var mapOptions = {
        zoom: 4,
        center: new google.maps.LatLng(40.0000, -98.0000),
        mapTypeId: google.maps.MapTypeId.TERRAIN
    }

    //Inscribe el mapa en un elemento HTML de Marcado a tra
    $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);



    //Array que almacna los datos de los marcadores
    $scope.markers = [];
    


    //Fijamos un objeto para InfoWindows de googlemaps
    var infoWindow = new google.maps.InfoWindow();
    $scope.createMarker = function (info){
        var marker = new google.maps.Marker({
            map: $scope.map,
            position: new google.maps.LatLng(info.lat, info.long),
            title: info.city
        });
        marker.content = '<div class="infoWindowContent">' + info.desc + '</div>';
        google.maps.event.addListener(marker, 'click', function(){
            infoWindow.setContent('<h2>' + marker.title + '</h2>' + marker.content);
            infoWindow.open($scope.map, marker);
        });
        $scope.markers.push(marker);
        console.log($scope.markers);
    }  
    

    $scope.inicia = function(){
        $scope.markers = [];
        console.log($scope.cities);
        
        for (i = 0; i < $scope.cities.length; i++){
            $scope.createMarker($scope.cities[i]);
        }
    }

    $scope.openInfoWindow = function(e, selectedMarker){
        e.preventDefault();
        google.maps.event.trigger(selectedMarker, 'click');
    }


     $scope.$watch("cities", $scope.inicia() );


});