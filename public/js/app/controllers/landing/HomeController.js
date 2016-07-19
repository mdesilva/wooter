/**
 * Created by Eric Rho.
 * User: {slack: erho87, skype: eric.rho}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.07.07
 * Description:
 *
 */
__Wooter.controller('Landing/HomeController', ['$scope', '$rootScope', 'Page', 'Authentify', function ($scope, $rootScope, Page, Authentify) {
	/*
	 * Clean page (title, assets, favicon badge, etc.)
	 */
	Page.reset();

	/*
     * Set Title Page
     */
	Page.title('Wooter | Home');

	Page.stylesheets('/css/landing/home.css');

    /*
     * Put here Action and Scopes
     */

     // $rootScope.authenticated = Authentify.GET.authCheck();
     // console.log($rootScope.authenticated);

}]);
