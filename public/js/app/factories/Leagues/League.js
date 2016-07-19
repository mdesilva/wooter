/**
 * Created by Dumitrana Alinus
 * User: alin.designstudio@gmail.com
 * For: League
 * License: Wooter LLC.
 * Date: 2016.03.01
 * Description: Factory to get data of a single league
 *
 */
__Wooter.factory('League', ['$window', '$http', 'Authentify', '$resource', function($window, $http, Authentify, $resource){
    var factory = {};

    var Generator = {
        apiURL: {
            league: function (url) {
                return 'api/leagues/{leagueId}/'+( ( url.slice(0,1) == '/' ) ? url.slice(1) : url );
            },
            organization: function (url) {
                return 'api/organizations/'+( ( url.slice(0,1) == '/' ) ? url.slice(1) : url );
            }
        }
    };

    /**
     * Data for request league
     */
    factory.request = {
        leagueId: null
    };
    factory.config = {
        urls: {
            league: Generator.apiURL.league(''),
            basics: Generator.apiURL.league('basics'),
            details: Generator.apiURL.league('details'),
            locations: Generator.apiURL.league('locations'),
            photos: Generator.apiURL.league('photos'),
            videos: Generator.apiURL.league('videos'),
            features: Generator.apiURL.league('features'),
            seasons: Generator.apiURL.league('seasons'),
            prices: Generator.apiURL.league('prices')
        },
        listLeagues: Generator.apiURL.organization('leagues/list'),
        leagueURL: Generator.apiURL.league('')
    };

    /*
     * Set League id for request
     */
    factory.setLeagueId = function (id) {
        factory.request.leagueId = id;
    };

    /**
     * Get instances
     *
     * @param leagueId
     * @returns {HttpPromise}
     */
    factory.createRequest = function(leagueId){
        factory.setLeagueId(leagueId);

        if (!isNull(factory.request.leagueId)) {
            var apis = factory.config.urls,
                object = {};

            angular.forEach(apis, function(v, k){
                object[k] = $http.get(tpl(v, {leagueId: factory.request.leagueId}), factory.request);
            });

            return object;
        } else {
            throw new Error('League request is not setup!');
        }
    };


    factory.getFullData = function (leagueId) {
        factory.setLeagueId(leagueId);

        if (!isNull(factory.request.leagueId)) {
            return $http.get(tpl(factory.config.leagueURL, {leagueId: factory.request.leagueId}), factory.request);
        } else {
            throw new Error('League request is not setup!');
        }
    };

    /**
     * Get all Leagues base on auth
     * @returns {HttpPromise}
     */
    factory.getListLeagues = function () {
        if(Authentify.check()){
            return $http.get(factory.config.listLeagues, factory.request);
        }
    };

    return factory;
}]);
