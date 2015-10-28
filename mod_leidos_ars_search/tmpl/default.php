<?php 
defined('_JEXEC') or die;

JHTML::stylesheet('modules/mod_leidos_ars_search/css/main.css'); 
JHTML::stylesheet('modules/mod_leidos_ars_search/css/bounce.animation.css'); 
JHTML::script('https://code.angularjs.org/1.4.7/angular.min.js'); 
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/main.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/controller.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/router.js'); 
?>


<div id="arsSearch" class="container">
	<div class="row">
		<h2><?php echo $page_header; ?></h2>
	</div>
	<div class="row" ui-view></div>
</div>