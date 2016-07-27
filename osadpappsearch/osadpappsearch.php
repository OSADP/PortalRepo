<?php
//First start with information about the Plugin and yourself. For example:
/**
 * @package     Joomla.Plugin
 * @subpackage  Search.Osadpappsearch
 *
 * @copyright   Copyright
 * @license     License, for example GNU/GPL
 */
 
// Prevent direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * All functions need to get wrapped in a class
 *
 * The class name should start with 'PlgSearch' followed by the name of the plugin. Joomla calls the class based on the name of the plugin, so it is very important that they match
 */
class PlgSearchOsadpappsearch extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       0.0.0
	 */

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
		$this->db = JFactory::getDbo();
	}
 
	// Define a function to return an array of search areas. Replace 'osadpappsearch' with the name of your plugin.
	// Note the value of the array key is normally a language string
	function onContentSearchAreas()
	{
		static $areas = array(
			'osadpappsearch' => 'Applications'
		);
		return $areas;
	}
	/**
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 * @param  string $text     Target search string
	 * @param  string $phrase   Mathcing option, exact|any|all
	 * @param  string $ordering Ordering option, newest|oldest|popular|alpha|category
	 * @param  mixed $areas    	An array if the search it to be restricted to areas, null if search all
	 * @return array            Return the search results in an array
	 */
	function onContentSearch( $text, $phrase='', $ordering='', $areas=null )
	{
		$user	= JFactory::getUser(); 
		$groups	= implode(',', $user->getAuthorisedViewLevels());
 
		// If the array is not correct, return it:
		if (is_array( $areas )) {
			if (!array_intersect( $areas, array_keys( $this->onContentSearchAreas() ) )) {
				return array();
			}
		}
 
		// Now retrieve the plugin parameters like this:
		$limit = $this->params->get('limit', 50 );
 
		// Use the PHP function trim to delete spaces in front of or at the back of the searching terms
		$text = trim( $text );
 
		// Return Array when nothing was filled in.
		if ($text == '') {
			return array();
		}
 
		// After this, you have to add the database part.
		// This will be the most difficult part, because this changes per situation.
		$wheres = array();
		switch ($phrase) {
 
			// Search exact
			case 'exact':
				$text		= $this->db->Quote( '%'.$this->db->escape( $text, true ).'%', false );
				$wheres2 	= array();
				$wheres2[] 	= 'LOWER(item.title) LIKE '.$text;
				$where 		= '(' . implode( ') OR (', $wheres2 ) . ')';
				break;
 
			// Search all or any
			case 'all':
			case 'any':
 
			// Set default
			default:
				$words 	= explode( ' ', $text );
				$wheres = array();
				foreach ($words as $word)
				{
					$word		= $this->db->Quote( '%'.$this->db->escape( $word, true ).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'LOWER(item.title) LIKE '.$word;
					$wheres[] 	= implode( ' OR ', $wheres2 );
				}
				$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
				break;
		}
 
		// Ordering of the results
		switch ( $ordering ) {
 
			//Alphabetic, ascending
			case 'alpha':
				$order = 'item.title ASC';
				break;
			// Oldest first
			case 'oldest':
 				$order = 'item.created ASC';
 				break;
			// Popular first
			case 'popular':
 				$order = 'item.hits DESC';
 				break;
			// Newest first
			case 'newest':
 				$order = 'item.created DESC';
 				break;
			// Default setting: alphabetic, ascending
			default:
				$order = 'item.title ASC';
		}
 
		// Replace osadpappsearch
		$section = JText::_( 'Applications' );
 
		// The database query; differs per situation:
		$query	= $this->db->getQuery(true);
		$query->select('item.id AS itemId, category.id AS catId, item.title AS title, item.hits AS hits, item.created AS created, item.description AS text');
				$query->select($query->concatenate(array($this->db->Quote($section), 'category.title'), " / ").' AS section');
				$query->select('"1" AS browsernav');
				$query->from('#__ars_items AS item');
				$query->innerJoin('#__ars_releases AS releases ON releases.id = item.release_id');
				$query->innerJoin('#__ars_categories AS category ON category.id = releases.category_id');
				$query->where('('. $where .')');
				$query->order($order);
 
		$this->db->setQuery( $query, 0, $limit );
		$rows = $this->db->loadObjectList();
		// Build the links to our applications, the parameter is a configuration
		// in our manifest and is set in the plugin's Joomla admin settings
		foreach($rows as $key => $row) {
			$link = $this->params['applications_page'] . '#/';
			$rows[$key]->href = $link . $row->catId.'/'. $row->itemId;
		}
 
	// Return the search results in an array
	return $rows;
	}
}