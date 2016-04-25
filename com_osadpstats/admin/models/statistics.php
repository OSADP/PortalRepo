<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpModelsStatistics extends JModelBase
{
 /**
  * @return array A list of statistics
  */
 public function getStats()
 {
    $db = JFactory::getDbo();
    $stats = array();

    //Retrieve total number of registered users
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__users');
    $db->setQuery($query);
    $stats['total_users'] = $db->loadResult();

    //Retrieve total number of active users
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__users')
          ->where("activation = ''");
    $db->setQuery($query);
    $stats['total_active_users'] = $db->loadResult();

    //Retrieve total number of inactive users
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__users')
          ->where("activation != ''");
    $db->setQuery($query);
    $stats['total_inactive_users'] = $db->loadResult();

    // get average user register per day
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__users');
    $db->setQuery($query);
    $allUsers = $db->loadResult();
    $stats['avg_register_per_day'] = $allUsers > 0 ? round($allUsers / 365, 2) : 0;

    //Retrieve total number of inactive users
    $query = $db->getQuery(true);
    $query->select( $db->quoteName(array('id', 'release_id', 'title', 'hits')) )
          ->from( $db->quoteName('#__ars_items') )
          ->where($db->quoteName('hits') . '> 0')
          ->order('hits DESC');
    $db->setQuery($query);
    $stats['top_downloads'] = $db->loadObjectList();

        // get akeeba categories
    $query = $db->getQuery( true );
    $query->select( $db->quoteName( array('id', 'title') ) )
          ->from( $db->quoteName('#__ars_categories') )
          ->order('title');
    $db->setQuery( $query );
    $stats['categories'] = $db->loadObjectList();

    $query = $db->getQuery( true );
    $query->select( $db->quoteName( array('id', 'username', 'email', 'registerDate', 'activation') ) )
    ->from( $db->quoteName('#__users') )
    ->order('registerDate DESC')
    ->setLimit( 5 );
    $db->setQuery( $query );
    $stats['latest_users'] = $db->loadObjectList();

    return $stats;
  }

  /**
   * Get registered users for this year and the previous year.
   * @param int $year Four numbers representing a year e.g. 2015.
   * @return array|null List of registrations grouped by month.
   */
  function getRegistrationsByYear( $year ) {
    $db = JFactory::getDbo();
    $query = $db->getQuery( true );
    $query->select('COUNT(*) as registrations, MONTH(registerDate) as month')
    ->from('#__users')
    ->where('YEAR(registerDate) = '. $year)
    ->group('MONTH(registerDate)');
    $db->setQuery( $query );
    return $db->loadObjectList();
  }

  /**
   * Get all items in a given month.
   * @param int $month integer representing a month 1 - 12.
   * @param int $year integer representing a year e.g. 2015.
   * @return array|null a list of downloads by day
   */
  function getItemsByMonth( $month, $year ) {
    $db = JFactory::getDbo();
    $from = $year . '-' . $month . '-' . '1';
    $until = $year . '-' . ($month + 1) . '-' . '1';
    $query = "SELECT id, title, created
              FROM jos_ars_items WHERE created BETWEEN '$from' AND '$until'
              ORDER BY created";
    $db->setQuery( $query );
    return $db->loadObjectList();
  }
  
  /**
   * Query database for recently created apps.
   * @param  int $limit Will be the amount of applications returned.
   * @return array|null A list of the latest applications created.
   */
  function getLatestApplications( $from, $until ) {
    $db = JFactory::getDbo();

    $query = "SELECT i.id, i.title, r.created
    FROM jos_ars_items as i
    LEFT JOIN jos_ars_releases as r
    ON i.release_id = r.id
    WHERE r.created BETWEEN '$from' AND '$until'
    ORDER BY r.created DESC";

    $db->setQuery($query);

    return $db->loadObjectList();
  }

  /**
   * Get downloads by month grouped daily, this is primarily
   * used in the Daily Downloads module in our component.
   * @param int $month integer representing a month 1 - 12.
   * @param int $year integer representing a year e.g. 2015.
   * @return array|null a list of downloads by day
   */
  function getUsersByMonth( $from, $until ) {
    $db = JFactory::getDbo();
    if( isset($from) && isset($until) ) {
      $query = "SELECT id, username, email, registerDate, activation
                FROM jos_users WHERE registerDate BETWEEN '$from' AND '$until'
                ORDER BY registerDate DESC";
      $db->setQuery( $query );
      return $db->loadObjectList();
    } else {
      return null;
    }
  }

  /**
   * Get downloads by month grouped daily, this is primarily
   * used in the Daily Downloads module in our component.
   * @param int $month integer representing a month 1 - 12.
   * @param int $year integer representing a year e.g. 2015.
   * @return array|null a list of downloads by day
   */
  function getDownloadsByMonth( $from, $until ) {
    $db = JFactory::getDbo();
    $query = "SELECT COUNT(*) as downloads, DAY(accessed_on) as day, MONTH(accessed_on) as month
              FROM jos_ars_log WHERE authorized = 1 AND accessed_on BETWEEN '$from' AND '$until'
              GROUP BY DAY(accessed_on), MONTH(accessed_on)";
    $db->setQuery( $query );
    return $db->loadObjectList();
  }

  function getItemsThisPeriod( $from, $until ) {
    $db = JFactory::getDbo();
    $query = "SELECT COUNT(*) as downloads, log.item_id as id, log.accessed_on as 'date', item.title
              FROM jos_ars_log as log
              INNER JOIN jos_ars_items as item
              ON log.item_id = item.id
              WHERE log.accessed_on BETWEEN '$from' AND '$until'
              GROUP BY item.title
              ORDER BY downloads DESC";
    $db->setQuery( $query );
    return $db->loadObjectList();
  }

  function testRange($from, $until) {
    $db = JFactory::getDbo();
    $query = "SELECT username FROM jos_users WHERE DATE(registerDate) BETWEEN '$from' AND '$until'";
    $db->setQuery( $query );
    return $db->loadObjectList();
  }

  // function getDownloadsByMonth( $month, $year ) {
  //   $db = JFactory::getDbo();
  //   $query = $db->getQuery( true );
  //   $query->select('COUNT(*) as downloads, DAY(accessed_on) as day, MONTH(accessed_on) as month')
  //   ->from('#__ars_log')
  //   ->where('MONTH(accessed_on) = '. $month .' AND YEAR(accessed_on) = '. $year)
  //   ->group('DAY(accessed_on), MONTH(accessed_on)');
  //   $db->setQuery( $query );
  //   return $db->loadObjectList();
  // }
  /**
   * @desc Get items by month; uses current date as default;
   * @param $month - integer representing a month 1 - 12.
   * @param $year - integer representing a year e.g. 2015.
   */
  // function getUsersByMonth( $month, $year ) {
  //   // set today's month/year if month/year variable is undefined
  //   $month = (isset($month)) ? $month : date('n');
  //   $year = (isset($year)) ? $year : date('Y');
  //   $db = JFactory::getDbo();
  //   $query = $db->getQuery( true );
  //   $query->select( $db->quoteName( array('id', 'username', 'email', 'registerDate', 'activation') ) )
  //   ->from('#__users')
  //   ->where('MONTH(registerDate) = '.$month.' AND YEAR(registerDate) = '.$year)
  //   ->order('registerDate DESC');
  //   $db->setQuery( $query );

  //   return $db->loadObjectList();
  // }

  /**
   * Get all items in a given month.
   * @param  int $month 1-12 Representing a month.
   * @param  int $year Four digit representation of a year e.g. 2016.
   * @return array|null A list of OSADP apps in a month.
   */
  // function getItemsByMonth( $month, $year ) {
  //   // set today's month/year if month/year variable is undefined
  //   $month = (isset($month)) ? $month : date('n');
  //   $year = (isset($year)) ? $year : date('Y');
  //   $db = JFactory::getDbo();
  //   $query = $db->getQuery( true );
  //   $query->select('id, title, created')
  //   ->from('#__ars_items')
  //   ->where('MONTH(created) = '.$month.' AND YEAR(created) = '.$year)
  //   ->order('created');
  //   $db->setQuery( $query );

  //   return $db->loadObjectList();
  // }

}