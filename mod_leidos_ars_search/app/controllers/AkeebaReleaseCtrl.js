
'use strict';

/**
*  Akeeba Releases Controller
*
* Description
* This controller handles the data for our items/releases
* and parse any necessary information to make it readable
* for users.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('AkeebaReleasesCtrl', ['$rootScope', '$scope', '$stateParams', 'AkeebaService', AkeebaReleasesCtrl])

function AkeebaReleasesCtrl ( $rootScope, $scope, $stateParams, AkeebaService ) {
	$rootScope.$broadcast('application:hidden');
	$scope.showLoader = true; // shows or hides loader on http load
	$scope.items = []; // actuall ARS items
	$scope.ordering = 'title'; // initial ordering setting
	$scope.reverse = false; // affects ascending or desc of order
	// get the current category id from the url
	var _categoryId = $stateParams.categoryId;
	// get all items, in the future this will be determined by category id
	// so we won't have to make a loop
	AkeebaService.getAllItems()
	.then( function( items ) {
		// var items = promise.data;
		$scope.showLoader = false;
		angular.forEach( items, function( item ) {
			item.hits = parseInt( item.hits );
		});
		// give all items to all
		if( _categoryId  == 'all' ) {
			$scope.items = items || [];
		} else {
			// display items based on current category id
			angular.forEach( items, function( item ) {
				if( item.release.category_id == _categoryId ) {
					$scope.items.push( item );
				}
			})
		}
	});
	
}