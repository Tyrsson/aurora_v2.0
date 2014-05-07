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
        'Page' =>
            array(
                'columns' => array('page_id'),
                'refTableClass' => 'Aurora_Model_Pages',
                'refColumns'    => array('id'),
                'onDelete'      => self::CASCADE,
                'onUpdate'      => self::RESTRICT
            )
    );

    public function saveNode($data, $pageId)
    {
        //Zend_Debug::dump($data);
        if(isset($data['id'])) {
            unset($data['id']);
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
}
