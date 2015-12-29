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
// require our helper class OSADPStatistics
require_once (dirname(__FILE__).'/helper.php');
// get the number of releases data from our helper class
$latestReleases = LatestReleases::getLatest();
// get explore applications link from params
$applicationsLink = $params->get('application', '');
// get the limit for displaying releases from module params
$limit = $params->get('limit', '');
//
require JModuleHelper::getLayoutPath('mod_leidos_latest_releases', $layout);
?>