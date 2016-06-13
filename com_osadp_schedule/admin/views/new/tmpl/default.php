<?php JHtml::_('jquery.framework', true, true); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/css/styles.css'); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/vendor/jquery-ui/jquery-ui.min.css'); ?>
<?php JHtml::stylesheet('administrator/components/com_osadp_schedule/vendor/jquery-ui/jquery-ui.theme.min.css'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/vendor/jquery-ui/jquery-ui.js'); ?>
<?php JHtml::script('//cdn.ckeditor.com/4.5.9/standard/ckeditor.js'); ?>
<?php JHtml::script('administrator/components/com_osadp_schedule/scripts/view.new.js'); ?>

<div class="row-fluid new-form" data-save-success="<?php echo $this->saveSuccess; ?>">
	<div class="span7">
		
		<div class="alert alert-danger hidden">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Error!</strong> Saving schedule failed. Please try again.
		</div>
		<div class="alert alert-success hidden">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Succes!</strong> Schedule is successfully SAVED in the database.
		</div>

		<form action="/administrator/index.php?option=com_osadp_schedule&amp;view=new" method="post">
			<fieldset>
				<legend>New Schedule</legend>
				<p><em>Note: Save and Edit an application in order to add applications.</em></p>
				<div class="row-fluid">
					<div class="span4">
						<label for="name">Project Name:</label>
						<input type="text" name="name" id="name" required>
					</div>
					<div class="span4">
						<label for="url">Project URL:</label>
						<input type="text" name="url" id="url">
					</div>
					<div class="span4">
						<label for="date">Date:</label>
						<input type="text" name="date" id="date" required>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span12 notes-editor">
						<label for="projectNotes">Notes:</label>
						<!-- <div class="div-editable" contenteditable="true"></div> -->
						<textarea name="notes" id="notes" cols="100" rows="10" class="span12" required></textarea>
					</div>
				</div>
				<br>
				<!-- CAPABILITIES -->
				<div class="row-fluid">
					<div class="span12">
						<label for="capabilities">Capabilities:</label>
						<textarea name="capabilities" id="capabilities" cols="100" rows="10" class="span12"></textarea>
					</div>
				</div>
				
				<div class="row-fluid">
					<br>
					<label>Is this a Dynamic Mobility Application?</label>
					<input type="radio" name="dma" id="dmaYes" value="1"> Yes
					<input type="radio" name="dma" id="dmaNo" value="0" checked="checked"> No
				</div>
				
				<div class="row-fluid">
					<br>
					<label>Is this Available or Coming Soon?</label>
					<input type="radio" name="available" value="1"> Yes
					<input type="radio" name="available" value="0" checked="checked"> No
				</div>
				
				<div class="row-fluid">
					<br>
					<label>Show Full Date (Including Day)?</label>
					<input type="radio" name="fullDate" value="1"> Yes
					<input type="radio" name="fullDate" value="0" checked="checked"> No
				</div>

				<div class="row-fluid">
					<br>
					<label>Published</label>
					<input type="radio" name="published" value="1"> Yes
					<input type="radio" name="published" value="0" checked="checked"> No
				</div>

			</fieldset>
			<input type="submit" class="hidden" id="btnSubmit">
		</form>
	</div>
</div>