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
angular.module('Leidos.OSADP.Akeeba.Application.Search')
// router configuration for this module
.config(['$urlRouterProvider', '$stateProvider', function( $urlRouterProvider, $stateProvider ) {
	// build our routes with $stateProvider
	$stateProvider
	// main state of our application
	.state('main', {
		url: '/:categoryId',
		templateUrl: '/modules/mod_leidos_ars_search/app/partials/main.ng.html',
		controller: 'AkeebaReleasesCtrl'
	})
	// this route show individual applications
	.state('application', {
		url: '/:categoryId/:itemId',
		templateUrl: '/modules/mod_leidos_ars_search/app/partials/application.ng.html',
		controller: 'ApplicationCtrl',
		onEnter: function() {
			// scroll to top in application pages for better browsing experience
			jQuery('html, body').animate({ scrollTop: -10000 }, 100);
		}
	})
	// set default route to display all releases
	$urlRouterProvider.otherwise('/all');

}])