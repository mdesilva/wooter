/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Register Page
 * License: Wooter LLC.
 * Date: 2016.01.13
 * Description:
 *
 */
__Wooter.controller('Auth/RegisterController', ['$scope', 'Page', 'Authentify', '$filter', 'Notify', '$state', function ($scope, Page, Authentify, $filter, Notify, $state) {

    /**
     * Clear previous styles and scripts, change title
     */
    Page.reset();
    Page.title('Register | Wooter');

    /**
     * Styles
     */
    Page.stylesheets('css/auth.css');

    var days = [];
    var i;
    for (i = 1; i <= 31; i++) {
        days.push({
            name: i,
            day: i
        });
    }

    var monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    var months = [];
    for (i = 1; i <= 12; i++) {
        months.push({
            name: monthNames[i-1],
            month: i
        });
    }

    var years = [];
    for (i = (new Date()).getFullYear(); i >= 1900; i--) {
        years.push({
            name: i,
            year: i
        });
    }

    /*
     * Formly Form
     */
    $scope.registerForm = {
        name: 'registerForm',
        /*
         * Form Model
         */
        model: { "preselected_role": "3" },

        /*
         * Form Options
         */
        options: {},

        /*
         * Form Fields
         */
        fields: [
            {
                className: "radio-header-box",
                fieldGroup: [
                    {
                        "className": "no-error flex-100",
                        "key": "preselected_role",
                        "type": "radio",
                        "templateOptions": {
                            "options": [
                                {
                                    "name": "Comissioner",
                                    "value": 3,
                                    "group": ""
                                },
                                {
                                    "name": "Athlete",
                                    "value": 1,
                                    "group": ""
                                }
                            ]
                        }
                    }
                ]
            },
            {
                className: "inner no-pdb clearfix",
                template: '<md-button class="full-btn no-margin fb md-raised" href="/auth/facebook"><i class="fa fa-facebook"></i> Sign Up with Facebook</md-button>'
            },
            {
                className: "inner no-pdb no-pdt clearfix",
                template: '<p class="or">or</p>'
            },
            {
                className: "inner clearfix no-pdb no-pdt",
                fieldGroup: [
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
                    },
                    {
                        "className": "no-errors layout-row",
                        "fieldGroup": [
                            {
                                "className": "flex-45 no-errors",
                                "type": "input",
                                "key": "first_name",
                                "templateOptions": {
                                    "type": "text",
                                    "label": "First Name:",
                                    "required": true
                                }
                            }, {
                                "className": "flex-10 no-errors",
                                "template": '<div class="flex-10"></div>'
                            },{
                                "className": "flex-45 no-errors",
                                "type": "input",
                                "key": "last_name",
                                "templateOptions": {
                                    "type": "text",
                                    "label": "Last Name:",
                                    "required": true
                                }
                            }
                        ]
                    },
                    {
                        "className": "no-errors material-input-full",
                        "type": "input",
                        "key": "phone",
                        "ngModelAttrs": {
                            "mask": {
                                "attribute": "mask"
                            },
                            "clean": {
                                "attribute": "clean"
                            }
                        },
                        "templateOptions": {
                            "type": "numeric",
                            "label": "Phone Number",
                            "mask": "(999) 999-9999",
                            "clean": true
                        }
                    }
                ]
            }
        ],

        /*
         * Form Submit Event
         */
        submitHandler: function(){
            loading();
            angular.element('.registerForm [type="submit"]').attr('disabled', 'disabled');

            Authentify.register($scope.registerForm.model, $scope.registerForm.Event.success, $scope.registerForm.Event.error);
        },

        /*
         * Form Request Event
         */
        Event: {
            success: function(res){
                loaded();
                angular.element('.registerForm [type="submit"]').removeAttr('disabled');

                Notify({
                    message: "Successfull Registration! Check your mail to confirm account.",
                    timeout: 3000,
                    type: 'success',
                    inverse: true,
                    icon: true
                });

                Authentify.login({
                    email: $scope.registerForm.model.email,
                    password: $scope.registerForm.model.password
                }, '.registerForm [type="submit"]');
            },
            error: function(e){
                loaded();
                angular.element('.registerForm [type="submit"]').removeAttr('disabled');

                var response = e.data;
                var k = 0;
                if(typeof response == "object"){
                    angular.forEach(response, function (error) {
                        var $error = (error[0])?error[0]:'Something went wrong!';
                        setTimeout(function(){
                            Notify({
                                message: $error,
                                timeout: 5000,
                                type: 'warning',
                                inverse: true,
                                icon: 'frown-o'
                            });
                        }, k*300);
                        k+=1;
                    });
                }
            }
        }

    };


}]);
