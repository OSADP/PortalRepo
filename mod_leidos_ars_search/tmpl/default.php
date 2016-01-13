<?php 
defined('_JEXEC') or die;

JHTML::stylesheet('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
JHTML::stylesheet('modules/mod_leidos_ars_search/css/main.css'); 
JHTML::stylesheet('modules/mod_leidos_ars_search/css/bounce.animation.css'); 
JHTML::script('https://code.angularjs.org/1.4.7/angular.min.js');
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.js');
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-beta.1/angular-sanitize.min.js');
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js');
JHTML::script('modules/mod_leidos_ars_search/app/main.js'); 
JHTML::script('modules/mod_leidos_ars_search/app/services/AkeebaService.js');
JHTML::script('modules/mod_leidos_ars_search/app/services/AkeebaItemDirective.js');
JHTML::script('modules/mod_leidos_ars_search/app/controllers/AkeebaReleaseCtrl.js');
JHTML::script('modules/mod_leidos_ars_search/app/controllers/CategoryListCtrl.js');
JHTML::script('modules/mod_leidos_ars_search/app/controllers/ViewCtrl.js');
JHTML::script('modules/mod_leidos_ars_search/app/controllers/ApplicationCtrl.js');
JHTML::script('modules/mod_leidos_ars_search/app/router.js'); 
?>


<div id="arsSearch" class="">
	<div class="">
		<h2>
			<a href="#/all">
				<?php
					echo $page_header;
				?>
			</a>
		</h2>
	</div>

	<div class="" ng-cloak>
		<!-- LEFT SIDE DISPLAY A LIST OF CATEGORIES -->
		<div class="ars-categories col-xs-12 col-md-4 col-lg-4" class="ars-categories" ng-controller="CategoryListCtrl" ng-hide="hideView">
			<div class="ars-categories--mobile visible-xs visible-sm">
				<button type="button" class="btn btn-lg btn-block btn-primary" style="border-radius: 0;">
					{{ currentCategory.title }}
					<span class="fa fa-angle-down"></span>
					<span class="sr-only">Show Categories</span>
				</button>
			</div>
			<h4 class="ars-categories__heading hidden-xs hidden-sm">Application Categories</h4>
			<!-- LIST ALL OUR CATEGORIES -->
			<div class="ars-categories__item hidden-xs hidden-sm" ng-class="{ 'ars-categories__item--active': category.active }" ng-repeat="category in categories | orderBy: 'title'" role="tabslist" aria-title="Browse Application Categories" aria-selected="{{ category.active }}">
				<a href="#/{{ category.id }}" ng-click="categoryChange( this )" role="tab">
					<span class="ars-categories__icon" style="display: inline-block;
				    position: relative;
				    height: 20px;
				    width: 20px;
				    vertical-align: top;
				    background: url({{ category.icon_url }});
				    background-size: cover;
				    margin-right: 5px;">
			    </span>
					{{ category.title }} <span class="badge pull-right">{{ category.items.length }} <span class="sr-only">Applications</span></span>
				</a>
			</div>
		</div>
		<!-- // -->
		<!-- RIGHT SIDE DISPLAY APPLICATION AND SEARCH AND SORT -->
		<div class="{{ width }} ars-container" ui-view autoscroll="false" ng-controller="ViewCtrl"></div>
	</div>
</div>



	<script>
		window.isGuest = function() {
			return <?php echo $user->guest;?> == 0;
		}
	</script>