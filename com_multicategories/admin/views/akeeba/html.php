<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpViewsAkeebaHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
   
    //retrieve task list from model
    $model = new OsadpModelsAkeeba();
    // get akeeba items from our model
    $this->akeebaItems = $model->getAllItems();
    // add a toolbar if available
    $this->addToolbar();
    // render our tmpl/default
    return parent::render();
  } 

  // Add the page title and toolbar.
  protected function addToolbar()
  {
    $canDo  = OsadpHelpersAkeeba::getActions();

    // Get the toolbar object instance
    $bar = JToolBar::getInstance('toolbar');

    JToolbarHelper::title(JText::_('COM_MULTICATEGORIES'));
           
    if ($canDo->get('core.admin'))
    {
      // JToolbarHelper::preferences('com_leidos_akeeba_multicategories');
    }
  }
}