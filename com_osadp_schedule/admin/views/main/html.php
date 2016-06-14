<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpViewsMainHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
   
    //retrieve task list from model
    $modelSchedules = new OsadpModelsSchedule();

    // delete schedule when requested
    if( isset($_POST['id']) ) {
      $id = $_POST['id'];
      $modelSchedules->deleteSchedule( $id );
    }

    // search projects
    if(isset($_POST['searchParam'])) {
      $this->param = $_POST['searchParam'];
      $this->schedules = $modelSchedules->searchScheduleByName($this->param);
    } else {
      $this->param = '';
      // get Schedule items from our model
      $this->schedules = $modelSchedules->getSchedules();
    }

    // clear search
    if(isset($_POST['clearSearch']))
      header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . '/administrator/index.php?option=com_osadp_schedule');

    // add a toolbar if available
    $this->addToolbar();
    // render our tmpl/default
    return parent::render();
  } 

  /**
   * Add the page title and toolbar.
   *
   * @since   1.6
   */
  protected function addToolbar()
  {
    $canDo  = OsadpHelpersSchedule::getActions();

    // Get the toolbar object instance
    $bar = JToolBar::getInstance('toolbar');

    JToolbarHelper::title(JText::_('COM_OSADP_SCHEDULE'));
    // add other view links
    $bar->appendButton('Link', 'new', 'New Schedule', '/administrator/index.php?option=com_osadp_schedule&view=new');
           
    if ($canDo->get('core.admin'))
    {
      // JToolbarHelper::preferences('com_leidos_Schedule_multicategories');
    }
  }
}