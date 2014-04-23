<?php

class IndexController extends Zend_Controller_Action
{
    public $nodes;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->nodes = new Com_Model_Nodes();
        $this->pages = new Com_Model_Pages();
    }

    public function indexAction()
    {
        // action body
        //Zend_Debug::dump($this->nodes);
        Zend_Debug::dump($this->pages->fetch('1')->toArray());
        $page = $this->pages->fetch('1');
        //$this->page = new stdClass();
        $this->view->label = $page->title;
        $this->view->uri = $page->uri;
        $this->view->contentNodes = $page->findDependentRowset('Com_Model_PageNodes', 'PageNodes');
        
    }


}

