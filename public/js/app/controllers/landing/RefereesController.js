/**
 * Created by Eric Rho.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.07.07
 * Description:
 *
 */
__Wooter.controller('Landing/RefereesController', ['$scope', '$http', '$window', '$mdDialog', 'Notify', 'Page', 'API', function ($scope, $http, $window, $mdDialog, Notify, Page, API) {
	/*
	 * Clean page (title, assets, favicon badge, etc.)
	 */
	Page.reset();

	/*
     * Set Title Page
     */
	Page.title('Wooter | Referees');

    Page.stylesheets(['/css/landing/referees.css', '/css/landing/modals/refereeQuote.css']);

    /*
     * Put here Action and Scopes
     */

     $refRequest = API.exec('serviceRequest');

     var updateMessage = function(notifyMessage, notifyStatus) {
     	Notify(notifyMessage, notifyStatus);
     };

     // $scope.submitRequest = function(e) {
     // 	debugger;
     // 	e.preventDefault();
     // 	$scope.referee.type = 3;
     // 	$scope.data = $scope.referee;

     // 	$http({
     // 		method: 'POST',
     // 		url: '/api/service-requests',
     // 		data: $scope.data
     // 	})
     // 	.success(function(data) {
     // 		$('#myModal2').modal('hide');
     // 		updateMessage('Referee demo request successful!', 'success');
     // 	})
     // 	.error(function(error) {
     // 		updateMessage('Oops! Something went wrong! Please try again', 'warning');
     // 	});
     // 	return false;
     // };

     $scope.request = {
     	name: $scope.name,
     	email: $scope.email,
     	phone: $scope.phone,
     	address_1: $scope.address_1,
     	address_2: $scope.address_2,
     	organizationName: $scope.organizationName,
     	sport: $scope.sportName,
     	number_of_players: $scope.number_of_players,
     	number_of_teams: $scope.number_of_teams,
     	number_of_games_per_team: $scope.number_of_games_per_team
     };

     $scope.submitRequest = function() {
     	$scope.request.type = 3;

     	$http({
     		method: 'POST',
     		url: '/api/service-requests',
     		data: $scope.request
     	}).success(function(data) {
     	}).error(function(error) {
     		console.log(error);
     	});
     };

     $scope.openRefModal = function(ev) {
     	$mdDialog.show({
     		parent: angular.element(document.body),
     		templateUrl: logicTemplate('modals/landing/refereeQuote.html'),
     		// controller: getControllerName('Landing/RefereesController'),
     		scope: $scope,
     		preserveScope: true,
     		clickOutsideToClose: false,
     		targetEvent: ev
     	});
     };

     $scope.hideModal = function() {
     	$mdDialog.hide();
     };
}]);
