<?php defined('_JEXEC') or die; ?>
<?php JHTML::stylesheet('modules/mod_leidos_statistics/css/main.css'); ?>
<?php JHTML::script('modules/mod_leidos_statistics/js/main.js'); ?>

<div>
	<ul class="statistics__container">
		<li class="statistics__item">
			Application Releases: <?php echo $totalReleases; ?>
		</li>
		<li class="statistics__item">
			Application Downloads: <?php echo $totalDownloads; ?>
		</li>
	</ul>
</div>