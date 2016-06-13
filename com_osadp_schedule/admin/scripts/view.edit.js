

'use strict';

(function(window, document, $, undefined) {
  $(function() {
    var updateSuccess = $('#mainForm').data('update-success')
    if( updateSuccess > 0 ) {
      $('.alert-success').removeClass('hidden')
    } else if( updateSuccess === 0 ) {
      $('.alert-danger').removeClass('hidden')
    }
    CKEDITOR.replace( 'notes' );
    CKEDITOR.replace( 'capabilities' );
    // Initiate our jquery-ui datepicker
    $('#date').datepicker({
      dateFormat: 'mm-dd-yy'
    });
    // Trigger form submit when the Save button on the toolbar is clicked
    $('#toolbar-save').find('button').click(function(e) {
      e.stopPropagation()
      $('#btnSubmit').trigger('click')
    })
  })
})(window, document, jQuery)