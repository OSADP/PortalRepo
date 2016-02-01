<?php 
defined('_JEXEC') or die;
JHTML::stylesheet('modules/mod_leidos_research_tools/css/main.css'); 
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js');
?>

<div id="osadpResearch">
	<div class="col-xs-12">
		<div class="row">
			<h3><?php if( $research_header != '' ) echo $research_header; ?></h3>
		</div>
		<div class="row">
			<div class="ars-categories__item">
				<?php
					foreach ($arrLink as $key => $value) {
						if( $value['url'] != '' ) {
							if( $value['name'] == '' ) {
								$value['name'] = $value['url'];
							}
							echo '<a href="'.$value['url'].'"><span class="fa fa-'.$value['icon'].'"></span> '.$value['name'].'</a>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>