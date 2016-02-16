<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpModelsAkeeba extends JModelBase {

 public function getCategories() {
 		$db = JFactory::getDbo();
    // get akeeba categories
    $query = $db->getQuery( true );
    $query->select( $db->quoteName( array('id', 'title') ) )
          ->from( $db->quoteName('#__ars_categories') )
          ->order('title');
    $db->setQuery( $query );
    
    return $db->loadObjectList();
 }

}