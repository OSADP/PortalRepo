


<?php
/**
 * Helper class for Custom Icon Links module
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
    defined('_JEXEC') or die;

    class ArsSearcher {

    	function getReleases() {
	    	// create our database object
	    	$db = JFactory::getDbo();
    		// create our SQL query
    		$query = "SELECT * FROM #__ars_releases as r  INNER JOIN #__ars_categories as c  ON r.category_id = c.id";
            // query the database
            $db->setQuery( $query );
            // return our result
	    	return $db->loadObjectList();
    	}

    	function getAuthor() {
    		return "Robert Roth";
    	}

    }
?>