


<?php
/**
 * Helper class for this Module
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
    defined('_JEXEC') or die;

    class ScheduleHelper {
        /**
         * Get all release schedules
         * @return array
         */
        function getAll() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT * FROM #__osadp_release_schedule WHERE published = 1 ORDER BY date DESC";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }
        /**
         * Get schedules that aren't available yet
         * @return array
         */
        function getComingSoon() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT * FROM #__osadp_release_schedule WHERE published = 1 AND available = 0 ORDER BY date DESC";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }
        /**
         * Get available schedules
         * @return array
         */
        function getAvailable() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT * FROM #__osadp_release_schedule WHERE published = 1 AND available = 1 ORDER BY date DESC";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }

    }
?>