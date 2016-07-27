// contains services for our akeeba component
// pass in jQuery as $
var MultiCategoriesService = (function( $ ) {
	'use strict';
	// constructor
	function MultiCategoriesService( args ) {
		// enforces new
		if (!(this instanceof MultiCategoriesService)) {
			return new MultiCategoriesService( args );
		}
	}
	// add a way to sort arrays by object's title
	MultiCategoriesService.prototype.SortByTitle = function(a, b){
	  var aName = a.title.toLowerCase();
	  var bName = b.title.toLowerCase();
	  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
	}

	// get category information
	MultiCategoriesService.prototype.initialize = function( itemId, categories ) {
		var _self = this;
		var defer = $.Deferred();
		$.get('/leidos/custom/services/multi/categories/' + itemId)
		.then( function Success( data ) {
			if( data ) {
				defer.resolve( data )
			} else {
				defer.resolve( _self.postCategories(itemId, categories) );
			}
		});
		return defer.promise();
	};
	// save categories together with their respective item id
	MultiCategoriesService.prototype.postCategories = function( itemId, categories ) {
		// build the data for our request
		var data = {
			'itemId': itemId,
			'categories': categories
		};
		return $.post('/leidos/custom/services/multi/save', data);
	};

	// return our service
	return MultiCategoriesService;
})( jQuery );