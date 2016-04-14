<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class OsadpControllersDisplay extends JControllerBase {
  public function execute() {
    // Get the application
    $app = $this->getApplication();
    // Get the document object.
    $document     = JFactory::getDocument();
    $viewName     = $app->input->getWord('view', 'statistics');
    $viewFormat   = $document->getType();
    $layoutName   = $app->input->getWord('layout', 'default');
    // set our view to views/statistics
    $app->input->set('view', $viewName);
    // Register the layout paths for the view
    $paths = new SplPriorityQueue;
    $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');
    // get our view's class 'OsadpViewsStatisticsHtml'
    $viewClass  = 'OsadpViews' . ucfirst($viewName) . ucfirst($viewFormat);
    // get our model's class 'OsadpModelsStatistics'
    $modelClass = 'OsadpModels' . ucfirst($viewName);
    // instantiate our view 'views/statistics'
    $view = new $viewClass(new $modelClass, $paths);
    // set the layout 'default.php'
    $view->setLayout( $layoutName );
    // Render our view.
    echo $view->render();

    return true;
  }
}