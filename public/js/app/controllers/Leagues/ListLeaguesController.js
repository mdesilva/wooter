/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: leagues/list
 * License: Wooter LLC.
 * Date: 2016.02.22
 * Description: Controller for leagues/list page
 *
 */
__Wooter.controller('Leagues/ListLeaguesController', ['$scope', 'Page', '$stateParams', '$state', '$timeout', 'MQ', 'API', function ($scope, Page, $stateParams, $state, $timeout, MQ, API) {

    // Destroy local variables so that it does not over-ride with previous local variables
    $$store.local.destroy('league_create_model');
    $$store.local.destroy('league_id');
    $$store.local.destroy('season_id');
    $$store.local.destroy('saved_steps');
    loading();
    /**
     * Resize events function
     * @type {{}}
     */
    var ResizeEvent = {};

    /**
     * Get parent
     * @returns {Element}
     */
    ResizeEvent.root = function () {
        return document.querySelector('.leagues-list');
    };

    /**
     * Get list with all items from leagues-list
     * @returns {NodeList}
     */
    ResizeEvent.elements = function () {
        return document.querySelectorAll('.item');
    };

    /**
     * Get max height from league list items
     * @param elements
     * @param find
     * @returns {number}
     */
    ResizeEvent.getMaxHeight = function (elements, find) {
        var max = 0;
        var k=0;
        angular.forEach(elements, function(value){
            k++;
            max = (max > $(value).find(find).height())?max:$(value).find(find).height();
        });
        return max;
    };

    /**
     * Define init function
     */
    ResizeEvent.on = function(){
        // Run just if width of window is more than 620px
        if(MQ.minWidth(620)){
            var $intv = setInterval(function () {
                if(count(ResizeEvent.elements()) > 1){
                    $(ResizeEvent.elements()).each(function(){
                        $(this).find('md-card').removeAttr('style');
                        $(this).find('.text').removeAttr('style');
                    });
                    $(ResizeEvent.elements()).each(function(){
                        $(this).find('md-card').css('height', ResizeEvent.getMaxHeight(ResizeEvent.elements(), 'md-card'));
                    });

                    $(ResizeEvent.elements()).each(function(){
                        $(this).find('.text').css('height', ResizeEvent.getMaxHeight(ResizeEvent.elements(), '.text'));
                    });
                    clearInterval($intv);
                }
            }, 50);
        } else {
            $(ResizeEvent.elements()).each(function(){
                $(this).find('md-card').removeAttr('style');
                $(this).find('.text').removeAttr('style');
            });
        }
    };

    /**
     * Register Tabs
     * @used just for check tab param
     * @type {string[]}
     */
    var tabs = ['active','past','archives'];

    /**
     * Clear params
     * @param tab
     * @param s
     * @returns {*}
     */
    function clearParam(tab, s) {
        switch (s){
            case "tab":
                if(!angular.isUndefined(tab)){
                    if( (tab === true && check_type(tab, 'boolean')) || (tab === "true" && check_type(tab, 'string')) ){
                        tab = 'active';
                    } else {
                        if(tabs.indexOf(tab.toString()) > -1){
                            tab = (angular.isUndefined(tab))?'active':( (tab == "")?'active':tab );
                        } else {
                            tab = 'active';
                        }
                    }
                } else {
                    tab = 'active';
                }
                break;
        }

        return tab;
    }

    /**
     * Check if is tab
     * @param tab
     * @returns {boolean}
     */
    function isTab(tab){
        return (clearParam(tab, 'tab') == $scope.activeTab);
    }

    /**
     * Filtering tab value (if are missing or is other value who dont exist in tabs var will be active)
     */
    $stateParams.tab = clearParam($stateParams.tab, 'tab');

    /**
     * Get and define API
     */
    var $leagueApi = API.exec('leagues');

    /**
     * Get List using API Request
     */
    $leagueApi.get({own:true},function (data) {
        $scope.leagues = getAllLeagues(data);

        ResizeEvent.on();
        loaded();
    });

    /**
     * Check function to determine if league exist (byID)
     * @param id
     * @param leagues
     * @param list
     * @returns {number}
     */
    var leagueExist = function (id, leagues, list) {
        var fd = -1;
        angular.forEach(leagues[list], function (value, key) {
            if(parseInt(value.id) == parseInt(id)){
                fd = key;
            }
        });
        return fd;
    };

    /**
     * Define actions
     * @type {{edit: LEAGUE.edit, manage: LEAGUE.manage, archive: LEAGUE.archive, delete: LEAGUE.delete, setList: LEAGUE.setList}}
     */
    var LEAGUE = {
        /**
         * Redirect action to league edit page
         * @param id
         */
        edit: function (id) {
            $state.go('dashboardLeagueEdit', {league_id: id});
        },

        /**
         * Redirect action to league management page
         * @param id
         */
        manage: function (id) {
            $state.go('dashboardTeams', {league_id: id});
        },

        /**
         * API action to archive league
         * @param league
         */
        archive: function (league) {
            debugger;
            $leagueApi.put({leagueId: league.id, name: league.name, archive:true, sport_id: league.sport_id}, function(res){
                var $item = $("[data-league-id="+parseInt(league.id)+"]");
                $item.fadeOut(400, function () {
                    $leagueApi.get({own:true},function (data) {
                        $scope.leagues = getAllLeagues(data);
                        ResizeEvent.on();
                    });
                });

                $$notify.create({
                    message: "League Archived successfully",
                    inverse: true,
                    type: "success",
                    fontIcon: "material",
                    icon: 'check',
                    timeout: 5000,
                    protect: true
                });
            }, function (res) {
                $$notify.create({
                    message: res.error.message,
                    inverse: true,
                    type: "error",
                    fontIcon: "material",
                    icon: 'error',
                    timeout: 5000,
                    protect: true
                });
            });
        },

        /**
         * API action to unarchive league
         * @param league
         */
        unarchive: function (league) {
            $leagueApi.put({leagueId: league.id, name: league.name, archive:false, sport_id: league.sport_id}, function(res){
                var $item = $("[data-league-id="+parseInt(league.id)+"]");
                $item.fadeOut(400, function () {
                    $leagueApi.get({own:true},function (data) {
                        $scope.leagues = getAllLeagues(data);
                        ResizeEvent.on();
                    });
                });

                $$notify.create({
                    message: "League Unarchived successfully",
                    inverse: true,
                    type: "success",
                    fontIcon: "material",
                    icon: 'check',
                    timeout: 5000,
                    protect: true
                });
            }, function (res) {
                $$notify.create({
                    message: res.error.message,
                    inverse: true,
                    type: "error",
                    fontIcon: "material",
                    icon: 'error',
                    timeout: 5000,
                    protect: true
                });
            });
        },

        /**
         * Setting view using tab values
         * @param tp
         */
        setList: function (tp) {
            tp = clearParam(tp, 'tab');
            var list = $('.leagues-list');
            ResizeEvent.on();
            list.fadeOut(400).delay(100).fadeIn(400);
            $timeout(function () {
                $scope.activeTab = tp;
                $timeout(function () {
                    ResizeEvent.on();
                }, 200);
            }, 400);
        }
    };

    /**
     * Run League action
     * @using LEAGUE
     * @param act
     * @param data
     * @returns {*}
     */
    function ACTION (act, data, name) {
        name = name || null;
        return LEAGUE[act](data,name);
    }

    /**
     * - Clean assets
     * - Setting title of page
     * - Adding Stylesheet
     */
    Page.reset();
    Page.title('Leagues List | Wooter');
    Page.stylesheets([
        'css/leagues/leagues-list.css'
    ]);

    /**
     * Function filter to get all leagues
     * @param $leagueApis
     * @returns {{active: Array, past: Array, archives: Array}}
     */
    function getAllLeagues($leagueApis) {
        var leagues = {
            active: [],
            past: [],
            archives: []
        };

        angular.forEach($leagueApis.data, function (league) {

            var season = league.seasons[0];

            var $leagueApi = {
                id: league.id,
                name: league.name,
                season: season.name,
                sport_id: league.sport_id,
                archived: league.archived,
                image: (league.basics && league.basics.logo)?league.basics.logo.file_path:""
            };

            var $now = (new Date()).getUnix();
            var $end = (new Date(season.ends_at)).getUnix();
            
            if(league.archived == 1){
                leagues.archives.push($leagueApi);
            } else {
                if($end < $now){
                    leagues.past.push($leagueApi);
                } else {
                    leagues.active.push($leagueApi);
                }
            }
        });

        return leagues;
    }

    /**
     * Create league method
     */
    function createNewLeague (){
        console.log('Created!');
    }

    /**
     * Bring active tab in views
     * @type {*}
     */
    $scope.activeTab = $stateParams.tab;
    ACTION('setList', $stateParams.tab);

    /**
     * Bring create league function in view
     * @type {createNewLeague}
     */
    $scope.createNewLeague = createNewLeague;

    /**
     * Bring Action function in view
     * @type {ACTION}
     */
    $scope.action = ACTION;

    /**
     * Bring isTab function in view
     * @type {isTab}
     */
    $scope.isTab = isTab;

    /**
     * Run event after Content are loaded
     */
    $scope.$on('$viewContentLoaded', ResizeEvent.on);

    /**
     * Init ResizeEvent on resize window
     * @type {ResizeEvent.on|*}
     */
    window.onresize = ResizeEvent.on;

}]);
