/*
 * Created by Eric Rho.
 * Edited by Dumitrana Alinus (alin.designstudio@gmail.com).
 * User: eric.rho
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.04.04
 * Description:
 *
 */
__Wooter.factory('Weekdays', ['$window', function($window){

    var weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    return {
        all: function() {
            var $return = [];
            var $index = 0;
            angular.forEach(weekdays, function (val) {
                $return.push({ id: $index+1, day: val });
                $index += 1;
            });
            return $return;
        }
    };
}]);
