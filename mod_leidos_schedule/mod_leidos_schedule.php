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
// require our helper class ScheduleHelper
require_once (dirname(__FILE__).'/helper.php');
/**
 * Module helper class
 * @var ScheduleHelper
 */
$schedules = new ScheduleHelper;
/**
 * All release schedules published
 * @var array
 */
$all = $schedules->getAll();
/**
 * Published release schedules yet to be released
 * @var array
 */
$comingSoon = $schedules->getComingSoon();
/**
 * Published available release schedules
 * @var array
 */
$available = $schedules->getAvailable();
/**
 * 
 */
require JModuleHelper::getLayoutPath('mod_leidos_schedule', $layout);
?>