<?php

class IndexController extends Zend_Controller_Action
{
    public $nodes;
    public $uri;
    
    public function preDispatch()
    {
        
    }
    public function init()
    {
        /* Initialize action controller here */
        $this->pages = new Aurora_Model_Pages();
        //Zend_Debug::dump($this->pages);
        //exit();
    }

    public function indexAction()
    {
        
    }
    public function categoryAction()
    {
        
    }

}

