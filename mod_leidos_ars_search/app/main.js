



'use strict';

/**
* Leidos.OSADP.Akeeba.Application.Search Module
*
* Description
* Main module for displaying Akeeba Release Systems'
* releases as well as provide a search and sort function.
*/
angular.module('Leidos.OSADP.Akeeba.Application.Search', ['ui.router', 'ngSanitize']);

;(function(window, document, $, FastClick, undefined) {
  $(document).ready( function() {
  	// FastClick removes the 300ms delay on touch devices for click events like links etc..
    FastClick.attach(document.body);
    // Since we're waiting for the PHP to load the DOM we need to bootstrap our Angular app
    // in this manner instead of the usual ng-app attribute
  	var arsSearcher = $('#arsSearch');
   	angular.bootstrap( arsSearcher, ['Leidos.OSADP.Akeeba.Application.Search']);
  });

 	$('.ars-categories--mobile').ready( function() {
 		var btn = $('.ars-categories--mobile').find('.btn');
 		btn.click(function() {
 			$('.ars-categories__item').toggle();
 		})
 	})

})(window, document, jQuery, FastClick);