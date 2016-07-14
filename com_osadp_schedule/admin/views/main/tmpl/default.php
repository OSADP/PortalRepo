<?php JHtml::_('jquery.framework',  true, true); ?>

<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/css/styles.css'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/vendor/moment/min/moment.min.js'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/vendor/angular/angular.js'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/scripts/view.main.js'); ?>

<!-- Bootstrap our Release Schedule application -->
<div class="row-fluid" ng-app="ReleaseSchedule">
	<!-- Instantiate our controller -->
	<div ng-controller="ScheduleCtrl as mainCtrl" class="container" ng-cloak>
		<!-- Search release schedules query input -->
		<input type="text" ng-model="scheduleSearch" placeholder="Search Releases...">
		<!-- Ordering options -->
		<select ng-model="scheduleOrder" ng-init="scheduleOrder = 'date'">
			<option value="date">Date</option>
			<option value="name">Name</option>
		</select>
		<!-- Availability display options -->
		<select ng-model="availability" ng-init="availability = ''">
			<option value="">All</option>
			<option value="1">Available</option>
			<option value="0">Coming Soon</option>
		</select>
		<!-- Release schedule table -->
		<table class="release-table table table-striped table-hover">
			<thead>
				<tr>
					<th class="clickable" ng-click="mainCtrl.changeOrder('name')">
						<span class="icon-menu-2" ng-if="scheduleOrder !== 'name'" style="color: #aaa;"></span>
						<span class="icon-arrow-up-3" ng-if="scheduleOrder == 'name' &amp;&amp; reverseOrder"></span>
						<span class="icon-arrow-down-3" ng-if="scheduleOrder == 'name' &amp;&amp; ! reverseOrder"></span>
						Project Name
					</th>
					<th class="centered clickable" ng-click="mainCtrl.changeOrder('date')">
						<span class="icon-menu-2" ng-if="scheduleOrder !== 'date'" style="color: #aaa;"></span>
						<span class="icon-arrow-up-3" ng-if="scheduleOrder == 'date' &amp;&amp; ! reverseOrder"></span>
						<span class="icon-arrow-down-3" ng-if="scheduleOrder == 'date' &amp;&amp; reverseOrder"></span>
						Date
					</th>
					<th class="centered">Availability</th>
					<th class="centered">Notes</th>
					<th class="centered">Capabilities</th>
					<th class="centered">Full Date</th>
					<th class="centered">DMA</th>
					<th class="centered">Published</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="schedule in mainCtrl.schedules | filter: scheduleSearch | orderBy: scheduleOrder: reverseOrder | filter: {available: availability}"
					ng-click="mainCtrl.editRelease(schedule.id)" ng-keyup="mainCtrl.onKeyupEditRelease($event, schedule.id)" tabindex="0">
					<!-- Release Name -->
					<td>
						<div style="">
							<span ng-bind="schedule.name"></span>
						</div>
					</td>
					<!-- Date -->
					<td class="centered" ng-bind="schedule.formattedDate"></td>
					<!-- Availability -->
					<td class="centered">
						<div class="badge" ng-if="schedule.available == 1" style="margin: 0 auto; background-color: #4ECDC4;">Available</div>
						<div class="badge" ng-if="schedule.available == 0" style="margin: 0 auto; background-color: #6C7A89;">Soon</div>
					</td>
					<!-- Notes -->
					<td class="centered">
						<span class="icon-cancel" ng-if="schedule.notes === ''" style="color: #EC644B;"></span>
						<span class="icon-checkmark-2" ng-if="schedule.notes !== ''" style="color: #2ECC71"></span>
					</td>
					<!-- Capabilities -->
					<td class="centered">
						<span class="icon-cancel" ng-if="schedule.capabilities === ''" style="color: #EC644B;"></span>
						<span class="icon-checkmark-2" ng-if="schedule.capabilities !== ''" style="color: #2ECC71"></span>
					</td>
					<!-- Full Date -->
					<td class="centered">
						<span class="icon-cancel" ng-if="schedule.full_date == 0" style="color: #EC644B;"></span>
						<span class="icon-checkmark-2" ng-if="schedule.full_date == 1" style="color: #2ECC71"></span>
					</td>
					<!-- DMA -->
					<td class="centered">
						<span class="icon-cancel" ng-if="schedule.dma == 0" style="color: #EC644B;"></span>
						<span class="icon-checkmark-2" ng-if="schedule.dma == 1" style="color: #2ECC71"></span>
					</td>
					<!-- Published -->
					<td class="centered">
						<span class="icon-cancel" ng-if="schedule.published == 0" style="color: #EC644B;"></span>
						<span class="icon-checkmark-2" ng-if="schedule.published == 1" style="color: #2ECC71"></span>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- When searching for releases yield no result -->
		<p ng-if="(mainCtrl.schedules | filter: scheduleSearch).length == 0"><em>No release found. Try a different search query.</em></p>
	</div>
</div>