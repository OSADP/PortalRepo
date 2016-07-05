

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
      $scope.day = moment($scope.schedule.date).format('D')
      $scope.date = moment($scope.schedule.date).format('MMM YYYY')
      $scope.$parent.hideLoader()
    }
  };
}]);