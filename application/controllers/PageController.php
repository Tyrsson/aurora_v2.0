<?php

/**
 * PageController
 * 
 * @author Joey Smith
 * @version 2.0.0
 */

require_once 'Zend/Controller/Action.php';

class PageController extends Zend_Controller_Action
{
    public $acl;
    
	public function preDispatch()
	{
		$this->_helper->actionContext();
		$this->acl = new Cms_Acl();
		$this->view->acl = $this->acl;
	}
    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // TODO Auto-generated PageController::indexAction() default action
        
    }
    public function listAction()
    {
        $pageModel = new Aurora_Model_Pages();

        $currentPages = $pageModel->fetchListing(true);
        
        if($currentPages->count() > 0) {
            $this->view->pages = $currentPages;
        }
        else {
            $this->view->pages = null;
        }
        $this->view->currentPageNumber = $this->_request->getParam('page', 1);
    }
    public function viewAction()
    {
        if(isset($this->_request->uri)) {
        	$model = new Aurora_Model_Pages();
        	$this->view->page = $model->fetchByUri($this->_request->uri);
        }
        else {
            throw new Zend_Controller_Action_Exception(Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION, 404);
        }
    }
}
