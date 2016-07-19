/**
 * Created by Borges Diaz.
 * User: borgdiaz
 * For: Game/modal
 * License: Wooter LLC.
 * Date: 2016.05.02
 * Description:
 *
 */
__Wooter.controller('Dashboard/Game/Modal/FullDetailsController', ['$scope', '$mdDialog', '$http', 'game_id', 'Leagues', 'Page', '$stateParams', 'league_id', 'API', function($scope, $mdDialog, $http, game_id, Leagues, Page, $stateParams, league_id, API) {
    
    Page.scripts([
        'js/scripts/dashboard/game-stats/jquery.tabletojson.min.js'
    ]);
    
    //Style sheet definitions
    
    Page.stylesheets([
        '/css/dashboard/games-stats.css'
    ]);
    
    /********** SPORT STATS DEFINITIONS **********/
    
    var basketballStats = {
        all : {
            jersey : 'Player #',
            PTS: 'PTS',
            "3FG": '3FG',
            "3FGA": '3FGA',
            AST: 'AST',
            BLK: 'BLK',
            FG: 'FG',
            FGA: 'FGA',
            FL: 'FL',
            FT: 'FT',
            FTA: 'FTA',
            STL: 'STL',
            TURN: 'TURN',
            OFFRB: 'OFFRB',
            DEFRB: 'DEFRB'
        }
    };

    var softballStats = {
        batter : {
            jersey : 'Player #',
            AB : 'AB',
            R : 'R',
            H : 'H',
            RBI : 'RBI',
            BB : 'BB',
            SO : 'SO',
            HBP : 'HBP',
            SF : 'SF',
            TB : 'TB',
            AVG : 'AVG',
            OBP : 'OBP',
            SLG : 'SLG'
        },
        pitcher : {
            jersey : 'Player #',
            IP : 'IP',
            H : 'H',
            R : 'R',
            ERR : 'ERR',
            BB : 'BB',
            SO : 'SO',
            HR : 'HR',
            PC : 'PC',
            ST : 'ST',
            ERA : 'ERA'
        }
    };

    var footballStats = {
        quarterback : {
            jersey : 'Player #',
            COMP : 'COMP',
            ATT : 'ATT',
            YDS : 'YDS',
            TD : 'TD',
            INT : 'INT',
            SACKS : 'SACKS',
            AVG : 'AVG',
            PCT : 'PCT',
            QBR : 'QBR'
        },
        receiver : {
            jersey : 'Player #',
            REC : 'REC',
            YDS : 'YDS',
            TD : 'TD',
            LONG : 'LONG',
            TGTS : 'TGTS',
            AVG : 'AVG',
        },
        defender : {
            jersey : 'Player #',
            INT : 'INT',
            YDS : 'YDS', 
            TKLS : 'TKLS',
            SACKS : 'SACKS',
            TD : 'TD'
        },
        rusher : {
            jersey : 'Player #',
            CAR : 'CAR',
            YDS : 'YDS',
            TD : 'TD',
            LONG : 'LONG',
            AVG : 'AVG',
        }
    };
    
    var basketballImmutableStats = {
        all : {
            
        }
    };
    
    var softballImmutableStats = {
        batter : {
            AVG : 'AVG',
            OBP : 'OBP',
            SLG : 'SLG'
        },
        pitcher : {
            ERA : 'ERA'
        }
    };
    
    var footballImmutableStats = {
        quarterback : {
            QBR : 'QBR',
            PCT : 'PCT',
            AVG : 'AVG'
        },
        receiver : {
            AVG : 'AVG'
        },
        defender : {
            
        },
        rusher : {
            AVG : 'AVG'
        }
    };
    
    var basketballStatsAliases = {
        all : {
            alias : 'all'
        }
    };
    
    var softballStatsAliases = {
        batter : {
            alias : 'hitters'
        },
        pitcher : {
            alias : 'pitchers'
        }
    };
    
    var footballStatsAliases = {
        quarterback : {
            alias : 'passing'
        },
        receiver : {
            alias : 'receiving'
        },
        defender : {
            alias : 'defending'
        },
        rusher : {
            alias : 'rushing'
        }
    };
    
    
    
    /**********  FUNCTION DEFINITIONS  **********/
    
    /**
     * Get a new stats object
     * 
     * @param sport
     */
    
    var getStatsObject  = function(sport, statsType) {
        var stats = {};
        switch(sport) {
            case 'Basketball':
                stats._jersey = 'new';
                stats.jersey = '';
                stats.name = '';
                stats.PTS = '';
                stats['3FG'] = '';
                stats['3FGA'] = '';
                stats.AST = '';
                stats.BLK = '';
                stats.FG = '';
                stats.FGA = '';
                stats.FL = '';
                stats.FT = '';
                stats.FTA = '';
                stats.STL = '';
                stats.TURN = '';
                stats.OFFRB = '';
                stats.DEFRB = '';
                break;
            case 'Softball':
                switch(statsType) {
                    case 'batter':
                        stats._jersey = 'new';
                        stats.jersey = null;
                        stats.name = '';
                        stats.AB = '';
                        stats.R = '';
                        stats.H = '';
                        stats.RBI = '';
                        stats.BB = '';
                        stats.SO = '';
                        stats.HBP = '';
                        stats.SF = '';
                        stats.TB = '';
                        stats.AVG = '';
                        stats.OBP = '';
                        stats.SLG = '';
                        break;
                    case 'pitcher':
                        stats._jersey = 'new';
                        stats.jersey = null;
                        stats.name = '';
                        stats.IP = '';
                        stats.H = '';
                        stats.R = '';
                        stats.ERR = '';
                        stats.BB = '';
                        stats.SO = '';
                        stats.HR = '';
                        stats.PC = '';
                        stats.ST = '';
                        stats.ERA = '';
                        break;
                }
                break;
            case 'Football':
                switch(statsType) {
                    case 'quarterback':
                        stats._jersey = 'new';
                        stats.jersey = null;
                        stats.name = '';
                        stats.COMP = '';
                        stats.ATT = '';
                        stats.YDS = '';
                        stats.TD = '';
                        stats.INT = '';
                        stats.SACKS = '';
                        stats.AVG = '';
                        stats.PCT= '';
                        stats.QBR = '';
                        break;
                    case 'receiver':
                        stats._jersey = 'new';
                        stats.jersey = null;
                        stats.name = '';
                        stats.REC = '';
                        stats.YDS = '';
                        stats.AVG = '';
                        stats.TD = '';
                        stats.LONG = '';
                        stats.TGTS = '';
                        break;
                    case 'defender':
                        stats._jersey = 'new';
                        stats.jersey = null;
                        stats.name = '';
                        stats.INT = '';
                        stats.YDS = '';
                        stats.TKLS = '';
                        stats.SACKS = '';
                        stats.TD = '';
                        break;
                    case 'rusher':
                        stats._jersey = 'new';
                        stats.jersey = null;
                        stats.name = '';
                        stats.CAR = '';
                        stats.YDS = '';
                        stats.AVG = '';
                        stats.TD = '';
                        stats.LONG = '';
                        break;
                }
                break;
        }
        
        return stats;
    };
    
    /*
     * Request object for updating a game
     */
    
    var updateGameRequest = {};
    
    updateGameRequest.leagueId = league_id;
    updateGameRequest.gameId = game_id;
    updateGameRequest.home_team_score = '';
    updateGameRequest.visiting_team_score = '';
    
    /*
     * Display a game's information
     * 
     * @param response
     */
    
    var displayGame = function(response) {
        var game = response.data;
        var teams = [{
            id : game.home_team_id,    
            name : game.home_team,
            score : game.home_team_score,
            playing_as : 'home'
        }, {
            id : game.visiting_team_id,
            name : game.visiting_team,
            score : game.visiting_team_score,
            playing_as : 'visiting'
        }];
    
        $scope.game = game;
        $scope.teams = teams;
        getGameStats(game.sport);
        
        if (game.sport !== 'Basketball') {
            $scope.hideUploads = true;
        }
    };
    
    /**
     * Display a Game's stats
     * 
     * @param response
     */
    
    var displayStats = function(response) {
        $scope.stats.home_team_stats = {};
        $scope.stats.visiting_team_stats = {};
        
        for (var statsType in response.data) {
            $scope.stats.home_team_stats[statsType] = [];
            $scope.stats.visiting_team_stats[statsType] = [];
            
            var set = response.data[statsType];
            for (var i = 0; i < set.length; i++) {
                var stats = set[i];
                if (stats.team_id == $scope.game.home_team_id) {
                    $scope.stats.home_team_stats[statsType].push(stats);
                } else if (stats.team_id == $scope.game.visiting_team_id) {
                    $scope.stats.visiting_team_stats[statsType].push(stats);
                }
                
            }
        }
        
        loaded();
    };
    
    /**
     * Get a game's stats
     * 
     * @param sport
     */
    loading();
    var getGameStats = function(sport) {
        $gamePlayerStatsApi.get({
            gameId : game_id,
            sport : sport
        }, displayStats);
    };
    
    /**
     * Add stats for a player
     * 
     * @param {type} 
     * @returns {undefined}
     */
    
    var addPlayerStats = function(team, statsType, sport) {
        switch(team) {
            case 'home':
                $scope.stats.home_team_stats[statsType].push(getStatsObject(sport, statsType));
                break;
            case 'visiting':
                $scope.stats.visiting_team_stats[statsType].push(getStatsObject(sport, statsType));
                break;
        }
    };
    
    var selected_players = {
        selected_home_players : {},
        selected_visiting_players : {}
    };
    
    var toggleAll = false;
    
    /**
     * Toggle a player's stats for deletion
     * 
     * @param player_id
     * @param playing_as
     */
    var togglePlayer = function(player_id, team, statsType, playerKey) {
        var checkbox = $(".select-player-checkbox[data-btn-id='" + team + statsType + playerKey + "']");
        if (checkbox.css('background-color') !== 'rgb(241, 105, 102)') {
            checkbox.css('background-color', '#f16966')
                    .css('border', '2px solid #f16966');
        } else {
           checkbox.css('background-color', 'white')
                   .css('border', '2px solid #757575');
        }
        
        var players = selected_players['selected_' + team + '_players'];
        
        if (!players[statsType]) {
            players[statsType] = [];
        }
        
        players = players[statsType];
        
        if ($.inArray(player_id, players) === -1) {
            players.push(player_id);
        } else {
            var index = players.indexOf(player_id);
            if (index > -1) {
                players.splice(index, 1);
            }
        }
        
        selected_players['selected_' + team + '_players'][statsType] = players;
    };
    
    /**
     * Toggle all player stats of a team for deletion
     * 
     * @param playing_as
     */
    
    var toggleAllPlayers = function(team, statsType) {
        toggleAll = !toggleAll;
        var players = selected_players['selected_' + team + '_players'];
        
        if (!players[statsType]) {
            players[statsType] = [];
        }
        
        var checkboxes = $(".select-player-checkbox[data-playing-as='" + team + statsType + "']");
        players = players[statsType];
        var playerStats = $scope.stats[team + '_team_stats'][statsType];
        if (toggleAll === true) {
            checkboxes.css('background-color', '#f16966')
                      .css('border', '2px solid #f16966');
            for (var i = 0; i < playerStats.length; i++) {
                if ($.inArray(i, players) === -1) {
                    players.push(i);
                }
            }
        } else {
            checkboxes.css('background-color', 'white')
                      .css('border', '2px solid #757575');
            players = [];
        }
        
        selected_players['selected_' + team + '_players'][statsType] = players;
    };
    
    /**
     * Remove all selected players
     * 
     * @param playing_as
     */
    
    var removeSelectedPlayers = function(team, statsType) {
        var players = selected_players['selected_' + team + '_players'][statsType];
        var playerStats = $scope.stats[team + '_team_stats'][statsType];
        var stats = [];
        
        for (var i = 0; i < playerStats.length; i++) {
            if (players.indexOf(i) === -1) {
                stats.push(playerStats[i]);
            }
        }
        
        $scope.stats[team + '_team_stats'][statsType] = stats;
        selected_players['selected_' + team + '_players'][statsType] = [];
        toggleAll = (toggleAll === true) ? false : toggleAll;
        var checkboxes = $(".select-player-checkbox[data-playing-as='" + team + statsType + "']");
        checkboxes.css('background-color', 'white');
    };
    
    /*
     * Display a an update game
     * 
     * @param response
     */
    
    var displayUpdatedGame = function(response) {
        var game = response.data;
        $("[data-game-id='" + game.id + "'").find('.home_team_score').html(game.home_team_score);
        $("[data-game-id='" + game.id + "'").find('.visiting_team_score').html(game.visiting_team_score);
        $$notify.create('The score has been saved.');
    };
    
    
    /**
     * Set the score of a game
     * 
     * @param home_team_score
     * @param visiting_team_score
     */
    
    var setScore = function(home_team_score, visiting_team_score) {
        updateGameRequest.home_team_score = home_team_score;
        updateGameRequest.visiting_team_score = visiting_team_score;
        $leagueGamesApi.put(updateGameRequest, displayUpdatedGame);
    };
    
    var saveStats = function(stats, game_id, home_team_id, visiting_team_id, sport) {
        $gamePlayerStatsApi.deleteByGameId({
            gameId : game_id,
            sport : sport
        }, function(response) {
               $gamePlayerStatsApi.save({
                    gameId : game_id,
                    homeTeamId : home_team_id,
                    visitingTeamId : visiting_team_id,
                    sport : sport,
                    method : 'form',
                    stats : stats
               }, saveStatsResponse);
           });
    };
    
    var saveStatsResponse = function(response) {
        displayStats(response);
        $$notify.create('Your stats have been saved.');
    };
    
    /**
     * Upload stats
     */
    
    var uploadStats = function(team_id) {
        $("#stats-upload-form input[name='team_id']").val(team_id);
        $('#files').click();
    };
    
    /**
     * Hide the game modal
     */
    
    var hideModal = function() {
        $mdDialog.hide();
    };
    
    /**********  API REQUESTS  **********/
    
    var $leagueGamesApi = API.exec('leagueGames');
    var $gamePlayerStatsApi = API.exec('gamePlayerStats');
    
    /**
     * Get the game by id & display the details
     */
    
    $leagueGamesApi.show({
        leagueId : league_id,
        gameId : game_id
    }, displayGame);
    
    /**********  SCOPE VARIABLE DEFINITIONS  **********/
    
    $scope.league_id = league_id;
    $scope.setScore = setScore;
    $scope.addPlayerStats = addPlayerStats;
    $scope.togglePlayer = togglePlayer;
    $scope.toggleAllPlayers = toggleAllPlayers;
    $scope.removeSelectedPlayers = removeSelectedPlayers;
    $scope.saveStats = saveStats;
    $scope.uploadStats = uploadStats;
    $scope.hideModal = hideModal;
    $scope.displayStats = displayStats;
    $scope.gamePlayerStatsApi = $gamePlayerStatsApi;
    
    $scope.stats = {
        home_team_stats : {},
        visiting_team_stats : {}
    };
    
    $scope.sportStats = {
        Basketball : basketballStats,
        Softball : softballStats,
        Football : footballStats,
    };
    
    $scope.immutableSportStats = {
        Basketball : basketballImmutableStats,
        Softball : softballImmutableStats,
        Football : footballImmutableStats
    };
    
    $scope.sportStatsAliases = {
        Basketball : basketballStatsAliases,
        Softball : softballStatsAliases,
        Football : footballStatsAliases
    };
}]);

