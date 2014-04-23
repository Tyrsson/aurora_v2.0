<?php
class System_Form_CreateCategory extends Zend_Dojo_Form
{
    public function init()
    {
        
        //Start Main Form
        $this->setAttribs(array(
            'name'  => 'wSFO',
            'data-dojo-id'  => 'wSFO',
            'action' => '/admin/page/create/category',
            'method' => 'post'
        
        ));
        
        $table = new System_Db_Categories();
        
        $parent = new Zend_Dojo_Form_Element_FilteringSelect('parentId');
        $parent->setAttrib('name', 'parentId');
        $parent->setLabel('Parent Category?');
        $parent->setMultiOptions($table->fetchPagecategoryDropDown('Page'));
        
        $name = new Zend_Dojo_Form_Element_TextBox('categoryName');
        $name->setAttrib('name', 'categoryName');
        $name->setLabel('Category Name');
        
        
        $submit = new Zend_Dojo_Form_Element_SubmitButton('submit_wSO', array('ignore' => true, 'label' => 'Save'));
        $submit->setAttrib('onSubmit', 'return false;');
        
        
        $this->addElement($parent, 'parentId');
        $this->addElement($name, 'categoryName');
        $this->addElement($submit);
        
    }
}