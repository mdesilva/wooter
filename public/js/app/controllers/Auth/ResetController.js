/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Login Page
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description:
 *
 */
__Wooter.controller('Auth/ResetController', ['$scope', 'Page', 'Notify', 'API', '$stateParams', function ($scope, Page, Notify, API, $stateParams) {

    var $recoverPasswordApi = API.exec('recoverPassword');

    Page.reset();
    Page.title('Reset Password | Wooter');
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
                    "label": "Email",
                    "required": true
                }
            },
            {
                "className": "no-errors material-input-full",
                "type": "input",
                "key": "password",
                "templateOptions": {
                    "type": "password",
                    "label": "New Password",
                    "required": true
                }
            },
            {
                "className": "no-errors material-input-full",
                "type": "input",
                "key": "password_confirmation",
                "templateOptions": {
                    "type": "password",
                    "label": "Confirm Password",
                    "required": true
                }
            }
        ],

        /*
         * Formly Form Submit Event
         */
        submitHandler: function(){
            $recoverPasswordApi.resetPassword({
                email: $scope.loginForm.model.email,
                password: $scope.loginForm.model.password,
                password_confirmation: $scope.loginForm.model.password_confirmation,
                token: $stateParams.token
            },
            function(response) {
                Notify({
                    message: 'Success! Your password has been modified. Please login.',
                    type: 'success',
                    inverse: true,
                    timeout: false,
                    icon: true
                });
            },
            function(error) {
                var message = '';

                if (error.data && error.data.password) {
                    message = error.data.password[0];
                }

                if (error.data && error.data.error && error.data.error.message && error.data.error.message.message) {
                    message = error.data.error.message.message;
                }

                Notify({
                    message: message,
                    type: 'error',
                    inverse: true,
                    timeout: false,
                    icon: true
                });
            } );
        }
    };

}]);
