/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Auth/Verify
 * License: Wooter LLC.
 * Date: 2016.01.16
 * Description: Verify controller for Auth
 *
 */
__Wooter.controller('Auth/VerifyController', ['$scope', 'Page', '$stateParams', '$http', 'Authentify', function ($scope, Page, $stateParams, $http, Authentify) {

    Page.reset();
    Page.title('Verify Account | Wooter');
    Page.stylesheets('css/auth.css');

    if(!Authentify.check){

        function hideForm(){
            var form = document.querySelector('.'+$scope.verifyForm.name+' .inner');
            var loader = document.querySelector('.'+$scope.verifyForm.name+' .loader');

            if(form){
                form.style.transition = 'all 500ms';
                form.style.overflow = 'hidden';
                form.style.height = "0";
                form.style.padding = "0";
            }
            loader.classList.remove('hide');
        }

        $scope.Params = $stateParams;

        $scope.rld = function(){
            window.location = '/#/verify-token';
        };

        $scope.verifyForm = {
            name: 'verifyForm',
            model: {
                "token": $stateParams.token
            },
            options: {},

            fields: [
                {
                    "className": "no-errors material-input-full",
                    "type": "input",
                    "key": "token",
                    "templateOptions": {
                        "type": "text",
                        "label": "Token:",
                        "required": true
                    }
                }
            ],
            submitHandler: function(){
                window.location.href = '/#/verify-token/'+$scope.verifyForm.model.token;
            },

            submitExec: function(){
                hideForm();
                $http({
                    method  : 'GET',
                    url     : '/verify-user/'+$scope.verifyForm.model.token
                })
                    .then($scope.verifyForm.event.success, $scope.verifyForm.event.error);
                return false;
            },

            event: {
                success: function(response){
                    var res = response.data;

                    $scope.showHeader = false;

                    if(res.success){

                        var loader = document.querySelector('.'+$scope.verifyForm.name+' .loader');
                        loader.classList.add('hide');

                        $scope.verify = {
                            messageState: true,
                            theme: "success",
                            message: "Awesome, all are good now! we will redirect to next page!"
                        };

                        window.location.href = '/#/login';
                    }

                },
        error: function(response){
            var res = response.data;

                    $scope.showHeader = false;

                    var loader = document.querySelector('.'+$scope.verifyForm.name+' .loader');
                    loader.classList.add('hide');

                    $scope.verify = {
                        messageState: true,
                        theme: "error",
                        message: res.error
                    };
                }
            }
        };

        $scope.showHeader = ($stateParams.token && $stateParams.token != "")?false:true;

        if($stateParams.token && $stateParams.token != ""){
            setTimeout(function(){
                $scope.verifyForm.submitExec();
            }, 400);
        }
    }

}]);
