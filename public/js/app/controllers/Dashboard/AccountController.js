/*
 * Created by Carlos Marra
 * User: loslambda / los_lambdas
 * For: Dashboard/albums
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description:
 *
 */
__Wooter.controller('Dashboard/AccountController', ['$scope','$mdDialog', 'Page', function ($scope, $mdDialog, Page) {
    
    /*
     * - Clean page (title, assets, favicon badge, etc.)
     * - Set Title Page
     */
    Page.reset();
    Page.title(getLeagueName() + ' - Albums| Wooter');

    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/account.css'
    ]);

    /*
     * Define League id
     */


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

    $scope.leagueName = getLeagueName();
    $scope.leagueSubtitle = getLeagueSubtitle();

    // $scope.league_id = $stateParams.league_id;

    $scope.createAlbum = function(ev) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Albums'),
            templateUrl: 'views/default/modals/dashboard/albums/add.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true
        });
    };

    $scope.editAlbum = function(ev) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Albums'),
            templateUrl: 'views/default/modals/dashboard/albums/edit.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true
        });
    };

    $scope.removeAlbum = function(ev) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Albums'),
            templateUrl: 'views/default/modals/dashboard/albums/remove.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true
        });
    };
}]);