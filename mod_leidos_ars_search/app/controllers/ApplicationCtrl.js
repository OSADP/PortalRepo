'use strict';
/**
*  Akeeba Category List Controller
*
* Description
* This generates the category list based on data
* from ARS.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('ApplicationCtrl',
	['$rootScope', '$scope', '$stateParams', 'AkeebaService', '$state', '$timeout', 'JoomlaApp',
	ApplicationCtrl])

function ApplicationCtrl ( $rootScope, $scope, $stateParams, AkeebaService, $state, $timeout, JoomlaApp ) {
	// here we control the tabs and texts to display
	$scope.activeTab = 'overview';
	$scope.login = false;
	// this changes the width of the RIGHT panel to full width
	$state.applicationWidth = 'col-xs-12';
	// get base64 of href
	$scope.redirect = btoa( location.href );
	$scope.token = JoomlaApp.token; // get a token for our login form
	$scope.userId = JoomlaApp.userId; // get user id if available
	$scope.loggedIn = ! JoomlaApp.isGuest; // check if user is logged in
	// broadcast the state since the category list is not part of the routing config
	$rootScope.$broadcast('application:visible');
	// var _environments = ["-", "-", "linux", "osx", "apple", "windows", "android"];
	// Get our specified item based on the item ID
	AkeebaService.getItem( $stateParams.itemId )
	.then( function( item ) {
		if( item.keywords = null ) {
			item.keywords = []
		}
		// ACL implementation: Remove item if user does not have access rights
		if( item.access != 2 ) {
			var access = JoomlaApp.usergroups[item.access];
			if( access == undefined ) {
				window.location.href = "#/all";
			}
		}
		// item.environment = _environments[item.environments.split('"')[1]];
		$scope.item = item;
		if($scope.item.release.description == null || $scope.item.release.description == '') {
			$scope.activeTab = 'description';
		}
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
		}).then(function() {
			var $ = jQuery
			var images = $('.ars-item__page').find('img');
			angular.forEach(images, function(image) {
				var firstChar = $(image).attr('src')[0];
				if( firstChar !== '/' )
					$(image).attr('src', '/' + $(image).attr('src'));
			})
		});
	});
	/**
	 * Toggles the display of the login form in our view
	 * @param  {object} $event        Angular event object
	 * @param  {string} focusSelector Selector for element to be focused
	 * @return {undefined}
	 */
	$scope.toggleLogin = function( $event, focusSelector ) {
		$scope.login = ! $scope.login;
		$timeout(function() {
			document.querySelector(focusSelector).focus();
		}, 100)
	}

}