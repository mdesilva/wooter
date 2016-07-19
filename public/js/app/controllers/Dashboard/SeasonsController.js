/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.05.23
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Dashboard/SeasonsController', ['$scope', '$mdDialog', '$stateParams', '$location', '$http', 'Page', 'Leagues', 'API', '$state', function ($scope, $mdDialog, $stateParams, $location, $http, Page, Leagues, API, $state) {
    
    /**********  INITIALIZATION  **********/
    
    //Redirect if league id is not present in the url
    
    if($stateParams.league_id === "" || !$stateParams.league_id){
        $state.go('404', {from: 'games'});
    }
    
    //Reset page
    
    Page.reset();
    
    //Style sheet definitions
    
    Page.stylesheets([
        '/css/dashboard/games-stats.css'
    ]);
}]);

