<?php JHtml::_('jquery.framework',  true, true); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/css/styles.css'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/scripts/view.main.js'); ?>

<div class="row-fluid">
	<div class="" style="">
		<!-- SEARCH BAR -->
		<div class="row-fluid">
			<div class="input-append pull-left">
				<form action="/administrator/index.php?option=com_osadp_schedule" method="post">
				  <input name="searchParam" type="text" value="<?php echo $this->param; ?>"
				  	placeholder="Search Projects">
				  <button class="btn" type="submit">
				  	<span class="icon-search"></span>
				  </button>
			  </form>
		  </div>
			<form action="/administrator/index.php?option=com_osadp_schedule" method="post" class="pull-left">
			  <input name="clearSearch" type="text" value=""
			  	placeholder="Search Projects"
			  	style="display: none;">
			  <button class="btn" type="submit" style="margin-left: 5px;">
			  	<span class="icon-undo-2"></span>
			  	Clear
			  </button>
		  </form>
		</div>
		<!-- END SEARCH -->

		<p><em>Note: Click the Project to Edit.</em></p>
		<table class="table table-bordered table-striped">
			<tr>
				<th class="centered span3">Project</th>
				<th class="centered">URL</th>
				<th class="centered">Notes</th>
				<th class="centered">Capabilities</th>
				<th class="centered span2">Date</th>
				<th class="centered" style="min-width: 80px;">Full Date</th>
				<th class="centered">DMA</th>
				<th class="centered">Available</th>
				<th class="centered">Published</th>
				<th class="centered">Delete</th>
			</tr>
			<?php foreach ($this->schedules as $key => $project) { ?>
				<tr>
					<td>
						<div class="text-fit">
							<a href="/administrator/index.php?option=com_osadp_schedule&amp;view=edit&amp;projectId=<?php echo $project->id; ?>">
							<?php echo filter_var($project->name, FILTER_SANITIZE_STRING); ?>
							</a>
						</div>
					</td>
					<td>
						<div class="text-fit">
							<?php echo $project->url; ?>
						</div>
					</td>
					<td><div class="text-fit"><?php echo htmlspecialchars($project->notes); ?></div></td>
					<td>
						<div class="text-fit"><?php echo htmlspecialchars($project->capabilities); ?></div>
					</td>
					<td class="centered"><?php echo date_format(date_create($project->date), 'm-d-Y'); ?></td>
					<!-- Full Date -->
					<?php if( $project->full_date ) { ?>
						<td class="centered" style="text-align: center; color: green;">
							<span class="icon-checkmark-2"></span>
						</td>
					<?php } else { ?>
						<td class="centered" style="text-align: center; color: red;">
							<span class="icon-cancel"></span>
						</td>
					<?php } ?>
					<!-- DMA -->
					<?php if( $project->dma ) { ?>
						<td class="centered" style="text-align: center; color: green;">
							<span class="icon-checkmark-2"></span>
						</td>
					<?php } else { ?>
						<td class="centered" style="text-align: center; color: red;">
							<span class="icon-cancel"></span>
						</td>
					<?php } ?>
					<!-- Available -->
					<?php if( $project->available ) { ?>
						<td class="centered" style="text-align: center; color: green;">
							<span class="icon-checkmark-2"></span>
						</td>
					<?php } else { ?>
						<td class="centered" style="text-align: center; color: red;">
							<span class="icon-cancel"></span>
						</td>
					<?php } ?>
					<!-- Published -->
					<?php if( $project->published ) { ?>
						<td class="centered" style="text-align: center; color: green;">
							<span class="icon-checkmark-2"></span>
						</td>
					<?php } else { ?>
						<td class="centered" style="text-align: center; color: red;">
							<span class="icon-cancel"></span>
						</td>
					<?php } ?>
					<td class="centered">
						<form action="/administrator/index.php?option=com_osadp_schedule" method="post" style="margin:0;">
							<input type="text" name="id" value="<?php echo $project->id; ?>" style="display: none;">
							<button class="btn btn-small btn-delete" type="submit">
								<span class="icon-trash"></span>
							</button>
						</form>
					</td>
				</tr>
			<?php } ?>
		</table>
		<?php if(count($this->schedules) == 0) { ?>
			<p>
				<em>No Schedules available, click</em>
				<a href="/administrator/index.php?option=com_osadp_schedule&amp;view=new" class="btn btn-small">
					<span class="icon-new"></span>	New Schedule
				</a>
				<em>to begin creating one.</em>
			</p>
		<?php } ?>
	</div>
</div>