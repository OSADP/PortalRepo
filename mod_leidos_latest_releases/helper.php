


<?php
/**
 * Helper class for Custom Icon Links module
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
    defined('_JEXEC') or die;

    class LatestReleases {

        function getLatest() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "SELECT i.id, i.release_id, i.title, i.created, c.short_description, r.category_id
            FROM #__ars_items AS i 
            LEFT JOIN #__akeeba_item_custom AS c ON i.id = c.item_id
            INNER JOIN #__ars_releases AS r ON i.release_id = r.id
            WHERE i.published = 1 
            ORDER BY i.created DESC
            LIMIT 10";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }

    }
?>