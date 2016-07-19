/*
 * Created by Rohan.
 * User: Rohan Jalil
 * For: Admin/navigation
 * License: Wooter LLC.
 * Date: 2016.04.28
 * Description: Controller for navigation dashboard pages, include navbar items and all methods to control
 * 				navigation.
 *
 */
__Wooter.controller('Admin/NavigationController', ['$scope', 'MQ' , '$stateParams', function ($scope, MQ,$stateParams) {

    $scope.navigation = [
        {
            name: 'League List',
            route: "admin({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'User List',
            route: "adminUserList({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Form Manager',
            route: "adminPackages({ code: '"+$stateParams.code+"' })"
        }
    ];

    $scope.fabButton = {
        direction: function () {
            return (MQ.maxWidth(959))?'up':'down';
        },
        isOpen: false,
        selectedMode: 'md-scale'
    };

    $(window).resize(function(){
        $scope.$digest();
    });
}]);
