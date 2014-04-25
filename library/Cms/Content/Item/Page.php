<?php

class Cms_Content_Item_Page extends Cms_Content_Item_Abstract
{
    public $id;
    public $name;
    public $headline;
    public $image;
    public $description;
    public $content;
    
    public function __construct($pageId = null)
    {
    	parent::__construct($pageId);
    	Zend_Debug::dump(__METHOD__);
    }
}