


<?php
/**
 * Helper class for Custom Icon Links module
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
    defined('_JEXEC') or die;

    class OSADPStatistics {

        function getReleases() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT COUNT(*) FROM #__ars_items as i INNER JOIN #__ars_releases as r ON i.release_id = r.id";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadResult();
        }

        function getDownloads() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT SUM(items.hits) FROM #__ars_items as items INNER JOIN #__ars_releases as releases ON items.release_id = releases.id";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadResult();
        }

    }
?>