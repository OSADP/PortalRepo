
/**
*  Controller
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('AkeebaItemsCtrl', ['$scope', '$timeout', '$http', '$stateParams', AkeebaItemsCtrl])

function AkeebaItemsCtrl ( $scope, $timeout, $http, $stateParams ) {
	$scope.showLoader = true;
	$scope.items = [];
	// environments are fontawesome icons, the DB returns an array index that we are using for this
	$scope.environments = ["-", "-", "linux", "osx", "apple", "windows", "android"];
	// get the current category id from the url
	var _categoryId = $stateParams.categoryId;
	// get all items, in the future this will be determined by category id
	// so we won't have to make a loop
	$http.get('/osadp/leidos/custom/services/akeeba/items')
	.then( function( promise ) {
		var items = promise.data;
		// give all items to all
		if( _categoryId  == 'all' ) {
			$scope.items = items || [];
		} else {
			// display items based on current category id
			angular.forEach( items, function( item ) {
				item.environment = $scope.environments[item.environments.split('"')[1]];
				if( item.category_id == _categoryId ) {
					$scope.items.push( item );
				}
			})
		}
		// timeout applies $apply so yea hide loader
		$timeout( function() {
			$scope.showLoader = false;
		}, 250);
	})
}