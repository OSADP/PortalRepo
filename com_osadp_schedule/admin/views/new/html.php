<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpViewsNewHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $input = $app->input;
    $user = JFactory::getUser();
    
    //retrieve task list from model
    $modelSchedules = new OsadpModelsSchedule();
    $this->saveSuccess = -1;

    // save schedule on request
    if( isset($_POST['name']) && isset($_POST['date']) && isset($_POST['notes']) ) {

      $name = $_POST['name'];
      $url = (isset($_POST['url'])) ? $_POST['url'] : '';
      $image = (isset($_POST['image'])) ? $_POST['image'] : '';
      $date = $_POST['date'];
      $notes = $_POST['notes'];
      $capabilities = $_POST['capabilities'];
      $dma = $_POST['dma'];
      $available = $_POST['available'];
      $published = $_POST['published'];
      $fullDate = $_POST['fullDate'];
      $daysNew = $_POST['daysNew'];

      if( $name != '' && $date != '' && $notes != '' ) {
        $confirm = $modelSchedules->saveSchedule($name, $image, $url, $date, $fullDate, $notes, $capabilities, $dma, $available, $published, $daysNew, $user->username );
        if($confirm) {
          unset($_POST);
          $_POST = array();
          $this->saveSuccess = 1;
        } else {
          $this->saveSuccess = 0;
        }
      }
    }
    
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
    JToolbarHelper::apply('', 'Save');
    // $bar->appendButton('Link', 'save', 'Save', '#');
    $bar->appendButton('Link', 'save', 'Save &amp; Close', '/administrator/index.php?option=com_osadp_schedule');
    $bar->appendButton('Link', 'cancel', 'Cancel', '/administrator/index.php?option=com_osadp_schedule');
    
    if ($canDo->get('core.admin'))
    {
        // JToolbarHelper::preferences('com_leidos_akeeba_multicategories');
    }
  }
}