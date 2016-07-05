

'use strict';

/**
* ScheduleToolbar Module
*
* Description
*/
angular.module('ScheduleToolbar', [])

.directive('scheduleToolbar', function(){
  return {
    scope: {
      order: '=',
      limit: '=',
      search: '=',
      pages: '=',
      page: '=',
      availability: '='
    },
    templateUrl: '/modules/mod_leidos_schedule/scripts/directives/toolbar/tmpl.ng.html',
    link: function($scope, iElm, iAttrs, controller) {
      // change our directive's parent's limit, not very
      // elegant but it works for now
      $scope.$watch('limit', function (newVal, oldVal) {
        if( newVal != oldVal ) {
          // $scope.$parent is this directive's parent's controller;
          // we have a changeLimit function in the parent's $scope
          $scope.$parent.changeLimit($scope.limit)
          // reset our page to the first page
          $scope.page = 0
        }
      })
      // rebuild our pagination pages when number of pages
      // change
      $scope.$watch('pages', function(newVal, oldVal) {
        if( newVal !== oldVal) {
          buildPages()
        }
      })

      // GOTO: 63
      buildPages()

      // used by Prev & Next to update our pagination page
      $scope.updatePage = function( num ) {
        if( num < 0 && $scope.page != 0) {
          $scope.page += num
          $scope.selectedPage = ($scope.page + 1).toString()
        }
        else if( num > 0 && $scope.page < $scope.pages - 1 ) {
          $scope.page += num
          $scope.selectedPage = ($scope.page + 1).toString()
        }
      }
      // Change page according to the current page
      $scope.changePage = function($event) {
        console.log($event);
        $scope.page = parseInt($scope.selectedPage) - 1
      }

      // builds our pages select element's options
      function buildPages(callback) {
        // our pagination page numbering
        $scope.pagesOption = [];
        // build our pages for pagination
        for(var i = 1; i <= $scope.pages; i++) {
          if(i==1)
            $scope.pagesOption.push({
              number: i,
              active: true
            })
          else
            $scope.pagesOption.push({
              number: i,
              active: false
            })
        }
        // initially set selected page to the first page
        $scope.selectedPage = $scope.pagesOption[0].number.toString()
        // run callback if available
        if( callback ) callback()
      }
    }
  };
})