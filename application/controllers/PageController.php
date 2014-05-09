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
        // fetch all of the current pages
//         $select = $pageModel->select();
//         $select->order('name');
//         $currentPages = $pageModel->fetchAll($select);
        $currentPages = $pageModel->fetchListing(true);
        
        if($currentPages->count() > 0) {
            $this->view->pages = $currentPages;
        }else{
            $this->view->pages = null;
        }
    }

}
