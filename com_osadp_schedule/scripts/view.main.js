

'use strict';

angular.module('ReleaseSchedule', [])

  .provider('$Moment', function() {
    this.$get = function() {
      return moment
    }
  })

  .factory('apiSchedules', ['$http', function($http){
    return {
      all: function() {
        return $http.get('/leidos/custom/services/schedules/every', function( promise ) {
          return promise
        })
      },
      get: function( id ) {
        return $http.get('/leidos/custom/services/schedules/get' + id, function( promise ) {
          return promise
        })
      },
      delete: function( id ) {
        return $http.post('/leidos/custom/services/schedules/delete', { id: id }, function( promise ) {
          return promise
        })
      }
    }
  }])

  .controller('ScheduleCtrl', ['apiSchedules', '$Moment', '$scope', '$timeout', function(schedules, moment, $scope, $timeout) {
    $scope.reverseOrder = true
    var _ctrl = this

    schedules.all().then(function( promise ) {
      var allSchedules = promise.data
      angular.forEach(allSchedules, function(schedule, index) {
        schedule.formattedDate = moment(schedule.date).format('MMM DD, YYYY')
      })
      _ctrl.schedules = allSchedules
    })

    _ctrl.editRelease = function(id) {
      location.href = '/administrator/index.php?option=com_osadp_schedule&view=edit&projectId=' + id
    }

    _ctrl.onKeyupEditRelease = function(event, id) {
      if(event.which === 13) {
        event.preventDefault();
        _ctrl.editRelease(id)
      }
    }

    _ctrl.changeOrder = function ( order ) {
      $scope.scheduleOrder = order
      $scope.reverseOrder = ! $scope.reverseOrder
    }

    _ctrl.deleteRelease = function ( $event, id, name ) {
      $event.preventDefault();
      var confirm = window.confirm('Are you sure you want to delete ' + name + '?');
      if( confirm ) var itemDeleted = schedules.delete( id );
      if( itemDeleted ) {
        $timeout(function() {
          schedules.all().then(function( promise ) {
            var allSchedules = promise.data
            angular.forEach(allSchedules, function(schedule, index) {
              schedule.formattedDate = moment(schedule.date).format('MMM DD, YYYY')
            })
            _ctrl.schedules = allSchedules
          })
        }, 100)
      }
    }
  }])