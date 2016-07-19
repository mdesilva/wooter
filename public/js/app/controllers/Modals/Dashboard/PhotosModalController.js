/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.23
 * Description:
 *
 */
__Wooter.controller('Modals/Dashboard/Photos', ['$scope', 'Page', '$stateParams', '$mdDialog', 'Notify', 'API', function ($scope, Page, $stateParams, $mdDialog, Notify, API) {

    Page.reset();

    Page.title('Wooter | Inspect Photos');
    $scope.leagueId = $stateParams.league_id;

    Page.stylesheets([
        '/css/dashboard/media.css',
        '/css/dashboard/management.css',
        '/css/dashboard/animate.css'
    ]);

    Page.scripts([
        '/js/scripts/dashboard/photo/index.js'
    ]);

    var $leaguePhotosAPI = API.exec('leaguePhotos');
    var $leaguePhotoAlbumsAPI = API.exec('leaguePhotoAlbums');


    var getPhotosRequest = function() {
        var request = {};
        request.leagueId = $stateParams.league_id;
        request.offset = 0;
        request.limit = 10;
        request.orderBy = 'created_at';
        request.orderDirection = 'ASC';
        return request;
    };

    var photosRequest = getPhotosRequest();

    $scope.synchronize = function(data) {

        $scope.leaguePhotos = data.photos;
        $scope.pages = data.pages;

        $scope.items = [];
        $scope.selected = [];
        $scope.leaguePhotos.forEach(function(video) {
            $scope.items.push(video.id);
        });

        loaded();
    };

    $scope.labels = [];

    $scope.hide = function() {
        if( $scope.delete)
            $scope.delete = false;

        $mdDialog.hide();

    };

    $scope.photos = {};
    $scope.postPhotos = {};

    $scope.loadPhotos = function()
    {

        loading();
        $leaguePhotosAPI.get(photosRequest, function (response) {
            $scope.synchronize(response.data);

        });
    };



    $scope.editPhoto = function() {
        $leaguePhotosAPI.put({
            leagueId: $stateParams.league_id,
            photoId: $scope.photoToEdit.image_id,
            photo: $scope.photoToEdit,
            teams: $scope.selectedTeams,
            players: $scope.selectedPlayers,
            leaguePublishPhotoFlag: true
        },
        function (response) {

            photosRequest.offset = $scope.photosOffset;

            $leaguePhotosAPI.get(photosRequest, function (response) {

                $scope.synchronize(response.data);
                Notify({
                    message: 'League Photos uploaded successfully!',
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });
            });
        });

        $mdDialog.hide();

    };

    $scope.photosToUpload = [];
    $scope.publishPhoto = function()
    {
        if(count($scope.photos) > 0 || $scope.edit) {

            loading();
            var data = {};
            data.photos = $scope.photosToUpload;
            data.teams = $scope.selectedTeams;
            data.players = $scope.selectedPlayers;
            data.leaguePublishPhotoFlag = true;

            $leaguePhotosAPI.save({leagueId: $stateParams.league_id}, data, function (resp) {

                photosRequest.offset = $scope.photosOffset;
                $leaguePhotosAPI.get(photosRequest, function (response) {
                    $scope.synchronize(response.data);
                    $mdDialog.hide();

                    Notify({
                        message: 'League Photos uploaded successfully!',
                        timeout: 3000,
                        type: 'success',
                        inverse: true,
                        icon: true
                    });
                });
            });

        }else{

            Notify({
                message: 'Please upload a photo!',
                timeout: 3000,
                type: 'success',
                inverse: true,
                icon: true
            });

        }
    };


    $scope.editBulkPhoto = function()
    {
        if(count($scope.photosBulk) > 0 || $scope.edit) {

            loading();
            var data = {};
            data.photos = $scope.photosToUpload;
            data.teams = $scope.selectedTeams;
            data.players = $scope.selectedPlayers;
            data.leaguePublishPhotoFlag = true;

            $leaguePhotosAPI.save({leagueId: $stateParams.league_id}, data, function (resp) {

                photosRequest.offset = $scope.photosOffset;
                $leaguePhotosAPI.get(photosRequest, function (response) {
                    $scope.synchronize(response.data);
                    $mdDialog.hide();

                    Notify({
                        message: 'League Photos uploaded successfully!',
                        timeout: 3000,
                        type: 'success',
                        inverse: true,
                        icon: true
                    });
                });
            });

        }else{

            Notify({
                message: 'Please upload a photo!',
                timeout: 3000,
                type: 'success',
                inverse: true,
                icon: true
            });

        }
    };
    $scope.uploadVideo = [];

    /**
     *  Delete photos upon clicking on cancel button on upload photo section
     */
    $scope.remove = function()
    {

        data = {};
        data.photos = $scope.photosToUpload;
        if(count($scope.photosToUpload) > 0 || $scope.delete )
        {
            $scope.photosToUpload.map(function ( photo ) {

                $leaguePhotosAPI.delete({
                    leagueId: $stateParams.league_id,
                    photoId: photo.image_id
                }, function(resp){
                    photosRequest.offset = $scope.photosOffset;
                    $leaguePhotosAPI.get(photosRequest, function (response) {
                        $scope.synchronize(response.data);
                        $mdDialog.hide();
                        Notify({
                            message: 'Photo removed',
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
    };
    /**
     *  Delete photos in bulk
     */

    $scope.removeBulkPhotos = function()
    {



        data = {};
        data.photos = $scope.photosBulk;
        if(count($scope.photosBulk) > 0 || $scope.delete )
        {
            $scope.photosBulk.map(function ( photo ) {

                $leaguePhotosAPI.delete({
                    leagueId: $stateParams.league_id,
                    photoId: photo.image_id
                }, function(resp){
                    photosRequest.offset = $scope.photosOffset;
                    $leaguePhotosAPI.get(photosRequest, function (response) {
                        $scope.synchronize(response.data);
                        $mdDialog.hide();
                        Notify({
                            message: 'Photo removed',
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

    if( count($scope.photoToEdit) > 0) {



            var teams = $scope.photoToEdit.tagTeams;
            var players = $scope.photoToEdit.tagPlayers;


            angular.forEach(teams, function (teamId) {
                angular.forEach($scope.teams, function (team) {
                    if (team.id == teamId) {
                        $scope.selectedTeams.push(team);
                    }
                });
            });

            angular.forEach(players, function (playerId) {
                angular.forEach($scope.players, function (player) {
                    if (player.id == playerId) {
                        $scope.selectedPlayers.push(player);
                    }
                });
            });





    }else{
        $scope.selectedTeams = [];
        $scope.selectedPlayers = [];
    }


    $scope.cancel = function()
    {
        $mdDialog.hide();
    }

    /***Albums CRUD ***/


    $scope.createPhotoAlbums = function()
    {
        loading();
        data = $scope.data;

        $leaguePhotoAlbumsAPI.save({leagueId:$stateParams.league_id}, data, function(response){

            $leaguePhotoAlbumsAPI.get({leagueId:$stateParams.league_id}, function(response){
                $scope.albums = response.data;


                Notify({
                    message: 'League photo album created successfully!',
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });
                loaded();

            });
        });
        $mdDialog.hide();
    };

    $scope.editPhotoAlbum = function()
    {
        loading();
        var data = $scope.data;

        $leaguePhotoAlbumsAPI.put({
            leagueId:$stateParams.league_id,
            photoAlbumId: data.id}, data, function(resp){

            $leaguePhotoAlbumsAPI.get({leagueId:$stateParams.league_id}, function(response){
                $scope.albums = response.data;


                Notify({
                    message: 'League photo album updated successfully!',
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });
                loaded();
            });
        });
        $mdDialog.hide();
    };


    $scope.removePhotoAlbum = function()
    {

        loading();
        var data = $scope.data;


        $leaguePhotoAlbumsAPI.delete({
            leagueId:$stateParams.league_id,
            photoAlbumId: data.id}, data, function(resp){

            $leaguePhotoAlbumsAPI.get({leagueId:$stateParams.league_id}, function(response){
                $scope.albums = response.data;
                $mdDialog.hide();

                Notify({
                    message: 'Album deleted successfully',
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });
                loaded();

            });


        });
    };

    $scope.notifyPhotoUploadError = function()
    {
        Notify({
            message: 'Image size is too big! Please upload optimize image',
            timeout: 3000,
            type: 'error',
            inverse: true,
            icon: true
        });
    };

    $scope.photoUploadAction = 'api/leagues/'+$scope.leagueId+'/photos'
}]);