<?php 
defined('_JEXEC') or die;

JHTML::stylesheet('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
JHTML::stylesheet('modules/mod_leidos_research_tools/css/main.css'); 
JHTML::stylesheet('modules/mod_leidos_research_tools/css/bounce.animation.css'); 
JHTML::script('https://code.angularjs.org/1.4.7/angular.min.js');
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.js');
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-beta.1/angular-sanitize.min.js');
JHTML::script('https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js');
JHTML::script('modules/mod_leidos_research_tools/app/main.js'); 
JHTML::script('modules/mod_leidos_research_tools/app/controllers/MainCtrl.js');
JHTML::script('modules/mod_leidos_research_tools/app/router.js'); 
?>


<div id="osadpResearch" class="">
	<div ui-view></div>
</div>