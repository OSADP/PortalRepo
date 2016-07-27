

// iife to protect scope
(function(window, document, $, undefined) {
	'use strict';
	// on document ready
	$(function() {
		// **** INITIALIZATION **** //
		// get categories container
		var main = $('.akeeba-categories');
		// get categories boxes/item
		var listCategories = $('.akeeba-categories li');
		// get our submit button
		var submit = $('.osadp-btn-active');
		// initialize our service which gather data from our
		// database for categories if any, and save the main
		// category if no record is found
		var multiService = new MultiCategoriesService();
		multiService.initialize( window._itemId, window._mainCategory )
		.then( function( data ) {
			if( data.category_ids ) {
				data.category_ids = data.category_ids.split(',');
			}
			loadCategories( listCategories, data.category_ids );
		});
		// instantiate our alert class
		var osadpAlert = new OsadpAlert();
		// initialize and make sure it's initially hidden
		osadpAlert.initialize( $('.osadp-alert') );
		// **** //

		// **** EVENTS **** //
		// trigger checkbox on li element click
		listCategories.click(function() {
			var checkbox = $(this).find('input');
			// trigger a click event
			checkbox.trigger('click');
		})
		// listen to click event and set as 'selected' if
		// checkbox is checked
		listCategories.find('input').change(function( event ) {
			event.stopPropagation();
			toggleSelection( $(this) );
		});
		// save or update our item's categories
		submit.click( function( event ) {
			event.stopPropagation();
			// hide our alert first
			osadpAlert.hide();
			// build the data we will send to our service
			multiService.postCategories( window._itemId, selectedCategories())
			.done( function( data ) {
				if ( data ) {
					osadpAlert.success()
						.message('Success: Categories are updated!');
				} else {
					osadpAlert.fail()
						.message('Error: Categories failed updating.');
				}
			})
			.fail(function() {
				osadpAlert.fail()
					.message('Error: Request failed.');
			})
			.always( function() {
				// clear previous alert popup timeouts
				if( osadpAlert.previous )
					clearTimeout( osadpAlert.previous );
				osadpAlert.previous = osadpAlert.popup( 3000 );
			});
		});
		// **** //

		loadCategories( listCategories );

		function gatherCategories() {
			var categories = [];
			categories.push( window._mainCategory, selectedCategories() );
			return categories;
		}

		function selectedCategories () {
			var result = [];
			result.push( window._mainCategory );
			for( var i = 0, len = listCategories.length; i < len; i++ ) {
				var item = $( listCategories[i] );
				if( item.hasClass('selected') ) {
					result.push( item.find('input').val() );
				}
			}
			return result;
		}
		// look through a list of categories and toggles selection
		// of the ones within the list
		// @params list = the element containing a list of elements as categories
		// @params currentCategories = array of category ids.
		function loadCategories( list, currentCategories ) {
			var categoryId, item, checkbox;
			if( ! currentCategories )
				currentCategories = gatherCategories();
			for( var i = 0, len = currentCategories.length; i < len; i++ ) {
				categoryId = currentCategories[i];
				for( var x = 0, len2 = list.length; x < len2; x++ ) {
					item = $( list[x] );
					checkbox = item.find('input');
					if( checkbox.val() == categoryId ) {
						if( checkbox.val() == window._mainCategory ) {
							checkbox.prop('disabled', true);
							item.addClass('main-category');
						} else {
							item.addClass('selected');
						}
					}
				}
			}
		}
		// function for toggling selection of categories
		// @params $element = the list element containing lists of categories
		function toggleSelection( $element ) {
			var listElement = $element.closest('li');
			// check if checked
			if( $element.prop('checked') ) {
				$element.closest('li').addClass('selected');
			} else {
				listElement.removeClass('selected');
			}
		}

	})
})(window, document, jQuery);