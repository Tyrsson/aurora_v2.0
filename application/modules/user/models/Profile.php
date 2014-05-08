<?php

/**
 * Profile
 *  
 * @author jsmith
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class User_Model_Profile extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'user_profile';
    protected $_primary = 'userId';
    
    protected $_referenceMap = array(
            'Locations' => array(
                    'columns' => array('userId'),
                    'refTableClass' => 'User_Model_User',
                    'refColumns' => array('userId'),
                    'onDelete'   => self::CASCADE
            )
    );
    
    public function fetchProfileRoles()
    {
        $table = new Zend_Db_Table('user_profile_roles');
        $table->select()->from('user_profile_roles', array('key' => 'roleId', 'value' => 'role'));
        //$roles = $table->fetchAll()->toArray();
        return $table->fetchAll()->toArray();
    }
}
