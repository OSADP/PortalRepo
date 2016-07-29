const $ = require('jquery')
/**
 * 
 */
export default class AkeebaService {
	constructor() {
		let _this = this
		// constructor body
		this.getInformation()
		// promise loading applications before using app data for info
		this.getApplications().done(this.getApplicationInfo).done( this.getApplicationDocs )
	}

	SortByTitle(a, b){
	  let aName = a.title.toLowerCase()
	  let bName = b.title.toLowerCase()
	  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0))
	}

	// get category information
	getInformation() {
		// get selected category id
		let data = {
			categoryId: $('#akeebaCategories option:selected').val()
		}
		if( data.categoryId == 0 ) {
			$('#categoryIcon').attr('disabled', 'disabled')
			let promise = $.post('/leidos/custom/services/extras/category', data)
			promise.done( function( data ) {
				data = (typeof data == 'string') ? JSON.parse( data ) : data
				let categoryIcon = ( data != null ) ? data.icon_url : ''
				$('#categoryIcon').val( categoryIcon )
				return categoryIcon
			})
		} else {
			$('#categoryIcon').attr('disabled', false)
			// request for data of the selected category
			let promise = $.post('/leidos/custom/services/extras/category', data)
			promise.done( function( data ) {
				data = (typeof data == 'string') ? JSON.parse( data ) : data
				let categoryIcon = ( data != null ) ? data.icon_url : ''
				$('#categoryIcon').val( categoryIcon )
				return categoryIcon
			})
		}
	}
	// get applications under selected category
	getApplications() {
		let _this = this
		let categoryId = $('#akeebaCategories option:selected').val()
		let itemsPromise = null
		if( parseInt(categoryId) === 0 ) {
			itemsPromise = $.getJSON('/leidos/custom/services/ars/items')
		} else {
			itemsPromise = $.getJSON('/leidos/custom/services/ars/items/category/' + categoryId)
		}
		let defer = $.Deferred()
		itemsPromise.done( function( data ) {
			// get the applications from the promise
			let applications = data
			if( applications != null ) applications.sort( _this.SortByTitle )
			// remove all options prior to adding new ones
			$('#akeebaApplications').find('option').remove().end()
			// add applications to our select element
			if( applications != null ) {
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
		let infoPromise = $.post('/leidos/custom/services/extras/item', data )
		infoPromise.done( function( data ) {
			// get the applications from the promise
			let info = JSON.parse( data )
			if( info != null && info != 'null' ) {
				$('#itemIcon').val( info.icon_url )
				$('#description').val( info.short_description )
				$('#mainDiscussion').val(info.discussion_url)
				$('#issuesDiscussion').val(info.issues_url)

				$('#arsKeywords').find('span').remove()
		    $('#arsKeywords input').css('display', 'block')
		    let keywords = info.keywords
		  	if( ! Array.isArray(keywords) && keywords !== null )
		  		keywords = keywords.split(',');
		    $.each(keywords, function(index, keyword) {
		      let span = $('<span></span>');
		      $('#arsKeywords').prepend(span.text(keyword))
		    })
		    if( keywords !== null && keywords.length >= 5 ) {
		      $('#arsKeywords input').css('display', 'none');
		    } else {
		      $('#arsKeywords input').css('display', 'block');
		    }
			} else {
				$('#itemIcon').val('')
				$('#description').val('')
				$('#mainDiscussion').val('')
				$('#issuesDiscussion').val('')
			}
		})
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

	saveApplicationDocs( data ) {
		let dfd = $.Deferred()
		$.post('/leidos/custom/services/extras/documentation', data, function( response ) {
			dfd.resolve( response )
		})

		return dfd.promise()
	}

	getApplicationDocs() {
		let dfd = $.Deferred()
		let data = {
			itemId: parseInt($('#akeebaApplications option:selected').val())
		}

		$.post('/leidos/custom/services/extras/documentation', data, function( response ) {
			dfd.resolve( response )
			let docs = $('#appDocumentation li')
			let links = JSON.parse( response )
			if( links != null && links != 'null' && links != '[]' ) {
				$.each(docs, function( index, doc ) {
					if( links[index] != undefined ) {
						$(doc).find('.docLink').val( links[index].documentation_link )
						$(doc).find('.docText').val( links[index].documentation_text )
					} else {
						$(doc).find('.docLink').val('')
						$(doc).find('.docText').val('')
					}
				})
			} else {
				$.each(docs, function( index, doc ) {
					$(doc).find('.docLink').val('')
					$(doc).find('.docText').val('')
				})
			}
		})

		return dfd.promise()
	}

}