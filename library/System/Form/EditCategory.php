<?php
class System_Form_EditCategory extends System_Form_CreateCategory
{
    public function init() 
    {
        parent::init();
        $this->setAttrib('action', '/admin/page/edit/category');
    }
}

