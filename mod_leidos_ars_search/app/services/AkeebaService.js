
/**
*  Module
*
* Description
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search')

.service('AkeebaService', ['$http', function( $http ){
	var _this = this;

	_this.getAll = function() {
		return $http.get('/osadp/leidos/custom/services/akeeba/items')
			.then( function( promise ) {
				return promise.data;
			})
	}

	_this.getReleased = function() {
		return $http.get('/osadp/leidos/custom/services/akeeba/items')
			.then( function( promise ) {
				var items = promise.data;
				var parsedItems = [];
				angular.forEach( items, function( item ) {
					if( item.release ) {
						if( item.release.category ) {
							parsedItems.push( item )
						}
					}
				})
				return parsedItems;
			})
	}

	return _this;
}])