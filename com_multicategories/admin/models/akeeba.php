<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpModelsAkeeba extends JModelBase {
	// get akeeba categories
	public function getCategories() {
		$db = JFactory::getDbo();
		$query = $db->getQuery( true );
		$query->select( $db->quoteName( array('id', 'title') ) )
			->from( $db->quoteName('#__ars_categories') )
			->order('title');
		$db->setQuery( $query );

		return $db->loadObjectList();
	}
	// get all akeeba items
	public function getAllItems() {
		$db = JFactory::getDbo();
		$query = $db->getQuery( true );
		$query->select( $db->quoteName( array('item.id', 'item.title', 'item.release_id', 'rel.category_id') ) )
			->from( $db->quoteName('#__ars_items', 'item') )
			->join('LEFT', $db->quoteName('#__ars_releases', 'rel') . ' ON (' . $db->quoteName('item.release_id') . ' = ' . $db->quoteName('rel.id') . ')')
			->where('rel.category_id != \'NULL\'')
			->order('title');
		$db->setQuery( $query );

		return $db->loadObjectList();
	}
	// get and item by id
	public function getItemById( $itemId ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery( true );
		$query->select( $db->quoteName( array('item.id', 'item.title', 'item.release_id', 'rel.category_id') ) )
			->from( $db->quoteName('#__ars_items', 'item') )
			->join('LEFT', $db->quoteName('#__ars_releases', 'rel') . ' ON (' . $db->quoteName('item.release_id') . ' = ' . $db->quoteName('rel.id') . ')')
			->where('item.id = ' . $itemId );
		$db->setQuery( $query );

		return $db->loadObject();
	}

}