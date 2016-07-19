/*
 * Created by Borges Diaz.
 * User: borgdiaz
 * For: Mailbox
 * License: Wooter LLC.
 * Date: 2016.01.31
 * Description:
 *
 */
__Wooter.factory('Mailboxes', ['$http', '$mdDialog', function($http, $mdDialog){


    var mailboxes = {};

    var $this = mailboxes;

    mailboxes.mailbox = [];
    mailboxes.dates   = [];
    mailboxes.conversation_ids = [];
    mailboxes.socket = io.connect('http://www.woozard.com:3000');

    /**
     * Retrieve & push a list of most recent mail
     * @param request
     * @return {object} $http
     */
    
    mailboxes.getMailbox = function(request){
        return $http.get($this.buildUrl(request))
                .success(function(response){
                    angular.forEach(response.data, function(value) {
                        value.datetime_label = $this.getDatetimeLabel(value.preview_datetime);
                        value.date_label     = $this.getDateLabel(value.preview_date);
                        $this.mailbox.push(value);
                    });
            });
    };
    
    /*
     * Retrieve & push most recent mail, & push a list of date labels
     * @param request
     */

    mailboxes.getDatedMail = function(request) {
        $this.getMailbox(request)
                .success(function() {
                    $this.dates = [];
                    $this.getMailDates();
        });
    };
    
    /*
     * Increment the request offset & retrieve & push more mail
     * @param request
     */

    mailboxes.loadMore = function(request){
        request.offset += 1;
        $this.getDatedMail(request);
    };
    
    /*
     * Filter mail by a user's team or league
     * @param request
     * @param club
     */

    mailboxes.filterByClub = function(request, club) {
        request.offset    = 0;
        request.club_type = club.type;
        request.club_id   = club.id;
        $this.mailbox     = [];
        $this.getDatedMail(request);
    };
    
    /*
     * Filter mail by a timeframe
     * @param request
     * @param timeframe
     */

    mailboxes.filterByTimeframe = function(request, timeframe) {
        request.offset    = 0;
        request.timeframe = timeframe.value;
        $this.mailbox     = [];
        $this.getDatedMail(request);
    };
    
    /*
     * Filter mail by keywords in the title
     * @param request
     * @param keywords
     */

    mailboxes.filterByKeywords = function(request, keywords) {
        request.offset    = 0;
        request.keywords  = keywords ? keywords : 0;
        $this.mailbox     = [];
        $this.getDatedMail(request);
    };
    
     /*
     * Build url from request object
     * @param request
     */
    
    mailboxes.buildUrl = function(request) {
        var url = 'api';
        for(var param in request) {
            url += '/' + request[param];
        }
        return url;
    };
    
    /*
     * Retrieve & push the date labels for retrieved mail
     * 
     */

    mailboxes.getMailDates = function() {
        angular.forEach($this.mailbox, function(value, key) {
            if ($this.dates.indexOf(value.preview_date) == -1) {
                $this.dates.push(value.preview_date);
            }
        });
    };
    
    /*
     * Get formatted datetime
     * @param date
     */
    
    mailboxes.getDatetimeLabel = function(datetime) {
        var date = new Date(datetime + ' UTC');
        var label = date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
        label += ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
        return label;
    };
    
    /*
     * Get formatted date
     * @param datetime
     */
    
    mailboxes.getDateLabel = function(date) {
        var date = new Date(date + ' UTC');
        var label = date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
        return label;
    };
    
    /*
     * Get inbox data
     * @param 
     */
    
    mailboxes.getInbox = function(url) {
        return $http.get('/mailbox/inbox');
    };
    
    /*
     * Get id's of all conversations in the user's mailbox
     * @param request
     */
    
    mailboxes.getConversationIds = function(request) {
        return $this.getMailIds(request, 'conversations');
    };
    
    /*
     * Get id's of all conversations in the user's mailbox
     * @param reauest
     */
    
    mailboxes.getBroadcastIds = function(request) {
        return $this.getMailIds(request, 'broadcasts');
    };
    
    /*
     * Get id's of all mail of a certaine type in the user's mailbox
     * @param request
     * @param mail_type
     */
    
    mailboxes.getMailIds = function(request, mail_type) {
        request = $this.newRequest(request.container, mail_type);
        request.limit = 0;
        return $http.get($this.buildUrl(request))
                    .success(function(response){
                        angular.forEach(response.data, function(value, key) {
                            $this.conversation_ids.push(value.id);
                    });
                });
    };
    
    /*
     * Send a message
     * @param
     */
    
    mailboxes.emitMessage = function(message, mail_type) {
        var inbox_ids = [];
        message.inboxes.forEach(function(inbox){
           inbox_ids.push(inbox.id);
        });
        
        var messageObj = {};
        
        messageObj.message   = message;
        messageObj.inbox_ids = inbox_ids;
        messageObj.mail_type = mail_type + 's';
        
        $this.socket.emit('mail', messageObj);
    };
    
    /*
     * Listen to updates 
     * 
     */
    
    mailboxes.listenToUpdates = function() {
        var inboxUrl = '/api/mailbox/inbox';
        $http.get(inboxUrl)
            .success(function(response){
                $this.socket.emit('inbox', response.data.id);                    
        });
    };
    
    /*
     * Updates to conversations list
     * @param msg
     */
    
    mailboxes.updateConversations = function(msg) {
        $(".conv[data-id='" + msg.message.id + "']").fadeOut(100);
        msg.message.date_label = $this.getDateLabel(msg.message.preview_date);
        $this.mailbox.unshift(msg.message);
    };
    
    /*
     * Open text messenger
     * @param $mdDialog
     */
    
    mailboxes.openTextMessenger = function() {
        $mdDialog.show({
                controller :  'Mailbox/TextMessengerController',
                templateUrl : logicTemplate('modals/mailbox/text-messenger.html')
            });
    };
    
    /*
     * Open mailer
     * @param $mdDialog
     */
    
    mailboxes.openMailer = function() {
        $mdDialog.show({
                controller :  'Mailbox/MailerController',
                templateUrl : logicTemplate('modals/mailbox/mailer.html')
            });
    };
    
    /*
     * Open the messenger
     * @param $mnDialog
     * @param ev
     * @param recipient_ids
     * @param recipients_type
     * @param mail_type
     */
    
    mailboxes.openMessenger = function(recipient_ids, recipients_type, mail_type) {
        $mdDialog.show({
                controller :  'Mailbox/MessengerController',
                templateUrl : logicTemplate('modals/mailbox/messenger.html'),
                locals : {
                    recipient_ids : recipient_ids,
                    recipients_type : recipients_type,
                    mail_type : mail_type
                }
            });
    };
    
    /*
     * Open recycler
     * @param
     */
    
    mailboxes.openRecycler = function(mail_type, mail_id) {
        $mdDialog.show({
            controller :  'Mailbox/RecyclerController',
            templateUrl : logicTemplate('modals/mailbox/recycler.html'),
            locals : {
                mail_type : mail_type,
                mail_id : mail_id
            }
        });
    };
    
    /*
     * Reset the request back to default state
     * @param request
     * @param container
     * @param mail_type
     */
    
    mailboxes.newRequest = function(container, mail_type) {
        var request = {};

        request.url       = 'mailbox';
        request.container = container;
        request.mail_type = mail_type;
        request.offset    = 0;
        request.limit     = 1;
        request.club_type = 0;
        request.club_id   = 0;
        request.timeframe = 'allTime';
        request.utcOffset = 0;
        request.keywords  = 0;
        request.sent      = (container === 'sent') ? 1 : 0;
        
        return request;
    };
    
    mailboxes.timeframes = [{
                    title : 'All Messages',
                    value : 'allTime'
                }, {
                    title : 'Today',
                    value : 'today'
                }, {
                    title : 'Yesterday',
                    value : 'yesterday'
                }, {
                    title : 'Past Week',
                    value : 'pastWeek'
                }, {
                    title : 'Past Month',
                    value : 'pastMonth'
                }, {
                    title : 'Past Year',
                    value : 'pastYear'
    }];

    mailboxes.default_clubs = [{
                    name : 'All',
                    type : 'all',
                    id   : 1
    }];


    return mailboxes;
}]);


