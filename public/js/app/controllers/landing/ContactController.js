/*
 * Created by Rohan Jalil.
 * User: rohan.jalil
 * For: Contact Page
 * License: Wooter LLC.
 * Date: 2016.02.16
 * Description:
 *
 */
__Wooter.controller('ContactController', ['$scope', 'Page', 'Authentify', '$filter', 'Notify', 'Util', '$state','ContactForm', function ($scope, Page, Authentify, $filter, Notify, Util, $state, ContactForm) {
    // Authentify.middleware.logged();

    Page.reset();
    Page.title('Contact | Wooter');
    // Page.stylesheets('css/auth.css');
    Page.stylesheets('css/landing/contact.css');

    $scope.contactForm = {
        name: 'contactForm',
        model: {
        },
        options: {},


        submitHandler: function(){
            ContactForm.submit($scope.contactForm.model, $scope.contactForm.event.success, $scope.contactForm.event.error);
        },

        event: {
            success: function(res){
                if(res.data.type){
                    Notify({
                        message: 'Contact Form Submitted Successfully! We will redirect to dashboard in some moments!',
                        timeout: 3000,
                        type: 'success',
                        inverse: true,
                        icon: true
                    });
                    setTimeout(function(){
                        $state.go('dashboard');
                    }, 3700);
                }
            },
            error: function(e){
                var type = e.data.type;

                if(e.data.state){
                    Notify({
                        message: e.data.state[0],
                        timeout: 5000,
                        type: 'warning',
                        inverse: true,
                        icon: true
                    });
                } else {

                            Notify({
                                message: 'Something went wrong!',
                                timeout: 5000,
                                type: 'warning',
                                inverse: true,
                                icon: true
                            });
          



                }
            }
        }

    };

}]);
