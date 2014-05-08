<?php

/**
 * Pages
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class Aurora_Model_Pages extends Cms_Content_Item_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'pages';
    protected $_sequence = true;
    protected $_primary = 'id';
    public $_nameSpace = 'page';
    
    protected $_rowsetClass = 'Aurora_Model_Rowset_Pages';
    protected $_rowClass = 'Aurora_Model_Row_Page';
    
    protected $_dependentTables = array('Aurora_Model_ContentNodes');
    protected $_referenceMap = array(
        'Page' => array(
                    'columns' => array('parent_id'),
                    'refTableClass' => 'Aurora_Model_Pages',
                    'refColumns'    => array('id'),
                    'onDelete'      => self::CASCADE,
                    'onUpdate'      => self::RESTRICT
        )
    );
    
    public function init()
    {
        $this->nodes = new Aurora_Model_ContentNodes();
    }
    public function createPage($data, $parentId = 0)
    {
    	
        //create the new page
        $row = $this->createRow($data);

        $row->namespace = $this->_nameSpace;
        $row->parent_id = $parentId;
        
        $row->date_created = time();
        $row->save();
        
        $nodes = new Aurora_Model_ContentNodes();
        
        // now fetch the id of the row you just created and return it
        $id = $this->_db->lastInsertId();
        
        $this->nodes->saveNodes($data, $id);
            
        return $id;
    }
    public function updatePage($id, $data)
    {
    	Zend_Debug::dump(__METHOD__);
        // find the page
        $row = $this->find($id)->current();
        if($row) {
            // update each of the columns that are stored in the pages table
            $row->name = $data['name'];
            $row->parent_id = $data['parent_id'];
            $row->save();
            // unset each of the fields that are set in the pages table
            
            $this->nodes->updateNodes($data, $row);
            
        } else {
            throw new Zend_Exception('Could not open page to update!');
        }
    }
    public function fetch($id) 
    {
        $row = $this->find($id)->current();
        $nodes = $row->findDependentRowset($this->_dependentTables[0], 'Nodes');
        $data = array();
        foreach($nodes as $node)
        {
            $data[$node->node] = $node->content;
        }
        return array_merge($row->toArray(), $data);
    }
    public function deletePage($id)
    {
        // find the row that matches the id
        $row = $this->find($id)->current();
        if($row) {
            $row->delete();
            return true;
        } else {
            throw new Zend_Exception("Delete function failed; could not find page!");
        }
    }
}
