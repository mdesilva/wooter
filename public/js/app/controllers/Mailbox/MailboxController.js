/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Mailbox/MailboxController', ['$scope', '$http', '$stateParams', 'Users', 'Mailboxes', 'Teams', 'Leagues', 'Page', function ($scope, $http, $stateParams, Users, Mailboxes, Teams, Leagues, Page) {
     
    //INITIALIZE
    Page.reset();
    Page.title('Mailbox | Wooter');

    //Page.stylesheets(['']);

    var request = Mailboxes.newRequest($stateParams.container, $stateParams.mailType);
 
    Mailboxes.mailbox = [];
    Mailboxes.request = request;
    Mailboxes.dates   = [];
    $scope.request    = request;
    $scope.mailbox    = Mailboxes;
    $scope.clubs      = Mailboxes.default_clubs;

    //Retrieve & display a date labeled list of most recent mail

    $scope.mailbox
          .getMailbox(request)
          .success(function(){
              $scope.mailbox.dates = [];
              $scope.mailbox.getMailDates();
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

    //Listen to mailbox updates

    Mailboxes.listenToUpdates();

    //Handle mailbox updates

    Mailboxes.socket.on($stateParams.mailType, function(msg){
            $scope.$apply(function(){
                Mailboxes.updateConversations(msg);
            });
    });

}]);