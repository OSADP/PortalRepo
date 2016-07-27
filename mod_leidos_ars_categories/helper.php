


<?php
/**
 * Helper class for Leidos ARS Display Categories
 * 
 * @package    Leidos.Custom.OSADP
 * @subpackage Modules
 * @link http://itsforge.net
 */
    defined('_JEXEC') or die;

    class ArsDisplay {
        function getCategories() {
            // create our database object
            $db = JFactory::getDbo();
            // create our SQL query
            $query = "select category.*, custom.icon_url from #__ars_categories as category left join #__akeeba_category_custom as custom on category.id = custom.category_id";
            // query the database
            $db->setQuery( $query );
            // return our result
            return $db->loadObjectList();
        }

    }
?>