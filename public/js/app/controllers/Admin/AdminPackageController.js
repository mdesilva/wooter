__Wooter.controller('Admin/AdminPackageController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Packages | Wooter');
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
        var $packages = API.exec('packageRequest');
        $scope.packages = $packages;

        /**
         * Get List using API Request
         */
        $packages.get(function (data) {
            $scope.packages = getAllPackages(data);

        });

        function getAllPackages($packages) {
        	var packages = [];
            angular.forEach($packages.data, function (val) {
                var $packages = {
                    id: val.id,
                    email: val.email,
                    name: val.name,
                    phone: val.phone,
                    sport: val.sport,
                    package_name: val.package_name,
                    teams: val.number_of_teams,
                    players: val.number_of_players,
                    games: val.number_of_games_per_team,
                };

                packages.push($packages);
            });

            return packages;
        }
    }
	}]);
    