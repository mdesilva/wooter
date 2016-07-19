/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.23
 * Description:
 *
 */
__Wooter.controller('Modals/Dashboard/VideoModal', ['$scope', 'Page', '$stateParams', '$mdDialog', 'Notify', '$sce', 'API', function ($scope, Page, $stateParams, $mdDialog, Notify, $sce, API) {
	/*
	 * Clean page (title, assets, favicon badge, etc.)
	 */

	Page.reset();

    var $leagueVideoLabelsAPI = API.exec('leagueVideoLabels');
    var $leagueVideosAPI = API.exec('leagueVideos');

    var getVideosRequest = function() {
        var request = {};
        request.leagueId = $stateParams.league_id;
        request.offset = 0;
        request.limit = 10;
        request.order_by = 'created_at';
        request.order_direction = 'DESC';

        return request;
    };


    var videosRequest = getVideosRequest();

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

    var leagueId = $stateParams.league_id;
    /*
     * Put here Action and Scopes
     */
     
    Page.stylesheets([
        '/css/dashboard/media.css',
        '/css/dashboard/management.css',
        '/css/dashboard/animate.css',
        '/css/dashboard/resumable.css'
    ]);

    Page.scripts([

        '/js/dashboard/main_management.js',
        /*'js/scripts/dashboard/video/index.js',*/
        /*'js/scripts/dashboard/video/resumable-lib.js',*/
        'js/scripts/dashboard/video/resumable.js'
    ]);

   // $scope.labels = [];

    $scope.uploadVideo = [];


/** CRUD For videos **/
    $scope.cancel = function() {

        if( count($scope.movies) > 0 ||  $scope.delete ) {
            loading();
            $scope.uploadVideo.map(function ( video ) {

                $leagueVideosAPI.delete({
                    leagueId: $stateParams.league_id,
                    videoId: video.videoId
                }, function(resp){
                    videosRequest.offset = $scope.videosOffset;
                    $leagueVideosAPI.get(videosRequest, function (response) {

                        $scope.synchronize(response.data);
                        $mdDialog.hide();

                        Notify({
                            message: 'League video is removed!',
                            timeout: 3000,
                            type: 'success',
                            inverse: true,
                            icon: true
                        });
                        loaded();
                    });
                });
            });

        } else {
            $scope.closeModal();
        }
    };
    /**
     *  Delete photos in bulk
     */

    $scope.removeBulkVideos = function()
    {


        data = {};
        data.photos = $scope.videoBulk;
        if(count($scope.videoBulk) > 0 || $scope.delete )
        {

            $scope.videoBulk.map(function ( video ) {

                $leagueVideosAPI.delete({
                    leagueId: $stateParams.league_id,
                    videoId: video.id
                }, function(resp){
                    videosRequest.offset = $scope.videosOffset;
                    $leagueVideosAPI.get(videosRequest, function (response) {

                        $scope.synchronize(response.data);
                        $mdDialog.hide();

                        Notify({
                            message: 'League video is removed!',
                            timeout: 3000,
                            type: 'success',
                            inverse: true,
                            icon: true
                        });
                        loaded();
                    });
                });
            });

        }else{

            if( $scope.delete)
                $scope.delete = false;

            $scope.hide();
        }
    }
    $scope.closeModal = function() {
        if ($scope.delete)
        $scope.delete = false;

        
        $mdDialog.hide();
    };


    $scope.publishVideo = function() {

        if (count($scope.movies) > 0 || $scope.edit) {
            loading();
            data = {};
            data.league_id = leagueId;
            data.videos = $scope.uploadVideo;
            data.teams = $scope.selectedTeams;
            data.players = $scope.selectedPlayers;
            data.leaguePublishVideoFlag = true;

            $leagueVideosAPI.save({
                leagueId:leagueId
            }, data, function(resp) {
                videosRequest.offset = $scope.videosOffset;
                $leagueVideosAPI.get(videosRequest, function(response) {
                    $scope.synchronize(response.data);
                    $mdDialog.hide();

                    Notify({
                        message: 'League video uploaded successfully!',
                        timeout: 3000,
                        type: 'success',
                        inverse: true,
                        icon: true
                    });
                    loaded();
                });
            });

        } else {
            Notify({
                message: 'Please upload video!',
                timeout: 3000,
                type: 'error',
                inverse: true,
                icon: true
            });
        }
    };

    $scope.video ={};
    $scope.leagueId = leagueId;
    $scope.movies = {};
    $scope.loadVideos = function() {
        $leagueVideosAPI.get(videosRequest, function(response) {
            $scope.synchronize(response.data);
        });
    };



    /**
     *
     * Team Chip suggestions
     **/

    $scope.transformTeams = function (teams)
    {

        return teams.map(function ( team ) {

            team._lowername = team.name.toLowerCase();
            team._lowertype = team.id;
            return team;
        });

    };


    /**
     * Create filter function for a query string
     */
    function createFilterFor(query)
    {
        var lowercaseQuery = angular.lowercase(query);

        return function filterFn(team) {

            return (team._lowername.indexOf(lowercaseQuery) === 0) ||
                (team.id === query.id);
        };

    }

    function querySearch(query)
    {

        var results = query ? $scope.teams.filter(createFilterFor(query)) : [];
        return results;
    }




    function transformChip(chip)
    {
        // If it is an object, it's already a known chip
        if (angular.isObject(chip)) {
            return chip;
        }
    }



    $scope.teams = $scope.transformTeams($scope.teams);
    $scope.selectedItem = null;
    $scope.searchText = null;
    $scope.querySearch = querySearch;
    //$scope.objTeam = [];
    $scope.selectedTeams = [];
    $scope.autocompleteDemoRequireMatch = true;
    $scope.transformChip = transformChip;


    /**
     *
     * Player Chip suggestions
     ***/

    $scope.transformPlayers = function (teams)
    {

        players = [];

        teams.map(function ( team ) {

            team.players.map(function ( player ) {

                //
                player._lowerFirstName = player.first_name.toLowerCase();
                player._lowerLastName = player.last_name.toLowerCase();
                players.push(player);
            });


        });

        return players;

    };

    /**
     * Create filter function for a query string
     */
    function createFilterForPlayer(query)
    {
        var lowercaseQuery = angular.lowercase(query);

        return function filterFn(player) {

            return (player._lowerFirstName.indexOf(lowercaseQuery) === 0) ||
                (player._lowerLastName.indexOf(lowercaseQuery) === 0);
        };

    };

    function playerSearchQuery(query)
    {

        var results = query ? $scope.players.filter(createFilterForPlayer(query)) : [];
        return results;
    }

    function playerTransformChip(chip)
    {
        // If it is an object, it's already a known chip
        if (angular.isObject(chip)) {
            return chip;
        }
    }

    $scope.players = $scope.transformPlayers($scope.teams);
    $scope.selectedPlayer = null;
    $scope.searchPlayer = null;
    $scope.playerSearchQuery = playerSearchQuery;
    $scope.selectedPlayers = [];
    $scope.autocompletePlayerRequireMatch = true;
    $scope.playerTransformChip = playerTransformChip;

    if( count($scope.videoToEdit) > 0 || count($scope.videoToDelete) > 0 )
    {

        if( count($scope.videoToEdit) > 0)
        {

            var teams = $scope.videoToEdit.tagTeams;
            var players = $scope.videoToEdit.tagPlayers;

        }else{
            var teams = $scope.videoToDelete.tagTeams;
            var players = $scope.videoToDelete.tagPlayers;
        }

        angular.forEach(teams, function (teamId) {
            angular.forEach($scope.teams, function (team) {
                if(team.id == teamId  )
                {
                    $scope.selectedTeams.push(team);
                }
            });
        });

        angular.forEach(players, function (playerId) {
            angular.forEach($scope.players, function (player) {
                if(player.id == playerId  )
                {
                    $scope.selectedPlayers.push(player);
                }
            });
        });
    }else{
        $scope.selectedTeams = [];
        $scope.selectedPlayers = [];
    }

    /** CRUD For labels **/

    $scope.createLabels = function()
    {

        loading();
        data = $scope.data;

        $leagueVideoLabelsAPI.save({leagueId:leagueId}, data, function(resp){
             $scope.labels = resp.data;
            $mdDialog.hide();

            Notify({
                message: "Label has been created!",
                timeout: 3000,
                type: 'success',
                inverse: true,
                icon: true
            });
            loaded();
         });


    }


    $scope.editLabels = function()
    {
        loading();
        data = $scope.data;
        $leagueVideoLabelsAPI.put({
            leagueId:leagueId,
            videoLabelId: data.id}, data, function(resp){

            $scope.labels = resp.data;
            $mdDialog.hide();

            Notify({
                message: 'Label has been updated successfully!',
                timeout: 3000,
                type: 'success',
                inverse: true,
                icon: true
            });
            loaded();
        });



    }


    $scope.removeLabel = function() {
        loading();
        data = $scope.data;
        // debugger;
        $leagueVideoLabelsAPI.delete({
            leagueId:leagueId,
            // videoLabelId: data.id
            videoLabelId: $scope.labelToRemove.id
        }, data, function(resp){
            $scope.labels = resp.data;
            $mdDialog.hide();

            Notify({
                message: 'Label has been deleted successfully!',
                timeout: 3000,
                type: 'success',
                inverse: true,
                icon: true
            });
            loaded();
        });
    };

    $scope.trusted = function (url)
    {
        return $sce.trustAsResourceUrl(url);
    }

    $scope.notifyVideoUploadError = function()
    {
        Notify({
            message: 'Video size is too big!',
            timeout: 3000,
            type: 'error',
            inverse: true,
            icon: true
        });
    }

}]);
