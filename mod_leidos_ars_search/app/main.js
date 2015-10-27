



'use strict';

/**
* Leidos.OSADP.Akeeba.Application.Search Module
*
* Description
* Main module for displaying Akeeba Release Systems'
* applications as well as provide a search and sort function.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search', ['ui.router']);

;(function(window, document, $, undefined) {

	$(document).ready( function() {
		var arsSearcher = $('#arsSearch');
		angular.bootstrap( arsSearcher, ['Leidos.OSADP.Akeeba.Application.Search']);
	});

})(window, document, jQuery);