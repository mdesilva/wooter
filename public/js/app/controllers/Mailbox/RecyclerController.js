/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Mailbox/RecyclerController', ['$scope', '$http', '$stateParams', '$mdDialog', 'Mailboxes', 'mail_type', 'mail_id', function ($scope, $http, $stateParams, $mdDialog, Mailboxes, mail_type, mail_id) {

    $scope.show_dialogue = true;

    $scope.hideRecycler = function(){
        $mdDialog.hide();
    };
    
    $scope.recycle = function(){

    };      
    
}]);