

'use strict';

(function(window, document, $, undefined){

	$(function() {
		var $element = $('.osadp-footer');
		// detects modifications to our DOM e.g. Asynchronous DOM changes
		$('document').bind("DOMSubtreeModified", toggleFooter);
		// run when footer loads in our DOM
		$element.ready(function() { 
			toggleFooter();
		});
		// detect scroll, might need requestFra
		$(window).scroll(function() {
			setTimeout(toggleFooter, 100);
		});

		function toggleFooter() {
			if($(window).scrollTop() + $(window).height() + 80 >= $(document).height()) {
	 			$element.show();
	   	} else {
				$element.hide();
			}
		}
	});

})(window, document, jQuery);