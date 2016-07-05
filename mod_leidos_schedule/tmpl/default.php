<?php defined('_JEXEC') or die; ?>

<?php JHTML::script('modules/mod_leidos_schedule/lib/angular/angular.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/lib/angular-sanitize/angular-sanitize.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/lib/moment/min/moment.min.js'); ?>

<?php JHTML::stylesheet('modules/mod_leidos_schedule/styles/main.css'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/main.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/directives/schedule/directive.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/directives/toolbar/directive.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/app.js'); ?>
<?php //JHTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js'); ?>


<div class="module-name-content" ng-app="ScheduleApp">
  <div class="">
    <h2>OPEN SOURCE RELEASE SCHEDULE</h2>
  </div>
  <div class="osadp-schedule clearfix" ng-controller="ComingSoonCtrl as soon">
    <!-- <h3 class="">Coming Soon</h3> -->
    <p class="loader" ng-if="loading">Loading...</p>
    <!-- Toolbar directive -->
    <div data-schedule-toolbar data-search="soon.searchText" data-order="soon.order" data-limit="soon.limit" data-page="soon.page" data-pages="soon.schedules.length" data-availability="soon.availability"></div>
    <!-- Display releases -->
    <div class="row">
      <!-- Display all Coming Soon releases filter by availability -->
      <div class="col-lg-12 col-xs-12" ng-repeat="(kay, schedule) in soon.schedules[soon.page] | filter: soon.searchText | filter: { available: soon.availability } | orderBy: soon.order">
        <div data-schedule-item
          schedule="schedule"
          name="schedule.name"
          dma="schedule.dma"
          day="soon.moment(schedule.date).format('D')"
          date="(schedule.full_date == 1) ? soon.moment(schedule.date).format('MMMM YYYY') 
        : soon.moment(schedule.date).format('MMMM')"
          notes="schedule.notes"
          capabilities="schedule.capabilities"
          image="http://www.itsforge.net/images/ForApplications/CV-DSRC-Msg-Parser.png"
          url="schedule.url"
          new="schedule.isNew">
        </div>
        <!-- Coming Soon -->
      </div>
    </div>
  </div>
  <!-- Display available releases -->



</div>

<script>
  ;(function() {
    'use strict';
    // create our module in page to pass our php value
    angular.module('SchedulesValue', [])
    // create a value for all published releases
    .value('AllSchedules', <?php echo json_encode($all); ?>)
    // create a value for our release schedules
    .value('ComingSoonSchedules', <?php echo json_encode($comingSoon); ?>)
    // create a value for our release schedules
    .value('AvailableSchedules', <?php echo json_encode($available); ?>)
  })();
</script>