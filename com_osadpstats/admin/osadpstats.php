<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

//load classes
JLoader::registerPrefix('Osadp', JPATH_COMPONENT_ADMINISTRATOR);

//Load plugins
JPluginHelper::importPlugin('osadp');
 
//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controller = $app->input->get('controller','display');

// Create the controller
$classname  = 'OsadpControllers'.ucwords($controller);
$controller = new $classname();

$author = 'Robert';
 
// Perform the Request task
$controller->execute();