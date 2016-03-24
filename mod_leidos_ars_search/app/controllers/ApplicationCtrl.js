
'use strict';

/**
*  Akeeba Category List Controller
*
* Description
* This generates the category list based on data
* from ARS.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('ApplicationCtrl', ['$rootScope', '$scope', '$stateParams', 'AkeebaService', '$state', '$timeout', ApplicationCtrl])

function ApplicationCtrl ( $rootScope, $scope, $stateParams, AkeebaService, $state, $timeout ) {
	// here we control the tabs and texts to display
	$scope.activeTab = 'description';
	$scope.login = false;
	// this changes the width of the RIGHT panel to full width
	$state.applicationWidth = 'col-xs-12';
	// get base64 of href
	$scope.redirect = btoa( location.href );
	$scope.token = window.__internal.getToken().split('"')[3];
	$scope.userId = window.__internal.getUserId();
	// broadcast the state since the category list is not part of the routing config
	$rootScope.$broadcast('application:visible');
	var _environments = ["-", "-", "linux", "osx", "apple", "windows", "android"];
	// get our application details based on the route's parameters
	$scope.loggedIn = ! window.__internal.isGuest();
	AkeebaService.getItem( $stateParams.itemId )
	.then( function( item ) {
		// item.environment = _environments[item.environments.split('"')[1]];
		$scope.item = item;
		// get item documentation
		AkeebaService.getItemDocumentation( item.id ).then( function( data ) {
			$scope.item.documentation = data;
		});
		AkeebaService.getOtherItems( item.release.category.id, item.id )
		.then( function( items ) {
			$scope.otherItems = items;
		});
		// get multiple categories id, and title
		AkeebaService.getAllCategories()
		.then( function( categories ) {
			// holder for our categories' id and title
			$scope.item.categories = [];
			angular.forEach($scope.item.category_ids, function( category_id ) {
				angular.forEach( categories, function( category ) {
					if( category_id == category.id ) {
						$scope.item.categories.push({id: category.id, title: category.title});
					}
				});
			});
		});
	});

	// this toggle the login form in the ui
	$scope.toggleLogin = function( $event ) {
		$scope.login = ! $scope.login;
		$timeout(function() {
			document.querySelector('.osadp__form__username').focus();
		}, 100)
	}

	// this toggle the login form in the ui
	$scope.closeLogin = function( $event ) {
		$scope.login = ! $scope.login;
		$timeout(function() {
			document.querySelector('.osadp__close__login').focus();
		}, 100)
	}

}