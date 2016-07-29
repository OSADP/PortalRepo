import AkeebaService from './akeeba.service';
const $ = require('jquery');

;(function() {
  $(function() {
    // instantiate our service
    // var AkeebaService = require('./akeeba.service.js');
    var akeeba = new AkeebaService();
    // get information and applications under selected category
    $('#akeebaCategories').change( function( evnt ) {
      evnt.preventDefault();
      akeeba.getApplications()
      .then(function() {
        akeeba.getApplicationInfo(akeeba)
      })
      .then(akeeba.getApplicationDocs);
      akeeba.getInformation();
    });
    // get information for selected application
    $('#akeebaApplications').change( function( evnt ) {
      evnt.preventDefault();
      akeeba.getApplicationInfo();
      akeeba.getApplicationDocs();
    })
    // save information given for selected category
    $('#akeebaSave').click(function( evnt ) {
      evnt.preventDefault();
      var data = {
        categoryId: parseInt($('#akeebaCategories option:selected').val()),
        iconUrl: $('#categoryIcon').val()
      }
      akeeba.saveCategoryInfo( data ).then( function( response ) {
        if( response == true ) alert('Category Icon for ' + $('#akeebaCategories option:selected').text() + ' is saved.');
      })
    });
    // save information given for selected application
    $('#akeebaItemSave').click(function( evnt ) {
      evnt.preventDefault();
      let data = {
        itemId: $('#akeebaApplications option:selected').val(),
        iconUrl: $('#itemIcon').val(),
        shortDescription: $('#description').val(),
        mainDiscussion: $('#mainDiscussion').val(),
        issuesDiscussion: $('#issuesDiscussion').val()
      }
      // get our keywords into an array
      data.keywords = []
      $('#arsKeywords span').each(function(index, item) {
        data.keywords.push($(item).text());
      })

      if( ! isNaN(data.itemId) ) {
        akeeba.saveApplicationInfo( data ).done( function( response ) {
          console.log(response);
          response = response.replace(/\s/g, '');
          if( response == true ) alert('Application Information for ' + $('#akeebaApplications option:selected').text() + ' is saved.');
        })
      } else {
        alert('Error: No valid application selected.');
      }
    });
    // save documentations for selected application
    $('#akeebaDocSave').click( function( evnt ) {
      evnt.preventDefault();
      var docs = $('#appDocumentation li');
      var data = {
        itemId: $('#akeebaApplications option:selected').val(),
        links: []
      }
      if( ! isNaN( data.itemId ) ) {
        $.each(docs, function( index, doc ) {
          data.links.push({
            link: $(doc).find('.docLink').val(),
            text: $(doc).find('.docText').val()
          })
        });
        akeeba.saveApplicationDocs( data ).done( function( response ) {
          response.replace(/\s/g, '');
          if( response == true ) alert('Documentation for ' + $('#akeebaApplications option:selected').text() + ' is saved.');
        })
      } else {
        alert('Error: No valid application selected.');
      }
    })
  })
})();