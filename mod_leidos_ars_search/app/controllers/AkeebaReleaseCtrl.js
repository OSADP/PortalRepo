/**
* This controller handles the data for our items/releases
* and parse any necessary information to make it readable
* for users.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')
.controller('AkeebaReleasesCtrl', ['$rootScope', '$scope', '$stateParams', 'AkeebaService', '$timeout', '$filter', AkeebaReleasesCtrl])

function AkeebaReleasesCtrl ( $rootScope, $scope, $stateParams, AkeebaService, $timeout, $filter ) {
	'use strict';
	$rootScope.$broadcast('application:hidden');
	$scope.showLoader = true; // shows or hides loader on http load
	$scope.items = []; // actual ARS items
	$scope.ordering = 'title'; // initial ordering setting
	$scope.reverse = false; // affects ascending or desc of order
	$scope.moment = moment;
	$scope.keywordsShow = false;
	// Options for limiting the number of items to display
	$scope.limitOptions = [
		{ name: 'Show 5 Items', value: 5	},
		{ name: 'Show 10 Items', value: 10	},
		{ name: 'Show 20 Items', value: 20	},
		{ name: 'Show All Items', value: 'all' }
	]
	/**
	 * Toggles the display of items with similar keywords
	 * @param  {objecy} $event  Angular event object passed
	 * @param  {boolean} displayInterface   True to open, false to close
	 * @param  {string} keyword Passed keyword clicked by user
	 * @return {undefined}
	 */
	$scope.displayKeywords = function($event, displayInterface, keyword ) {
		// $event.stopPropagation()
		// $event.preventDefault()
		displayInterface = ( displayInterface === undefined ) ? true : displayInterface
		$scope.keywordsShow = displayInterface
		$scope.keyword = keyword
		document.body.style.overflow = ( displayInterface ) ? 'hidden' : 'auto'
		return keyword;
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
		// create a separate items array for keywords process
		$scope.allItems = items;
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

	/**
	 * Allows to simulate pagination by creating an array that holds items
	 * @param  {array} items 	Items to be paginated
	 * @param  {int} limit 		Number of items per page
	 * @return {array}       	Array of paginated items
	 */
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

	/**
	 * Filter items with the text search filter and order filter
	 * @param  {array} items   Items to be sorted
	 * @param  {string} orderFilter  Type of ordering
	 * @param  {boolean} reverse Ascending or Descending order
	 * @return {array}         Sorted Items
	 */
	function sortItems( items, orderFilter, reverse ) {
		items = $filter('filter')( items, $scope.searchFilter );
		var sortedItems = $filter('orderBy')( items, orderFilter, reverse );
		return sortedItems;
	}

	/**
	 * Change current page of items
	 * @param  {int} num Current page to display
	 * @return {undefined}
	 */
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