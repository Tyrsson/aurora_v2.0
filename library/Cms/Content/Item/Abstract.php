<?php
abstract class Cms_Content_Item_Abstract extends Zend_Db_Table_Abstract
{
    public $id;
    public $_nameSpace;
    
    public function init()
    {
        return $this;
    }
    public function loadContentObject($id)
    {
        
        

        if($row) {
            
            if($row->namespace != $this->_namespace) {
                throw new Zend_Exception('Unable to cast page type:' .
                        $row->namespace . ' to type:' . $this->_namespace);
            }
            $this->name = $row->name;
            $this->parent_id = $row->parent_id;
            $contentNode = new Aurora_Model_ContentNodes();
            $nodes = $row->findDependentRowset($contentNode);
            if($nodes) {
                $properties = $this->_getProperties();
                foreach ($nodes as $node) {
                    $key = $node['node'];
                    if(in_array($key, $properties)) {
                        // try to call the setter method
                        $value = $this->_callSetterMethod($key, $nodes);
                        if($value === self::NO_SETTER) {
                            $value = $node['content'];
                        }
                        $this->$key = $value;
                    }
                } 
            }
         } else {
                throw new Zend_Exception("Unable to load content item");
         } 

    }
	/**
     * @return the $id
     */
    public function getId ()
    {
        return $this->id;
    }

	/**
     * @param field_type $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

	/**
     * @return the $_nameSpace
     */
    public function getNameSpace ()
    {
        return $this->_nameSpace;
    }

	/**
     * @param field_type $_nameSpace
     */
    public function setNameSpace ($_nameSpace)
    {
        $this->_nameSpace = $_nameSpace;
    }

    
}