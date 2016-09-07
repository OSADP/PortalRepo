

angular.module('Leidos.OSADP.Akeeba.Application.Search')

.directive('akeebaitem', function() {
	// Runs during compile
	return {
		scope: {
			item: '=',
			toggleKeywords: '=displaykeywords',
			showKeywordTags: '=showkeywordtags',
			activeKeyword: '=activekeyword'
		},
		restrict: 'EA', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: '/modules/mod_leidos_ars_search/app/partials/item.ng.html',
		link: function($scope, iElm, iAttrs, controller) {
      // default to true
      $scope.showKeywordTags = ( $scope.showKeywordTags == undefined ) ? true : $scope.showKeywordTags;
		}
	};
});