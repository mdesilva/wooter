/**
 * Created by Eric Rho.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.07.08
 * Description:
 *
 */
__Wooter.controller('Landing/PackagesController', ['$scope', '$http', '$mdDialog', 'API', 'Page', function ($scope, $http, $mdDialog, API, Page) {
	/*
	 * Clean page (title, assets, favicon badge, etc.)
	 */
	Page.reset();

	/*
     * Set Title Page
     */
	Page.title('Wooter | Packages');

	Page.stylesheets(['/css/landing/packages.css', '/css/landing/modals/packageModal.css']);

    /*
     * Put here Action and Scopes
     */

     setInterval(function(){ 
        $(".space_one").height($(".popup_one").height());
        $(".space_two").height($(".popup_two").height());
        $(".space_three").height($(".popup_three").height());
	}, 10);

     $scope.openPackModal = function() {
     	$mdDialog.show({
     		parent: angular.element(document.body),
     		templateUrl: logicTemplate('modals/landing/packageModal.html'),
     		scope: $scope,
     		preserveScope: true,
     		clickOutsideToClose: false,
     	});
     };

     $scope.hideModal = function() {
     	$mdDialog.hide();
     };
}]);
