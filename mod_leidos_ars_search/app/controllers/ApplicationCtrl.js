
'use strict';

/**
*  Akeeba Category List Controller
*
* Description
* This generates the category list based on data
* from ARS.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('ApplicationCtrl', ['$rootScope', '$scope', '$stateParams', 'AkeebaService', '$state', ApplicationCtrl])

function ApplicationCtrl ( $rootScope, $scope, $stateParams, AkeebaService, $state ) {
	// broadcast the state since the category list is not part of the routing config
	$rootScope.$broadcast('application:visible');
	var _environments = ["-", "-", "linux", "osx", "apple", "windows", "android"];
	// get our application details based on the route's parameters
	$scope.loggedIn = ! window.isGuest();
	AkeebaService.getItem( $stateParams.itemId )
	.then( function( item ) {
		// item.environment = _environments[item.environments.split('"')[1]];
		$scope.item = item;
		AkeebaService.getOtherItems( item.release.category.id, item.id )
		.then( function( items ) {
			$scope.otherItems = items;
		})
	})

	// here we control the tabs and texts to display
	$scope.activeTab = 'description';
	// this changes the width of the RIGHT panel to full width
	$state.applicationWidth = 'col-xs-12';
}