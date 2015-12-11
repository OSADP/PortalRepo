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

 public function getCustomInfo() {
    $db = JFactory::getDbo();

    // get custom information for each categories
    $query = $db->getQuery( true );
    $query->select( $db->quoteName( array('id', 'category_id', 'fullname', 'description', 'created', 'modified') ) )
          ->from( $db->quoteName('#__akeebacustom') );
    $db->setQuery( $query );
    return $db->loadObjectList();
 }

}