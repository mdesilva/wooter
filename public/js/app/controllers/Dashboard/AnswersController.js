/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Dashboard/AnswersController', ['$scope', '$mdDialog', '$stateParams', 'Page', 'Leagues', function ($scope, $mdDialog, $stateParams, Page, Leagues) {

    Page.reset();
    Page.title('Answers | Wooter');


    Leagues.getLeagueById($stateParams.league_id);
    var league_id = $stateParams.league_id;

    $scope.league_id = $stateParams.league_id;

    var answersRequest       = Leagues.getAnswersRequest();
    answersRequest.league_id = league_id;

    var request = Leagues.getPlayersRequest();
    Leagues.getPlayersByLeagueId(request, league_id);

    $scope.leagues           = Leagues;
    $scope.request           = request;
    $scope.answersRequest    = answersRequest;
    $scope.sortPlayersByName = 1;
    $scope.playersOffset     = 0;
    $scope.currentIndex      = 1;
    $scope.playerPages       = 10;

    $scope.viewFullDetails = function(answersRequest, player) {
        $mdDialog.show({
            controller : answersDetailsController,
            templateUrl : logicTemplate('modals/dashboard/answers-details.html'),
            locals : {
                $scope : $scope,
                $mdDialog : $mdDialog,
                player : player,
                Leagues : Leagues,
                answersRequest : answersRequest
            }
        });
    };

    var answersDetailsController = function($scope, $mdDialog, player, Leagues, answersRequest) {
        Leagues.getRegistrationAnswersByPlayerId(answersRequest, player.id);

        $scope.leagues = Leagues;
        $scope.player  = player;

        $scope.hideDetails = function() {
            $mdDialog.hide();
        };
    };

    $scope.exportAnswersAsCsv = function(answersRequest) {
        Leagues.getRegistrationAnswers(answersRequest)
            .success(function() {
                var csvContent = "data:text/csv;charset=utf-8,";
                csvContent += 'Player Name, Question, Answer' + '\n';
                Leagues.registrationAnswers.forEach(function(details, index){
                    csvContent += details.user_name + ', ' + details.question + ', ' + details.answer + '\n';
                });

                var encodedUri = encodeURI(csvContent);
                window.open(encodedUri);
            });
    };

    $scope.firstPage = true;
    $scope.lastPage  = ($scope.playerPages > 1) ? false : true;

    $scope.navFirst = function(request, playersOffset) {
        Leagues.getPlayersByOffset(request, playersOffset);

        $scope.currentIndex = 1;
        $scope.firstPage    = true;
        $scope.lastPage     = false;
    };

    $scope.navBefore = function(request, playersOffset) {
        Leagues.getPlayersByOffset(request, playersOffset);

        $scope.lastPage      = false;
        $scope.currentIndex--;
        if ($scope.currentIndex === 1) {
            $scope.firstPage = true;
        }
    };

    $scope.navNext = function(request, playersOffset) {
        Leagues.getPlayersByOffset(request, playersOffset);

        $scope.firstPage    = false;
        $scope.currentIndex++;
        if ($scope.currentIndex === $scope.playerPages) {
            $scope.lastPage  = true;
        }
    };

    $scope.navLast = function(request, playersOffset) {
        Leagues.getPlayersByOffset(request, playersOffset);

        $scope.currentIndex = $scope.playerPages;
        $scope.lastPage     = true;
        $scope.firstPage    = false;
    };

}]);
