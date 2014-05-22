<?php

/**
 * PageAdminController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class PageAdminController extends Zend_Controller_Action
{
	public $isAdmin = true;
	
    public function preDispatch()
    {
        $this->_helper->actionContext();
       // Zend_Debug::dump($this->_request->controller);
    }
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated PageAdminController::indexAction() default action
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
    public function createAction()
    {
        //$this->_helper->adminAction();
        $pageForm = new Cms_Form_ManagePage();
        //$pageForm->setAction('/page/create');
    
        if($this->_request->isPost()) {
            if($pageForm->isValid($this->_request->getPost())) {
    
                $data = $pageForm->getValues();
                $filter = new Zend_Filter_Word_SeparatorToDash();
                $data['uri'] = $filter->filter($data['name']);
                
                $page = new Aurora_Model_Pages();
                $page->createPage($data);
    
                return $this->forward('list');
                //} catch (Exception $e) {
                //echo $e->getMessage();
                //}
            }
        }
    
        $this->view->form = $pageForm;
    }
    public function editAction()
    {
        $id = $this->_request->getParam('id');
        $model = new Aurora_Model_Pages();
        $pageForm = new Cms_Form_ManagePage();
        if($this->_request->isPost()) {
            if($pageForm->isValid($this->_request->getPost())) {
    
                $data = $pageForm->getValues();
                
                $filter = new Zend_Filter_Word_SeparatorToDash();
                $data['uri'] = $filter->filter($data['name']);
    
                // save the content item
                $model->updatePage($id, $data);
    
                return $this->forward('list');
            }
        }
        else {
            $page = $model->fetch($id);
            if(isset($page['image']) && $page['image'] != null)
            {
                $page['current_image'] = $page['image'];
                // create the image preview
                $imagePreview = $pageForm->createElement('image', 'image_preview');
                // element options
                $imagePreview->setLabel('Preview Image: ');
                $imagePreview->setAttrib('style', 'width:200px;height:auto;');
                // add the element to the form
                $imagePreview->setOrder(4);
                $imagePreview->setImage('/modules/cms/content/'.$page['image']);
                $pageForm->addElement($imagePreview);
            }
             
            $pageForm->populate($page);
        }
        $this->view->form = $pageForm;
    }
    public function deleteAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $id = $this->_request->id;
        $page = new Aurora_Model_Pages();
        $row = $page->find($id)->current();
        $row->delete();
        $this->forward('list');
    }
}
