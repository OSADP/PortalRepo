<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpControllersDisplay extends JControllerBase
{
  public function execute()
  {

    // Get the application
    $app = $this->getApplication();
 
    // Get the document object.
    $document     = JFactory::getDocument();
 
    $viewName     = $app->input->getWord('view', 'akeeba');
    $viewFormat   = $document->getType();
    $layoutName   = $app->input->getWord('layout', 'default');

    $app->input->set('view', $viewName);
 
    // Register the layout paths for the view
    $paths = new SplPriorityQueue;
    $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');
    // get our view class
    $viewClass  = 'OsadpViewsAkeebaHtml';
    // get our model
    $modelClass = 'OsadpModelsAkeeba';

    $view = new $viewClass(new $modelClass, $paths);

    $view->setLayout($layoutName);

    // Render our view.
    echo $view->render();
 
    return true;
  }

}