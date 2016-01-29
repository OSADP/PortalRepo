<?php
/**
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
 
// No direct access
defined('_JEXEC') or die;
// get our module layout, for now we're using the default
$layout = $params->get('layout', 'default');
// get the header text from user input
$research_header = $params->get('header');

// create the array of Links
$arrLink = [];
for ($i=0; $i < 8; $i++) { 
	$arrLink[$i] = array(
		'name' => $params->get('link'. ($i + 1) . '_name'),
		'url' => $params->get('link'. ($i + 1) . '_url'),
		'icon' => $params->get('link'. ($i + 1) . '_icon', 'link')
		);
}
// user
$user = JFactory::getUser();
// require our helper class OsadpResearch
require_once (dirname(__FILE__).'/helper.php');
// get akeeba releases data from our helper class
$releases = OsadpResearch::getReleases();
//
require JModuleHelper::getLayoutPath('mod_leidos_research_tools', $layout);
?>