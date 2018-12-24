var GmapsLines = (function lines_factory(){
    //https://medium.com/@vvkchandra/essential-javascript-mastering-immediately-invoked-function-expressions-67791338ddc6
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 3,
        center: {lat: 0, lng: -180},
        mapTypeId: 'terrain'
    });

    var flightPlanCoordinates = [
        {lat: 37.772, lng: -122.214},
        {lat: 21.291, lng: -157.821},
        {lat: -18.142, lng: 178.431},
        {lat: -27.467, lng: 153.027}
    ];
    
    var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });

    return {
        run(){
            flightPath.setMap(map);
        }
    }
    
    
    //alert("puntos");
}());