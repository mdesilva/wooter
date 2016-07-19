/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio@gmail.com
 * For: Errors
 * License: Wooter LLC.
 * Date: 2016.04.01
 * Description:
 *
 */
__Wooter.controller('Error/404', ['$scope', '$stateParams', function ($scope, $stateParams) {
		redirect('error/404?from='+$stateParams.from);
}]);
