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
// require our helper class ModuleHelper
require_once (dirname(__FILE__).'/helper.php');
$helper = new ModuleHelper;
//
$totalReleases = $helper->getAll();
//
require JModuleHelper::getLayoutPath('mod_leidos_sample', $layout);
?>