
<?php JHtml::stylesheet('administrator/components/com_multicategories/css/styles.css'); ?>
<?php JHtml::script('https://code.jquery.com/jquery-1.12.0.min.js'); ?>
<?php JHtml::script('administrator/components/com_multicategories/scripts/multicategories.service.js'); ?>
<?php JHtml::script('administrator/components/com_multicategories/scripts/osadp.alert.js'); ?>
<?php JHtml::script('administrator/components/com_multicategories/scripts/main.js'); ?>

<div class="row-fluid">
	<div class="span6">
		<div class="osadp-alert">
			<p>
				<span class="icon-info-circle"></span>
				<span class="message"></span>
				<span class="icon-cancel"></span>
			</p>
		</div>
		<h2><?php echo $this->item->title; ?></h2>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<h3>Choose Categories:</h3>
		<p>Categories defined within Akeeba are marked <span class="main-category" style="padding: 3px 5px;">red</span> and cannot be removed within this component.</p>
		<ul class="akeeba-categories">
			<?php foreach ($this->categories as $key => $value) { ?>
				<li>
					<label><?php echo $value->title; ?></label>
					<input type="checkbox" value="<?php echo $value->id; ?>">
				</li>
			<?php } ?>
		</ul>

		<a href="/administrator/index.php?option=com_multicategories" class="osadp-btn osadp-btn-inactive">
			<span class="icon-arrow-left-2"></span>
			Back to Items
		</a>
		<a href="#" class="osadp-btn osadp-btn-active">
			<span class="icon-checkmark-circle"></span>
			Submit
		</a>
		
	</div>
</div>

<script>
	window._itemId = <?php echo $this->item->id; ?>;
	window._mainCategory = <?php echo $this->item->category_id; ?>;
</script>