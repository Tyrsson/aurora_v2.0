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
    protected $_rowClass = 'Aurora_Model_Row_ContentNode';
    protected $_rowsetClass = 'Aurora_Model_Rowset_ContentNodes';
    
    protected $_referenceMap = array(
        'Nodes' =>
            array(
                'columns' => array('page_id'),
                'refTableClass' => 'Aurora_Model_Pages',
                'refColumns'    => array('id'),
                'onDelete'      => self::CASCADE,
                'onUpdate'      => self::RESTRICT
            )
    );

    public function saveNodes($data, $pageId)
    {
        //TODO:: this really belongs in the __set method of this row class
        foreach ($data as $node => $content) {
            $row = $this->createRow();
            $row->node = $node;
            $row->content = $content;
            $row->page_id = $pageId;
            $row->save();
        }
    }
    public function updateNodes($data, $pageRow)
    {
        try {
            $nodes = $pageRow->findDependentRowset(__CLASS__, 'Nodes');
            $nodeCount = $nodes->count();
            for ($i = 0; $i < $nodeCount; $i++) {
                $node = $nodes[$i];
                foreach($node as $columnName => $columnValue)
                {
                    if(array_key_exists($columnValue, $data))
                    {
                        if($columnValue === 'image' && $data[$columnValue] === null && $data['current_image'] != null) {
                            $data[$columnValue] = $data['current_image'];
                        } 
                        $node->content = $data[$columnValue];
                        
                        $node->save();
                    }
                }
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
    }
    public function fetchNode($node, $pageId)
    {
        
    }
}
