
/**
*  Controller
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('CategoriesCtrl', ['$scope', '$timeout', '$http', '$stateParams', 'categories', 'items', CategoriesList])

function CategoriesList ( $scope, $timeout, $http, $stateParams, categories, items ) {
	$scope.showLoader = true;
	$scope.categories = categories.data || [];
	$scope.items = items.data || [];
	$scope.environments = ["-", "-", "linux", "osx", "apple", "windows", "android"];

	if( $scope.categories.length > 0 ) {	
		$scope.categories.unshift({
			title: 'All Applications',
			active: true,
			id: 'all'
		});
	}

	angular.forEach( $scope.categories, function( category ) {
		category.active = false;
		category.items = [];

		if( category.id == 'all' ) {
			category.items = $scope.items;
		} else {
			angular.forEach( $scope.items, function( item ) {
				item.environment = $scope.environments[item.environments.split('"')[1]];
				if( category.id == item.category_id ) {
					category.items.push( item );
				}
			})
		}

		if ( $stateParams.categoryId == category.id ) {
			$scope.currentCategory = category;
			category.active = true;
		}
	})

	$timeout( function() {
		$scope.showLoader = false;
	}, 800)
}