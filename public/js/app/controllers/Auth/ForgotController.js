/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Login Page
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description:
 *
 */
__Wooter.controller('Auth/ForgotController', ['$scope', 'Page', 'Notify', 'API', function ($scope, Page, Notify, API) {

    var $recoverPasswordApi = API.exec('recoverPassword');

    Page.reset();
    Page.title('Password recovery | Wooter');
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
            }
        ],

        /*
         * Formly Form Submit Event
         */
        submitHandler: function(){
            $recoverPasswordApi.forgotPassword({email: $scope.loginForm.model.email}, function(response) {
                Notify({
                    message: 'Success! Check your email to continue recovering your password.',
                    type: 'success',
                    inverse: true,
                    timeout: false,
                    icon: true
                });
            });
        }
    };

}]);
