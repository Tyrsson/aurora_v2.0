<?php

/**
 * Pages
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class Aurora_Model_Pages extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'pages';
    protected $_sequence = true;
    protected $_primary = 'id';
    
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
    
    public function createPage($name, $namespace, $parentId = 0)
    {
    	Zend_Debug::dump(__METHOD__);
        //create the new page
        $row = $this->createRow();
        $row->name = $name;
        $row->namespace = $namespace;
        $row->parent_id = $parentId;
        $row->date_created = time();
        $row->save();
        // now fetch the id of the row you just created and return it
        $id = $this->_db->lastInsertId();
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
            unset($data['id']);
            unset($data['name']);
            unset($data['parent_id']);
            // set each of the other fields in the content_nodes table
            if(count($data) > 0) {
                $mdlContentNode = new Aurora_Model_ContentNodes();
                foreach ($data as $key => $value) {
                    $mdlContentNode->setNode($id, $key, $value);
                }
            }
        } else {
            throw new Zend_Exception('Could not open page to update!');
        }
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
