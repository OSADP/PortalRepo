<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_osadp_schedule
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Lendr component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_osadp_schedule
 * @since       1.6
 */
class OsadpHelpersSchedule
{
	public static $extension = 'com_osadp_schedule';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_osadp_schedule';
		$level = 'component';

		$actions = JAccess::getActions('com_osadp_schedule', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}