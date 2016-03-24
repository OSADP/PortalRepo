<?php defined('_JEXEC') or die; ?>
<?php JHTML::stylesheet('modules/mod_leidos_ars_categories/css/main.css'); ?>


<div class="row">
	<ol class="ars__categories" role="navigation">
		<?php
			for( $i = 0; $i < count($categories); $i++ ) {
				$item = $categories[$i];
				if( $i == 0 ) {
					?>
					<div class="ars__categories_wrapper col-xs-12 col-lg-6">
					<?php
				} else if ( $i % 4  == 0 ) {
					?>
					</div>
					<div class="ars__categories_wrapper col-xs-12 col-lg-6">
					<?php
				}
				?>
				<li class="col-xs-6 col-lg-3">
					<a href="<?php echo $applicationsModule; ?>#/<?php echo $item->id; ?>">
						<div class="ars__categories__container">
							<div class="ars__categories__image">
								<span class="" style="background: url(<?php echo $item->icon_url; ?>) center no-repeat;"></span>
							</div>
							<div class="ars__categories__item">
								<?php
									echo "<strong>" . $item->title . "</strong>";
								?>
							</div>
						</div>
					</a>
				</li>
				<?php
			}
		?>
		</div>
	</ol>
</div>