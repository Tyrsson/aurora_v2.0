<?php

/**
 * Locations
 *  
 * @author Joey
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class User_Model_Locations extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'user_locations';
    
    protected $_primary = 'id';
    
    protected $_sequence = true;
    
    protected $_rowsetClass = 'User_Model_Rowset_Locations';

    protected $_referenceMap = array(
        'Locations' => array(
                'columns' => array('userId'),
                'refTableClass' => 'User_Model_User',
                'refColumns' => array('userId'),
                'onDelete'   => self::CASCADE
        )
    );
    
    public function fetch($id, $userId = null, $primary = false)
    {
        $query = $this->select()
        ->from($this->_name)
        ->where('id = ?', $id);
        if(null !== $userId) {
            $query->where('userId = ?', $userId);
        }
        
    
        if($primary) {
        	$query->where('primary = ?', 1);
        }
        
        return $this->fetchRow($query);
    
    }
    
}
