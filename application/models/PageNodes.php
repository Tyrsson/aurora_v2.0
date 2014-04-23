<?php

/**
 * page_nodes
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class Com_Model_PageNodes extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'page_nodes';
    protected $_sequence = true;
    protected $_primary = 'id';
    protected $_referenceMap = array(
	        'ComNodes' => array(
	                'columns' => array('nodeId'),
	                'refTableClass' => 'Com_Model_Nodes',
	                'refColumns' => array('id'),
	                'onDelete'   => self::CASCADE
	        ),
            'PageNodes' => array(
	                'columns' => array('pageId'),
	                'refTableClass' => 'Com_Model_Pages',
	                'refColumns' => array('id'),
	                'onDelete'   => self::CASCADE
	        )
	);
    
}
