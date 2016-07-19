__Wooter.controller('Admin/AdminVideoDemoRequestController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Video Demo | Wooter');
	Page.stylesheets([
        '/css/dashboard/players.css'
    ]);

    var $code = $stateParams.code;

    var $adminCode = API.exec('adminCode');
    $scope.adminCode = $adminCode;

    loading();
    $adminCode.get({code: $code}, function(response) {
        if (response.data != true) {
            $window.location.href = '/';
        }else{
            loaded();
            start();
        }
    });

	
    function start() {
        /**
         * Get and define API
         */
        var $videodemo = API.exec('serviceRequest');
        $scope.videodemo = $videodemo;

        /**
         * Get List using API Request
         */
        $videodemo.get(function (data) {
            $scope.videodemo = getAllVideos(data);

        });

        function getAllVideos($videodemo) {
        	var videodemo = [];
            angular.forEach($videodemo.data, function (val) {
                if (val.type == 1) {
                    var $videodemo = {
                        id: val.id,
                        email: val.email,
                        name: val.name,
                        phone: val.phone,
                        sport: val.sport,
                        address_1: val.address_1,
                        address_2: val.address_2,
                        teams: val.number_of_teams,
                        players: val.number_of_players,
                        games: val.number_of_games_per_team,
                    };

                    videodemo.push($videodemo);
                }
            });

            return videodemo;
        }
    }
	}]);
    