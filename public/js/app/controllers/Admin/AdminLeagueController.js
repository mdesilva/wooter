__Wooter.controller('Admin/AdminLeagueController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Leagues | Wooter');
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
        var $leagues = API.exec('adminLeagues');
        $scope.leagues = $leagues;

        /**
         * Get List using API Request
         */
        $leagues.get(function (data) {
            $scope.leagues = getAllLeagues(data);

        });

        function getAllLeagues($leagues) {
        	var leagues = [];
            angular.forEach($leagues.data, function (val) {
                //If it is not dream league
                if (val.dream_league == 0) {
                    var $leagues = {
                        id: val.id,
                        name: val.name,
                        description: val.description,
                        sport: val.sport_name,
                        phone: val.phone,
                    };

                    leagues.push($leagues);
                }
            });
            console.log(leagues);
            return leagues;
        }
    }
	}]);
    