<?php

/**
 * PageController
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class PageController extends Zend_Controller_Action
{
	public function preDispatch()
	{
		$this->_helper->actionContext();
		$this->acl = new Cms_Acl();
		$this->view->acl = $this->acl;
	}
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated PageController::indexAction() default action
        
    }

    public function listAction()
    {
        $pageModel = new Aurora_Model_Pages();

        $currentPages = $pageModel->fetchListing(true);
        
        if($currentPages->count() > 0) {
            $this->view->pages = $currentPages;
        }else{
            $this->view->pages = null;
        }
    }
    public function viewAction()
    {
        if(isset($this->_request->uri)) {
        	Zend_Debug::dump($this->_request->uri);
        }
    }
}
