/**
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.04.25
 * Description:
 *
 */
__Wooter.service('Autocomplete', ['$http', '$q', function( $http, $q ) {
    function getSearch(search) {
        
        var deferredAbort = $q.defer();
        
        var request = $http({
            method: "POST",
            url: "/api/auto-complete-search",
            data: {search: search},
            timeout: deferredAbort.promise
        });
        
        var promise = request.then(function( response ) { return( response.data ) }, function(response) { return $q.reject() });

        promise.abort = function() {
            deferredAbort.resolve();
        };

        promise.finally(
            function() {
                promise.abort = angular.noop;
                deferredAbort = request = promise = null;
            }
        );

        return( promise );
    }

    return({
        getSearch: getSearch
    });
}]);
