__Wooter.controller('Admin/AdminDreamLeagueController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Dream Leagues | Wooter');
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
        var $dream_leagues = API.exec('adminLeagues');
        $scope.dream_leagues = $dream_leagues;

        /**
         * Get List using API Request
         */
        $dream_leagues.get(function (data) {
            $scope.dream_leagues = getAllDreamLeagues(data);

        });

        function getAllDreamLeagues($dream_leagues) {
        	var dream_leagues = [];
            angular.forEach($dream_leagues.data, function (val) {
                //If it is dream league
                if (val.dream_league == 1) {
                    var $dream_leagues = {
                        id: val.id,
                        name: val.name,
                        description: val.description,
                        sport: val.sport_name,
                        phone: val.phone,
                    };

                    dream_leagues.push($dream_leagues);
                }
            });

            return dream_leagues;
        }
    }
	}]);
    