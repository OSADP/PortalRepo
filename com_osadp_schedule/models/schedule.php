<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpModelsSchedule extends JModelBase {
	protected $limit = null;
	protected $limitstart = null;
	/**
   * Items total
   * @var integer
   */
  var $_total = null;
 
  /**
   * Pagination object
   * @var object
   */
  var $_pagination = null;
	/**
	 * Get all schedule saved from the DB
	 * @return array List of Schedules
	 */
	public function getSchedules() {
		$db = JFactory::getDbo();
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM jos_osadp_release_schedule ORDER BY name";

    $application = JFactory::getApplication();

    $config = JFactory::getConfig(); 

    $this->limitstart = JRequest::getInt( 'limitstart', 0 );
    $this->limit = $application->getUserStateFromRequest( 'global.list.limit', 
        'limit', $config->get('config.list_limit'), 'int' ); 

		$db->setQuery( $query, $this->limitstart, $this->limit );
		$_data = $db->loadObjectList();
		$db->setQuery('SELECT FOUND_ROWS();');
		
		jimport('joomla.html._pagination');
		$this->_pagination = new JPagination( $db->loadResult(), $this->limitstart, $this->limit );
		$this->_data = $_data;
		return $_data;
	}
	public function _getList($query, $limitstart, $limit) {
		$db = JFactory::getDbo();
    $application = JFactory::getApplication();
    $config = JFactory::getConfig(); 

		$db->setQuery( $query, $limitstart, $limit );
		$_data = $db->loadObjectList();
		$db->setQuery('SELECT FOUND_ROWS();');
		
		return $_data;
	}
	public function _getListCount($query) {
		$db = JFactory::getDbo();
    $application = JFactory::getApplication();
    $config = JFactory::getConfig(); 

		$db->setQuery( $query, $this->limitstart, $this->limit );
		$_data = $db->loadObjectList();
		
		return count($_data);
	}

	function getData() 
  {
	 	// if data hasn't already been obtained, load it
	 	if (empty($this->_data)) {
	 	    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM jos_osadp_release_schedule ORDER BY name";
	 	    $this->_data = $this->_getList($query, $this->limitstart, $this->limit);
	 	}
	 	return $this->_data;
  }
	function getTotal()
  {
	 	// Load the content if it doesn't already exist
	 	if (empty($this->_total)) {
	 	    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM jos_osadp_release_schedule ORDER BY name";
	 	    $this->_total = $this->_getListCount($query);	
	 	}
	 	return $this->_total;
  }

	function getPagination()
  {
	 	// Load the content if it doesn't already exist
	 	if (empty($this->_pagination)) {
	 	    jimport('joomla.html.pagination');
	 	    $this->_pagination = new JPagination($this->getTotal(), $this->limitstart, $this->limit );
	 	}
	 	return $this->_pagination;
  }

	public function getSchedules3($lim0, $lim) {
		$db = JFactory::getDbo();

    $db->setQuery('SELECT SQL_CALC_FOUND_ROWS * FROM jos_osadp_release_schedule',$lim0, $lim);
    $rL=&$db->loadAssocList();
    if (empty($rL)) {
    	$jAp->enqueueMessage($db->getErrorMsg(),'error'); return;
  	} else {
	    ////Here the beauty starts
	    $db->setQuery('SELECT FOUND_ROWS();'); 

			return $db->loadAssocList();
		}
	}
	/**
	 * Get Schedule information by Project Id
	 * @param  int 		$projectId Unique Id of the project
	 * @return object The Schedule/Project itself
	 */
	public function getScheduleById( $projectId ) {
		$db = JFactory::getDbo();
		$query = "SELECT * FROM jos_osadp_release_schedule WHERE id = '$projectId'";
		$db->setQuery( $query );

		return $db->loadObject();
	}
	public function searchScheduleByName( $param )
	{
		$db = JFactory::getDbo();
		$query = "SELECT * FROM jos_osadp_release_schedule WHERE name LIKE '%$param%'";
		$db->setQuery( $query );

		return $db->loadObjectList();
	}
	/**
	 * Insert a new Schedule to our DB
	 * @param  string $name      Name of the Project
	 * @param  string $date      Date to release the Project
	 * @param  string $notes     Notes
	 * @param  int $dma       	 Dynamic Mobility Application
	 * @param  int $available 	 Avaible or Coming Soon
	 * @param  int $published 	 Publish to client or not
	 * @param  string $username  Username of who created this Schedule
	 * @return boolean           Success or Fail
	 */
	public function saveSchedule($name, $image, $url, $date, $fullDate, $notes, $capabilities, $dma, $available, $published, $daysNew, $username)
	{
		$db = JFactory::getDbo();

		$name = $db->escape($name);
		$image = $db->escape($image);
		$url = $db->escape($url);
		$notes = $db->escape($notes);
		$capabilities = $db->escape($capabilities);
		$username = $db->escape($username);
		$created = date_format(date_create(), 'Y-m-d H:i:s');
		$date = date_format(date_create_from_format('m-d-Y H:i:s', $date . ' 00:00:00'), 'Y-m-d H:i:s');

		$query = "INSERT INTO jos_osadp_release_schedule
							(name, image, url, date, full_date, notes, capabilities, dma, available, published, days_new, created, created_by)
							VALUES ('$name', '$image', '$url', '$date', $fullDate, '$notes', '$capabilities', $dma, $available, $published, $daysNew, '$created', '$username')";
		$db->setQuery($query);
		return $db->execute();
	}
	/**
	 * Update a Schedule by it's ID
	 * @param  int $id 					 Unique ID associated with the Project we're updating
	 * @param  string $name      Name of the Project
	 * @param  string $date      Date to release the Project
	 * @param  string $notes     Notes
	 * @param  int $dma       	 Dynamic Mobility Application
	 * @param  int $available 	 Avaible or Coming Soon
	 * @param  int $published 	 Publish to client or not
	 * @param  string $username  Username of who created this Schedule
	 * @return boolean           Success or Fail
	 */
	public function updateSchedule($id, $name, $image, $url, $date, $fullDate, $notes, $capabilities, $dma, $available, $published, $daysNew, $username)
	{
		$db = JFactory::getDbo();

		$name = $db->escape($name);
		$image = $db->escape($image);
		$url = $db->escape($url);
		$date = $db->escape($date);
		$notes = $db->escape($notes);
		$capabilities = $db->escape($capabilities);
		$username = $db->escape($username);
		$modified = date_format(date_create(), 'Y-m-d H:i:s');
		$date = date_format(date_create_from_format('m-d-Y H:i:s', $date . ' 00:00:00'), 'Y-m-d H:i:s');

		$query = "UPDATE jos_osadp_release_schedule
							SET
								name='$name',
								image='$image',
								url='$url',
								date='$date',
								full_date=$fullDate,
								notes='$notes',
								capabilities='$capabilities',
								dma=$dma,
								available=$available,
								published=$published,
								modified='$modified',
								last_modified_by='$username',
								days_new='$daysNew'
							WHERE id=$id";
		$db->setQuery($query);
		return $db->execute();
	}
	/**
	 * Delete a schedule by id
	 * @param  int $id Unique id associated with the schedule
	 * @return boolean Delete success of fail
	 */
	public function deleteSchedule($id)
	{
		$db = JFactory::getDbo();
		$query = "DELETE FROM jos_osadp_release_schedule WHERE id=$id";
		$db->setQuery($query);
		return $db->execute();
	}
	/**************************/
	/****** APPLICATIONS ******/
	/**************************/
	/**
 	 * Get Applications by Project Id
	 * @param  int $id Project/Schedule Id
	 * @return array List of Applications associated by Project Id
	 */
	public function getApplications($id)
	{
		$db = JFactory::getDbo();
		$query = "SELECT * FROM jos_osadp_release_applications WHERE project_id = $id";
		$db->setQuery( $query );

		return $db->loadObjectList();
	}
	/**
	 * Save Application with associated Project
	 * @param  int $projectId 		Project ID associated with the app
	 * @param  string $appname   	Name of the application
	 * @param  string $username  	Username of the creator
	 * @return boolean            Success or failure
	 */
	public function saveApplication($projectId, $appname, $username)
	{
		$created = date_format(date_create(), 'Y-m-d H:i:s');
		$db = JFactory::getDbo();
		$query = "INSERT INTO jos_osadp_release_applications
							(project_id, name, created, created_by)
							VALUES ($projectId, '$appname', '$created', '$username')";
		$db->setQuery($query);
		return $db->execute();
	}
	/**
	 * Delete any application associated with the Project Id given
	 * @param  int $projectId 	The associated ID of the applications
	 * @return boolean          Success or failure
	 */
	public function deleteApplications($projectId)
	{
		$db = JFactory::getDbo();
		$query = "DELETE FROM jos_osadp_release_applications WHERE project_id = $projectId";
		$db->setQuery($query);

		return $db->execute();
	}
}