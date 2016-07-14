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
    var settings = {
      page: 0, // current page
      order: '-date', // sorting order
      limit: '5', // number of items to display
      availability: '0', // 0 = Coming Soon
      moment: moment // just referencing momentJS `bad practice`
    }
    // cache our controller adding our settings
    var _ctrl = angular.extend(this, settings);

    // add a new flag to schedules that are newly created
    schedules.forEach( function(schedule, index) {
      var thisDate = moment(schedule.created).startOf('day')
      // days_new defines how many days this schedule will be 
      // considered new
      var weekAgo = moment().subtract(schedule.days_new, 'days').startOf('day')
      schedule.isNew = thisDate.isAfter(weekAgo)
    });
    // use our paginate function to paginate schedules
    _ctrl.schedules = paginater(schedules, _ctrl.limit)
    // this function is in the scope to $digest changes
    $scope.changeLimit = function() {
      if(_ctrl.limit == 'all')
        _ctrl.schedules = paginater(schedules, 0)
      else
        _ctrl.schedules = paginater(schedules, _ctrl.limit)
    }

    $scope.updatePagination = function() {
      _ctrl.schedules = paginater(schedules, _ctrl.limit)
      return _ctrl.schedules
    }


    function paginater(schedules, limit) {
      var filterByAvail = $filter('filter')(schedules, {available: _ctrl.availability})
      var filterByOrder = $filter('orderBy')(filterByAvail, _ctrl.order)
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