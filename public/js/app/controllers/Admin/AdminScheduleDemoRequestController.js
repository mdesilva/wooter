__Wooter.controller('Admin/AdminScheduleDemoRequestController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Schedule Demo | Wooter');
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
        var $scheduledemo = API.exec('scheduleDemoRequest');
        $scope.scheduledemo = $scheduledemo;

        /**
         * Get List using API Request
         */
        $scheduledemo.get(function (data) {
            $scope.scheduledemo = getAllSchedules(data);

        });

        function getAllSchedules($scheduledemo) {
        	var scheduledemo = [];
            angular.forEach($scheduledemo.data, function (val) {
                var $scheduledemo = {
                    id: val.id,
                    name: val.name,
                    email: val.email,
                    phone: val.phone,
                    comments: val.comments,
                    date: val.created_at,
                };

                scheduledemo.push($scheduledemo);
            });

            return scheduledemo;
        }
    }
	}]);
    