
'use strict';

/**
*  Akeeba Category List Controller
*
* Description
* This generates the category list based on data
* from ARS.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('CategoryListCtrl', ['$scope', '$timeout', '$http', '$location', 'AkeebaService', CategoryListCtrl])

function CategoryListCtrl ( $scope, $timeout, $http, $location, AkeebaService ) {
	$scope.categories = [];
	// populate our category list with items from the ARS database
	$http.get('/osadp/leidos/custom/services/akeeba/categories')
	.then( function( promise ) {
		$scope.categories = promise.data;
		// create All Applications category as it's not part of the
		// Akeeba Release System database
		if( $scope.categories.length > 0 ) {
			var _currentCategory = {
				title: 'All Releases',
				id: 'all'
			}
			// unshift() adds object to the beginning of the array
			$scope.categories.unshift( _currentCategory );
		}
		// grab current category id from the url path to select
		// current category on page load/refresh
		angular.forEach( $scope.categories, function( category ) {
			if( category.id == $location.path().split("/")[1] ) {
				_currentCategory = category;
				_currentCategory.active = true;
			}
		})
		// this is our event for changing active/current category
		$scope.categoryChange = function() {
			_currentCategory.active = false;
			_currentCategory = this.category;
			_currentCategory.active = true;
		}
		// this will show how many applications are under each category
		// TODO: This should probably be part of the data from the category
		// web service.
		AkeebaService.getAll()
		.then( function( _items ) {
			// var _items = promise.data;
			angular.forEach( $scope.categories, function( category ) {
				category.items = [];
				if( category.id == 'all' ) category.items = _items;
				angular.forEach( _items, function( item ) {
					if( item.release.category_id == category.id )
						category.items.push( item );
				})
			});
		});

	});
}