
/**
*  Controller
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
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