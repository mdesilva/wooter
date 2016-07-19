/**
 *
 * @param $scope
 * @param $http
 * @constructor
 */
function Messages ($scope, $http) {
    
    var scope = this;
    
    var read_messages;
    
    var all_messages;
    
    var unread_messages = 0;
    
    var reading_notifications;
    
    var iteration = 0;
    
    var conversation_id;
    
    var message_count;
    
    var see_messages_link = false;
    
    var updated_once = false;
    
    var total_conversations;
    
    var time;
    
    var total_notifications;
    
    var notified_once = false;
    
    var notification_time;
    
    var update_conversation = false;
    
    var navigation_index = 0;
    
    var current_index = 1;
    
    var range = 0;
    
    this.authAccess = function()
    {
        //
    };
    
    this.runNotifier = function()
    {
        scope.pollMessages();
        scope.loadNotificationsBoxTrigger();
        scope.loadNotificationsOverlay();
        scope.updateNotificationsList();
    }; 
    
    this.pollMessages = function()
    {
        //
    };
    
    this.countReadMessages = function()
    {
       //
   };
    
    this.countAllMessages = function()
    {
        //
    };
    
    this.countUnreadMessages = function()
    {
        //
    };
    
    this.notify = function()
    {
        //
    };
    
    this.updateNotificationsList = function()
    {
        //
    };
    
    this.loadTrigger = function()
    {
        //
    };
    
    this.loadOverlay = function()
    {
        //
    };
    
    this.loadMessenger = function()
    {
        //
    };
    
    this.runChatroom = function()
    {
        reading_notifications = true;
        scope.loadChatroom();
        scope.pollConversations();
        conversation_id = $('#current_conversation_id').val();
        message_count = $('#messages li').length;
        $('#chatbox').scrollTop($('#chatbox')[0].scrollHeight);
    };
    
    this.loadChatroom = function()
    {
        scope.loadReadMessagesMarker();
        scope.loadConversationLinks();
        scope.loadChatbox();
        scope.loadSendButton();
        scope.loadMessageField();
    };
    
    this.loadReadMessagesMarker = function()
    {
        //
    };
    
    this.loadConversationLinks = function()
    {
        //
    };
    
    this.loadChatbox = function()
    {
        //
    };
    
    this.loadSendButton = function()
    {
        $('#send').click(function() {
            scope.sendMessage();
        });
    };
    
    this.loadMessageField = function()
    {
        $('#message').keypress(function(e){
            if (e.which === 13 && !e.shiftKey){
                scope.sendMessage();
                return false;
            }
        });
    };
    
    this.sendMessage = function()
    {
        //
    };
    
    this.pollConversations = function()
    {
        setInterval(function(){
            scope.updateConversationsList();
            if (update_conversation)
            {
                scope.updateCurrentConversation(conversation_id);
            }
            scope.updateLoggedStatus();
        }, 500);
    };
    
    this.updateCurrentConversation = function(id)
    {
        //
    };
    
    this.updateConversationsList = function()
    {
        //
    };
    
    this.updateLoggedStatus = function()
    {
        //
    };
    
    this.loadInbox = function()
    {
        //
    };
    
    this.loadNavigation = function()
    {
        range = $('#range').val();
        scope.loadNextNav();
        scope.loadPreviousNav();
        scope.loadFirstNav();
        scope.loadLastNav();
    };
    
    this.loadNextNav = function()
    {
        $('#next').click(function() {
            navigation_index += 1;
            current_index += 1;
            
            if ($('#previous').hasClass('disabled')){
                $('#previous').removeClass('disabled');
                $('#first').removeClass('disabled');
            }
            
            if (navigation_index >= range - 1){
                $(this).addClass('disabled');
                $('#last').addClass('disabled');
            }
            
            $('#current_index').html(current_index);
            scope.getConversationsList();
        });
    };
    
    this.loadPreviousNav = function()
    {
        $('#previous').click(function() {
            navigation_index -= 1;
            current_index -= 1;
            
            if (navigation_index === 0){
                $(this).addClass('disabled');
                $('#first').addClass('disabled');
            }
            
            if ($('#next').hasClass('disabled')){
                $('#next').removeClass('disabled');
                $('#last').removeClass('disabled');
            }
            
            $('#current_index').html(current_index);
            scope.getConversationsList();
        });
    };
    
    this.loadFirstNav = function()
    {
        $('#first').click(function() {
            navigation_index = 0;
            current_index = 1;
            
            $(this).addClass('disabled');
            $('#previous').addClass('disabled');
            
            if ($('#next').hasClass('disabled')){
                $('#next').removeClass('disabled');
                $('#last').removeClass('disabled');
            }
            
            $('#current_index').html(current_index);
            scope.getConversationsList();
        });
    };
    
    this.loadLastNav = function()
    {
        $('#last').click(function() {
            navigation_index = range - 1;
            current_index = range;
            
            $(this).addClass('disabled');
            $('#next').addClass('disabled');
            
            if ($('#previous').hasClass('disabled')){
                $('#previous').removeClass('disabled');
                $('#first').removeClass('disabled');
            }
            
            $('#current_index').html(current_index);
            scope.getConversationsList();
        });
    };
    
    this.getConversationsList = function()
    {
        //
    };
};

var messages = new Messages();