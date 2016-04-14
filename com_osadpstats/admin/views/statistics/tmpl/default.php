
<?php 
	JHTML::stylesheet('administrator/components/com_osadpstats/styles/main.css');
	JHTML::stylesheet('administrator/components/com_osadpstats/vendor/jquery-ui/jquery-ui.min.css');
	JHTML::stylesheet('administrator/components/com_osadpstats/vendor/jquery-ui/jquery-ui.theme.min.css');
	JHTML::script('administrator/components/com_osadpstats/vendor/Chart.min.js');
	JHTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
	JHTML::script('https://code.highcharts.com/highcharts.js');
	JHTML::script('administrator/components/com_osadpstats/vendor/exporting.js');
	JHTML::script('administrator/components/com_osadpstats/scripts/osadp.charts.top.downloads.js');
	JHTML::script('administrator/components/com_osadpstats/scripts/osadp.charts.daily.downloads.js');
	JHTML::script('administrator/components/com_osadpstats/scripts/osadp.charts.registrations.js');
	JHTML::script('administrator/components/com_osadpstats/vendor/jquery-ui/jquery-ui.js');

	if( isset($_GET) ) {
		$arrMonths = ['Invalid', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		// get our month parameter, else default to current month
		if( isset($_GET['month']) && is_numeric( $_GET['month']) ) {
			$month = $_GET['month'];
		} else {
			$month = date('n');
		}
		// the date function begins the year as 1 = January
		// catch array behavior if invalid
		if( $arrMonths[$month] == 'Invalid' ) {
			$month = date('n');
		}
		// get our range parameters, else default to current month
		if( isset($_GET['from']) && isset($_GET['until']) ) {
			$from = $_GET['from'];
			$until = $_GET['until'];
		} else {
			$from = date('Y-n-') . 1;
			$until = date('Y') . '-' . (date('n') + 1) . '-1';
		}
		// get the month from our starting range string
		$month = explode('-', $from)[1];
		// get the difference in days between the two date ranges
		$diff = strtotime($until) - strtotime($from);
		$daysApart = floor($diff/(60*60*24));
	}
 ?>
<style>
	.chart-legent {
		list-style-type: none;
	}
	.chart-legend li span{
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-right: 5px;
	}

	.thumbnail {
		height: 370px;
		margin-bottom: 10px;
		padding: 4px 12px;
		color: rgb(52, 73, 94);
		border-radius: 0;
		overflow: auto;
	}
	.thumbnail h3 {
		color: rgb(52, 73, 94);
	}
	.thumbnail p {
		color: rgb(103, 128, 159);
	}
	.accent-blue {
		border-top: 3px solid rgb(129, 207, 224);
	}
	.accent-red {
		border-top: 3px solid rgb(210, 77, 87);
	}
	.accent-green {
		border-top: 3px solid rgb(38, 194, 129);
	}
	.accent-yellow {
		border-top: 3px solid rgb(244, 208, 63);
	}
	.accent-purple {
		border-top: 3px solid rgb(155, 89, 182);
	}

	.btn.btn-osadp {
		margin-top: 8px;
	}
	.row {
		margin: 0;
	}
	.span6 {
		margin-left: 15px !important;
	}
	.table, .table * {
		border-radius: 0 !important;
	}
	.table th {
		text-align: center;
	}
	.centered {
		text-align: center !important;
	}

	.row-fluid [class*="span"] {
		margin: 0 15px 15px 0;
	}
	
	.row-fluid [class*="span"].fullscreen {
		display: block;
    position: fixed;
    width: 100%;
    height: 100%;
    background: #fff;
    top: 0;
    margin-top: 31px;
    padding-bottom: 50px;
    left: 0;
    z-index: 9999;
	}
	.row-fluid [class*="span"].fullscreen .table {
		width: 50%;
	}

	@media print {
		.row [class*="span"] {
			border: none;
			max-width: 100% !important;
			width: 100% !important;
		}
		.row {
			page-break-after: always;
		}
	}

	/* highcharts styling */
	.highcharts-button, .highcharts-tooltip+text {
		display: none !important;
	}

	#menuItems.hide {
		display: none;
	}

	.inline-container {
		display: inline-block;
		vertical-align: middle;
	}

	.container-main * {
		border-radius: 0 !important;
	}
</style>
	<div class="row">
		<div class="span12 hide">
			<button class="btn btn-osadp" id="btnMenu" style="padding-top: 7px;">
				<span class="icon-menu-3"></span> Menu
			</button>
		</div>
		<div id="menuItems" class="span12" style="margin: 0;">
			<div class="inline-container">
				<label for="datepicker">From:</label><input type="text" class="osadp-datepicker" id="dateFrom">
			</div>
			<div class="inline-container">
				<label for="datepicker">Until:</label><input type="text" class="osadp-datepicker" id="dateUntil">
			</div>
			<div class="inline-container">
				<a href="/administrator/index.php?option=com_osadpstats" id="datepickerSubmit" class="btn btn-osadp" style="margin-top: 14px;">
					<span class="icon-ok"></span> Submit
				</a>
			</div>
			<!-- <a href="/administrator/index.php?option=com_osadpstats&amp;month=1">January</a> | 
			<a href="/administrator/index.php?option=com_osadpstats&amp;month=2">February</a> |
			<a href="/administrator/index.php?option=com_osadpstats&amp;from=2016-3-1&amp;until=2016-4-1">March</a> | 
			<a href="/administrator/index.php?option=com_osadpstats&amp;from=2016-4-1&amp;until=2016-5-1">April</a> | 
			<a href="/administrator/index.php?option=com_osadpstats&amp;month=5">May</a> | 
			<a href="/administrator/index.php?option=com_osadpstats&amp;month=6">June</a> | 
			<a href="/administrator/index.php?option=com_osadpstats&amp;month=7">July</a> -->
		</div>
	</div>
	<!-- 1st row -->
	<div class="row">
		<div class="span3 thumbnail accent-red users__container">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3 class="hidden-print">
				<?php echo JText::_('COM_OSADPSTATS_STATISTICS_TOTAL_USERS'); ?>
			</h3>
			<p class="hidden-print"><?php echo JText::_('COM_OSADPSTATS_STATISTICS_TOTAL_USERS_DESC'); ?></p>
			<div class="chart-legend" id="usersLegend"></div>
			<div style="height: 230px; margin-top: -10px;">
				<canvas id="usersChart" style="width: 100%; height: 100%;"></canvas>
			</div>
		</div>

		<div class="span5 thumbnail accent-green downloads__container" style="margin-left:0 !important;">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3 class="hidden-print">Monthly User Registrations</h3>
			<p class="hidden-print">Display the number of user registrations per month for this year as well as the previous year for comparison.</p>
			<div id="userRegistrations" style="min-width: 310px; min-height: 280px; margin: 0 auto"></div>
		</div>

		<div class="span4	thumbnail accent-yellow">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3>Registered Users</h3>
			<p>Shows users who registered in the month selected.</p>
			<table class="table table-striped table-bordered" id="latestUsers">
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th class="hidden-phone">Email</th>
					<th>Register Date</th>
					<th class="hidden-phone">Activated</th>
				</tr>
				<?php
					$users = $this->getUsersThisMonth( $month );
					foreach ($users as $key => $user) {
						$active = ( empty( $user->activation ) ) ? 'Yes': 'No';
						$date = date_create($user->registerDate);
						$registerDate = date_format($date, 'M d, Y');
						echo '<tr>';
						echo '<td>'.$user->id.'</td>';
						echo '<td><strong>'. $user->username .'</strong></td>';
						echo '<td class="hidden-phone">'. $user->email .'</td>';
						echo '<td class="centered">'.$registerDate.'</td>';
						echo '<td class="hidden-phone centered">'. $active .'</td>';
						echo '</tr>';
					}
				 ?>
			</table>
		</div>
	</div>
	
	<!-- 2nd row -->
	<div class="row">
		<div class="span4 thumbnail accent-blue downloads__container highcharts-nolabels" style="margin-left:0 !important;">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3 class="hidden-print">Top Downloaded Items</h3>
			<p class="hidden-print">List of most downloaded applications sorted by number of downloads.</p>
			<div id="highchartsContainer" style="min-width: 310px; min-height: 280px; margin: 0 auto"></div>
		</div>

		<div class="span5 thumbnail accent-red downloads__container highcharts-nolabels">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3 class="hidden-print">Daily Downloads</h3>
			<p class="hidden-print">Show the daily downloads for this month.</p>
			<div id="downloadsChart" style="min-width: 310px; min-height: 280px; margin: 0 auto"></div>
		</div>

		<div class="span3 thumbnail accent-green">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3 class="hidden-print">Latest Applications</h3>
			<p class="hidden-print">List of newest applications in OSADP.</p>
			<table class="table table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Created</th>
				</tr>
			<?php 
					$latestApps = $this->getLatestApplications( 6 );
					foreach ($latestApps as $key => $value) { ?>
				<tr>
					<td><?php echo $value->id; ?></td>
					<td><?php echo $value->title; ?></td>
					<td><?php echo date_format( date_create($value->created), 'M d, Y - h:i:s a'); ?></td>
				</tr>
			<?php } ?>
			</table>
		</div>
	</div>
	<!-- eof 2nd row -->

	<!-- 3rd row -->
	<div class="row">
		<!-- -->
		<div class="span4 thumbnail accent-purple hidden-print">
			<button class="btn btn-osadp btn-fullscreen expander hidden-print pull-right">
				<span class="icon-expand"></span>
			</button>
			<h3>Applications Released</h3>
			<p>Shows any applications released during this period.</p>
			<table class="table table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Created</th>
				</tr>
				<?php 
				$apps = $this->getItemsThisMonth( $month );
				foreach ($apps as $key => $value) { ?>
				<tr>
					<td><?php echo $value->id; ?></td>
					<td><?php echo $value->title; ?></td>
					<td><?php echo $value->created; ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
<script src="/administrator/components/com_osadpstats/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript">
	(function() {
		// chart for top downloads
		var items = <?php echo json_encode($this->modelStatistics['top_downloads']); ?>;
		window.OSADP.topDownloadsChart( '#highchartsContainer', items );
		// chart for user registrations
		var current = <?php echo json_encode($this->getRegistrationsThisYear()); ?>;
		var previous = <?php echo json_encode($this->getRegistrationsLastYear()); ?>;
		window.OSADP.registrationsChart( '#userRegistrations', current, previous );
		// chart for downloads this month
		var downloadLogs = <?php echo json_encode($this->getDownloadsThisMonth( $from, $until )); ?>;
		window.OSADP.dailyDownloadsChart('#downloadsChart', downloadLogs,
			<?php echo json_encode(explode('-', $from)); ?>,
			<?php echo json_encode(explode('-', $until)); ?>);
	})();

	(function(window, document, $, undefined) {
		'use strict';

		$(function() {
			// start of jquery.ready scope
			// 
			$('#usersChart').ready(function() {
				var data = [
					{
						value: parseInt(<?php echo $this->modelStatistics['total_active_users']; ?>),
						label: 'Active Users',
						color: '#03C9A9',
						highlight: '#36D7B7'
					},
					{
						value: parseInt(<?php echo $this->modelStatistics['total_inactive_users']; ?>),
						label: 'Inactive Users',
						color: '#F4D03F',
						highlight: '#F5D76E'
					}
				];
				var options  = {
					responsive: true,
					legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\" style=\"list-style-type: none; margin: 0;\">" +
					"<% var total = 0; for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span>" +
					"<%if(segments[i].label){%><%=segments[i].label%> - <%=segments[i].value%> <% total = total + segments[i].value } %></li><%}%>" +
					'<li><span style="background-color: #999;"></span>Total - <%= total %> </li></ul>'
				}
				var ctx = $("#usersChart").get(0).getContext("2d");
				var usersPieChart = new Chart( ctx ).Doughnut(data, options);
				$('#usersLegend').html( usersPieChart.generateLegend() );
			})

			$('.btn-fullscreen').click( function() {
				var btn = $(this);
				var container = btn.closest('[class*="span"]');
				if( btn.hasClass('expander') ) {
					btn.addClass('collapser').removeClass('expander')
					 .find('span').removeClass('icon-expand')
					 .addClass('icon-remove');
					container.addClass('fullscreen');
				} else {
					var container = btn.closest('[class*="span"]');
					btn.addClass('expander').removeClass('collapser')
						 .find('span').removeClass('icon-remove')
						 .addClass('icon-expand');
					container.removeClass('fullscreen');
				}
			});

			$('#btnMenu').click( function() {
				$('#menuItems').toggleClass('hide');
			})

			$('#dateFrom, #dateUntil').datepicker({
				dateFormat: 'yy-mm-dd'
			});

			$('.osadp-datepicker').change( function() {
				var fromDate = $('#dateFrom').val();
				var untilDate = $('#dateUntil').val();
				console.log(fromDate);
				$('#datepickerSubmit').attr('href', '/administrator/index.php?option=com_osadpstats&from='+fromDate+'&until='+untilDate);
			})

			// end of jquery.ready scope
		})
	})(window, document, jQuery);
</script>