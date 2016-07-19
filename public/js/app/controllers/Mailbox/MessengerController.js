/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Mailbox/MessengerController', ['$scope', '$http', '$stateParams', '$mdDialog', 'recipient_ids', 'recipients_type', 'mail_type', 'Mailboxes', function ($scope, $http, $stateParams, $mdDialog, recipient_ids, recipients_type, mail_type, Mailboxes) {

    $scope.show_messenger = true;

    $scope.hideMessenger = function(){
        $mdDialog.hide();
    };
    
    $scope.sendMessage = function(title, message){
        var url        = '/api/mailbox/inbox/' + mail_type + '/store';
        var messageObj = {};
        
        messageObj.title           = title ? title : '';
        messageObj.message         = message ? message : '';
        messageObj.recipient_ids   = recipient_ids;
        messageObj.recipients_type = recipients_type;
        
        $http.post(url, messageObj)
             .success(function(response){
                 Mailboxes.emitMessage(response.data, mail_type);
            }); 
    };      
    
}]);
