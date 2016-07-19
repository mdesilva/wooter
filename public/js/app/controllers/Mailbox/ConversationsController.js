/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Mailbox/ConversationsController', ['$scope', '$http', '$stateParams', '$state', '$mdDialog', 'Mailboxes', 'Leagues', 'Teams', 'Page', function ($scope, $http, $stateParams, $state, $mdDialog, Mailboxes, Leagues, Teams, Page) {
       
    Page.reset();
    Page.title('Conversations | Wooter');


    //Page.stylesheets(['']);

    var mailboxRequest = Mailboxes.newRequest($stateParams.container, 'conversations');

    Mailboxes.mailbox      = [];
    $scope.mailbox         = Mailboxes;
    $scope.mailboxRequest  = mailboxRequest;
    $scope.clubs           = Mailboxes.default_clubs;
    $scope.$mdDialog       = $mdDialog;

    //Configure Conversation Messages Request

    var messagesRequest = {};

    messagesRequest.url       = 'mailbox';
    messagesRequest.container = $stateParams.container;
    messagesRequest.parent    = 'conversations';
    messagesRequest.id        = $stateParams.id;
    messagesRequest.resource  = 'messages';
    messagesRequest.offset    = 0;
    messagesRequest.limit     = 1;

    //Initialize

    $scope.messages         = [];
    $scope.messagesRequest  = messagesRequest;
    $scope.conversation_id  = $stateParams.id;
    var messagesScroll      = document.getElementById('messages-scroll');
    var conversationsScroll = document.getElementById('conversations');
    var conversationsList   = document.getElementById('conversations-list');

    
    //LIBRARY

    /*
     * Retrieve & display conversation messages
     * @param messagesRequest
     */

    function getMessages(messagesRequest) {
        return $http.get(Mailboxes.buildUrl(messagesRequest))
                    .success(function(response) {
                        if (response.data.length) {
                            $scope.messages.unshift(response.data);
                            messageScrollDown();
                        }
        });
    };

    /*
     * Retreive & display conversation messages by id
     * @param messagesRequest
     * @param id
     */

    $scope.getMessagesById = function(messagesRequest, id) {
        messagesRequest.id = id;
        messagesRequest.offset = 0;
        getMessages(messagesRequest);
    };

    /*
     * Scroll messages window to bottom
     */

    function messageScrollDown() {
        messagesScroll.scrollTop = messagesScroll.scrollHeight;
    };

    /*
     * Reset scope & url state & set new conversation id
     * @param id
     */

    $scope.resetState = function(id) {
        $state.go('inboxMessages', {id : id}, {notify : false});
        $scope.messages = [];
        $scope.conversation_id = id;
    };

    /*
     * Highlight conversation by id
     * @param id
     */

    $scope.highlightConversation = function(id) {
        $('.conv').removeClass('active');
        $(".conv[data-id='" + id + "']").addClass('active');
    };

    /*
     * Reply to a message
     * @param message
     * @param messagesRequest

     *    */

    $scope.reply = function(message, messagesRequest) {
        if (message) {
            var url = '/api/mailbox/inbox/conversations/' + messagesRequest.id + '/message/store';
            $http.post(url, {message : message})
                    .success(function(response) {
                        Mailboxes.emitMessage(response.data, 'conversation');
                        document.getElementById('message').value = '';
            });
        }
    };

    //LOAD PAGE

    //load the scroll window for the messages list

    angular.element(messagesScroll).bind('scroll', function() {
        if (messagesScroll.scrollTop === 0) {
            messagesRequest.offset += 1;
            getMessages(messagesRequest).success(function() {
                messagesScroll.scrollTop = 10;
            });
        }
    });

    //load the scroll window for the conversations list

    angular.element(conversationsScroll).bind('scroll', function() {
        var scroll = conversationsScroll.scrollTop + conversationsScroll.offsetHeight;
        if ((scroll - 15) >= conversationsList.offsetHeight) {
            mailboxRequest.offset += 1;
            $scope.mailbox.getMailbox(mailboxRequest)
                    .success(function(){
                       conversationsScroll.scrollTop = conversationsScroll.offsetHeight + 14;
            });
        }
    });

    //Retrieve & display user leagues

    /*Leagues.getCurrentPlayerLeagues()
         .success(function(response) {
             response.data.forEach(function(league){
                 var leagueObj  = {};
                 leagueObj.id   = league.id;
                 leagueObj.name = league.name;
                 leagueObj.type = 'league';
                 $scope.clubs.push(leagueObj);
             });
    });*/

    //Retrieve & display user teams

    Teams.getCurrentPlayerTeams()
         .success(function(response) {
             response.data.forEach(function(team){
                 var teamObj  = {};
                 teamObj.id   = team.id;
                 teamObj.name = team.name;
                 teamObj.type = 'team';
                 $scope.clubs.push(teamObj);
             });
    });

    //Retrieve & display list of most recent conversations

    $scope.mailbox.getMailbox(mailboxRequest);

    //Retrieve & display list of most recent messages from a selected conversation

    getMessages(messagesRequest);

    //Listen to mailbox updates

    Mailboxes.listenToUpdates();

    //Handle mailbox updates

    Mailboxes.socket.on('conversations', function(msg){
        $scope.$apply(function(){
            Mailboxes.updateConversations(msg);
            if (msg.message.id == $scope.conversation_id){
                $scope.messages.push([msg.message]);
                messageScrollDown();
            }
        });
    });
        
}]);

