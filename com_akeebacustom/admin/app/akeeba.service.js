import $ from 'jquery'
/**
 * 
 */
export default class AkeebaService {
	constructor() {
		// promise loading applications before using app data for info
		this.getApplications()
			.done( this.getApplicationInfo )
			.done( this.getApplicationDocs )
	}

	sortByTitle(a, b){
	  let aName = a.title.toLowerCase()
	  let bName = b.title.toLowerCase()
	  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0))
	}
	// get applications under selected category
	getApplications() {
		let _this = this
		let categoryId = $('#akeebaCategories option:selected').val()
		let itemsPromise = null
		if( categoryId === 'all' ) {
			itemsPromise = $.getJSON('/leidos/custom/services/ars/items')
		} else {
			itemsPromise = $.getJSON('/leidos/custom/services/ars/items/category/' + categoryId)
		}
		let defer = $.Deferred()
		itemsPromise.done( function( data ) {
			// get the applications from the promise
			let applications = data
			if( applications.length !== 0 ) applications.sort( _this.sortByTitle )
			// remove all options prior to adding new ones
			$('#akeebaApplications').find('option').remove().end()
			// add applications to our select element
			if( applications.length !== 0 ) {
				$.each( applications, function( index, app ) {
					$('#akeebaApplications').append('<option value="' + app.id + '">' + app.title + '</option>')
				})
			} else {
				$('#akeebaApplications').append('<option value="null">No applications found</option>')
			}
			defer.resolve()
		})
		return defer.promise()
	}
	// get information for selected application
	getApplicationInfo() {
		// let _self = new AkeebaService()
		let data = {
			'itemId': $('#akeebaApplications option:selected').val()
		}

		if( data.itemId ) {
			let infoPromise = $.post('/leidos/custom/services/extras/item', data )
			infoPromise.done( function( data ) {
				// get the applications from the promise
				let info = JSON.parse( data )
				if( info != null && info != 'null' ) {
					$('#itemIcon').val( info.icon_url )
					$('#description').val( info.short_description )
					$('#mainDiscussion').val(info.discussion_url)
					$('#issuesDiscussion').val(info.issues_url)
					$('#arsKeywords').val(info.keywords)
				} else {
					$('#itemIcon').val('')
					$('#description').val('')
					$('#mainDiscussion').val('')
					$('#issuesDiscussion').val('')
				}
			})
		} else {
			$('#itemIcon').val('')
			$('#description').val('')
			$('#mainDiscussion').val('')
			$('#issuesDiscussion').val('')
			$('#arsKeywords').val('')
		}
	}

	saveCategoryInfo( data ) {
		let dfd = $.Deferred()
		$.post('/leidos/custom/services/extras/category', data, function( response ) {
			dfd.resolve( response )
		})

		return dfd.promise()
	}

	saveApplicationInfo( data ) {
		let dfd = $.Deferred()
		$.post('/leidos/custom/services/extras/item', data, function( response ) {
			dfd.resolve( response )
		})

		return dfd.promise()
	}

	getApplicationDocs() {
		let dfd = $.Deferred()
		let data = {
			itemId: parseInt($('#akeebaApplications option:selected').val())
		}

    $('#akeebaApplications').trigger('app:change', data);

		return dfd.promise()
	}

}