__Wooter.controller('Admin/AdminStatsDemoRequestController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Stats Demo | Wooter');
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
        var $statsdemo = API.exec('serviceRequest');
        $scope.statsdemo = $statsdemo;

        /**
         * Get List using API Request
         */
        $statsdemo.get(function (data) {
            $scope.statsdemo = getAllStats(data);

        });

        function getAllStats($statsdemo) {
        	var statsdemo = [];
            angular.forEach($statsdemo.data, function (val) {
                if (val.type == 2) {
                    var $statsdemo = {
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

                    statsdemo.push($statsdemo);
                }
            });

            return statsdemo;
        }
    }
	}]);
    