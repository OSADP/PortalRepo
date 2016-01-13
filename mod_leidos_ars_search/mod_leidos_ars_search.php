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
// get the header text from user input
$page_header = $params->get('header', 'Applications');
// user
$user = JFactory::getUser();
// require our helper class ArsSearcher
// require_once (dirname(__FILE__).'/helper.php');
//
require JModuleHelper::getLayoutPath('mod_leidos_ars_search', $layout);
?>