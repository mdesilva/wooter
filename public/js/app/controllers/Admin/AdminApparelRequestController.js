__Wooter.controller('Admin/AdminApparelRequestController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Apparel Request | Wooter');
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
        var $apparels = API.exec('apparelRequest');
        $scope.apparels = $apparels;

        /**
         * Get List using API Request
         */
        $apparels.get(function (data) {
            $scope.apparels = getAllapparels(data);

        });

        function getAllapparels($apparels) {
        	var apparels = [];
            angular.forEach($apparels.data, function (val) {
                var $apparels = {
                    id: val.id,
                    name: val.name,
                    email: val.email,
                    message: val.message,
                    date: val.created_at,
                };

                apparels.push($apparels);
            });

            return apparels;
        }
    }
	}]);
    