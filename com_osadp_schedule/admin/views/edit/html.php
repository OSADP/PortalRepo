<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpViewsEditHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $input = $app->input;
    // get user
    $user = JFactory::getUser();
    //retrieve task list from model
    $modelSchedules = new OsadpModelsSchedule();
    // get item id from our parameter
    $projectId = $input->getInt('projectId', 0);
    /**
     * Update our user when a POST request is available
     * @since 0.3.2
     */
    $this->updateSuccess = -1;
    if( isset($_POST['name']) && isset($_POST['url']) && isset($_POST['date']) && isset($_POST['notes']) ) {
        $name = $_POST['name'];
        $url = $_POST['url'];
        $date = $_POST['date'];
        $fullDate = $_POST['fullDate'];
        $notes = $_POST['notes'];
        $capabilities = $_POST['capabilities'];
        $dma = $_POST['dma'];
        $available = $_POST['available'];
        $published = $_POST['published'];

        $this->updateSuccess = $modelSchedules->updateSchedule($projectId, $name, $url, $date, $fullDate, $notes, $capabilities, $dma, $available, $published, $user->username);
    }
    /**
     * Save Applications to this Project when available
     * @since  0.4.0
     */
    if(isset($_POST['apps'])) {
        $apps = $_POST['apps'];
        foreach ($apps as $key => $app) {
            if($app != '')
                $modelSchedules->saveApplication($projectId, $app, $user->username);
        }
    }
    // get application by item id
    $this->project = $modelSchedules->getScheduleById( $projectId );
    // display toolbar if available
    $this->addToolbar();

    //display
    return parent::render();
  } 

    /**
     * Add the page title and toolbar.
     *
     * @since   1.6
     */
    protected function addToolbar()
    {
        $canDo = OsadpHelpersSchedule::getActions();

        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');
        // get our title from our language files
        JToolbarHelper::title(JText::_('COM_OSADP_SCHEDULE'));
        // add other view links
        $bar->appendButton('Link', 'save', 'Save', '#');
        $bar->appendButton('Link', 'cancel', 'Close', '/administrator/index.php?option=com_osadp_schedule');
        
        if ($canDo->get('core.admin'))
        {
            // JToolbarHelper::preferences('com_leidos_akeeba_multicategories');
        }
    }
}