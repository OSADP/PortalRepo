import $ from 'jquery'
/**
 * 
 */
export default class AkeebaService {
	constructor() {
		// promise loading applications before using app data for info
	}

	sortByTitle(a, b){
	  let aName = a.title.toLowerCase()
	  let bName = b.title.toLowerCase()
	  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0))
	}

	saveApplicationInfo( data ) {
		let dfd = $.Deferred()
		$.post('/leidos/custom/services/extras/item', data, function( response ) {
			dfd.resolve( response )
		})

		return dfd.promise()
	}

}