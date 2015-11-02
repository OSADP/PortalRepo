

angular.module('Leidos.OSADP.Akeeba.Application.Search')
// router configuration for this module
.config(['$urlRouterProvider', '$stateProvider', function( $urlRouterProvider, $stateProvider ) {
	// build our routes with $stateProvider
	$stateProvider
	// State for Listing all users
	.state('listAll', {
		url: '/:categoryId',
		templateUrl: '/osadp/modules/mod_leidos_ars_search/app/partials/main.ng.html',
		controller: 'AkeebaItemsCtrl'
	})
	// set default route, works specially on initial page load
	$urlRouterProvider.otherwise('/all');

}])