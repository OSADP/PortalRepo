
/**
*  Module
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')

.service('AkeebaService', ['$http', function( $http ){
	var _this = this;

	_this.getAllCategories = function() {
		return $http.get('/osadp/leidos/custom/services/ars/categories')
			.then( function( promise ) {
				return promise.data;
			})
	}

	_this.getCategory = function( categoryId ) {
		return $http.get('/osadp/leidos/custom/services/ars/categories/' + categoryId)
			.then( function( promise ) {
				return promise.data;
			})
	}

	_this.getAllItems = function() {
		return $http.get('/osadp/leidos/custom/services/ars/items')
			.then( function( promise ) {
				angular.forEach( promise.data, function( item ) {
					item.environments = envToFontAwesome( item.environments );
				});
				return promise.data;
			})
	}

	_this.getItemsByCategory = function( categoryId ) {
		return $http.get('/osadp/leidos/custom/services/ars/items')
			.then( function( promise ) {
				var _parsedItems= [];
				angular.forEach( promise.data, function( item ) {
					if( item.release.category.id == categoryId ) {
						item.environments = envToFontAwesome( item.environments );
						_parsedItems.push( item );
					}
				});
				return _parsedItems;
			})
	}

	_this.getOtherItems = function( categoryId, itemId ) {
		return $http.get('/osadp/leidos/custom/services/ars/items')
			.then( function( promise ) {
				var _parsedItems= [];
				angular.forEach( promise.data, function( item ) {
					if( item.release.category.id == categoryId && item.id != itemId ) {
						item.environments = envToFontAwesome( item.environments );
						_parsedItems.push( item );
					}
				});
				return _parsedItems;
			})
	}

	_this.getItem = function( itemId ) {
		return $http.get('/osadp/leidos/custom/services/ars/items/' + itemId)
			.then( function( promise ) {
				promise.data.environments = envToFontAwesome( promise.data.environments );
				return promise.data;
			})
	}

	_this.getItemDocumentation = function( itemId ) {
		return $http.post('/osadp/leidos/custom/services/extras/documentation', { itemId: parseInt( itemId ) })
			.then( function( promise ) {
				return promise.data;
			})
	}

	// parse environments to match equivalent fontawesome icons
	function envToFontAwesome( items ) {
		items = items.split('"');
		var _fontAwesome = ["-", "-", "linux", "apple", "apple", "windows", "android"];
		var _parsedItems = [];
		angular.forEach( items, function( item, index ) {
			if( index % 2 ) _parsedItems.push( _fontAwesome[ item ] );
		});

		return _parsedItems;
	}

	return _this;
}])