<?php defined('_JEXEC') or die; ?>

<?php //JHTML::script('//code.jquery.com/jquery-1.12.4.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/lib/jquery/dist/jquery.slim.min.js') ?>
<?php JHTML::script('modules/mod_leidos_schedule/lib/angular/angular.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/lib/angular-sanitize/angular-sanitize.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/lib/moment/min/moment.min.js'); ?>

<?php JHTML::stylesheet('modules/mod_leidos_schedule/styles/main.css'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/main.min.js'); ?>

<?php JHTML::script('modules/mod_leidos_schedule/scripts/directives/schedule/directive.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/directives/toolbar/directive.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_schedule/scripts/app.min.js'); ?>


<div class="osadp-schedule" ng-app="ScheduleApp">
  <div class="clearfix osadp-schedule__header">
    <h2 class="pull-left">OPEN SOURCE RELEASE SCHEDULE</h2>
    <a href="/community/explore-applications#/all" class="pull-right osadp-schedule__header-link explore-applications">
      <span class="icon-container green circle">
        <span class="fa fa-puzzle-piece icon"></span>
      </span>
      Explore Applications
    </a>
  </div>
  <div class="clearfix" ng-controller="ComingSoonCtrl as soon">
    <p class="loader" ng-show="loading">Loading...</p>
    <!-- Toolbar directive -->
    <div data-schedule-toolbar data-search="soon.searchText" data-order="soon.order" data-limit="soon.limit" data-page="soon.page" data-pages="soon.schedules.length" data-availability="soon.availability"></div>
    <!-- Display releases -->
    <div class="row">
      <!-- Display all Coming Soon releases filter by availability -->
      <div class="col-lg-12 col-xs-12 osadp-schedule__card-container"
        ng-repeat="(kay, schedule) in soon.schedules[soon.page] |
        filter: soon.searchText |
        filter: { available: soon.availability } |
        orderBy: soon.order : (soon.availability === '0')">
        <div data-schedule-item
          schedule="schedule"
          name="schedule.name"
          dma="schedule.dma"
          day="soon.moment(schedule.date).format('D')"
          date="(schedule.full_date == 1) ? soon.moment(schedule.date).format('MMMM YYYY') :
                soon.moment(schedule.date).format('MMMM')"
          notes="schedule.notes"
          capabilities="schedule.capabilities"
          image="{{ schedule.image || 'http://www.itsforge.net/images/uploads/image_unavailable.jpg' }}"
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
