
;(function( window, document, $, undefined) {
    $(function() {
      var notes = CKEDITOR.replace( 'notes' )
      var capabilities = CKEDITOR.replace( 'capabilities' )
      
      // add validation for our notes editor
      notes.on( 'required', function( evt ) {
        $('.notes-editor').addClass('required')
        console.log(notes)
        evt.cancel()
      } )
      notes.on('focus', function( evt ) {
        console.log(notes.getData())
        if( notes.getData() != '' )
          $('.notes-editor').removeClass('required')
        else
          $('.notes-editor').addClass('required')
      })
      notes.on('change', function( evt ) {
        console.log(notes.getData())
        if( notes.getData() != '' )
          $('.notes-editor').removeClass('required')
        else
          $('.notes-editor').addClass('required')
      })

      // Alert on success
      var saveSuccess = $('.new-form').data('save-success')
      if(saveSuccess > 0)
        if(saveSuccess) {
          $('.alert.alert-success').removeClass('hidden')
        } else {
          $('.alert.alert-danger').removeClass('hidden')
        }
      // initiate jquery ui datepicker
      $('#date').datepicker({
        dateFormat: 'mm-dd-yy'
      })
      // trigger submit on joomla toolbar save button click event
      $('#toolbar-apply, #toolbar-save > button').find('button').click(function(e) {
        e.stopPropagation()
        $('#btnSubmit').trigger('click')
      })
    })
  })( window, document, jQuery);