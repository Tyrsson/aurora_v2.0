<?php

/**
 * AdminController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class AdminController extends Zend_Controller_Action
{
    public function preDispatch()
    {
        $this->_helper->actionContext();
    }
    public function init()
    {
        
    }
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated AdminController::indexAction() default action
    }
    
}
