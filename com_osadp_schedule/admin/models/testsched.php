<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpTest extends JModelBase {
  var $_total = null;
  var $_pagination = null;

  function __construct()
  {
        parent::__construct();
 
        global $option;
        $mainframe = JFactory::getApplication();
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');

        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
  }


    /**
     * Loads the pagination
     */
  function getPagination()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  }

    /**
     * Gets the total number of products
     */
  function getTotal()
  {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  }
  function getData() 
  {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
        }
        return $this->_data;
  }

  
      function _buildQuery()
      {
          $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__osadp_release_schedule ');
        return $query;
      }

}
	/**
	 * Get all schedule saved from the DB
	 * @return array List of Schedules
	 */
	public function getSchedules() {
		$db = JFactory::getDbo();
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM jos_osadp_release_schedule";

    $application = JFactory::getApplication();

    $config = JFactory::getConfig(); 

    $limitstart = JRequest::getInt( 'limitstart', 0 );
    $limit = $application->getUserStateFromRequest( 'global.list.limit', 
        'limit', $config->get('config.list_limit'), 'int' ); 

		$db->setQuery( $query, $limitstart, $limit );
		$_data = $db->loadObjectList();
		$db->setQuery('SELECT FOUND_ROWS();');
		
		jimport('joomla.html._pagination');
		$this->pagination = new JPagination( $db->loadResult(), $limitstart, $limit );

		return $_data;
	}
}