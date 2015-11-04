
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
.controller('AkeebaReleasesCtrl', ['$scope', '$timeout', '$http', '$stateParams', 'AkeebaService', AkeebaReleasesCtrl])

function AkeebaReleasesCtrl ( $scope, $timeout, $http, $stateParams, AkeebaService ) {
	$scope.showLoader = true;
	$scope.reverse = false;
	$scope.items = [];
	$scope.ordering = 'title';
	// environments are fontawesome icons, the DB returns an array index that we are using for this
	$scope.environments = ["-", "-", "linux", "osx", "apple", "windows", "android"];
	// get the current category id from the url
	var _categoryId = $stateParams.categoryId;
	// get all items, in the future this will be determined by category id
	// so we won't have to make a loop
	AkeebaService.getAll()
	.then( function( items ) {
		// var items = promise.data;
		$scope.showLoader = false;
		angular.forEach( items, function( item ) {
			item.hits = parseInt( item.hits );
			item.environment = $scope.environments[item.environments.split('"')[1]];
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