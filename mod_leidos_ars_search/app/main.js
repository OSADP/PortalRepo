



'use strict';

/**
* Leidos.OSADP.Akeeba.Application.Search Module
*
* Description
* Main module for displaying Akeeba Release Systems'
* applications as well as provide a search and sort function.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search', ['ui.router'])
// configure our router
.config(['$urlRouterProvider', '$stateProvider', function( $urlRouterProvider, $stateProvider ) {
	// build our routes
	$stateProvider
	// State for Listing all users
	.state('listAll', {
		url: '/:category',
		templateUrl: 'modules/mod_leidos_ars_search/app/partials/main.ng.html',
		controller: 'CategoriesCtrl',
		resolve: {
			categories: ['$http', function( $http ) {
				return $http.get('/osadp/leidos/custom/services/akeeba/categories')
					.then( function( promise ) {
						return promise;
					})
			}]
		}
	})

	$urlRouterProvider.otherwise('/all');

}])

.controller('CategoriesCtrl', ['$scope', '$timeout', '$http', '$stateParams', 'categories', CategoriesList])

function CategoriesList ( $scope, $timeout, $http, $stateParams, categories ) {
	$scope.showLoader = true;
	$scope.categories = categories.data || {};

	$scope.categories.unshift({
		title: 'All Applications',
		active: true,
		id: 'all'
	});

	angular.forEach( categories.data, function( category ) {
		category.active = false;
		if ( $stateParams.category == category.id ) {
			$scope.currentCategory = category.title;
			category.active = true;
		}
	})

	$http.get('/osadp/leidos/custom/services/akeeba/releases')
	.then( function( promise ) {
		$timeout(function() {
			$scope.showLoader = false;
			$scope.releases = promise.data;
			$scope.categories[0].num_releases = $scope.releases.length;
			angular.forEach( $scope.categories, function( category, index ) {
				if( index != 0 ) {
					category.num_releases = 0;
					angular.forEach( $scope.releases, function( release ) {
						if( release.category_id == category.id) {
							category.num_releases++;
						}
					})
				}
			})
		}, 1000)
	})


}

;(function(window, document, $, undefined) {

	$(document).ready( function() {
		var arsSearcher = $('#arsSearch');
		angular.bootstrap( arsSearcher, ['Leidos.OSADP.Akeeba.Application.Search']);
	});

})(window, document, jQuery);