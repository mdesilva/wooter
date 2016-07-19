/*
 * Created by Alinus.
 * User: alin.designstudio
 * For: Dashbord/navigation
 * License: Wooter LLC.
 * Date: 2016.02.11
 * Description: Controller for navigation dashboard pages, include navbar items and all methods to control
 * 				navigation.
 *
 */
__Wooter.controller('Dashboard/NavigationController', ['$scope', 'MQ', 'API', '$stateParams', function ($scope, MQ, API, $stateParams) {

    $leagueSeason = API.exec('leagueSeasons');

    $leagueSeason.get({
        leagueId: $stateParams.league_id
    }, function(res) {
        $scope.seasonID = res.data[res.data.length - 1].id;
    });

    $scope.navigation = [
        {
            name: 'Teams',
            route: 'dashboardTeams'
        },
        {
            name: 'Players',
            route: 'dashboardPlayers'
        },
        {
            name: 'Schedule',
            route: 'dashboardSchedule'
        },
        {
            name: 'Games',
            route: 'dashboardGames'
        },
        {
            name: 'Photos',
            route: 'dashboardPhotos'
        },
        {
            name: 'Videos',
            route: 'dashboardVideos'
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
