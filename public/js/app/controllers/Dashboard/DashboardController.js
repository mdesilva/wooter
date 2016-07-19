/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.01.12
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Dashboard/DashboardController', ['$scope', 'Page', 'Authentify','$window', function ($scope, Page, Authentify,$window) {

	/*
	 * Reset page assets, title and notifications
	 */
	Page.reset();

	/*
	 * Set title of Page
	 */
	Page.title('Dashboard | Wooter');


	/*
	 * Add css files
	 */
	Page.stylesheets([
		'css/dashboard.css'
	]);

	$window.location.href = '/dashboard/leagues';
	// Put here Action and Scopes
}]);
