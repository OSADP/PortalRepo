if( jQuery ) {
	'use strict';

	var OsadpAlert = (function( $ ) {
		// constructor
		function OsadpAlert( args ) {
			// enforces new
			if (!(this instanceof OsadpAlert)) {
				return new OsadpAlert( args );
			}
		}
		// bootstrap our object
		OsadpAlert.prototype.initialize = function( element ) {
			console.log('Class OsadpAlert initialized.');
			var _this = this;
			// set our alert element
			_this._element = element;
			// hide it on init
			_this.hide();
			_this._element.find('.icon-cancel').click(function() {
				_this.hide();
			})
			// enable chaning of functions
			return this;
		};
		// hide our element
		OsadpAlert.prototype.hide = function() {
			this._element.animate({ opacity: 0 }, 300);
			// enable chaning of functions
			return this;
		};
		// show our alert element
		OsadpAlert.prototype.show = function() {
			this._element.animate({ opacity: 1 }, 300);
			// enable chaning of functions
			return this;
		};
		// set alert as a success
		OsadpAlert.prototype.success = function() {
			this._element.removeClass('fail');
			this._element.addClass('success');
			// enable chaning of functions
			return this;
		};
		// set alert as a failure
		OsadpAlert.prototype.fail = function() {
			this._element.removeClass('success');
			this._element.addClass('fail');
			// enable chaning of functions
			return this;
		};
		// change the message in the alert
		OsadpAlert.prototype.message = function( message ) {
			this._element.find('.message').text( message );
			// enable chaning of functions
			return this;
		};
		// create a popup where it automatically hides after some time
		OsadpAlert.prototype.popup = function( seconds ) {
			var _this = this;
			// set default to 2 seconds
			seconds = seconds || 2000;
			_this.show();
			return setTimeout(function() {
				_this.hide();
			}, seconds);
		};

		return OsadpAlert;

	})( jQuery );

} else {
	console.error('Error: jQuery is required.');
}