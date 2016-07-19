/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.23
 * Description:
 *
 */
__Wooter.controller('Modals/Dashboard/Details', ['$scope', 'Page', '$stateParams', '$mdDialog', 'Leagues', function ($scope, Page, $stateParams, $mdDialog, Leagues) {
    
    /*
     * Clean page (title, assets, favicon badge, etc.)
     */

    Page.reset();

    /*
     * Set Title Page
     */

    Page.title('Wooter | Teams');
    var leagueId = $stateParams.league_id;
    
    /*
     * Put here Action and Scopes
     */

    Page.stylesheets([
        '/css/dashboard/details.css'
    ]);

    // Page.scripts([

    //     'js/scripts/dashboard/video/index.js'
    // ]);

    $scope.labels = [];

    $scope.cancel = function() { $mdDialog.hide(); }

    $scope.leagues = Leagues;

    $scope.leagueId = leagueId;

    $scope.movies = {}

    $scope.loadVideos = function() { Leagues.getLeagueById(leagueId); }

}]);