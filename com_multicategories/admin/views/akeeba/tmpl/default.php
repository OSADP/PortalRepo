

<div class="row-fluid">
	<h3>Applications</h3>
</div>

<div class="row-fluid">
	<div class="span6">
		<table class="table">
			<tr>
				<th>Title</th>
				<th>ID</th>
				<th>Release ID</th>
				<th>Category ID</th>
			</tr>
			<?php foreach ($this->akeebaItems as $key => $value) { ?>
				<tr>
					<td><?php echo $value->id; ?></td>
					<td>
						<a href="index.php?option=com_multicategories&amp;view=main&amp;title=<?php echo $value->title; ?>&amp;itemId=<?php echo $value->id; ?>">
							<?php echo $value->title; ?>
						</a>
					</td>
					<td><?php echo $value->release_id; ?></td>
					<td><?php echo $value->category_id; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>