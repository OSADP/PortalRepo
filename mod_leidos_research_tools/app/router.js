

'use strict';

/**
* Angular UI-Router Configuration
*
* Description
* This is where we will configure routes for our application.
* So far there's only one route but it's needed to keep the state
* of our application especially when reloading the page or using
* the browser's back button, as well as sharing the link.
*/
angular.module('Leidos.OSADP.Research.Tools')
// router configuration for this module
.config(['$urlRouterProvider', '$stateProvider', function( $urlRouterProvider, $stateProvider ) {
	// build our routes with $stateProvider
	$stateProvider
	// main state of our application
	.state('main', {
		url: '/',
		templateUrl: '/osadp/modules/mod_leidos_research_tools/app/partials/main.ng.html',
		controller: 'MainCtrl'
	})
	// set default route to display all releases
	$urlRouterProvider.otherwise('/');

}])