
/**
*  Module
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')

.service('AkeebaService', ['$http', 'JoomlaApp', function( $http, JoomlaApp ){
	var _this = this;
	console.log(JoomlaApp);
	/**
	 * Get all published Akeeba Release System Categories
	 * @return {array} List of category objects
	 */
	_this.getAllCategories = function() {
		return $http.get('/leidos/custom/services/ars/categories')
			.then( function( promise ) {
				return promise.data;
			})
	}
	/**
	 * Get an ARS Category based on its ID
	 * @param  {int} categoryId ID of the category to get
	 * @return {object}            Category object
	 */
	_this.getCategory = function( categoryId ) {
		return $http.get('/leidos/custom/services/ars/categories/' + categoryId)
			.then( function( promise ) {
				return promise.data;
			})
	}
	/**
	 * Get all published ARS Items
	 * @return {array} A list of item objects
	 */
	_this.getAllItems = function() {
		return $http.get('/leidos/custom/services/ars/items')
			.then( function( promise ) {
				var items = promise.data;
				var removeItems = [];

				angular.forEach( items, function( item, index ) {
					// match item environments to fontawesome icons
					item.environments = envToFontAwesome( item.environments );
					// ensure hits is int
					item.hits = parseInt( item.hits );
					// format our modified date
					item.release.modified = moment(item.release.modified).format('MMM D, YYYY');

					// explode our string
					if( item.keywords ) {
						item.keywords = item.keywords.split(',');
						item.keywordsReversed = angular.copy(item.keywords);
						item.keywordsReversed = item.keywordsReversed.reverse();

						item.meta = {
							joined: item.keywords.join(''),
							spaced: item.keywords.join(' '),
							comma: item.keywords.join(),
							'comma-spaced': item.keywords.join(', '),
							'joined-reversed': item.keywordsReversed.join(''),
							'spaced-reversed': item.keywordsReversed.join(' '),
							'comma-reversed': item.keywordsReversed.join(),
							'comma-spaced-reversed': item.keywordsReversed.join(', ')
						}
					} else {
						item.keywords = [] // this prevents the angular dupes error
					}

					// ACL implementation: Remove item if user does not have access rights
					if( item.access != 2 ) {
						var hasAccess = false;
						angular.forEach(JoomlaApp.usergroups, function( group ) {
							if( hasAccess === false ) {
								angular.forEach(JSON.parse(item.rules), function( rule ) {
									hasAccess = (rule == group);
								})
							}
						})
						if( ! hasAccess ) {
							removeItems.push(index);
						}
					}
				});
				// remove item to which the user have no access to
				angular.forEach(removeItems, function(removeItem, index) {
					items.splice(removeItem - index, 1);
				});

				return items;
			})
	}
	/**
	 * Get every item under a specified category
	 * @param  {int} categoryId ID of the category to retrieve items from
	 * @return {array}            A list of item objects
	 */
	_this.getItemsByCategory = function( categoryId ) {
		return $http.get('/leidos/custom/services/ars/items')
			.then( function( promise ) {
				var _parsedItems= [];
				var removeItems = [];

				angular.forEach( promise.data, function( item, index ) {
					if( item.release.category.id == categoryId ) {
						item.environments = envToFontAwesome( item.environments );
						if( item.keywords )
							item.keywords = item.keywords.split(',');
						else
							item.keywords = []
						_parsedItems.push( item );
					}
				});

				// ACL implementation: Remove item if user does not have access rights
				angular.forEach(_parsedItems, function( item, index) {
					if( item.access != 2 ) {
						var access = JoomlaApp.usergroups[item.access];
						if( access == undefined ) {
							removeItems.push(index);
						}
					}
				});
				
				// remove item to which the user have no access to
				angular.forEach(removeItems, function(removeItem, index) {
					_parsedItems.splice(removeItem - index, 1);
				});

				return _parsedItems;
			})
	}
	/**
	 * Get other items within the same category
	 * @param  {int} categoryId The ID of the sepecific category
	 * @param  {int} itemId     The sibling item
	 * @return {array}            List of sibling items
	 */
	_this.getOtherItems = function( categoryId, itemId ) {
		return $http.get('/leidos/custom/services/ars/items')
			.then( function( promise ) {
				var _parsedItems= [];
				var removeItems = [];

				angular.forEach( promise.data, function( item, index ) {
					if( item.release.category.id == categoryId && item.id != itemId ) {
						item.environments = envToFontAwesome( item.environments );
						if( item.keywords )
							item.keywords = item.keywords.split(',');
						_parsedItems.push( item );
					}
				});

				// ACL implementation: Remove item if user does not have access rights
				angular.forEach(_parsedItems, function( item, index) {
					if( item.access != 2 ) {
						var access = JoomlaApp.usergroups[item.access];
						if( access == undefined ) {
							removeItems.push(index);
						}
					}
				});

				// remove item to which the user have no access to
				angular.forEach(removeItems, function(removeItem, index) {
					console.log(_parsedItems.splice(removeItem - index, 1));
				});

				return _parsedItems;
			})
	}
	/**
	 * Get a specific ARS Item
	 * @param  {int} itemId unique identifier of the item
	 * @return {object}        Item object
	 */
	_this.getItem = function( itemId ) {
		return $http.get('/leidos/custom/services/ars/items/' + itemId)
			.then( function( promise ) {
				var item = promise.data;
				item.environments = envToFontAwesome( promise.data.environments );
				if( item.keywords )
					item.keywords = item.keywords.split(',');
				else
					item.keywords = []
				return item;
			})
	}
	/**
	 * Get documentations of a specific item
	 * @param  {int} itemId Unique identifier of the item
	 * @return {array}        List of documentation links
	 */
	_this.getItemDocumentation = function( itemId ) {
		return $http.post('/leidos/custom/services/extras/documentation', { itemId: parseInt( itemId ) })
			.then( function( promise ) {
				return promise.data;
			})
	}
	/**
	 * Parse environments to match equivalent fontawesome icons
	 * @param  {array} items A list of ARS items
	 * @return {array}       Same list of items with parsed environments
	 */
	function envToFontAwesome( items ) {
		items = items.split('"');
		var _fontAwesome = ["-", "-", "linux", "osx", "ios", "windows", "android"];
		var _parsedItems = [], environment;
		angular.forEach( items, function( item, index ) {
			if( index % 2 ) {
				environment = _fontAwesome[ item ];
				_parsedItems.push({
					icon: ( environment == 'osx' || environment == 'ios' ) ? 'apple' : environment,
					name: environment
				});
			}
		});

		return _parsedItems;
	}

	return _this;
}])