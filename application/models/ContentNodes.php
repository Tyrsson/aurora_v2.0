<?php

/**
 * ContentNode
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';


class Aurora_Model_ContentNodes extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'content_nodes';
    protected $_sequence = true;
    protected $_primary = 'id';
    
    protected $_referenceMap = array(
        'Page' =>
            array(
                'columns' => array('page_id'),
                'refTableClass' => 'Aurora_Model_Pages',
                'refColumns'    => array('id'),
                'onDelete'      => self::CASCADE,
                'onUpdate'      => self::RESTRICT
            )
    );
    
    public function setNode($pageId, $node, $value)
    {
        // fetch the row if it exists
        $select = $this->select();
        $select->where("page_id = ?", $pageId);
        $select->where("node = ?", $node);
        $row = $this->fetchRow($select);
        //if it does not then create it
        if(!$row) {
            $row = $this->createRow();
            $row->page_id = $pageId;
            $row->node = $node;
        }
        //set the content
        $row->content = $value;
        $row->save();
    }
}
