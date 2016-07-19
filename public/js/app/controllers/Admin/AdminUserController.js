__Wooter.controller('Admin/AdminUserController', ['API','$scope','$mdDialog','Page','Notify','$window','$state','$stateParams','Authentify', function (API,$scope, $mdDialog, Page , Notify , $window, $state , $stateParams,Authentify) {
   
   	Page.reset();
	Page.title('Admin User | Wooter');
	Page.stylesheets([
        '/css/dashboard/players.css'
    ]);

    console.log(Authentify.GET.user());
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
        var $users = API.exec('users');
        $scope.users = $users;

        var $loginUser = API.exec('loginUser');
        $scope.loginUser = $loginUser;

        /**
         * Get List using API Request
         */
        $users.get(function (data) {
            $scope.users = getAllUsers(data);

        });

        function getAllUsers($users) {
        	var users = [];
            angular.forEach($users.data, function (val) {
                var $users = {
                    id: val.id,
                    name: val.first_name+" "+val.last_name,
                    email: val.email,
                    phone: val.phone,
                    created_at: val.created_at,
                    last_login: val.updated_at.date,
                    status: val.active
                };

                users.push($users);
            });

            return users;
        }

        $scope.deactivateUser = function ($event, user) {

            $scope.userToDeactivate = user;

            $mdDialog.show({
                controller: getControllerName('Admin/AdminUserController'),
                templateUrl: 'views/default/modals/admin/deactivate-user.html',
                parent: angular.element(document.body),
                scope: $scope,
                preserveScope: true,
                targetEvent: $event,
                clickOutsideToClose: true
            });
        };

        $scope.deactivateUserInModal = function(user) {
            loading();
            $users.put({userId: user.id , status:'0'}, function(response) {
                updateMessage('User ' + user.name + ' was successfully deactivated', 'success');
            });

            $mdDialog.hide();
        };

        var updateMessage = function(notifyMessage, notifyStatus) {

            $users.get(null, function (response) {
                $scope.users = response.data;
                loaded();
                Notify(notifyMessage, notifyStatus);
                $state.go($state.current, {}, {reload: true});
            });
        };

        $scope.activateUser = function ($event, user) {

            $scope.userToDeactivate = user;

            $mdDialog.show({
                controller: getControllerName('Admin/AdminUserController'),
                templateUrl: 'views/default/modals/admin/activate-user.html',
                parent: angular.element(document.body),
                scope: $scope,
                preserveScope: true,
                targetEvent: $event,
                clickOutsideToClose: true
            });
        };

        $scope.activateUserInModal = function(user) {
            loading();
            $users.put({userId: user.id , status:'1'}, function(response) {
                updateMessage('User ' + user.name + ' was successfully activated', 'success');
            });

            $mdDialog.hide();
        };

        $scope.loginUser = function ($event, user) {
            $users.show({userId: user.id}, function (response) {
                Authentify.Destroy.user();
                Authentify.SET.user(user);
                Authentify.SET.session(user);
            });
            $loginUser.get({userId: user.id}, function(response) {
                Authentify.SET.token(response.token);
                
                updateMessage('User logged in successfully', 'success');
                $window.location.href = '/';
            });
        };
    }

	}]);
    