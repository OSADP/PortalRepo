import AkeebaService from './akeeba.service';
import $ from 'jquery'
// require('../styles/akeeba.form.css');
// const $ = require('jquery');

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
        akeeba.getApplicationInfo( akeeba )
      })
      .then( akeeba.getApplicationDocs );
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
        if( response === true ) alert('Category Icon for ' + $('#akeebaCategories option:selected').text() + ' is saved.');
      })
    });
    // save information given for selected application
    $('#akeebaItemSave').click(function( evnt ) {
      evnt.preventDefault();
      // Modify keyword input to ensure every string
      // is lowercased and trimmed of leading or trailing spaces
      var keywordInput = $('#arsKeywords');
      var arrKeywords = keywordInput.val().split(',');
      var arrKeywords = $.map(arrKeywords, function( keyword ) {
        return keyword.toLowerCase().trim();
      })
      keywordInput.val(arrKeywords.join());

      // Get data from user input values
      let data = {
        itemId: $('#akeebaApplications option:selected').val(),
        iconUrl: $('#itemIcon').val(),
        shortDescription: $('#description').val(),
        mainDiscussion: $('#mainDiscussion').val(),
        issuesDiscussion: $('#issuesDiscussion').val(),
        keywords: $('#arsKeywords').val().toLowerCase()
      }

      if( ! isNaN(data.itemId) ) {
        akeeba.saveApplicationInfo( data ).done( function( response ) {
          response = response.replace(/\s/g, '');
          if( response === true ) alert('Application Information for ' + $('#akeebaApplications option:selected').text() + ' is saved.');
        })
      } else {
        alert('Error: No valid application selected.');
      }
    });
  })
})();