<?php defined('_JEXEC') or die; ?>
<?php JHTML::stylesheet('modules/mod_leidos_custom_icons/css/main.css'); ?>
<?php JHTML::script('modules/mod_leidos_custom_icons/js/countUp.min.js'); ?>
<?php JHTML::script('modules/mod_leidos_custom_icons/js/main.js'); ?>


<ol class="row" role="navigation">
	
	<li class="col-xs-6 col-lg-3 card">
		<a href="<?php echo $applicationLink; ?>" class="iconlink" title="Explore Applications">
			<span class="btn btn-primary btn-circle animation-target" aria-hidden="true">
				<i class="fa fa-puzzle-piece"></i>
			</span>
			<h4>Explore Applications</h4>
		</a>
	</li>
	
	<li class="col-xs-6 col-sm-6 col-lg-3 card">
		<a href="<?php echo $releasesLink; ?>" class="iconlink" title="Upcoming Releases">
			<span class="btn btn-primary btn-circle animation-target" aria-hidden="true">
				<i class="fa fa-calendar"></i>
			</span>
			<h4>Upcoming Releases</h4>
		</a>
	</li>
	
	<li class="col-xs-6 col-sm-6 col-lg-3 card">
		<a href="<?php echo $resourcesLink; ?>" class="iconlink" title="Resources and Tools">
			<span class="btn btn-primary btn-circle animation-target" aria-hidden="true">
				<i class="fa fa-gears"></i>
			</span>
			<h4>Resources &amp; Tools</h4>
		</a>
	</li>
	
	<li class="col-xs-6 col-sm-6 col-lg-3 card">
		<a href="<?php echo $discussionsLink; ?>" class="iconlink" title="Recent Discussion">
			<span class="btn btn-primary btn-circle animation-target" aria-hidden="true">
				<i class="fa fa-comment"></i>
			</span>
			<h4>Discussion Forum</h4>
		</a>
	</li>

</ol>