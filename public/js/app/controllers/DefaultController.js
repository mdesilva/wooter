__Wooter.controller('DefaultController', ['$scope', 'Authentify', 'Page', 'Notify', '$state',function ($scope, Authentify, Page, Notify, $state) {
    // Clear Notify, Favicon and Title on change state

    Notify().clear();
    Page.title('Wooter');
    Page.favicon.badge.setBadge(0);

    $scope.dynamicTheme = 'wooter-black';

    $scope.setTheme = function($c){
        $scope.dynamicTheme = $c;
    };

    $scope.capitalize = function(a){
    	return capitalize(a);
    };

    $scope.showMenu = function($mdOpenMenu, e) {
        $mdOpenMenu(e);
    };

}]);
