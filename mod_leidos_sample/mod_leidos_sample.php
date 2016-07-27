<?php
  /**
   *
   */
  defined('_JEXEC') or die;
  // Get our module layout, for now we're using the default
  $layout = $params->get('layout', 'default');
  // Require our helper class ModuleHelper which acts
  // as our model class.
  require_once (dirname(__FILE__).'/helper.php');
  $helper = new ModuleHelper;
  //
  $sampleHelperProperty = $helper->getAll();
  // Get a value from our module's parameter.
  // Parameters are created in the <config> tag in our manifest
  // and is used within the module's Joomla admin settings.
  $sampleParameterProperty = $params->get('header');
  //
  require JModuleHelper::getLayoutPath('mod_leidos_sample', $layout);
?>