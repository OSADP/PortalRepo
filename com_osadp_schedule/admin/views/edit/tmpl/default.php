<?php JHtml::_('jquery.framework', true, true); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/css/styles.css'); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/vendor/jquery-ui/jquery-ui.min.css'); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/vendor/jquery-ui/jquery-ui.theme.min.css'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/vendor/jquery-ui/jquery-ui.js'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/scripts/view.edit.js'); ?>
<?php JHtml::script('//cdn.ckeditor.com/4.5.9/standard/ckeditor.js'); ?>

<div id="mainForm" class="row-fluid" data-update-success="<?php echo $this->updateSuccess; ?>">
	<!-- SPAN6: -->
	<form action="/administrator/index.php?option=com_osadp_schedule&amp;view=edit&amp;projectId=<?php echo $this->project->id; ?>"
		method="post">
		<div class="span7">

			<div class="alert alert-danger hidden">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Error!</strong> Updating schedule failed. Please try again.
			</div>
			<div class="alert alert-success hidden">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Succes!</strong> Schedule is successfully UPDATED in the database.
			</div>

			<fieldset>
			<legend>Edit Project</legend>
				<!-- PROJECT NAME and DATE -->
				<div class="row-fluid">
					<div class="span6">
						<label for="name">Project Name:</label>
						<input type="text" name="name" id="name" value="<?php echo $this->project->name; ?>" required>
					</div>
					<div class="span6">
						<label for="image">Project Image:</label>
						<input type="text" name="image" id="image" value="<?php echo $this->project->image; ?>">
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<label for="url">Project URL:</label>
						<input type="text" name="url" id="url" value="<?php echo $this->project->url; ?>">
					</div>
					<div class="span6">
						<label for="date">Date:</label>
						<input type="text" name="date" id="date" value="<?php echo date_format(date_create($this->project->date), "m-d-Y"); ?>" required>
					</div>
				</div>
				<!-- NOTES -->
				<div class="row-fluid">
					<label for="notes">Notes:</label>
					<textarea name="notes" id="notes" cols="100" rows="10" class="span12"><?php echo $this->project->notes; ?></textarea>
				</div>
				<br>
				<!-- CAPABILITIES -->
				<div class="row-fluid">
					<label for="capabilities">Capabilities:</label>
					<textarea name="capabilities" id="capabilities" cols="100" rows="10" class="span12"><?php echo $this->project->capabilities; ?></textarea>
				</div>
				<!-- DMA -->
				<div class="row-fluid">
					<br>
					<label>Is this a Dynamic Mobility Application?</label>
					<?php if($this->project->dma): ?>
						<input type="radio" name="dma" id="dmaYes" value="1" checked="checked"> Yes
						<input type="radio" name="dma" id="dmaNo" value="0"> No
					<?php else: ?>
						<input type="radio" name="dma" id="dmaYes" value="1"> Yes
						<input type="radio" name="dma" id="dmaNo" value="0" checked="checked"> No
					<?php endif; ?>
				</div>
				<!-- AVAILABLE -->
				<div class="row-fluid">
					<br>
					<label>Is this Available? (or Coming Soon)</label>
					<?php if($this->project->available): ?>
						<input type="radio" name="available" id="availableYes" value="1" checked="checked"> Yes
						<input type="radio" name="available" id="availableNo" value="0"> No
					<?php else: ?>
						<input type="radio" name="available" id="availableYes" value="1"> Yes
						<input type="radio" name="available" id="availableNo" value="0" checked="checked"> No
					<?php endif; ?>
				</div>
				<!-- FULL DATE -->
				<div class="row-fluid">
					<br>
					<label>Show Full Date (Including Day)?</label>
					<?php if($this->project->full_date): ?>
						<input type="radio" name="fullDate" id="availableYes" value="1" checked="checked"> Yes
						<input type="radio" name="fullDate" id="availableNo" value="0"> No
					<?php else: ?>
						<input type="radio" name="fullDate" id="availableYes" value="1"> Yes
						<input type="radio" name="fullDate" id="availableNo" value="0" checked="checked"> No
					<?php endif; ?>
				</div>
				<!-- PUBLISHED -->
				<div class="row-fluid">
					<br>
					<label>Is this Published?</label>
					<?php if($this->project->published): ?>
						<input type="radio" name="published" id="publishedYes" value="1" checked="checked"> Yes
						<input type="radio" name="published" id="publishedNo" value="0"> No
					<?php else: ?>
						<input type="radio" name="published" id="publishedYes" value="1"> Yes
						<input type="radio" name="published" id="publishedNo" value="0" checked="checked"> No
					<?php endif; ?>
				</div>
				<!-- Days New -->
				<div class="row-fluid">
					<br>
					<label>How many days will this be considered new?</label>
					<input type="number" name="daysNew" id="daysNew" value="<?php echo $this->project->days_new; ?>" style="width: 40px;">
				</div>
			</fieldset>
		</div>
		<button id="btnSubmit" class="hidden" type="submit"></button>
		<!-- END SPAN6 -->
	</form>
</div>