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
                
                $page = new Aurora_Model_Pages();
                $page->createPage($data);
                
                // create a new page item
//                 $itemPage = new Cms_Content_Item_Page();
//                 $itemPage->name = $data['name'];
//                 $itemPage->headline = $data['headline'];
//                 $itemPage->description = $data['description'];
//                 $itemPage->content = $data['content'];
//                 $itemPage->image = $data['image'];
                // upload the image
//                 if($pageForm->image->isUploaded()){
//                     $pageForm->image->receive();
//                     $itemPage->image = '/images/upload/' .
//                             basename($pageForm->image->getFileName());
//                 }
                // save the content item
               // try {
//                     $itemPage->save();
                    return $this->_forward('list');
                //} catch (Exception $e) {
                    //echo $e->getMessage();
                //}
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
            if($pageForm->isValid($this->_request->getPost())) {
                
                $data = $pageForm->getValues();
                //Zend_Debug::dump($data);
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
        else {
        	// create the image preview 
        	$imagePreview = $pageForm->createElement('image', 'image_preview');
        	// element options 
        	$imagePreview->setLabel('Preview Image: '); 
        	$imagePreview->setAttrib('style', 'width:200px;height:auto;'); 
        	// add the element to the form 
        	$imagePreview->setOrder(4); 
        	$imagePreview->setImage('/modules/cms/content/'.$itemPage->image); 
        	$pageForm->addElement($imagePreview);
        	$pageForm->populate($itemPage->toArray());
        }
        $this->view->form = $pageForm;
    }
}
