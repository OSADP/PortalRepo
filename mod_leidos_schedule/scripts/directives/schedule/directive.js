

'use strict';

angular.module('ScheduleDirective', [])

.directive('scheduleItem', ['$http', function($http){
  return {
    scope: {
      schedule: '=',
      image: '@'
    },
    restrict: 'A',
    templateUrl: '/modules/mod_leidos_schedule/scripts/directives/schedule/all.ng.html',
    link: function($scope, iElm, iAttrs, controller) {
      $scope.day = moment($scope.schedule.date).format('MMM')
      $scope.date = moment($scope.schedule.date).format('D, YYYY')
      if($scope.schedule.full_date == 0)
        $scope.date = moment($scope.schedule.date).format('YYYY')
      $scope.$parent.hideLoader()

      $scope.notesOverflowed = function() {
        var notesContainer = iElm.children()
        .children('.notes-container')[0];
        return notesContainer.scrollHeight > notesContainer.clientHeight || notesContainer.scrollWidth > notesContainer.clientWidth;
      }
    }
  };
}]);