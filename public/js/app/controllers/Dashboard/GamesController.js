/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Dashboard/GamesController', ['$scope', '$mdDialog', '$stateParams', '$location', '$http', 'Page', 'Leagues', 'API', '$state', '$window', function ($scope, $mdDialog, $stateParams, $location, $http, Page, Leagues, API, $state, $window) {
    
    var regularId = 1;
    /**********  INITIALIZATION  **********/
    
    //Redirect if league id is not present in the url
    
    if($stateParams.league_id === "" || !$stateParams.league_id){
        $state.go('404', {from: 'games'});
    }
    
    //Reset page
    
    Page.reset();
    
    //Style sheet definitions
    
    Page.stylesheets([
        '/css/dashboard/games-stats.css'
    ]);
    
    /**********  REQUEST OBJECT DEFINITIONS  **********/
    
    /*
     * Request object for games
     */
    
    var getGamesRequest = function() {
        var request = {};
    
        request.leagueId = $stateParams.league_id;
        request.offset = 0;
        request.limit = 10;
        request.orderBy = 'time';
        request.orderDirection = 'ASC';
        request.teamId = '';
        request.playerId = '';
        request.seasonId = '';
        request.divisionId = '';
        request.weekId = '';
        request.competitionId = '';
        request.competitionType = '';
        request.pick = '';
        request.game_status = 'completed';
        request.scored = 'false';
        
        return request;
    };
    
    var gamesRequest = getGamesRequest();
    
    /*
     * Request object for seasons
     */
    
    var seasonsRequest = {};
    
    seasonsRequest.leagueId = $stateParams.league_id;
    seasonsRequest.offset = 0;
    seasonsRequest.limit = 20;
    
    /*
     * Request object for divisions
     */
    
    var divisionsRequest = {};
    
    divisionsRequest.leagueId = $stateParams.league_id;
    divisionsRequest.offset = 0;
    divisionsRequest.limit = 20;
    
    /*
     * Request object for weeks
     */
    
    var weeksRequest = {};
    
    weeksRequest.regularId = regularId;
    weeksRequest.offset = '';
    weeksRequest.limit = 20;
    
    
    /**********  FUNCTION DEFINITIONS  **********/
    
    /**
     * Extract weeks
     *
     * @param response
     */
    
    var extractWeeks = function(response) {
        $scope.weeks = {};
        response.data.games.forEach(function(game, index) {
            if (game.week && !$scope.weeks[game.week.id]) {
                $scope.weeks[game.week.id] = game.week;
            }
        });
    };
    
    /**
     * Extract dates
     *
     * @param response
     */

    var extractDates = function(response) {
        $scope.dates = [];
        response.data.games.forEach(function(game, index) {
            if (($scope.dates.indexOf(game.date) === -1)) {
                $scope.dates.push(game.date);
            }
        });
    };
    
    /**
     * Display the games
     *
     * @param response
     */
    
    var displayGames = function(response) {

        extractDates(response);
        if ($scope.competition_type === 'season') {
            extractWeeks(response);
        }
        $scope.games = rearrangeGames(response.data.games);
        $scope.pages = response.data.pages;
        loaded();
    };
    
    /**
     * Rearrange the games to display in a specific order
     * @param games
     */
    
    var rearrangeGames = function(games) {
        var rearranged = [];
        for (var i = 0; i < $scope.dates.length; i++) {
            for (var n = 0; n < games.length; n++) {
                if ((games[n].date == $scope.dates[i]) && (games[n].home_team_win == 0 && games[n].home_team_loss == 0 && games[n].home_team_draw == 0)) { 
                    games[n].home_team_score = '';
                    games[n].visiting_team_score = '';
                    rearranged.push(games[n]);
                }
            }
            
            for (var n = 0; n < games.length; n++) {
                if ((games[n].date == $scope.dates[i]) && (games[n].home_team_win == 1 || games[n].home_team_loss == 1 || games[n].home_team_draw == 1)) { 
                    rearranged.push(games[n]);
                }
            }
        }
        
        return rearranged;
    };
    
    /**
     * Display the seasons
     *
     * @param response
     */
    
    var displaySeasons = function(response) {
        $scope.seasons = response.data;
    };
    
    /**
     * Display competition information
     * 
     * @param response
     */
    
    var displayCompetition = function(response) {
        $scope.competition = response.data;
    };
    
    /**
     * Display the divisions
     *
     * @param response
     */
    
    var displayDivisions = function(response) {
        $scope.divisions = response.data;
    };
    
    /**
     * Display the weeks
     *
     * @param response
     */
    
    var displayWeeks = function(response) {
        $scope.week_filters = response.data;
    };
    
    /**
     * Get games by competition type
     *
     * @param competitionType
     */

    var getGamesByCompetitionType = function(competitionType) {
        gamesRequest = getGamesRequest();
        $scope.competition.name = null;
        switch(competitionType) {
            case 'season':
                $leagueSeasonsApi.get(seasonsRequest, displaySeasons);
                gamesRequest.competitionType = 'Wooter\\SeasonCompetition';
                $scope.week_filters = null;
                $scope.games_scope = 'All Season Games';
                break;
            case 'tournament':
                gamesRequest.competitionType = 'Wooter\\TournamentCompetition';
                $scope.games_scope = 'All Tournament Games';
                break;
            case 'cup':
                gamesRequest.competitionType = 'Wooter\\CupCompetition';
                $scope.games_scope = 'All Cup Games';
                break;
            case '':
                $scope.seasons = null;
                $scope.seasonId = null;
                $scope.week_filters = null;
                $scope.weekId = null;
                $scope.showWeeks = false;
                $scope.competition = false;
                $scope.games_scope = 'All League Games';
                break;
        }
        gamesRequest.competitionId = '';
        $scope.competition_type = competitionType;
        $leagueGamesApi.get(gamesRequest, displayGames);
    };
    
    /**
     * Get games by season id
     *
     * @param seasonId
     */
    
    var getGamesBySeasonId = function(seasonId) {
        gamesRequest.competitionId = seasonId;
        weeksRequest.regularId = regularId;
        $leagueCompetitionWeeksApi.get(weeksRequest, displayWeeks);
        $leagueGamesApi.get(gamesRequest, displayGames);
        getSeasonById(seasonId);
        $scope.showWeeks = true;
        $scope.weekId = null;
    };
    
    /**
     * Get games by division id
     *
     * @param divisionId
     */
    
    var getGamesByDivisionId = function(divisionId) {
        gamesRequest.divisionId = divisionId;
        $leagueGamesApi.get(gamesRequest, displayGames);
    };
    
    /**
     * Get games by week id
     *
     * @param weekId
     */
    
    var getGamesByWeekId = function(weekId) {
        gamesRequest.weekId = weekId;
        $leagueGamesApi.get(gamesRequest, displayGames);
    };
    
    /**
     * Get games by offset
     *
     * @param weekId
     */
    
    var getGamesByOffset = function(gamesRequest, offset) {
        gamesRequest.offset = offset;
        $leagueGamesApi.get(gamesRequest, displayGames);
    };
    
    /**
     * Get competition by id
     * 
     * @param competitionId
     */
    
    var getSeasonById = function(seasonId) {
        seasonsRequest.leagueId = $stateParams.league_id;
        seasonsRequest.seasonId = seasonId;
        $leagueSeasonsApi.show(seasonsRequest, displayCompetition);
    };
    
    /**
     * Match Date and Week
     *
     * @param gameStartTime
     * @param weekStartTime
     * @param weekEndTime
     * @returns {boolean}
     */
    
    var matchDateAndWeek = function(gameStartTime, weekStartTime, weekEndTime) {
        var weekStartDate   = new Date(weekStartTime).getUnix();
        var weekEndDate     = new Date(weekEndTime).getUnix();
        var gameStartDate   = new Date(gameStartTime).getUnix();

        return (gameStartDate >= weekStartDate && gameStartDate <= weekEndDate);
    };
    
    /**
     * Compare Game time to current time
     * @param gameDatetime
     */
    
    var checkIfGameIsPlayed = function(gameDatetime) {
        var date = new Date();
        var year = date.getFullYear();
        var month =  date.getMonth() + 1;
        month = '0' + month;
        var day = date.getDate();
        var hours = date.getHours();
        var minutes = "0" + date.getMinutes();
        var seconds = "0" + date.getSeconds();

        var currentDatetime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        
        return (gameDatetime < currentDatetime);
    };
    
    var gamesOffset = 0;
    
    /**
     * Navigate to the next page
     */
    var navNext  = function() {
        $scope.gamesIndex++;
        gamesOffset += 10;
                
        getGamesByOffset(gamesRequest, gamesOffset);
    };

    /**
     * Navigate to the last page
     */
    var navLast = function() {
        $scope.gamesIndex = $scope.pages;
        gamesOffset = ($scope.pages * 10) - 10;
        
        getGamesByOffset(gamesRequest, gamesOffset);
    };

    /**
     * Navigate to the previous page
     */
    var navPrev = function() {
        $scope.gamesIndex--;
        gamesOffset -= 10;
        
        getGamesByOffset(gamesRequest, gamesOffset);
    };

    /**
     * Navigate to the first page
     */
    var navFirst = function() {
        $scope.gamesIndex = 1;
        gamesOffset = 0;
        
        getGamesByOffset(gamesRequest, gamesOffset);
    };
    
    /**
     * Paginate Games
     * @param response
     */
    var paginateGames = function(response) {
        $scope.gamesPages = response.data.pages;
        $scope.gamesLastPage  = (response.data.pages <= 1);
    };
    
    /**
     * Clean Date Function (eg: Monday, May 9)
     * @param date
     * @returns {*}
     */
    var cleanDate = function(date) {
        return moment(date).format('dddd, MMM D');
    };

    /**
     * Clean DateWeek Function (eg: May 9
     * @param date
     * @returns {*}
     */
    var cleanDateWeek = function(date) {
        return moment(date).format('MMM D');
    };
    
    /**
     * Format game data text
     * @param text
     */
    var formatGameDataText = function(text) {
        var length = text.length;
        if (length > 20) {
            var sliceIndex = length - 20;
            text = text.slice(-(length), -(sliceIndex));
            text += '...';
        }
        return text;
    };

    /**
     * Clean Time Function (eg: 21:00)
     * @param date
     * @returns {*}
     */
    var cleanTime = function(date) {
        var time =  moment(date).format('HH:mm');
        var segmentOfTheDay;
        var hour = time.split(':');
        if (hour[0] > 12) {
            segmentOfTheDay = 'PM';
            hour[0] = hour[0] - 12;
        } else {
            segmentOfTheDay = 'AM';
        }
        
        if (hour[0][0] == 0) {
            hour[0] = hour[0][1];
        }
        time = hour[0] + ':' + hour[1];
        return time + ' ' + segmentOfTheDay;
    };
    
    /**
     * Delete a game
     * @param gameId
     */
    
    var deleteGame = function(ev, gameId) {
        $scope.gameIdToDelete = gameId;

        var parentEl = angular.element(document.body);
        $mdDialog.show({
            parent: parentEl,
            controller: getControllerName('Modals/Dashboard/GamesModalController'),
            templateUrl: logicTemplate('modals/dashboard/schedule/deleteCompletedGame.html'),
            scope: $scope,
            preserveScope: true,
            targetEvent: ev,
            clickOutsideToClose: true
        });
    };


    /**********  SCOPE VARIABLE DEFINITIONS  **********/
    
    /**
     * Set the scope variables
     */
    
    $scope.competition_type = '';
    $scope.games_scope = 'All League Games';
    $scope.competition = {};
    $scope.getGamesByCompetitionType = getGamesByCompetitionType;
    $scope.getGamesBySeasonId = getGamesBySeasonId;
    $scope.getGamesByDivisionId = getGamesByDivisionId;
    $scope.getGamesByWeekId = getGamesByWeekId;
    $scope.getSeasonById = getSeasonById;
    $scope.matchDateAndWeek = matchDateAndWeek;
    $scope.navNext = navNext;
    $scope.navLast = navLast;
    $scope.navPrev = navPrev;
    $scope.navFirst = navFirst;
    $scope.paginateGames = paginateGames;
    $scope.cleanDate = cleanDate;
    $scope.cleanDateWeek = cleanDateWeek;
    $scope.formatGameDataText = formatGameDataText;
    $scope.cleanTime = cleanTime;
    $scope.checkIfGameIsPlayed = checkIfGameIsPlayed;
    $scope.deleteGame = deleteGame;
    $scope.gamesRequest = gamesRequest;
    $scope.displayGames = displayGames;

    $scope.sort_games = true;
    $scope.recentGamesOffset = 0;
    $scope.postGameOffset = 0;
    $scope.league_id = $stateParams.league_id;
    $scope.competition_id = $stateParams.league_id;
    $scope.gamesIndex = 1;
    $scope.gamesFirstPage = true;
    

    /**********  API REQUESTS  **********/
    /**
     * Define API's
     */
    
    var $leaguesApi = API.exec('leagues');
    var $leagueGamesApi = API.exec('leagueGames');
    $scope.$leagueGamesApi = $leagueGamesApi;
    var $leagueSeasonsApi = API.exec('leagueSeasons');
    //var $leagueDivisionsApi = API.exec('leagueDivisions');
    var $leagueCompetitionWeeksApi = API.exec('regularCompetitionWeeks');

    /**
     * Get & display league information
     */
    loading();
    $leaguesApi.show({
        leagueId : $stateParams.league_id
    }, function(response) {
        $scope.league = response.data;
    });

    $leagueSeasonsApi.get({leagueId: $stateParams.league_id}, function (response) {
        $scope.season = response.data[0];
    });
    
    /**
     * Get & display games belonging to the league
     */
    $leagueGamesApi.get(gamesRequest, displayGames);
    
    /**
     * Get & display divisions belonging to the league
     */
    //$leagueDivisionsApi.get(divisionsRequest, displayDivisions);
    
    //var $averagesApi = API.exec('leagueTeamsStatsAverages');
    
    //$averagesApi.get({
        //leagueId : 1,
        //offset : '',
        //limit : 3,
        //order_by : '',
        //order_direction : '',
        //team_id : 1,
        //season_id: 1,
        //stage_id: '',
        //game_id : '',
        //sport : 'Basketball',
        //bulk : 'false'
    //}, function(response) {
        
    //});
                        
    /*var $averagesApi = API.exec('leagueStatsAverages');
    
    $averagesApi.get({
        leagueId : 1,
        sport : 'Basketball',
        type : '',
        competition_id : '',
        game_id : '',
        team_id : '',
        player_id : 3,
        offset : '',
        limit : '',
        order_by : '',
        order_direction : '',
        stat_name : '',
        bulk : 'false'
    }, function(response) {
        
    });*/
                        
    /*var $gamesApi = API.exec('games');
    
    $gamesApi.save({
        home_team_id : 1,
        visiting_team_id : 2,
        location_id : 1,
        game_structure_id : 1,
        sport_id : 2,
        competition_week_id : 1,
        stage_id : 1,
        stage_type : 'regular',
        time : '2016-06-05 00:00:00'
    }, function(response) {
        
    });*/
    
}]);
