/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.02.18
 * Description:
 *
 */
__Wooter.factory('ContactForm', ['$window', '$http', '$q', function($window, $http, $q){
    var theFactory = {};

    theFactory.init = function (){
        return 'something'
    };
    theFactory.save = function(){
    	console.log("saving");
    	return "DONE";
    };
    return theFactory;
}]);