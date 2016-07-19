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
__Wooter.controller('Admin/FormManagementNavigationController', ['$scope', 'MQ','$stateParams', function ($scope, MQ,$stateParams) {

    $scope.navigation = [
        {
            name: 'Packages',
            route: "adminPackages({ code: '"+$stateParams.code+"' })"
        },
        // {
        //     name: 'Leagues',
        //     route: "adminLeagues({ code: '"+$stateParams.code+"' })"
        // },
        {
            name: 'Dream Leagues',
            route: "adminDreamLeagues({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Apparel Request',
            route: "adminApparel({ code: '"+$stateParams.code+"' })",
        },
        {
            name: 'Reviews',
            route: "adminReviews({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Contact Form',
            route: "adminContact({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Schedule Demo Request',
            route: "adminScheduleDemo({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Video Demo Request',
            route: "adminVideoDemo({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Stats Demo Request',
            route: "adminStatsDemo({ code: '"+$stateParams.code+"' })"
        },
        {
            name: 'Referee Demo Request',
            route: "adminRefreeDemo({ code: '"+$stateParams.code+"' })"
        }
    ];
    $scope.code = $stateParams.code;
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
