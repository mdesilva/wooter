
__Wooter.controller('Dashboard/UserAccountController', ['$scope','$mdDialog', 'Page', 'Authentify','API','Notify','$http', function ($scope, $mdDialog, Page, Authentify,API,Notify,$http) {
    
    /*
     * - Clean page (title, assets, favicon badge, etc.)
     * - Set Title Page
     */
    Page.reset();
    Page.title(' Setting | Wooter');

    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/account.css'
    ]);

    Page.stylesheets([
        'css/auth.css',
        'css/vendors/owl/index.css'
    ]);
    Page.scripts([
        'js/scripts/auth/setup/index.js'
    ]);

    var users = API.exec('users');
    var userPhotos = API.exec('userPhotos');
    var user = Authentify.GET.user();
    
    users.show({
        userId: user.id,
    }, function (res) {
        $scope.organization = res.data;
    });

    $scope.uploadActionClick = function(){
        var toggle = document.querySelector('.company_details .drop-area');
        toggle.click();
        return false;
    };
    
    $scope.updateOrganization = function () {
        // var uploadUrl = 'api/users/'+user.id;
        // var file = document.getElementById('photo').files[0];
        // var fd = new FormData();
        // fd.append('file', file);
        // fd.append('userId', user.id);
        // fd.append('fromCreate', true);
        // fd.append('status', 1);
        // fd.append('first_name', $scope.organization.first_name);
        // fd.append('last_name', $scope.organization.last_name);
        // fd.append('email', $scope.organization.email);
        // fd.append('phone', $scope.organization.phone);
        loading();
        users.put({
            userId: user.id,
            status: 1,
            first_name: $scope.organization.first_name,
            last_name: $scope.organization.last_name,
            email: $scope.organization.email,
            phone: $scope.organization.phone,
        }, function (res) {
            Notify('Organization updated successfully', 'success');
            $scope.organization = res.data;
            loaded();
        },function (res) {
            Notify('Oops! Someting went wrong. Please try again', 'warning');
            loaded();
        });
        
        // $http.put(uploadUrl, fd, {
        //     transformRequest: angular.identity,
        //     headers: {
        //         "X-Requested-With": "XMLHttpRequest",
        //         "Authorization": "Bearer "+Authentify.token()
        //     }
        // })
        // .success(function(){
        // })
        // .error(function(){
        // });
    };  

    $scope.fileUpload = function () {
        loading();
        var uploadUrl = "/api/user/"+user.id+"/photos";
        var file = document.getElementById('photo').files[0];

        if (angular.isUndefined(file)) {
            Notify('No file selected', 'warning');
            loaded();
            return false;
        }

        var fd = new FormData();
        fd.append('photo', file);
        fd.append('fromCreate', true);
        fd.append('user_id', user.id);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined,
                "X-Requested-With": "XMLHttpRequest",
                "Authorization": "Bearer "+Authentify.token()
            }
        })
        .success(function(){
            Notify('Photo uploaded successfully', 'success');
            users.show({
                userId: user.id,
            }, function (res) {
                $scope.organization = res.data;
                loaded();
            });
        })
        .error(function(){
            Notify('Oops! Someting went wrong. Please try again', 'warning');
            loaded();
        });
    };   
    
}]);