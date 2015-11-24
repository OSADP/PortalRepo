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
// get akeeba releases data from our helper class
$releases = ArsRelease::getReleases();
// get akeeba releases data from our helper class
$items = ArsRelease::getItems();
// get joomla users data from our helper class
$users = ArsRelease::getUsers();
// get forum topics data from our helper class
$discussions = ArsRelease::getDiscussions();
//
require JModuleHelper::getLayoutPath('mod_leidos_custom_icons', $layout);
?>