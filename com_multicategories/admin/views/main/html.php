<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpViewsMainHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $input = $app->input;
    //retrieve task list from model
    $model = new OsadpModelsAkeeba();
    // get item id from our parameter
    $itemId = $input->getInt('itemId', 0);
    // get application by item id
    $this->item = $model->getItemById( $itemId );
    // get all categories
    $this->categories = $model->getCategories();
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
        $canDo = OsadpHelpersAkeeba::getActions();

        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');

        JToolbarHelper::title(JText::_('COM_MULTICATEGORIES'));
               
        if ($canDo->get('core.admin'))
        {
            // JToolbarHelper::preferences('com_leidos_akeeba_multicategories');
        }
    }
}