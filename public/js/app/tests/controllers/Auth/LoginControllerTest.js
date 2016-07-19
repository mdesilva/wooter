describe('LoginController', function () {
    beforeEach(module('Wooter'));

    var LoginController,
        scope;

    beforeEach(
        inject(function($controller, $rootScope){
            scope = $rootScope.$new();
            LoginController = $controller("Auth/LoginController", {
                $scope: scope
            });
        })
    );

    it ('creates controller', function() {
        expect(scope.loginForm.name).toEqual('loginForm');
    })

    it ('logs in', function() {
        scope.loginForm.model.email = 'carlos@wooter.co';
        scope.loginForm.model.password = 'carlos123';
        scope.loginForm.submitHandler();


    })

});