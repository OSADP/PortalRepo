;(function() {

  'use strict';
  
  angular.module('ScheduleApp', ['SchedulesValue', 'ScheduleDirective', 'ScheduleToolbar', 'ngSanitize'])
  // Controller for release schedules yet to be released
  .controller('ComingSoonCtrl', ['AllSchedules', '$scope', '$filter', ScheduleCtrl])
  // Controller for available release schedules
  // .controller('AvailableCtrl', ['AvailableSchedules', '$scope', ScheduleCtrl])

  function ScheduleCtrl( schedules, $scope, $filter ){
    $scope.loading = true
    $scope.hideLoader = function() {
      $scope.loading = false
    }
    // cache our controller
    var ctrl = this;
    // the current page in the pagination
    ctrl.page = 0;
    // add moment to our controller's space
    ctrl.moment = moment
    // the ordering of the schedules
    ctrl.order = '-date'
    // the number of schedules to display
    ctrl.limit = '5'
    // filter availability, default is blank which display all
    ctrl.availability == ''
    // add a new flag to schedules that are newly created
    schedules.forEach( function(schedule, index) {
      var thisDate = moment(schedule.created).startOf('day')
      // days_new defines how many days this schedule will be 
      // considered new
      var weekAgo = moment().subtract(schedule.days_new, 'days').startOf('day')
      schedule.isNew = thisDate.isAfter(weekAgo)
    });
    // use our paginate function to paginate schedules
    ctrl.schedules = paginater(schedules, ctrl.limit)
    // this function is in the scope to $digest changes
    $scope.changeLimit = function() {
      if(ctrl.limit == 'all')
        ctrl.schedules = paginater(schedules, 0)
      else
        ctrl.schedules = paginater(schedules, ctrl.limit)
    }

    $scope.updatePagination = function() {
      ctrl.schedules = paginater(schedules, ctrl.limit)
      return ctrl.schedules
    }


    function paginater(schedules, limit) {
      var filterByAvail = $filter('filter')(schedules, {available: ctrl.availability})
      var filterByOrder = $filter('orderBy')(filterByAvail, ctrl.order)
      return paginate(filterByOrder, limit)
    }
  }
  // allows to simulate pagination by creating an array that holds
  // items depending on the 'limit' variable of our scope
  function paginate( items, limit ) {
    if( limit != 'all' ) {
      var parsedItem = [];
      var x = 0;
      angular.forEach( items , function( stuff, index ) {
        parsedItem[x] = parsedItem[x] || [];
        parsedItem[x].push( stuff );
        if( items.length > limit )
          if( (index + 1) % limit == 0 ) {
            x += 1;
          }
      })

      return parsedItem;
    } else {
      if( items.length == 0 )
        return items;
      else
        return [items];
    }
  }

})();