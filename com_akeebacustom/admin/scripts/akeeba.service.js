'use strict';


// contains services for our akeeba component
// pass in jQuery as $
var AkeebaService = (function( $ ) {
	'use strict';
	// constructor
	function AkeebaService(args) {
		// enforces new
		if (!(this instanceof AkeebaService)) {
			return new AkeebaService(args);
		}
		// constructor body
		this.getInformation();
		// promise loading applications before using app data for info
		this.getApplications().done( this.getApplicationInfo ).done( this.getApplicationDocs );
	}
	// add a way to sort arrays by object's title
	AkeebaService.prototype.SortByTitle = function(a, b){
	  var aName = a.title.toLowerCase();
	  var bName = b.title.toLowerCase();
	  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
	}

	// get category information
	AkeebaService.prototype.getInformation = function() {
		// get selected category id
		var data = {
			categoryId: $('#akeebaCategories option:selected').val()
		}
		if( data.categoryId == 0 ) {
			$('#categoryIcon').attr('disabled', 'disabled');
			var promise = $.post('/bookshop/leidos/custom/services/extras/category', data);
			promise.done( function( data ) {
				data = (typeof data == 'string') ? JSON.parse( data ) : data;
				var categoryIcon = ( data != null ) ? data.icon_url : '';
				$('#categoryIcon').val( categoryIcon );
				return categoryIcon;
			});
		} else {
			$('#categoryIcon').attr('disabled', false);
			// request for data of the selected category
			var promise = $.post('/bookshop/leidos/custom/services/extras/category', data);
			promise.done( function( data ) {
				data = (typeof data == 'string') ? JSON.parse( data ) : data;
				var categoryIcon = ( data != null ) ? data.icon_url : '';
				$('#categoryIcon').val( categoryIcon );
				return categoryIcon;
			});
		}
	};
	// get applications under selected category
	AkeebaService.prototype.getApplications = function() {
		var _this = this;
		var categoryId = $('#akeebaCategories option:selected').val();
		if( categoryId == 0 ) {
			var itemsPromise = $.getJSON('/bookshop/leidos/custom/services/ars/items');
		} else {
			var itemsPromise = $.getJSON('/bookshop/leidos/custom/services/ars/items/category/' + categoryId);
		}
		var defer = $.Deferred();
		itemsPromise.done( function( data ) {
			// get the applications from the promise
			var applications = data;
			if( applications != null ) applications.sort( _this.SortByTitle );
			// remove all options prior to adding new ones
			$('#akeebaApplications').find('option').remove().end();
			// add applications to our select element
			if( applications != null ) {
				$.each( applications, function( index, app ) {
					$('#akeebaApplications').append('<option value="' + app.id + '">' + app.title + '</option>');
				})
			} else {
				$('#akeebaApplications').append('<option value="null">No applications found</option>');
			}
			defer.resolve();
		})
		return defer.promise();
	};
	// get information for selected application
	AkeebaService.prototype.getApplicationInfo = function() {
		var data = {
			'itemId': $('#akeebaApplications option:selected').val()
		}
		var infoPromise = $.post('/bookshop/leidos/custom/services/extras/item', data );
		infoPromise.done( function( data ) {
			// get the applications from the promise
			var info = JSON.parse( data );
			if( info != null && info != 'null' ) {
				$('#itemIcon').val( info.icon_url );
				$('#description').val( info.short_description );
				$('#mainDiscussion').val(info.discussion_url);
				$('#issuesDiscussion').val(info.issues_url);
			} else {
				$('#itemIcon').val('');
				$('#description').val('');
				$('#mainDiscussion').val('');
				$('#issuesDiscussion').val('');
			}
		});
	};

	AkeebaService.prototype.saveCategoryInfo = function( data ) {
		var dfd = $.Deferred();
		$.post('/bookshop/leidos/custom/services/extras/category', data, function( response ) {
			dfd.resolve( response );
		})

		return dfd.promise();
	};

	AkeebaService.prototype.saveApplicationInfo = function( data ) {
		var dfd = $.Deferred();
		$.post('/bookshop/leidos/custom/services/extras/item', data, function( response ) {
			dfd.resolve( response );
		})

		return dfd.promise();
	};

	AkeebaService.prototype.saveApplicationDocs = function( data ) {
		var dfd = $.Deferred();
		$.post('/bookshop/leidos/custom/services/extras/documentation', data, function( response ) {
			dfd.resolve( response );
		})

		return dfd.promise();
	};

	AkeebaService.prototype.getApplicationDocs = function() {
		var dfd = $.Deferred();
		var data = {
			itemId: parseInt($('#akeebaApplications option:selected').val())
		}

		$.post('/bookshop/leidos/custom/services/extras/documentation', data, function( response ) {
			dfd.resolve( response );
			var docs = $('#appDocumentation li');
			var links = JSON.parse( response );
			if( links != null && links != 'null' && links != '[]' ) {
				$.each(docs, function( index, doc ) {
					if( links[index] != undefined ) {
						$(doc).find('.docLink').val( links[index].documentation_link );
						$(doc).find('.docText').val( links[index].documentation_text );
					} else {
						$(doc).find('.docLink').val('');
						$(doc).find('.docText').val('');
					}
				});
			} else {
				$.each(docs, function( index, doc ) {
					$(doc).find('.docLink').val('');
					$(doc).find('.docText').val('');
				});
			}
		})

		return dfd.promise();
	};
	// return our service
	return AkeebaService;
}( jQuery ));