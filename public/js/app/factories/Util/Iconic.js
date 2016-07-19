/**
 * @underconstruction
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Icon Manager
 * License: Wooter LLC.
 * Date: 2016.03.09
 * Description: Icon Manager
 *
__Wooter.factory('Iconic', ['$window', '$http', 'STORE', function($window, $http, STORE){

    function iconic(){
        this.Request.icons();
        return this.instances;
    }

    var factory = iconic.prototype;

    factory.config = {
        url: {
            mdl: 'api/icons/mdl',
            fa: 'api/icons/fa'
        }
    };

    factory.Request = {
        icons: function(){
            factory.Request.icon.mdl();
        }
    };

    factory.instances = {
        mdl: function(){},
        fa: function () {}
    };

    return new iconic();
}]);
 */