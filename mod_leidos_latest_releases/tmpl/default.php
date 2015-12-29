<?php defined('_JEXEC') or die; ?>
<?php JHTML::stylesheet('modules/mod_leidos_latest_releases/css/main.css'); ?>
<?php JHTML::script('modules/mod_leidos_latest_releases/js/main.js'); ?>

<div>
	<ul class="latest-releases__container">
		<?php for( $x = 0; $x < $limit; $x++) {
			$release = $latestReleases[$x]; 
			if( $release != null ) { ?>
		<li class="latest-releases__item">
			<a href="<?php echo $applicationsLink; ?>#/<?php echo $release->category_id;?>/<?php echo $release->id;?>">
				<?php
					echo '<strong>'.$release->title.'</strong><br>';
					if( $release->short_description != '' )
						echo $release->short_description;
				?>
			</a>
		</li>
		<?php }
		}?>
	</ul>
</div>