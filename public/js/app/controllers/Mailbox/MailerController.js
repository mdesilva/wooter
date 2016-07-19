/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Mailbox/MailerController', ['$scope', '$http', '$stateParams', '$mdDialog', 'Mailboxes', function ($scope, $http, $stateParams, $mdDialog, recipient_ids, recipients_type, mail_type, Mailboxes) {

    $scope.show_messenger = true;

    $scope.hideMessenger = function(){
        $mdDialog.hide();
    };
    
    $scope.sendEmail = function(title, message){
        //
    };      
    
}]);


