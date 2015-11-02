
/**
*  Controller
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('CategoryListCtrl', ['$scope', '$timeout', '$http', '$location', CategoryListCtrl])

function CategoryListCtrl ( $scope, $timeout, $http, $location ) {
	$scope.categories = [];
	console.log($location.path().split("/")[1]);

	$http.get('/osadp/leidos/custom/services/akeeba/categories')
	.then( function( promise ) {
		$scope.categories = promise.data;

		if( $scope.categories.length > 0 ) {
			var _currentCategory = {
				title: 'All Applications',
				id: 'all'
			}
			$scope.categories.unshift( _currentCategory );
		}
		
		angular.forEach( $scope.categories, function( category ) {
			if( category.id == $location.path().split("/")[1] ) {
				_currentCategory = category;
				_currentCategory.active = true;
			}
		})

		$scope.categoryChange = function() {
			_currentCategory.active = false;
			_currentCategory = this.category;
			_currentCategory.active = true;
		}

		$http.get('/osadp/leidos/custom/services/akeeba/items')
		.then( function( promise ) {
			var _items = promise.data;
			angular.forEach( $scope.categories, function( category ) {
				category.items = [];
				if( category.id == 'all' ) category.items = _items;
				angular.forEach( _items, function( item ) {
					if( item.category_id == category.id )
						category.items.push( item );
				})
			});
		});

	});
}