/*
 * Created by Rohan Jalil.
 * User: rohan.jalil
 * For: Contact Page
 * License: Wooter LLC.
 * Date: 2016.02.16
 * Description:
 *
 */
__Wooter.controller('Share/TestController', ['$scope', 'Page', 'Authentify', '$filter', 'Notify', 'Util', '$state','ContactForm', function ($scope, Page, Authentify, $filter, Notify, Util, $state, ContactForm) {

    Page.reset();
    Page.title('Test | Wooter');
	Page.stylesheets([
		'css/landing/about.css'
	]);
	Page.scripts([
		'js/landing/index.js'
	]);

}]);
