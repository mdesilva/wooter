/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Mailbox/BroadcastsController', ['$scope', '$http', '$stateParams', '$mdDialog', 'Mailboxes', 'Page', function ($scope, $http, $stateParams, $mdDialog, Mailboxes, Page) {
       
    //INITIALIZE
    Page.reset();
    Page.title('Broadcasts | Wooter');

    $scope.mailbox = Mailboxes;

    //Page.stylesheets(['']);

    $scope.openFullscreen = function() {
        $mdDialog.show({
            controller : fullScreenBroadcastController,
            templateUrl : logicTemplate('modals/mailbox/broadcast-fullscreen.html'),
            locals : {
                $scope : $scope,
                $mdDialog : $mdDialog
            }
        });
    };

    var fullScreenBroadcastController = function($scope, $mdDialog) {
        $scope.closeFullscreen = function() {
            $mdDialog.hide();
        };
    };

    //Broadcast request URL

    var url = '/api/mailbox/' + $stateParams.container + '/broadcasts/' + $stateParams.id;

    $http.get(url)
         .success(function(response){
             $scope.broadcast = response.data;
    });
}]);