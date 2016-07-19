__Wooter.controller('Admin/AdminContactController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin Contact | Wooter');
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
        var $contacts = API.exec('contactSubmission');
        $scope.contacts = $contacts;

        /**
         * Get List using API Request
         */
        $contacts.get(function (data) {
            $scope.contacts = getAllcontacts(data);

        });

        function getAllcontacts($contacts) {
        	var contacts = [];
            angular.forEach($contacts.data, function (val) {
                var $contacts = {
                    id: val.id,
                    name: val.name,
                    email: val.email,
                    phone: val.phone,
                    comments: val.comments,
                    date: val.date,
                };

                contacts.push($contacts);
            });

            return contacts;
        }
    }
	}]);
    