require('../styles/keywords.css');

import AkeebaService from './akeeba.service';
const $ = require('jquery');

(function() {
  'use strict';
  var akeebaservice = new AkeebaService();

  $(function(){
    var keywords = $('#arsKeywords span');
    countKeywords();
    $("#arsKeywords input").on({
      focusout : function() {
        var txt= this.value.replace(/[^a-z0-9\+\-\.\# ]/ig,''); // allowed characters
        if( keywords.length < 5 )
          if(txt) $("<span/>",{text:txt.toLowerCase(), insertBefore:this});
        this.value="";
        countKeywords();
      },
      keyup : function(ev) {
        if( keywords.length < 5 )
          if(/(188|13)/.test(ev.which)) $(this).focusout();
      }
    });

    function countKeywords() {
      keywords = $('#arsKeywords span');
      if( keywords.length >= 5 ) {
        $('#arsKeywords input').css('display', 'none');
      } else {
        $('#arsKeywords input').css('display', 'block');
      }
    }

    $('#arsKeywords').on('click', 'span', function() {
      if(confirm("Remove "+ $(this).text() +"?")) $(this).remove(); 
      countKeywords();
    });
  });
})()