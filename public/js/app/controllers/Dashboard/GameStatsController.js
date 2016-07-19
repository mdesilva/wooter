/**
 * Created by Borges Diaz.
 * User: borgdiaz
 * For: Game/modal
 * License: Wooter LLC.
 * Date: 2016.05.02
 * Description:
 *
 */
__Wooter.controller('Dashboard/GameStatsController', ['$scope', '$mdDialog', '$http', 'Page', '$stateParams', 'API', function($scope, $mdDialog, $http, Page, $stateParams, API) {

    var game_id = $stateParams.game_id;

    Page.scripts([
        'js/scripts/dashboard/game-stats/jquery.tabletojson.min.js'
    ]);
    
    //Style sheet definitions
    
    Page.stylesheets([
        '/css/dashboard/management.css'
    ]);
    
    /********** SPORT STATS DEFINITIONS **********/
    
    var footballTeamStats = {
        first_quarter_score : '1st Quarter',
        second_quarter_score : '2nd Quarter',
        third_quarter_score : '3rd Quarter',
        fourth_quarter_score : '4th Quarter'
    };
    
    var basketballStats = {
        all : {
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
            REC : 'REC',
            YDS : 'YDS',
            TD : 'TD',
            LONG : 'LONG',
            TGTS : 'TGTS',
            AVG : 'AVG',
        },
        defender : {
            INT : 'INT',
            YDS : 'YDS', 
            TKLS : 'TKLS',
            SACKS : 'SACKS',
            TD : 'TD'
        },
        rusher : {
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
                stats.player_id = 0;
                stats.active = '';
                stats.deactivate = 0;
                stats.activate = 0;
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
                        stats.player_id = 0;
                        stats.active = '';
                        stats.deactivate = 0;
                        stats.activate = 0;
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
                        stats.player_id = 0;
                        stats.active = '';
                        stats.deactivate = 0;
                        stats.activate = 0;
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
                        stats.player_id = 0;
                        stats.active = '';
                        stats.deactivate = 0;
                        stats.activate = 0;
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
                        stats.player_id = 0;
                        stats.active = '';
                        stats.deactivate = 0;
                        stats.activate = 0;
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
                        stats.player_id = 0;
                        stats.active = '';
                        stats.deactivate = 0;
                        stats.activate = 0;
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
                        stats.player_id = 0;
                        stats.active = '';
                        stats.deactivate = 0;
                        stats.activate = 0;
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
    
    updateGameRequest.teamId = '';
    updateGameRequest.gameId = '';
    updateGameRequest.final_score = '';
    updateGameRequest.win = 0;
    updateGameRequest.loss = 0;
    updateGameRequest.draw = 0;
    
    
    
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
        displayPlayerStats(response);
        getNewPlayers();   
        loaded();
    };
    
    /**
     * Display player stats
     * @param response
     */
    
    var displayPlayerStats = function(response) {
        $scope.stats.home_team_stats = {};
        $scope.stats.visiting_team_stats = {};
        selected_roster_players.selected_home_players = {};
        selected_roster_players.selected_visiting_players = {};
        
        for (var statsType in response.data) {
            if (statsType !== 'teams') {
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
        }
        addActivePlayers(response);
    };
    
    /**
     * Get new players in roster
     */
    
    var getNewPlayers = function() {
        var teams = $scope.teams;
        for (var i = 0; i < teams.length; i++) {
            $teamPlayersApi.get({
                teamId : teams[i].id,
                league_id : $scope.league_id,
                offset : 0,
                limit : 30,
                order_by : 'created_at',
                order_direction : 'ASC'
            }, function(response) {
                displayNewPlayers(response);
            });
        }
    };
    
    /**
     * Display new players in the roster
     */
    
    var displayNewPlayers = function(response) {
        for (var a = 0; a < response.data.length; a++) {
            var player = response.data[a];
            var player_info = response.data[a].player_info;
            var positions = player_info.positions;
            if ($scope.game.sport == 'Basketball') {
                var positions = [{
                        position : 'all'
                }];
            }
            var playing_as = (player_info.team_id == $scope.game.home_team_id) ? 'home' : 'visiting';
            var teamStats = $scope.stats[playing_as + '_team_stats'];
            for (var b = 0; b < positions.length; b++) {
                var player_ids = [];
                for (var c = 0; c < teamStats[positions[b].position].length; c++) {
                    player_ids.push(teamStats[positions[b].position][c].player_id);
                }
                if ((player_ids.indexOf(player.id) === -1) && ($scope.game.stage_id == player_info.stage_id)) {
                    var statsObject = getStatsObject($scope.game.sport, positions[b].position);
                    statsObject.player_id = player.id;
                    statsObject.name = player.first_name + ' ' + player.last_name;
                    statsObject.jersey = player_info.jersey;
                    $scope.stats[playing_as + '_team_stats'][positions[b].position].push(statsObject);
                }
            }
        }
        loaded();
    };
    
    /**
     * Add active players
     * @param response
     */
    
    var addActivePlayers = function(response) {
        for (var team in $scope.stats) {
            var playing_as = (team == 'home_team_stats') ? 'home' : 'visiting';
            var players = selected_roster_players['selected_' + playing_as + '_players'];
            var teamStats = $scope.stats[team];
            for (var statsType in teamStats) {
                if (!players[statsType]) {
                    players[statsType] = [];
                }
            
                players = players[statsType];
                for (var a = 0; a < teamStats[statsType].length; a++) {
                    var playerStats = teamStats[statsType][a];
                    if ((playerStats.player_id && playerStats.player_id != 0) && (playerStats.active && playerStats.active != 0)) {
                        players.push(a);
                    }
                }
                
                selected_roster_players['selected_' + playing_as + '_players'][statsType] = players;
            }
        }
    };
    
    /**
     * Get a game's stats
     * 
     * @param sport
     */
    var getGameStats = function(sport) {
        $gamePlayerStatsApi.get({
            gameId : game_id,
            sport : sport,
            limit : 100
        }, displayStats);
    };
    
    var selected_roster_players = {
        selected_home_players : {},
        selected_visiting_players : {}
    };
    
    var toggleAllRoster = false;
    
    /**
     * Toggle roster players
     * @param player_id
     * @param team
     * @param statsType
     * @param playerKey
     */
    
    var toggleRosterPlayer = function(team, statsType, playerKey, sport) {
        var statsRow = $(".stats-row[data-player-stats-id='" + team + statsType + playerKey + "']");
        
        var playerStats = $scope.stats[team + '_team_stats'][statsType][playerKey];
        var players = selected_roster_players['selected_' + team + '_players'];
        if (!players[statsType]) {
            players[statsType] = [];
        }
        
        players = players[statsType];
        if ($.inArray(playerKey, players) === -1) {
            players.push(playerKey);
            playerStats.active = 1;
            playerStats.activate = 1;
            playerStats.deactivate = 0;
            statsRow.find('.stats-name').removeClass('inactive-name');
            statsRow.find('.stat-value').prop('disabled', false);
        } else {
            var index = players.indexOf(playerKey);
            players.splice(index, 1);
            for (var n in playerStats) {
                if($scope.sportStats[sport][statsType][n]) {
                    playerStats[n] = 0;
                    playerStats.active = 0;
                    playerStats.deactivate = 1;
                    playerStats.activate = 0;
                }
            }
            statsRow.find('.stats-name').addClass('inactive-name');
            statsRow.find('.stat-value').prop('disabled', true);
        }
        $scope.stats[team + '_team_stats'][statsType][playerKey] = playerStats;
    };
    
    /**
     * Toggle all roster players
     * 
     */
    
    var toggleAllRosterPlayers = function(team, statsType, sport) {
        var statsRows = $(".stats-row[data-team-stats-id='" + team + statsType + "']");
        toggleAllRoster = !toggleAllRoster;
        var players = selected_roster_players['selected_' + team + '_players'];
        
        if (!players[statsType]) {
            players[statsType] = [];
        }
        
        players = players[statsType];
        var playerStats = $scope.stats[team + '_team_stats'][statsType];
        if (toggleAllRoster === true) {
            $scope.checked = team + statsType;
            
            for (var i = 0; i < playerStats.length; i++) {
                if (playerStats[i].player_id) {
                    if ($.inArray(i, players) === -1) {
                        players.push(i);
                        playerStats[i].activate = 1;
                        playerStats[i].deactivate = 0;
                    }
                }
            }
            statsRows.find('.stats-name').removeClass('inactive-name');
            statsRows.find('.stat-value').prop('disabled', false);
        } else {
            $scope.checked = false;
            players = [];
            for (var i = 0; i < playerStats.length; i++) {
                for (var n in playerStats[i]) {
                    if (playerStats[i].player_id) {
                        if($scope.sportStats[sport][statsType][n]) {
                            playerStats[i][n] = 0;
                            playerStats[i].deactivate = 1;
                            playerStats[i].activate = 0;
                        }
                    }
                }
            }
            statsRows.find('.stats-name').addClass('inactive-name');
            statsRows.find('.stat-value').prop('disabled', true);
        }
        selected_roster_players['selected_' + team + '_players'][statsType] = players;

    };
    
    /**
     * Check if a player is active
     * @param player_id
     * @param team
     * @param statsType
     * @param playerKey
     */
    
    var checkIfPlayerIsActive = function(team, statsType, playerKey) {
        var players = selected_roster_players['selected_' + team + '_players'][statsType];
        for (var i = 0; i < players.length; i++) {
            if (players[i] === playerKey) {
                return true;
            }
        }
        
        return false;
    };
    
    /**
     * Check if a player is marked for deletion
     * @param player_id
     * @param team
     * @param statsType
     * @param playerKey
     */
    
    var checkIfPlayerIsMarkedForDeletion = function(team, statsType, playerKey) {
        var players = selected_players['selected_' + team + '_players'][statsType];
        if (players && players.length) {
            for (var i = 0; i < players.length; i++) {
                if (players[i] === playerKey) {
                    return true;
                }
            }
        }

        return false;
    };
    
    /**
     * Add stats for a player
     * 
     * @param {type} 
     * @returns {undefined}
     */
    
    var addPlayerStats = function(team, statsType, sport) {
        var newStatsObj = getStatsObject(sport, statsType);
        newStatsObj.active = 1;
        newStatsObj.activate = 1;
        switch(team) {
            case 'home':
                $scope.stats.home_team_stats[statsType].push(newStatsObj);
                break;
            case 'visiting':
                $scope.stats.visiting_team_stats[statsType].push(newStatsObj);
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
        
        players = players[statsType];
        var playerStats = $scope.stats[team + '_team_stats'][statsType];
        if (toggleAll === true) {
            $scope.checkedForDeletion = team + statsType;
            for (var i = 0; i < playerStats.length; i++) {
                if (!playerStats[i].player_id || playerStats[i].player_id == 0) {
                    if ($.inArray(i, players) === -1) {
                        players.push(i);
                    }
                }
                
            }
        } else {
            $scope.checkedForDeletion = false;
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
        $scope.checkedForDeletion = false;
    };
    
    
    var getTotal = function(statName, statsType, team) {
        var playerStats = $scope.stats[team + '_team_stats'][statsType];
        var total = 0;
        if (playerStats && playerStats.length) {
            for (var i = 0; i < playerStats.length; i++) {
                var value = parseFloat(playerStats[i][statName]);
                if (isNaN(value)) {
                    value = 0;
                }
                total += value;
            }
        }
        
        var immutables = $scope.immutableSportStats[$scope.game.sport][statsType];
        if (immutables[statName]) {
            total = total / playerStats.length;
        }
        
        return limitNumberLength(total, 5);
    };
    
    var limitNumberLength = function(number, limit) {
        var string = number.toString();
        var length = string.length;
        if (length > limit) {
            var sliceIndex = length - limit;
            string = string.slice(-(length), -(sliceIndex));
        }
        
        return parseInt(string);
    };
    
    /*
     * Show a team's player stats
     * @param team
     */
    
    var showTeamStats = function(team) {
        $scope.selectedTeam = team;
    };
    
    /*
     * Hide a Team's stats
     */
    
    var hideTeamStats = function() {
        $scope.selectedTeam = false;
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
        updateGameRequest.gameId = $scope.game.id;
        updateGameRequest.sport = $scope.game.sport;
        
        updateGameRequest.teamId = $scope.game.home_team_id;
        updateGameRequest.final_score = home_team_score;
        updateGameRequest.win = (home_team_score > visiting_team_score) ? 1 : 0;
        updateGameRequest.loss = (home_team_score < visiting_team_score) ? 1 :0;
        updateGameRequest.draw = (home_team_score == visiting_team_score) ? 1 : 0;
        $teamStatsApi.put(updateGameRequest, function(response){
            updateGameRequest.teamId = $scope.game.visiting_team_id;
            updateGameRequest.final_score = visiting_team_score;
            updateGameRequest.win = (visiting_team_score > home_team_score) ? 1 : 0;
            updateGameRequest.loss = (visiting_team_score < home_team_score) ? 1 :0;
            updateGameRequest.draw = (visiting_team_score == home_team_score) ? 1 : 0;
            $teamStatsApi.put(updateGameRequest, displayUpdatedGame);
        });
        
        
    };
    
    var saveStats = function(stats, game_id, home_team_id, visiting_team_id, sport) {
        loading();
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
        displayPlayerStats(response);
        loaded();
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
    
    var $leaguesApi = API.exec('leagues');
    var $leagueSeasonsApi = API.exec('leagueSeasons');
    var $leagueGamesApi = API.exec('leagueGames');
    var $gamesApi = API.exec('games');
    var $gamePlayerStatsApi = API.exec('gamePlayerStats');
    var $teamPlayersApi = API.exec('teamPlayers');
    var $teamStatsApi = API.exec('teamStats');
    
    /**
     * Get the game by id & display the details
     */
    loading();

    $gamesApi.show({gameId: game_id}, function (response) {

        $scope.league_id = response.data.organization_id;

        $leaguesApi.show({
            leagueId : $scope.league_id
        }, function(response) {
            $scope.league = response.data;
        });

        $leagueSeasonsApi.get({leagueId: $scope.league_id}, function (response) {
            $scope.season_id = response.data[0].id;
            $scope.season = response.data[0];
        });

        $leagueGamesApi.show({
            leagueId : $scope.league_id,
            gameId : game_id
        }, displayGame);

    });

    /**********  SCOPE VARIABLE DEFINITIONS  **********/
    
    $scope.setScore = setScore;
    $scope.toggleRosterPlayer = toggleRosterPlayer;
    $scope.toggleAllRosterPlayers = toggleAllRosterPlayers;
    $scope.addPlayerStats = addPlayerStats;
    $scope.togglePlayer = togglePlayer;
    $scope.toggleAllPlayers = toggleAllPlayers;
    $scope.removeSelectedPlayers = removeSelectedPlayers;
    $scope.checkIfPlayerIsActive = checkIfPlayerIsActive;
    $scope.checkIfPlayerIsMarkedForDeletion = checkIfPlayerIsMarkedForDeletion;
    $scope.getTotal = getTotal;
    $scope.saveStats = saveStats;
    $scope.uploadStats = uploadStats;
    $scope.hideModal = hideModal;
    $scope.displayStats = displayStats;
    $scope.showTeamStats = showTeamStats;
    $scope.hideTeamStats = hideTeamStats;
    $scope.selected_roster_players = selected_roster_players;
    $scope.gamePlayerStatsApi = $gamePlayerStatsApi;
    $scope.selectedTeam = false;
    $scope.checked = false;
    $scope.checkedForDeletion = false;
    
    $scope.stats = {
        home_team_stats : {},
        visiting_team_stats : {}
    };
    
    $scope.teamStats = {
        home_team_stats : {},
        visiting_team_stats : {}
    };
    
    
    
    $scope.sportStats = {
        Basketball : basketballStats,
        Softball : softballStats,
        Football : footballStats,
        Football_team : footballTeamStats
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


