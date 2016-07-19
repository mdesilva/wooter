__Wooter.factory('Teams', ['$http', '$stateParams', '$resource', function($http, $stateParams, $resource){

    function Teams() {
        this.service = $resource('api/leagues/:league_id/teams/:team_id', {
            league_id: $stateParams.league_id,
        }, {
            query: {
                method: 'GET',
                isArray: true,
                // transformResponse: function(resp) {
                //     return angular.fromJson(resp).data;
                // }
                transformResponse: function(data, header) {
                    var teams = angular.fromJson(data).data;
                    angular.forEach(teams, function(value) {
                        // console.log(value);
                    });
                    return teams;
                }
            }
        });
    }

    Teams.prototype.all = function() {
        return this.service.query();
    };

    return new Teams();


    // var teams = {};
    // var $this = teams;
    
    // teams.teams;
    
    // /*
    //  * Get the teams of the chrrent user
    //  */
    
    // var teams = {
    //     teams: null
    // };
    // var $this = teams;
    
    /*
     * Get the teams of the chrrent user
     */
    
    // teams.getCurrentPlayerTeams = function() {
    //     var url = 'api/teams/1/0';
    //     return $http.get(url)
    //                 .success(function(response){
    //                     $this.teams = response.data;
    //     });
    // };
    
    // /*
    //  * Get teams of a player by the player id
    //  * @param id
    //  */
    
    // teams.getTeamsByPlayerId = function(id) {
    //     var url = 'api/teams/0/' + id;
    //     return $http.get(url)
    //                 .success(function(response) {
    //                     $this.teams = response.data;
    //     });
    // };
    
    // /*
    //  * Get a team by id
    //  * @param id
    //  */
    
    // teams.getTeamById = function(id) {
    //     var url = 'api/teams/' + id;
    //     alert(url);
    //     return $http.get(url)
    //                 .success(function(response) {
    //                     $this.teams = response.data;
    //     });
    // };

    // /*
    // * Get all teams by League ID
    // *
    // */

    // teams.all = function(leagueId) {
    //     var apiUrl = 'api/leagues/' + $stateParams.league_id + '/teams';

    //     return $http({
    //         method: 'GET',
    //         url: apiUrl
    //     });
    // };
 
    // return teams;
     
}]);
