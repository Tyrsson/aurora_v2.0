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
    public function createAction()
    {
        $pageForm = new Cms_Form_ManagePage();
        $pageForm->setAction('/page/create');
        
        if($this->_request->isPost()) {
            if($pageForm->isValid($this->_request->getPost())) {
                
                $data = $pageForm->getValues();
                // create a new page item
                $itemPage = new Cms_Content_Item_Page();
                $itemPage->name = $data['name'];
                $itemPage->headline = $data['headline'];
                $itemPage->description = $data['description'];
                $itemPage->content = $data['content'];
                // upload the image
//                 if($pageForm->image->isUploaded()){
//                     $pageForm->image->receive();
//                     $itemPage->image = '/images/upload/' .
//                             basename($pageForm->image->getFileName());
//                 }
                // save the content item
                try {
                    $itemPage->save();
                    return $this->_forward('list');
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } 
        }
        
        $this->view->form = $pageForm;
    }
    public function listAction()
    {
        $pageModel = new Aurora_Model_Pages();
        // fetch all of the current pages
        $select = $pageModel->select();
        $select->order('name');
        $currentPages = $pageModel->fetchAll($select);
        if($currentPages->count() > 0) {
            $this->view->pages = $currentPages;
        }else{
            $this->view->pages = null;
        }
    }
    public function editAction()
    {
    
        $id = $this->_request->getParam('id');
        $itemPage = new Cms_Content_Item_Page($id);
        $pageForm = new Cms_Form_ManagePage();
        $pageForm->setAction('/page/edit');
        if($this->_request->isPost()) {
            if($pageForm->isValid($this->_request->getPost)) {
                
                $data = $pageForm->getValues();
                
                $itemPage->name = $data['name'];
                $itemPage->headline = $data['headline'];
                $itemPage->description = $data['description'];
                $itemPage->content = $data['content'];
                $itemPage->image = $data['image'];
    //             if($pageForm->image->isUploaded()){
    //                 $pageForm->image->receive();
    //                 $itemPage->image = '/images/upload/' .
    //                     basename($pageForm->image->getFileName());
    //             }
                // save the content item
                $itemPage->save();
                return $this->_forward('list');
            }
        }
    }
}
