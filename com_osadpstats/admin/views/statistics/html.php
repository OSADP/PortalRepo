
<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpViewsStatisticsHtml extends JViewHtml
{
  /**
  * Get items in a given month and year; default to current date.
  * @param $month - integer representing a month 1-12
  * @param $year - integer representing a year e.g. 2015
  * @since 0.0.12
  */
  function getItemsThisMonth( $month ) {
    // instantiate our Statistics model
    $modelStats = new OsadpModelsStatistics();
    // set current month and year
    $month = ( isset( $month ) ) ? $month : date('n');
    $year = date('Y');
    // return our item/s
    return $modelStats->getItemsByMonth( $month, $year );
  }

  /**
   * Get top downloaded items within the given period.
   * @param  string $from  starting date period
   * @param  string $until ending date period
   * @return array
   */
  function getItemsThisPeriod( $from, $until ) {
    $modelStats = new OsadpModelsStatistics();
    if( ! isset($from) && ! isset($until) ) {
      $from = $year . '-' . $month . '-' . '1';
      $until = $year . '-' . ($month + 1) . '-' . '1';
    }
    $from .= ' 00:00:00';
    $until .= ' 23:59:59';

    return $modelStats->getItemsThisPeriod( $from, $until );
  }

  /**
   * Query database for recently created apps.
   * @param $limit - integer that we use to set the limit in our query.
   * @since 0.0.12
   */
  function getLatestApplications( $from, $until ) {
    $modelStats = new OsadpModelsStatistics();
    if( ! isset($from) && ! isset($until) ) {
      $from = $year . '-' . $month . '-' . '1';
      $until = $year . '-' . ($month + 1) . '-' . '1';
    }
    $from .= ' 00:00:00';
    $until .= ' 23:59:59';
    // return our item/s
    return $modelStats->getLatestApplications( $from, $until );
  }

  function getDownloadsThisMonth( $from, $until ) {
    $modelStats = new OsadpModelsStatistics();
    if( ! isset($from) && ! isset($until) ) {
      $from = $year . '-' . $month . '-' . '1';
      $until = $year . '-' . ($month + 1) . '-' . '1';
    }
    $from .= ' 00:00:00';
    $until .= ' 23:59:59';
    return $modelStats->getDownloadsByMonth($from, $until);
  }
  /**
  * Get items in a given month and year; default to current date.
  * @param $month - integer representing a month 1-12
  * @param $year - integer representing a year e.g. 2015
  * @since 0.1.0
  */
  function getUsersThisMonth( $from, $until) {
    // instantiate our Statistics model
    $modelStats = new OsadpModelsStatistics();
    if( ! isset($from) && ! isset($until) ) {
      $from = $year . '-' . $month . '-' . '1';
      $until = $year . '-' . ($month + 1) . '-' . '1';
    }
    $from .= ' 00:00:00';
    $until .= ' 23:59:59';
    // return our item/s
    return $modelStats->getUsersByMonth( $from, $until );
  }
  /**
  * @since 0.1.0
  */
  function getRegistrationsThisYear() {
    // instantiate our Statistics model
    $modelStats = new OsadpModelsStatistics();
    $year = date('Y');
    return $modelStats->getRegistrationsByYear( $year );
  }
  /**
  * @since 0.1.0
  */
  function getRegistrationsLastYear() {
    // instantiate our Statistics model
    $modelStats = new OsadpModelsStatistics();
    $year = date("Y",strtotime("-1 year"));
    return $modelStats->getRegistrationsByYear( $year );
  }
  function testRange($from, $until) {
    $modelStats = new OsadpModelsStatistics();
    return $modelStats->testRange($from, $until);
  }
  /**
   * Add the page title and toolbar.
   *
   * @since   0.0.1
   */
  protected function addToolbar() {
    $canDo  = OsadpHelpersOsadpstats::getActions();
    // Get the toolbar object instance
    $bar = JToolBar::getInstance('toolbar');
    JToolbarHelper::title(JText::_('COM_OSADPSTATS_STATISTICS'));
    if ($canDo->get('core.admin')) {
      JToolbarHelper::preferences('com_osadpstats');
    }
  }

  /**
   * Define models and render our View.
   */
  function render() {
    $app = JFactory::getApplication();
    // retrieve task list from model
    $modelStatistics = new OsadpModelsStatistics();
    $this->modelStatistics = $modelStatistics->getStats();
    // add our toolbar
    $this->addToolbar();
    // display
    return parent::render();
  } 
}