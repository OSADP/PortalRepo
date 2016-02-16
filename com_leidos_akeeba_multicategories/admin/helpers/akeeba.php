<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_leidos_akeeba_multicategories
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Lendr component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_leidos_akeeba_multicategories
 * @since       1.6
 */
class OsadpHelpersAkeeba
{
	public static $extension = 'com_leidos_akeeba_multicategories';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_leidos_akeeba_multicategories';
		$level = 'component';

		$actions = JAccess::getActions('com_leidos_akeeba_multicategories', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}