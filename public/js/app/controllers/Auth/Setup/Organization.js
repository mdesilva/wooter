/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: First setup Page
 * License: Wooter LLC.
 * Date: 2016.01.18
 * Description: First setup page is a page for setup account of organization after register and verify if user login
 * 				first time will be redirect to this page to complete information
 *
 */
__Wooter.controller('Auth/Setup/Organization', ['$scope', 'Page', '$stateParams', '$http', 'Authentify', function ($scope, Page, $stateParams, $http, Authentify) {

    Page.reset();

	Page.title('Setup Account | Wooter');

	Page.stylesheets([
		'css/auth.css',
		'css/vendors/owl/index.css'
	]);
	Page.scripts([
		'js/scripts/auth/setup/index.js'
	]);

	if(Authentify.check){

		$scope.uploadActionClick = function(){
			var toggle = document.querySelector('.setupForm .drop-area');
			toggle.click();
			return false;
		};

		$scope.setupForm = {
			name: 'setupForm',
			model: {
				"type": "3",
                "newImage": 0
			},
			options: {},

			slides: [
				{
					title: "Enter some basic information about your company.",
					fields: {
						name: {
							element: "input",
							label: "Company Name",
							type: "text",
							required: true
						},
						email: {
							element: "input",
							label: "Company Email",
							type: "email",
							required: true
						},
						website: {
							element: "input",
							label: "Company Website",
							type: "text",
							required: false
						},
						phone: {
							element: "input",
							type: "text",
							label: "Phone Number",
							mask: "(999) 999-9999",
							required: true,
							clean: true
						}
					}
				},
				{
					title: "Upload Your Organization\'s Logo"
				},
				{
					title: 'Where is your organization located?',
					fields:{
                        street:{
                            element: "input",
                            label: "Street Address",
                            type: "text",
                            required: true
                        },
                        address:{
                            element: "input",
                            label: "Apt/Suite/Bldg",
                            type: "text",
                            required: true
                        },
                        city:{
                            element: "input",
                            label: "City",
                            type: "text",
                            required: true
                        },
                        state:{
                            element: "input",
                            label: "State",
                            type: "text",
                            required: true
                        },
                        zip:{
                            element: "input",
                            type: "text",
                            label: "Zip Code",
                            "mask": "99999",
                            "required": true,
                            "clean": true
                        }
                    }
				},
                {
                    title: "Describe your company in up to 500 words.",
                    fields: {
                        description: {
                            element: "textarea",
                            label: "Description",
                            type: "text",
                            maxlength: 500,
                            required: true
                        }
                    }
                }
			],

			submitHandler: function(){
				console.log($scope.setupForm.model);
			}

		};
	}

}]);
