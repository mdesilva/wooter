/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Login Page
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description:
 *
 */
__Wooter.controller('Auth/LoginController', ['$scope', 'Page', '$filter', 'Notify', 'Util', 'MQ', '$auth', '$rootScope', 'STORE', 'Authentify', '$location', '$state', function ($scope, Page, $filter, Notify, Util, MQ, $auth, $rootScope, STORE, Authentify, $location, $state) {

    Page.reset();
    Page.title('Login | Wooter');
    Page.stylesheets('css/auth.css');
    Page.stylesheets('css/landing/header/input.css');
    
    /*
     * Formly Form
     */
    $scope.loginForm = {
        name: 'loginForm',

        /*
         * Form Model
         */
        model: {},

        /*
         * Formly Form Options
         */
        options: {},

        /*
         * Formly Form Fields
         */
        fields: [
            {
                "className": "no-errors material-input-full",
                "type": "input",
                "key": "email",
                "templateOptions": {
                    "type": "email",
                    "label": "Email:",
                    "required": true
                }
            },
            {
                "className": "no-errors material-input-full",
                "type": "input",
                "key": "password",
                "templateOptions": {
                    "type": "password",
                    "label": "Password:",
                    "required": true
                }
            }
        ],

        /*
         * Formly Form Submit Event
         */
        submitHandler: function(){
            /*
             * Auth Request
             * @use Satellizer
             */
            Authentify.login({
                email: $scope.loginForm.model.email,
                password: $scope.loginForm.model.password
            }, '.loginForm button[type="submit"]');
        }
    };

}]);
