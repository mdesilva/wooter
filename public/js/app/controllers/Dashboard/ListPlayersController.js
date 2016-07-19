/*
 * Created by Carlos Marra
 * User: loslambda / los_lambdas
 * For: Dashboard/listplayer
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description:
 *
 */
__Wooter.controller('Dashboard/ListPlayersController', ['$scope', 'Page', function ($scope, Page) {
    

    /*
	 * - Clean page (title, assets, favicon badge, etc.)
	 * - Set Title Page
	 */
	Page.reset();
	Page.title(getLeagueName() + ' - List Players | Wooter');

    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/listplayers.css'
    ]);

    /*
     * Define League id
     */
    var leagueId = $stateParams.league_id;
    $scope.league_id = $stateParams.league_id;
    
    /*
     * Function method to get league name
     */
    function getLeagueName(){
        return "Dream Leagues Elite 8.5";
    }

    /*
     * Function method to get league subtitle
     */
    function getLeagueSubtitle(){
        return "Fall 2016";
    }

    /*
     * Get Players by League id
     */
    Players.getByLeagueId(leagueId);

    $scope.leagueName = getLeagueName();
    $scope.leagueSubtitle = getLeagueSubtitle();


}]);

