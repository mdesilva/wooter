/*
 * Created by Carlos Marra
 * User: loslambda / los_lambdas
 * For: Dashboard/details
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description:
 *
 */
__Wooter.controller('Dashboard/DetailsController', ['$scope', 'Page', function ($scope, Page) {
    

    /*
	 * - Clean page (title, assets, favicon badge, etc.)
	 * - Set Title Page
	 */
	Page.reset();
	Page.title(getLeagueName() + ' - Team Details | Wooter');

    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/details.css'
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
    $scope.league_id = $stateParams.league_id;

    $scope.addPlayer = function(ev, photo) {
        Videos.setPhoto(photo);
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Details'),
            templateUrl: 'views/default/modals/dashboard/details/addPlayer.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:false
        });
    };

    $scope.addPhoto = function(ev, photo) {
        Videos.setPhoto(photo);
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Details'),
            templateUrl: 'views/default/modals/dashboard/details/addPhoto.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:false
        });
    };

    $scope.addVideo = function(ev, photo) {

        Videos.setPhoto(photo);
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Details'),
            templateUrl: 'views/default/modals/dashboard/details/addVideo.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true
        });
    };

}]);

