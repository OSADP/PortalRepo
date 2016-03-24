<?php
/**
 * Leidos ARS Display Categories Module Entry Point
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
 
// No direct access
defined('_JEXEC') or die;
// get our module layout, for now we're using the default
$layout = $params->get('layout', 'default');
// require our helper class ArsDisplay
require_once (dirname(__FILE__).'/helper.php');
$helper = new ArsDisplay();
// get akeeba categories data from our helper class
$categories = $helper->getCategories();
// get explore applications link from params
$applicationsModule = $params->get('application_module', '');
//
require JModuleHelper::getLayoutPath('mod_leidos_ars_categories', $layout);
?>