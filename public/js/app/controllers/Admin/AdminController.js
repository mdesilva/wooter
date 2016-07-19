__Wooter.controller('Admin/AdminController', ['API','$scope','$mdDialog', 'Page' , 'Notify' , '$stateParams' , '$window' , function (API,$scope, $mdDialog, Page , Notify , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin | Wooter');
	Page.stylesheets([
          '/css/dashboard/management.css',
        '/css/dashboard/animate.css',
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
    // var $organization = API.exec('organizations');
    // $scope.organizations = $organization;
    
    // var $loginUser = API.exec('loginUser');
    // $scope.loginUser = $loginUser;
    /**
     * Get List using API Request
     */
    // $organization.get(function (data) {
    //     $scope.organizations = getAllOrganizations(data);
    // });

    // function getAllOrganizations($organizations) {
    // 	var organizations = [];
    //     angular.forEach($organizations.data, function (val) {
    //         var $organization = {
    //             id: val.id,
    //             name: val.name,
    //             phone: val.phone,
    //             created_at: val.created_at,
    //             user_id: val.user_id,
    //             email: val.email,
    //             url : val.url,
    //             code: val.code
    //         };

    //         organizations.push($organization);
    //     });

    //     return organizations;
    // }


    // $scope.editOrganization = function ($event, organization) {
    //     $scope.organization = organization;

    //     $mdDialog.show({
    //         controller: organizationEditorController,
    //         templateUrl: 'views/default/modals/admin/edit-organization.html',
    //         parent: angular.element(document.body),
    //         scope: $scope,
    //         preserveScope: true,
    //         targetEvent: $event,
    //         clickOutsideToClose: true
    //     });
    // };

    // var organizationEditorController = function($scope, $mdDialog) {
    //     $scope.show_main = true;

    //     $scope.editOrganizationInModal = function($event, organization) {
    //         $name = $($event.target.form[0]).val();
    //         $email = $($event.target.form[1]).val();
    //         $phone = $($event.target.form[2]).val();
            
    //         $organization.put({id: organization.id , url:organization.url , name:$name , email:$email , phone:$phone}, function(response) {
    //             updateMessage('Organization ' + organization.name  + ' is edited successfully', 'success');
    //         });

    //         $mdDialog.hide();
    //     };
    // };

    // $scope.hiddenOrganizationUrl = function($event, organization) {
    //     loading();
    //     $organization.put({id: organization.id , url:'0' , name:organization.name , email:organization.email , phone:organization.phone}, function(response) {
    //         updateMessage('Organization ' + organization.name  + ' is hidden successfully', 'success');
    //     });

    //     $mdDialog.hide();
    // };

    // $scope.publicOrganizationUrl = function($event, organization) {
    //     loading();
    //     $organization.put({id: organization.id , url:'1' , name:organization.name , email:organization.email , phone:organization.phone}, function(response) {
    //         updateMessage('Organization ' + organization.name  + ' is public successfully', 'success');
    //     });

    //     $mdDialog.hide();
    // };

    // $scope.removeOrganization = function ($event, organization) {
    //     $scope.organizationToDelete = organization;

    //     $mdDialog.show({
    //         controller: getControllerName('Admin/AdminController'),
    //         templateUrl: 'views/default/modals/admin/remove-organization.html',
    //         parent: angular.element(document.body),
    //         scope: $scope,
    //         preserveScope: true,
    //         targetEvent: $event,
    //         clickOutsideToClose: true
    //     });
    // };

    // $scope.removeOrganizationInModal = function(organization) {
    //     loading();

    //     $organization.delete({id: organization.id}, function(response) {
    //         updateMessage('Organization ' + organization.name  + ' was successfully deleted', 'success');
    //     });

    //     $mdDialog.hide();
    // };

    // var updateMessage = function(notifyMessage, notifyStatus) {

    //     $organization.get(null, function (response) {
    //         $scope.organizations = response.data;
    //         loaded();
    //         Notify(notifyMessage, notifyStatus);
    //     });
    // };

    // $scope.loginOrganization = function ($event, organization) {
    //     $loginUser.get({userId: organization.user_id}, function(response) {
    //     });
    //     $window.location.href = '/';
    // };

    // $scope.hideModal = function() {
    //     $mdDialog.hide();
    // };

        var $leagues = API.exec('adminLeagues');
        $scope.leagues = $leagues;

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

            return leagues;
        }

    }

	}]);
    