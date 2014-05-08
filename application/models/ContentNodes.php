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
        if(isset($data['id'])) {
            unset($data['id']);
        }
        if(isset($data['name'])) {
            unset($data['name']);
        }
        foreach ($data as $node => $content) {
            $row = $this->createRow();
            $row->node = $node;
            $row->content = $content;
            //$row->setFromArray(array($node => $content));
            $row->page_id = $pageId;
            $row->save();
        }

    }
    public function updateNodes($data, $pageRow)
    {
        //Zend_Debug::dump($data);
        
        try {
            if(isset($data['id'])) {
                unset($data['id']);
            }
            if(isset($data['name'])) {
                unset($data['name']);
            }
            //Zend_Debug::dump($pageRow);
            $nodes = $pageRow->findDependentRowset(__CLASS__, 'Nodes');
            //Zend_Debug::dump($nodes->toArray());
            foreach ($nodes as $row) {
                
                if(in_array($row->node, $data))
                {
                    $row->content = $data[$row->node];
                    $row->save();
                }
                //$row->node = $node;
                //if($data)
                //$row->content = $content;
                //$row->save();
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        
    }
    public function fetchNode($node, $pageId)
    {
        
    }
}
