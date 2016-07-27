


<?php
/**
 * Helper class for Custom Icon Links module
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
    defined('_JEXEC') or die;

    class ArsRelease {

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

        function getItems() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT * FROM #__ars_items as i INNER JOIN #__ars_releases as r ON i.release_id = r.id";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }

        function getUsers() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT `id`, `name` FROM #__users";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }

        function getDiscussions() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT `id`, `subject` FROM #__kunena_topics";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }

    }
?>