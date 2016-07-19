/**
 * First Validate Page
 */
if(validate_page()){
    /**
     * Initialize application instance
     */
    var __Wooter = angular.module('Wooter', [
        'ui.router',
        'ngMaterial',
        'ngMask',
        'resource',
        'ngAnimate',
        'angularVideoBg',
        'formly',
        'formlyMaterial',
        'ngCookies',
        'ngMessages',
        'ngAria',
        'satellizer',
        'nemLogging',
        'uiGmapgoogle-maps',
        'ngMaterialDatePicker',
        'Api.DuplicateRequestsFilter.Decorator'
    ]);
} else {
    window.location.reload();
}
