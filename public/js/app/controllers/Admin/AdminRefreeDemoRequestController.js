__Wooter.controller('Admin/AdminRefreeDemoRequestController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Referee Demo | Wooter');
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
        var $refreedemo = API.exec('serviceRequest');
        $scope.refreedemo = $refreedemo;

        /**
         * Get List using API Request
         */
        $refreedemo.get(function (data) {
            $scope.refreedemo = getAllRefree(data);

        });

        function getAllRefree($refreedemo) {
        	var refreedemo = [];
            angular.forEach($refreedemo.data, function (val) {
                if (val.type == 3) {
                    var $refreedemo = {
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

                    refreedemo.push($refreedemo);
                }
            });

            return refreedemo;
        }
    }
	}]);
    