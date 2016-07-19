/*
 * Created by Borges Diaz.
 * User: borges@wooter.co
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.01.06
 * Description: 
 *
 */
__Wooter.factory('Leagues', ['$http', 'Notify', function($http, Notify){
    
    var leagues = {};
    var $this = leagues;
    
    leagues.leagues;
    leagues.registrationAnswers;
    leagues.playersByLeagueId;
    leagues.seasons;
    leagues.games;
    leagues.recent_games;
    leagues.post_games;
    leagues.stats;
    leagues.game_stats;
    leagues.video_labels;
    leagues.photo_albums;
    leagues.league_photos;
    leagues.league_division;
    leagues.teams;
    
    leagues.deletePlayerStats = function(league_id, team_id, game_id, sport) {
        var url = 'api/leagues/' + league_id + '/games/' + game_id + '/player-stats?sport=' + sport + '&team_id=' + team_id;
        return $http.delete(url)
                    .success(function(response) {
                        
        });
    };
    
    leagues.createPlayerStats = function(stats, league_id, game_id, team_id, sport) {
        var url = 'api/leagues/' + league_id + '/games/' + game_id + '/player-stats?sport=' + sport + '&method=upload';
        return $http.post(url, {stats : stats, league_id : league_id, game_id : game_id, team_id : team_id});
    };
    
    /*
     * Get a league by id
     * @param league_id
     */
    
    leagues.getLeagueById = function(id) {
        var url = 'api/leagues/' + id;
        return $http.get(url)
                    .success(function(response){
                        leagues.league_photos = response.data.photos;
                        leagues.league_divisions = response.data.divisions;
                        $this.leagues = [response.data];
                        $this.league = response.data;
                loaded();
        });
    };


    /**
     * leagues videos
     * @returns {Array|$scope.leagues|*}
     */
    leagues.getVideos = function() {

        return leagues.leagues;
    };

    /**
     * Fix for get photos
     *
     */

    leagues.getPhotos = function() {

        return leagues.league_photos;
    };

    /**
     * Fix for get divisions
     *
     */

    leagues.getLeagueDivisions = function() {

        return leagues.league_divisions;
    };


    leagues.getLeagueTeams = function(id) {
        var url = 'api/leagues/'+id+'/teams';

        return $http.get(url)
            .success(function(response){
              leagues.teams = response.data;

            });
    };

    leagues.loadLeagueTeams = function() {

        return leagues.teams;
    };
    /**
     * Add/Update league videos titles and set labels for videos
     *
     * @param id
     * @param data
     * @returns {*}
     */
    leagues.publishLeagueVideos = function(id, data) {

       loading();

        var config = {
            method: "POST",
            url: 'api/leagues/' + id+ '/publishLeagueVideos',
            data: data,
            unique:true,
            requestId: 'create-comment'
        };

        $http(config).success(function(response){

            return $this.getLeagueById(id);
        });
    };





    /**
     * Update uploaded qnap server eague videos titles and set labels for videos
     *
     * @param id
     * @param data
     * @returns {*}
     */

    leagues.updateQnapVideos = function(id, data) {
        loading();
        var url = 'api/qnap/updateVideos';
        return $http.post(url, data)
            .success(function(response){

                return $this.getLeagueById(id);
            });
    };

    /*
     * Get leagues of user
     */
    
    leagues.getCurrentPlayerLeagues = function() {
        var url = 'api/leagues/';
        return $http.get(url)
                    .success(function(response){
                        $this.teams = response.data;
        });
    };
    
    /*
     * Get registration answers of a pleyer by the player id
     * @param league_id
     * @param player_id
     */
    
    leagues.getRegistrationAnswers = function(request) {
        return $http.get($this.buildUrl(request))
                    .success(function(response){
                        $this.registrationAnswers = response.data;
        });
    };
    
    /*
     * Get registration answers by player id & league id
     * @param player_id
     * @param league_id
     */
    
    leagues.getRegistrationAnswersByPlayerId = function (request, player_id) {
        request.player_id = player_id;
        return $this.getRegistrationAnswers(request);
    };
    
    /*
     * Get players
     * @param request
     */
    
    leagues.getPlayers = function(request) {
        return $http.get($this.buildUrl(request))
                    .success(function(response){
                        $this.players = response.data;
        });
    };
    
    /*
     * Get players that belong to a league
     * @param request
     * @param league_id
     */
    
    leagues.getPlayersByLeagueId = function(request, league_id) {
        request.league_id = league_id;
        return $this.getPlayers(request);
    };
    
    /*
     * Get players by name
     * @param request
     * @param name
     */
    
    leagues.getPlayersByName = function(request, name) {
        request.name = name;
        return $this.getPlayers(request);
    };
    
    /*
     * Sort players by name
     * @param request
     * @param sortBy
     */
    
    leagues.sortPlayersByName = function(request, sortBy) {
        request.sortBy = sortBy ? 0 : 'name';
        return $this.getPlayers(request);
    };
    
    /*
     * Get players by offset
     * @param request
     * @param offset
     */
    
    leagues.getPlayersByOffset = function(request, offset) {
        request.offset = offset;
        return $this.getPlayers(request);
    };
    
    /*
     * Get a list of seasons
     * @param request
     */
    
    leagues.getSeasons = function(request) {
        return $http.get($this.buildUrl(request))
                    .success(function(response){
                        $this.seasons = response.data;
        });
    };
    
    /*
     * Get a list of seasons belonging to a league
     * @param request
     * @param league_id
     */
    
    leagues.getSeasonsByLeagueId = function(request, league_id) {
        request.league_id = league_id;
        return $this.getSeasons(request);
    };
    
    /*
     * Get a season by id
     * @param league_id
     * @param season_id
     */
    
    leagues.getSeasonById = function(league_id, season_id) {
        var url = 'api/leagues/' + league_id + '/seasons/' + season_id;
        $http.get(url)
             .success(function(response) {
                 $this.competition = response.data.name;
        });
    };
    
    /*
     * Get a list of divisions
     * @param request
     */
    
    leagues.getDivisions = function(request) {
        return $http.get($this.buildUrl(request))
                    .success(function(response){
                        $this.divisions = response.data;
        });
    };
    
    /*
     * Get a list of divisions league id
     * @param request
     */
    
    leagues.getDivisionsByLeagueId = function(request, league_id) {
        request.league_id = league_id;
        return $this.getDivisions(request);
    };
    
    /*
     * Get seasons
     * @param request
     */
    
    leagues.getGames = function(request) {
        return $http.get($this.buildUrl(request))
                    .success(function(response) {
                        $this.weeks = {};
                        response.data.games.forEach(function(game, index) {
                            if (game.week && !$this.weeks[game.week.id]) {
                                $this.weeks[game.week.id] = game.week;
                            }
                        });
                        
                        $this.dates = [];
                        response.data.games.forEach(function(game, index) {
                            if (!($this.dates.indexOf(game.datetime) > -1)) {
                                $this.dates.push(game.datetime);
                            }
                        });
        })
                    .success(function(response){
                        $this.games = response.data.games;
                        $this.games_pages = response.data.pages;
        });
    };
    
    /*
     * Get all league games by league id
     * @param request
     * @param league_id
     */
    
    leagues.getAllLeagueGames = function(request, league_id) {
        request.season_id = 0;
        request.league_id = league_id;
        return $this.getGames(request);
    };
    
    /*
     * Get games by time period
     * @param request
     * @param time_period
     */
    
    leagues.getGamesByTimePeriod = function(request, time_period, competition_id) {
        alert(time_period + '    ' + competition_id);
        
    };
    
    /*
     * Get a league competition's weeks
     * @param request
     */
    
    leagues.getWeeks = function(request, competition_type) {
        var url = $this.buildUrl(request) + '?competition_type=' + competition_type;
        return $http.get(url)
                    .success(function(response) {
                        $this.competition_weeks = response.data;
        });
    };
    
    /*
     * Get weeks by competition
     * @param league_id
     */
    
    leagues.getWeeksByCompetitionId = function(request, league_id, competition_id, competition_type) {
        request.league_id = league_id;
        request.competition_id = competition_id;
        return $this.getWeeks(request, competition_type);
    };
    
    
    
    /*
     * Get games by league id
     * @param request
     * @param league_id
     */
    
    leagues.getGamesByLeagueId = function(request, league_id) {
        request.league_id = league_id;
        request.status    = 'all';
        return $this.getGames(request)
                    .success(function(response){
                        $this.games = response.data.games;
        });
    };
    
    /*
     * Get games by season id
     * @param request
     * @param season_id
     */
    
    leagues.getGamesBySeasonId = function(request, season_id) {
        request.season_id = season_id;
        request.status    = 'all';
        return $this.getGames(request)
                    .success(function(response){
                        $this.games = response.data.games;
        });
    };
    
    /*
     * Get games by division id
     * @param request
     * @param division_id
     */
    
    leagues.getGamesByDivisionId = function(request, division_id) {
        request.division_id = division_id;
        request.status = 'all';
        return $this.getGames(request)
                    .success(function(response){
                        $this.games = response.data.games;
        });
    };
    
    /*
     * Sort games
     * @param request
     * @param sort_by
     */
    
    leagues.sortGames = function(request, sort) {
        request.sort   = sort ? 1 : 0;
        request.status = 'all';
        return $this.getGames(request)
                    .success(function(response){
                        $this.games = response.data.games;
        });
    };
    
    /*
     * Get games by offset
     * @param request
     * @param offset
     */
    
    leagues.getGamesByOffset = function(request, offset) {
        request.offset = offset;
        request.status = 'all';
        return $this.getGames(request)
                    .success(function(response){
                        $this.games = response.data.games;
        });
    };
    
    /*
     * Get games by week
     * @param request
     * @param week
     */
    
    leagues.getGamesByWeekId = function(request, week_id) {
        request.week_id = week_id;
        request.status = 'all';
        return $this.getGames(request);
    };
    
    /*
     * Get post games by league id
     * @param request
     * @param league_id
     */
    
    leagues.getPostGamesByLeagueId = function(request, league_id) {
        request.league_id = league_id;
        request.status    = 'post';
        return $this.getGames(request)
                    .success(function(response){
                        $this.post_games = response.data.games;
        });
    };
    
     /*
     * Get post games by season id
     * @param request
     * @param season_id
     */
    
    leagues.getPostGamesBySeasonId = function(request, season_id) {
        request.season_id = season_id;
        request.status    = 'post';
        return $this.getGames(request)
                    .success(function(response){
                        $this.post_games = response.data.games;
        });
    };
    
     /*
     * Get games by offset
     * @param request
     * @param offset
     */
    
    leagues.getPostGamesByOffset = function(request, offset) {
        request.offset = offset;
        request.status = 'post';
        return $this.getGames(request)
                    .success(function(response){
                        $this.post_games = response.data.games;
        });
    };
    
    /*
     * Get recent games by league id
     * @param request
     * @param league_id
     */
    
    leagues.getRecentGamesByLeagueId = function(request, league_id) {
        request.league_id = league_id;
        request.status    = 'recent';
        return $this.getGames(request)
                    .success(function(response){
                        $this.recent_games = response.data.games;
        });
    };
    
    /*
     * Get recent games by season id
     * @param request
     * @param season_id
     */
    
    leagues.getRecentGamesBySeasonId = function(request, season_id) {
        request.season_id = season_id;
        request.status    = 'recent';
        return $this.getGames(request)
                    .success(function(response){
                        $this.recent_games = response.data.games;
        });
    };
    
    /*
     * Get games by offset
     * @param request
     * @param offset
     */
    
    leagues.getRecentGamesByOffset = function(request, offset) {
        request.offset = offset;
        request.status = 'recent';
        return $this.getGames(request)
                    .success(function(response){
                        $this.recent_games = response.data.games;
        });
    };
    
    /*
     * Get recent games by division id
     * @param request
     * @param division_id
     */
    
    leagues.getRecentGamesByDivisionId = function(request, division_id) {
        request.division_id = division_id;
        request.status = 'recent';
        return $this.getGames(request)
                    .success(function(response){
                        $this.recent_games = response.data.games;
        });
    };
    
    /*
     * Get post games by division id
     * @param request
     * @param division_id
     */
    
    leagues.getPostGamesByDivisionId = function(request, division_id) {
        request.division_id = division_id;
        request.status = 'post';
        return $this.getGames(request)
                    .success(function(response){
                        $this.post_games = response.data.games;
        });
    };
    
    /*
     * Sort recent games
     * @param request
     * @param sort_by
     */
    
    leagues.sortRecentGames = function(request, sort) {
        request.sort   = sort ? 1 : 0;
        request.status = 'recent';
        return $this.getGames(request)
                    .success(function(response){
                        $this.recent_games = response.data.games;
        });
    };
    
    /*
     * Sort post games
     * @param request
     * @param sort_by
     */
    
    leagues.sortPostGames = function(request, sort) {
        request.sort   = sort ? 1 : 0;
        request.status = 'post';
        return $this.getGames(request) 
                    .success(function(response){
                        $this.post_games = response.data.games;
        });
    };
    
    /*
     * Get stats
     * @param request
     */
    
    leagues.getStats = function(request, sport) {
        var url = $this.buildUrl(request) + '?sport=' + sport;
        return $http.get(url)
                    .success(function(response){
                        $this.game_stats = response.data;
        });
    };
    
    /*
     * Get stats for a league's season game
     * @param league_id
     * @param season_id
     * @param game_id
     */
    
    leagues.getLeagueGameStats = function(league_id, game_id, sport) {
        var request = $this.getStatsRequest();
        request.league_id = league_id;
        request.game_id = game_id;
        return $this.getStats(request, sport)
                    .success(function(response){
                        $this.game_stats = response.data;
        });
    };
    
    /*
     * Create a game
     */
    
    leagues.createGame = function() {
        var url = 'leagues/1/seasons/1/games/store';
        return $http.post(url)
                    .success(function(response){
                        
        });
    };
    
    /**
     * leagues videos
     * @returns {Array|$scope.leagues|*}
     */
    leagues.getVideos = function() {
        return leagues.leagues;
    };

    /**
     * Fix for get photos
     *
     */

    leagues.getPhotos = function() {
        return leagues.league_photos;
    };

    /**
     * Fix for get divisions
     *
     */

    leagues.getLeagueDivisions = function() {
        return leagues.league_divisions;
    };


    leagues.getLeagueTeams = function(id) {
        var url = 'api/leagues/'+id+'/teams';
        return $http.get(url)
            .success(function(response){
              leagues.teams = response.data;

            });
    };

    leagues.loadLeagueTeams = function() {
        return leagues.teams;
    };
    


    leagues.publishLeaguePhotos = function(id, data) {
        var url = 'api/leagues/' + id+ '/publishLeaguePhotos';
        return $http.post(url, data)
            .success(function(response){
                return $this.getLeagueById(id);
            });
    };

    leagues.deletePublishedLeaguePhotos = function(id, data) {
        loading();
        var url = 'api/leagues/' + id+ '/deletePublishedLeaguePhotos';
        return $http.post(url, data)
            .success(function(response){
                return $this.getLeagueById(id);
            });
    };




    /**
     * delete uploaded league videos
     *
     * @param id
     * @param data
     * @returns {*}
     */
    
    leagues.deletePublishedLeagueVideos = function(id, data) {
        loading();
        var url = 'api/leagues/' + id+ '/deletePublishedLeagueVideos';
        return $http.post(url, data)
            .success(function(response){
                return $this.getLeagueById(id);
            });
    };

    /**Start of video labels CRUD model ****/
    /**
     *
     * @param id
     * @param data
     * @returns {*}
     */

    leagues.createLeagueVideoLabels = function(id, data) {
        loading();
        var url = 'api/leagues/'+ id +'/videoLabel';
        return $http.post(url, data)
            .success(function(response){
               return $this.getVideoLabelsById(id);
            });
    };

    leagues.updateLeagueVideoLabels = function(id, data) {
        loading();
        var url = 'api/leagues/'+ id +'/videoLabel';
        return $http.put(url, data)
            .success(function(response){
                return $this.getVideoLabelsById(id);
            });
    };

    leagues.removeLeagueVideoLabels = function(id, data) {
        loading();
        var url = 'api/leagues/'+ id +'/videoLabel/delete';
        return $http.post(url, data)
            .success(function(response){
                $this.getVideoLabelsById(id);
                setTimeout(function(){
                    Notify({
                            message: 'League video label deleted successfully!',
                            timeout: 3000,
                            type: 'success',
                            icon: true
                        });
                    }, 1000);

            }).error(function(data, status){
                loaded();
                setTimeout(function(){
                    Notify({
                            message: 'Please unlink the videos belongs to this category!',
                            timeout: 3000,
                            type: 'error',
                            icon: true
                        });
                    }, 1000);
            });
    };

    leagues.getVideoLabelsById = function(id) {
        var url = 'api/leagues/'+ id +'/videoLabel';
        return $http.get(url)
            .success(function(response){
                loaded();
               return $this.video_labels = (response.data);
            });
    };

    leagues.loadLeagueLabels = function() {
        return $this.video_labels;
    };

    /** End of Video Labels CRUD model **/

    leagues.createLeaguePhotoAlbums = function(id, data) {
        loading();
        var url = 'api/leagues/'+ id +'/photoAlbum';
        return $http.post(url, data)
            .success(function(response){
                return $this.getPhotoAlbumsById(id);
            });
    };

    /** Start of League Album CRUD **/

    leagues.updateLeaguePhotoAlbums = function(id, data) {
        loading();
        var url = 'api/leagues/'+ id +'/photoAlbum';
        return $http.put(url, data)
            .success(function(response){
                return $this.getPhotoAlbumsById(id);
            });
    };

    leagues.removeLeaguePhotoAlbum = function(id, data) {
        loading();
        var url = 'api/leagues/'+ id +'/photoAlbum/delete';
        return $http.post(url, data)
            .success(function(response){
              $this.getPhotoAlbumsById(id);
                setTimeout(function(){
                    loaded();
                Notify({
                    message: 'League photo album deleted successfully!',
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });
                }, 1000);

            }).error(function(data, status){
                loaded();
                Notify({
                    message: 'Please unlink the photos belongs to this album!',
                    timeout: 3000,
                    type: 'error',
                    inverse: true,
                    icon: true
                });
                //return status;
            });;
    };

    leagues.getPhotoAlbumsById = function(id) {
        var url = 'api/leagues/'+ id +'/photoAlbum';
        return $http.get(url)
            .success(function(response){
                loaded();
                return $this.photo_albums = (response.data);
            });
    };

    leagues.loadLeagueAlbums = function() {
        return $this.photo_albums;
    };

    /** End of League Album CRUD **/
    /**
     * Get all games for the single league
     *
     * @param id
     * @returns {*}
     */
    
    leagues.getLeagueGames = function(id) {
        var url = '/api/leagues/'+id+'/games';
        return $http.get(url)
            .success(function(response){
                return $this.games = response.data.games;
            });
    };

    /**
     * return leagues games to the views
     */
    
    leagues.loadLeagueGames = function() {
        return $this.games;
    };

    /*
     * Build url from request object
     * @param request
     */
    
    leagues.buildUrl = function(request) {
        var url = 'api';
        for(var param in request) {
            url += '/' + request[param];
        }
        return url;
    };
    
    /*
     * Return a standard request object for league players
     */
    
    leagues.getPlayersRequest = function() {
        var request = {};
        
        request.url       = 'leagues';
        request.league_id = 0;
        request.models    = 'players';
        request.name      = 0;
        request.sortBy    = 0;
        request.offset    = 0;
        request.limit     = 10;
        
        return request;
    };
 
    /*
     * Return standard request object for registration answers
     */
    
    leagues.getAnswersRequest = function() {
        var request = {};
        
        request.url       = 'leagues';
        request.league_id = 0;
        request.resource  = 'registration-answers';
        request.player_id = 0;
        request.offset    = 0;
        request.limit     = 1;
        
        return request;
    };
    
    /*
     * Return standard request object for a league's seasons
     */
    
    leagues.getSeasonsRequest = function() {
        var request = {};
        
        request.url       = 'leagues';
        request.league_id = 0;
        request.resource  = 'seasons';
        
        return request;
    };
    
    /*
     * Return standard request object for a league's divisions
     */
    
    leagues.getDivisionsRequest = function() {
        var request = {};
        
        request.url       = 'leagues';
        request.league_id = 0;
        request.resource  = 'divisions';
        
        return request;
    };
    
    /*
     * Return standard request object for a league's games
     */
    
    leagues.getGamesRequest = function() {
        var request = {};
        
        request.url = 'leagues';
        request.league_id = 0;
        request.resource  = 'games';
        request.status    = 'all';
        request.sort      = 1;
        request.offset    = 0;
        request.limit     = 10;
        request.season_id = 0;
        request.division_id = 0;
        request.week_id   = 0;
        
        return request;
    };
    
     /*
     * Return standard request object for a league's games
     */
    
    leagues.getStatsRequest = function() {
        var request = {};
        
        request.url       = 'leagues';
        request.league_id = 0;
        request.games     = 'games';
        request.game_id   = 0;
        request.resource  = 'player-stats';
        
        return request;
    };
    
    /*
     * Return standard request object for a league competition's weeks
     */
    
    leagues.getWeeksRequest = function() {
        var request = {};
        
        request.url            = 'leagues';
        request.league_id      = 0;
        request.competition    = 'competition';
        request.competition_id = 0;
        request.resource       = 'weeks';
        
        return request;
    };
    
    return leagues;
     
}]);

