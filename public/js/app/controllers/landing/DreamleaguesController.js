/*
 * Created by Rohan Jalil.
 * User: rohan.jalil
 * For: Contact Page
 * License: Wooter LLC.
 * Date: 2016.02.16
 * Description:
 *
 */
__Wooter.controller('Landing/DreamleaguesController', ['$scope', 'Page', 'Authentify', '$filter', 'Notify', 'Util', '$state','ContactForm', function ($scope, Page, Authentify, $filter, Notify, Util, $state, ContactForm) {

    Page.reset();
    Page.title('Dream Leagues | Wooter');
	Page.stylesheets([
		'css/landing/dreamleagues.css',
		'css/landing/modals.css'
	]);
	Page.scripts([
		'js/landing/index.js'
	]);

}]);
