

'use strict';

(function(window, document, $, undefined){

	$(function() {
		var $element = $('.osadp-footer');
		// detects modifications to our DOM e.g. Asynchronous DOM changes
		$('document').bind("DOMSubtreeModified", toggleFooter);
		$element.on('OSADPFooterToggle', toggleFooter);
		// run when footer loads in our DOM
		$element.ready( function() { 
			toggleFooter();
		});
		// detect scroll, might need requestFra
		$(window).scroll(function() {
			setTimeout(toggleFooter, 100);
		});
		// function to show/hide the footer
		function toggleFooter() {
			console.info('Info: Footer toggled.');
			if($(window).scrollTop() + $(window).height() + 80 >= $(document).height()) {
	 			$element.show();
	   	} else {
				$element.hide();
			}
		}
	});

})(window, document, jQuery);