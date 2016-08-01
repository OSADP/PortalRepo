
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
.controller('AkeebaReleasesCtrl', ['$rootScope', '$scope', '$stateParams', 'AkeebaService', '$timeout', '$filter', AkeebaReleasesCtrl])

function AkeebaReleasesCtrl ( $rootScope, $scope, $stateParams, AkeebaService, $timeout, $filter ) {
	$rootScope.$broadcast('application:hidden');
	$scope.showLoader = true; // shows or hides loader on http load
	$scope.items = []; // actuall ARS items
	$scope.ordering = 'title'; // initial ordering setting
	$scope.reverse = false; // affects ascending or desc of order
	$scope.moment = moment;
	$scope.keywordsShow = false;

	$scope.limitOptions = [
		{ name: 'Show 5 Items', value: 5	},
		{ name: 'Show 10 Items', value: 10	},
		{ name: 'Show 20 Items', value: 20	},
		{ name: 'Show All Items', value: 'all' }
	]

	$scope.displayKeywords = function($event, value, keyword ) {
		$event.stopPropagation()
		$event.preventDefault()
		value = ( value === undefined ) ? true : value
		$scope.keywordsShow = value
		console.log($scope.keywordsShow);
	}

	$scope.limit = $scope.limitOptions[0].value;
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
			item.release.modified = moment(item.release.modified).format('MMM D, YYYY');
			if( item.keywords )
				item.keywords = item.keywords.split(',');
		});
		// give all items to all
		if( _categoryId  == 'all' ) {
			// $scope.items = items || [];
			$scope.currentItems = 0;
			$scope.items = paginate(sortItems( items, $scope.ordering, $scope.reverse ), $scope.limit);
			// this limits how many items are shown: pagination
			$scope.$watch('limit', function() {
				$scope.items = paginate(sortItems( items, $scope.ordering, $scope.reverse ), $scope.limit);
				$scope.currentItems = 0;
			});
			// watch for a change in the ordering variable and do an ngFilter: orderBy function
			$scope.$watchGroup(['ordering', 'reverse'], function() {
				$scope.items = paginate(sortItems( items, $scope.ordering, $scope.reverse ), $scope.limit);
			});
			// filter rersults based on the searchFilter variable
			$scope.$watch('searchFilter', function() {
				if( $scope.searchFilter != undefined ) {
					$scope.items = paginate(sortItems( items, $scope.ordering, $scope.reverse ), $scope.limit);
					$scope.currentItems = 0;
				}
			});
		} else {
			// display items based on current category id
			var categorizedItems = [];
			angular.forEach( items, function( item ) {
				// NEW: Multicategory implementation
				// @author Robert Roth
				angular.forEach( item.category_ids, function( category_id ) {
					if( category_id == _categoryId ) {
						categorizedItems.push( item );
					}
				});
			});
			$scope.items = paginate(sortItems( categorizedItems, $scope.ordering, $scope.reverse ), $scope.limit);
			// this limits how many items are shown: pagination
			$scope.$watch('limit', function() {
				$scope.items = paginate(sortItems( categorizedItems, $scope.ordering, $scope.reverse ), $scope.limit);
				$scope.currentItems = 0;
			});
			// watch for a change in the ordering variable and do an ngFilter: orderBy function
			$scope.$watchGroup(['ordering', 'reverse'], function() {
				$scope.items = paginate(sortItems( categorizedItems, $scope.ordering, $scope.reverse ), $scope.limit);
			});
			// filter rersults based on the searchFilter variable
			$scope.$watch('searchFilter', function() {
				if( $scope.searchFilter != undefined ) {
					$scope.items = paginate(sortItems( categorizedItems, $scope.ordering, $scope.reverse ), $scope.limit);
					$scope.currentItems = 0;
				}
			})
		}
	});

	// allows to simulate pagination by creating an array that holds
	// items depending on the 'limit' variable of our scope
	function paginate( items, limit ) {
		if( limit != 'all' ) {
			var parsedItem = [];
			var x = 0;
			angular.forEach( items , function( stuff, index ) {
				parsedItem[x] = parsedItem[x] || [];
				parsedItem[x].push( stuff );
				if( items.length > limit )
					if( (index + 1) % limit == 0 ) {
						x += 1;
					}
			})

			return parsedItem;
		} else {
			if( items.length == 0 )
				return items;
			else
				return [items];
		}
	}

	// moved orderBy filter to the controller
	function sortItems( items, filter, reverse ) {
		items = $filter('filter')( items, $scope.searchFilter );
		var sortedItems = $filter('orderBy')( items, filter, reverse );
		return sortedItems;
	}
	// moved text filter to the controller
	function filterItems( items, query ) {
		var filteredItems = $filter('filter')( items, query );
		return filteredItems;
	}

	$scope.adjustCurrentItems = function( num ) {
		if( num == 'last' ) {
			$timeout(function() {
				$scope.currentItems = $scope.items.length - 1;
			})
		} else if( num == 'first' ) {
			$timeout(function() {
				$scope.currentItems = 0;
			})
		} else {
			var newNumber = $scope.currentItems + num;
			if( newNumber >= 0 && newNumber < $scope.items.length ) {
				$timeout(function() {
					$scope.currentItems = newNumber;
				})
			}
		}
	}
} // end-