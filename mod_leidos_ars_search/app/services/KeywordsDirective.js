

angular.module('Leidos.OSADP.Akeeba.Application.Search')

.directive('keywordsDisplay', function(){
  return {
    scope: {
      items: '=', // all items
      keyword: '=', // keyword selected
      toggle: '=', // function to toggle keyword template display
      show: '=' // toggle display status
    },
    restrict: 'EA', // E = Element, A = Attribute, C = Class, M = Comment
    templateUrl: '/modules/mod_leidos_ars_search/app/partials/keywords.ng.html',
    link: function($scope, iElm, iAttrs, controller) {
    }
  };
});