/*
 * Created by Carlos Marra
 * User: loslambda / los_lambdas
 * For: Dashboard/videos
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description:
 *
 */
__Wooter.controller('Dashboard/VideosController', ['$scope', '$mdDialog', 'Page', '$sce', '$stateParams', 'API', function ($scope, $mdDialog, Page, $sce, $stateParams, API) {

    loading();
    var leagueId = $stateParams.league_id;
    Page.reset();



    $scope.league_id = $stateParams.league_id;

    var $leaguesAPI = API.exec('leagues');
    var $leagueGamesAPI = API.exec('leagueGames');
    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $leagueVideoLabelsAPI = API.exec('leagueVideoLabels');
    var $leagueSeasonsAPI = API.exec('leagueSeasons');
    var $leagueVideosAPI = API.exec('leagueVideos');


    var getVideosRequest = function() {
        var request = {};
        request.leagueId = $stateParams.league_id;
        request.offset = 0;
        request.limit = 10;
        request.order_by = 'created_at';
        request.order_direction = 'DESC';
        request.order_by_videos_type = 'Qnap',
        request.get_videos_type = 'All'

        return request;
    };

    var videosRequest = getVideosRequest();


    $scope.leagues = [];
    $leaguesAPI.show({
        leagueId: $stateParams.league_id
    }, function(resp) {

        var league = resp.data;
        $scope.leagueName = league.name;
        Page.title($scope.leagueName + ' - Videos | Wooter');
        $scope.leagues = league;
        $scope.league = league;
     });


    $leagueVideosAPI.get(videosRequest, function (response) {
        $scope.synchronize(response.data);

    });


    $scope.synchronize = function(data) {
        $scope.leagueVideos = data.videos;
        $scope.pages = data.pages;

        $scope.items = [];
        $scope.selected = [];
        $scope.leagueVideos.forEach(function(video) {
            $scope.items.push(video.id);
        });

        loaded();
    };

    $leagueSeasonsAPI.get({leagueId: $stateParams.league_id}, function (response) {
        $scope.season = response.data[0];
    });

    $leagueGamesAPI.get({
        leagueId: $stateParams.league_id,
        orderBy:'time',
        orderDirection:'Asc'

    }, function(resp) {
        $scope.games = [];
        $scope.games = resp.data.games;


    });

    $scope.teams = [];

    $leagueTeamsAPI.show({
        leagueId: $stateParams.league_id
    }, function(resp) {

        $scope.teams = resp.data.teams;


    });

    $scope.labels = [];

    $leagueVideoLabelsAPI.get({
        leagueId: $stateParams.league_id
    }, function(resp) {

        $scope.labels = resp.data;

    });
    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/media.css',
        '/css/dashboard/management.css',
        '/css/dashboard/animate.css'
    ]);

    Page.scripts([
        '/js/dashboard/main_management.js',
    ]);

     $scope.createVideo = function(ev) {
        //Videos.setVideo("");
        $mdDialog.show({
            controller: getControllerName('modals/dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/uploadLeagueVideo.html',
            parent: angular.element(document.body),
            scope: $scope,
            targetEvent: ev,
            clickOutsideToClose:false,
            preserveScope:true
        });

    };

    $scope.editVideo = function( ev, video) {

        //Videos.setVideo(video);
        $scope.videoToEdit = video;
        $mdDialog.show({
            controller: getControllerName('modals/dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/editLeagueVideo.html',
            parent: angular.element(document.body),
            scope: $scope,
            targetEvent: ev,
            clickOutsideToClose:false,
            preserveScope:true


        });
    };

    $scope.deleteVideo = function(ev, video) {

       $scope.videoToDelete = video;
       console.log('VIDEO TO DELETE', $scope.videoToDelete);
        $mdDialog.show({
            controller: getControllerName('modals/dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/deleteLeagueVideo.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:false,
            preserveScope:true
        });
    };

    $scope.playVideo = function($event, video) {

        $scope.videoToPlay = video;
        $mdDialog.show({
            controller: getControllerName('modals/dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/playLeagueVideo.html',
            parent: angular.element(document.body),
            targetEvent: $event,
            scope: $scope,
            clickOutsideToClose:true,
            preserveScope:true

        });

    };

    $scope.createCategory = function(ev) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/addDiv.html',
            parent: angular.element(document.body),
            scope: $scope,
            targetEvent: ev,
            clickOutsideToClose: true,
            preserveScope: true
        });
    };

    $scope.editCategory = function(ev, label) {

        $scope.labelToEdit = label;
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/editDiv.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope:$scope,
            clickOutsideToClose:true,
            preserveScope:true
        });
    };

    $scope.removeCategory = function(ev, label) {
        $scope.labelToRemove = label;
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/removeDiv.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope:$scope,
            clickOutsideToClose:true,
            preserveScope:true
        });
    };

    $scope.deleteBulk = function(ev) {

        $scope.videoBulk = $scope.selected;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/videos/deleteBulk.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:false,
            preserveScope:true,

        });
    };


    $scope.editBulk = function(ev) {
        $scope.videoToEdit = {};
        $scope.videoBulk = $scope.selected;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/videoModal'),
            templateUrl: 'views/default/modals/dashboard/photos/editBulk.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:false,
            preserveScope:true,

        });
    };

    //$scope.leagues = Leagues;



    $scope.leagues.videos = "";

    //Filters
    $scope.dateCreated = '-date';
    $scope.FilterByLabel = 0;
    $scope.FilterByGame = 0;
    $scope.filterVideos = 0;

    $scope.labelFilter = function () {


        return leagueVideos;

    }

    $scope.trusted = function (url)
    {
        return $sce.trustAsResourceUrl(url);
    }


    $scope.getVideosByType = function (video){
        loading();


        videosRequest.offset = 0;
        videosRequest.limit = 10;
        videosRequest.orderBy = 'created_at';
        videosRequest.orderDirection = 'ASC';
        videosRequest.orderByVideosType = 'Qnap',
        videosRequest.getVideosType = video;

        $leagueVideosAPI.get(videosRequest, function (response) {
            $scope.videosIndex = 1;
            $scope.synchronize(response.data);
        });
    }
    /**
     * Get videos by offset
     * @param videosRequest
     * @param offset
     */

    var getVideosByOffset = function(videosRequest, offset) {
        loading();
        videosRequest.offset = offset;
        $leagueVideosAPI.get(videosRequest, function (response) {
             $scope.synchronize(response.data);
        });
    };

    $scope.videosOffset = 0;
    $scope.videosIndex = 1;

    /**
     * Navigate to the next page
     */
    var navNext  = function() {
        $scope.videosIndex++;
        $scope.videosOffset += 10;

        getVideosByOffset(videosRequest, $scope.videosOffset);
    };

    /**
     * Navigate to the last page
     */
    var navLast = function() {
        $scope.videosIndex = $scope.pages;
        $scope.videosOffset = ($scope.pages * 10) - 10;

        getVideosByOffset(videosRequest, $scope.videosOffset);
    };

    /**
     * Navigate to the previous page
     */
    var navPrev = function() {
        $scope.videosIndex--;
        $scope.videosOffset -= 10;

        getVideosByOffset(videosRequest, $scope.videosOffset);
    };

    /**
     * Navigate to the first page
     */
    var navFirst = function() {
        $scope.videosIndex = 1;
        $scope.videosOffset = 0;

        getVideosByOffset(videosRequest, $scope.videosOffset);
    };


    $scope.navNext = navNext;
    $scope.navLast = navLast;
    $scope.navPrev = navPrev;
    $scope.navFirst = navFirst;


    $scope.items = [];
    $scope.selected = [];

    $scope.exists = function (item, list) {

        return list.indexOf(item) > -1;
    };

    $scope.toggle = function (item, list) {
        var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        }
        else {
            list.push(item);
        }


    };

}]);

