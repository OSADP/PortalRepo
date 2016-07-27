;(function(window, document, $, undefined) {
  'use strict';
  $(function() {
    // Show success or fail errors
    var updateSuccess = $('#mainForm').data('update-success')
    if( updateSuccess > 0 ) {
      $('.alert-success').removeClass('hidden')
    } else if( updateSuccess === 0 ) {
      $('.alert-danger').removeClass('hidden')
    }
    // CKEDITOR is a plugin that transforms any passed on textarea
    // into a robust text editor
    CKEDITOR.replace( 'notes' );
    CKEDITOR.replace( 'capabilities' );
    // Initiate our jquery-ui datepicker
    $('#date').datepicker({
      dateFormat: 'mm-dd-yy'
    });
    // Trigger form submit when the Save button on the toolbar is clicked
    $('#toolbar-apply, #toolbar-save').find('button').click(function(e) {
      e.stopPropagation()
      $('#btnSubmit').trigger('click')
    })
  })
})(window, document, jQuery);