/*
 * Created by Carlos Marra
 * User: loslambda / los_lambdas
 * For: Dashboard/videos
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description:
 *
 */
__Wooter.controller('Dashboard/PhotosController', ['$scope', '$mdDialog', 'Page', '$stateParams', 'API', function ($scope, $mdDialog, Page, $stateParams, API) {
    loading();
    /*
     * - Clean page (title, assets, favicon badge, etc.)
     * - Set Title Page
     */
    Page.reset();
    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/media.css',
        '/css/dashboard/management.css',
        '/css/dashboard/animate.css'
    ]);

    Page.scripts([
        '/js/dashboard/main_management.js'
    ]);

    $scope.league_id = $stateParams.league_id;

    var $leaguesAPI = API.exec('leagues');
    var $leagueGamesAPI = API.exec('leagueGames');
    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $leaguePhotoAlbumsAPI = API.exec('leaguePhotoAlbums');
    var $leagueSeasonsAPI = API.exec('leagueSeasons');
    var $leaguePhotosAPI = API.exec('leaguePhotos');

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

    $leagueSeasonsAPI.get({leagueId: $stateParams.league_id}, function (response) {

        $scope.season = response.data[0];
    });

    $leaguesAPI.show({
        leagueId: $stateParams.league_id
    }, function(response) {

        var league = response.data;

        $scope.leagueName = league.name;
        Page.title($scope.leagueName + ' - Photos | Wooter');
        $scope.leagues = league;
        $scope.league = league;
    });



    $leaguePhotosAPI.get(photosRequest, function (response) {
        $scope.synchronize(response.data);

    });

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

     $leagueGamesAPI.get({
        leagueId: $stateParams.league_id,
        orderBy:'time',
        orderDirection:'Asc'

    }, function(resp) {
        $scope.games = [];
        $scope.games = resp.data.games;


    });

    $leaguePhotoAlbumsAPI.get({
        leagueId: $stateParams.league_id
      }, function(response) {
        $scope.albums = response.data;
    });
    $leagueTeamsAPI.show({
        leagueId: $stateParams.league_id
    }, function(resp) {
        $scope.teams = resp.data.teams;
    });

    $scope.editPhotos = function(ev, photo) {
        $scope.photoToEdit = photo;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/edit-photo.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:false,
            preserveScope:true,
            scope: $scope
        });
    };

    $scope.removePhotos = function(ev, photo) {
        $scope.photoToDelete = photo;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/remove.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:false,
            preserveScope:true,
            scope: $scope
        });
    };

    $scope.viewPhotos = function(ev, photo) {

        $scope.photoToView = photo;
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/view.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true,
            preserveScope:true,
            scope: $scope
        });
    };

    $scope.createPhotos = function(ev) {

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/create.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:false,
            preserveScope:true,
            scope: $scope
        });
    };


    $scope.createAlbum = function(ev) {

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/addDiv.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:false,
            preserveScope:true,
            scope: $scope
        });
    };

    $scope.editAlbum = function(ev, album) {

        $scope.albumToEdit = album;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/editDiv.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:true,
            preserveScope:true

        });

    };

    $scope.removeAlbum = function(ev, album) {

        $scope.albumToRemove = album;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/removeDiv.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:false,
            preserveScope:true,

        });
    };


    $scope.deleteBulk = function(ev) {

        $scope.photosBulk = $scope.selected;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/deleteBulk.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:false,
            preserveScope:true,

        });
    };


    $scope.editBulk = function(ev) {
            $scope.photoToEdit = {};
        $scope.photosBulk = $scope.selected;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Photos'),
            templateUrl: 'views/default/modals/dashboard/photos/editBulk.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            scope: $scope,
            clickOutsideToClose:false,
            preserveScope:true,

        });
    };


    $scope.dateCreated = '-date';
    $scope.FilterByAlbum = 0;
    $scope.FilterByGame = 0;
    $scope.FilterByDivision = 0;
    $scope.FilterByTeam = 0;

    /**
     * Get photos by offset
     * @param photosRequest
     * @param offset
     */

    var getPhotosByOffset = function(photosRequest, offset) {
        loading();
        photosRequest.offset = offset;
        $leaguePhotosAPI.get(photosRequest, function (response) {
            $scope.synchronize(response.data);
        });
    };


    $scope.photosOffset = 0;
    $scope.photosIndex = 1;

    /**
     * Navigate to the next page
     */
    var navNext  = function() {
        $scope.photosIndex++;
        $scope.photosOffset += 10;

        getPhotosByOffset(photosRequest, $scope.photosOffset);
    };

    /**
     * Navigate to the last page
     */
    var navLast = function() {
        $scope.photosIndex = $scope.pages;
        $scope.photosOffset = ($scope.pages * 10) - 10;

        getPhotosByOffset(photosRequest, $scope.photosOffset);
    };


    /**
     * Navigate to the previous page
     */
    var navPrev = function() {
        $scope.photosIndex--;
        $scope.photosOffset -= 10;

        getPhotosByOffset(photosRequest, $scope.photosOffset);
    };


    /**
     * Navigate to the first page
     */
    var navFirst = function() {
        $scope.photosIndex = 1;
        $scope.photosOffset = 0;

        getPhotosByOffset(photosRequest, $scope.photosOffset);
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

