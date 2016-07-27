<?php
    /**
     * 
     */
    defined('_JEXEC') or die;

    class ModuleHelper {

        function getAll() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT * FROM #__table_name";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadResult();
        }
        
    }
?>