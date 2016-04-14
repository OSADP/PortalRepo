<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_osadpstats
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 *
 * @package     Joomla.Administrator
 * @subpackage  com_osadpstats
 * @since       1.6
 */
class OsadpHelpersOsadpstats
{
	public static $extension = 'com_osadpstats';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_osadpstats';
		$level = 'component';

		$actions = JAccess::getActions('com_osadpstats', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}