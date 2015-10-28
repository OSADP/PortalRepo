

angular.module('Leidos.OSADP.Akeeba.Application.Search')
// router configuration for this module
.config(['$urlRouterProvider', '$stateProvider', function( $urlRouterProvider, $stateProvider ) {
	// build our routes
	$stateProvider
	// State for Listing all users
	.state('listAll', {
		url: '/:categoryId',
		templateUrl: '/osadp/modules/mod_leidos_ars_search/app/partials/main.ng.html',
		controller: 'CategoriesCtrl',
		resolve: {
			categories: ['$http', function( $http ) {
				return $http.get('/osadp/leidos/custom/services/akeeba/categories')
					.then( function( promise ) {
						return promise;
					})
			}],
			items: ['$http', function( $http ) {
				return $http.get('/osadp/leidos/custom/services/akeeba/items')
					.then( function( promise ) {
						return promise;
					})
			}]
		}
	})

	$urlRouterProvider.otherwise('/all');

}])