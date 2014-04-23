<?php

/**
 * Pages
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class Com_Model_Pages extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'pages';
    protected $_sequence = true;
    protected $_primary = 'id';
    protected $_dependentTables = array('Com_Model_PageNodes');
    
    public function fetch($id = null, $uri = null)
    {
        $q = $this->select()->from($this->_name);
        switch(true) {
            case ($id !== null) :
                $q->where('id = ?', $id);
                break;
            case ($uri !== null) :
                $q->where('uri = ?', $uri);
                break;
            default :
                $q->where('id = ?', '1');
                break;
        }
        //$result = $this->fetchRow($q);
        //return $result->findDependentRowset('Com_Model_PageNodes', 'PageNodes');
        return $this->fetchRow($q);
    }
}
