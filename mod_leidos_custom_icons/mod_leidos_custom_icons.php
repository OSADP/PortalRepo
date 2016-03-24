<?php
/**
 * Custom Icon Links Module Entry Point
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
 
// No direct access
defined('_JEXEC') or die;
// get our module layout, for now we're using the default
$layout = $params->get('layout', 'default');
// require our helper class ArsRelease
require_once (dirname(__FILE__).'/helper.php');
// instantiate our helper class
$arsRelease = new ArsRelease();
// get akeeba releases data from our helper class
$releases = $arsRelease->getReleases();
// get akeeba releases data from our helper class
$items = $arsRelease->getItems();
// get joomla users data from our helper class
$users = $arsRelease->getUsers();
// get forum topics data from our helper class
$discussions = $arsRelease->getDiscussions();
// get the link for Explore Applications from our params
$applicationsLink = $params->get('applicationsLink');
// get the link for Upcoming Releases from our params
$releasesLink = $params->get('releasesLink');
// get the link for Resources and Tools from our params
$resourcesLink = $params->get('resourcesLink');
// get the link for Discussion Forum from our params
$discussionsLink = $params->get('discussionsLink');
//
require JModuleHelper::getLayoutPath('mod_leidos_custom_icons', $layout);
?>