/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: ZIP Locations
 * License: Wooter LLC.
 * Date: 2016.01.28
 * Description: factory to controll zip code and coordinates
 *
 */
__Wooter.factory('ZIP', ['$window', '$http', '$cookies', '$q', function($window, $http, $cookies, $q){
    var zip = {};

    zip.name = 'ZIP';

    zip.setZip = function(cb) {
        if (document.location.protocol === 'http:' || document.location.protocol === 'https:' && (navigator.geolocation != null)) {
            return navigator.geolocation.getCurrentPosition(function(pos) {
                var coords, url;
                var protocol = document.location.protocol;
                coords = pos.coords;
                url = protocol+"//nominatim.openstreetmap.org/reverse?format=json&lat=" + coords.latitude + "&lon=" + coords.longitude + "&addressdetails=1";

                var coordinates = {
                    latitude: coords.latitude,
                    longitude: coords.longitude
                };

                window.coordinates = coordinates;

                $cookies.put(zip.name+"_COORDS", JSON.stringify(coordinates));

                return $.getJSON(url,{}, function(data) {

                    $cookies.put(zip.name,parseInt(data.address.postcode));

                    //return (zipCode, coordinates, nameOfCookie)
                    cb(data.address.postcode, coordinates, zip.name);

                });

            });
        }
    };  

    zip.get = function (){
        return $cookies.get(zip.name);
    };

    return zip;
}]);
