<?php 
defined('_JEXEC') or die;

JHTML::stylesheet('modules/mod_leidos_ars_search/css/main.css'); 
JHTML::stylesheet('modules/mod_leidos_ars_search/css/bounce.animation.css'); 
JHTML::script('https://code.angularjs.org/1.4.7/angular.min.js'); 
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/main.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/controllers/akeebaItemsCtrl.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/controllers/categoryListCtrl.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/router.js'); 
?>


<div id="arsSearch" class="container">
	<div class="row">
		<h2><?php echo $page_header; ?></h2>
	</div>

	<div class="row" ng-cloak>
		<!-- LEFT SIDE DISPLAY A LIST OF CATEGORIES -->
		<div class="col-xs-12 col-sm-4 col-lg-4" class="ars__categories" ng-controller="CategoryListCtrl">
			<h4 class="ars__categories--heading">Categories</h4>
			<!-- LIST ALL OUR CATEGORIES -->
			<div class="ars__categories--item" ng-class="{ 'ars_categories--item-active': category.active }" ng-repeat="category in categories">
				<a href="#/{{ category.id }}" ng-click="categoryChange( this )">{{ category.title }} <span class="badge pull-right">{{ category.items.length }}</span></a>
			</div>
		</div>
		<!-- // -->
		<!-- RIGHT SIDE DISPLAY APPLICATION AND SEARCH AND SORT -->
		<div class="col-xs-12 col-sm-8" ui-view></div>
	</div>
</div>