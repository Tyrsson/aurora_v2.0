<?php

/**
 * Nodes
 *  
 * @author Joey Smith
 * @version 2.0.0
 */
require_once 'Zend/Db/Table/Abstract.php';

class Com_Model_Nodes extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'nodes';
    protected $_sequence = true;
    protected $_primary = 'id';
    
    protected $_dependentTables = array('');
    
    
}
