



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
 			$('.ars-categories__item').toggleClass('hidden-xs hidden-sm');
 			var icon = btn.find('.fa');
 			if( icon.hasClass('fa-angle-down') ) {
 				icon.removeClass('fa-angle-down').addClass('fa-angle-up');
 			} else {
 				icon.removeClass('fa-angle-up').addClass('fa-angle-down');
 			}
 		})
 	})

})(window, document, jQuery, FastClick);