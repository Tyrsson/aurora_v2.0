<?php
/**
 * Roles
 *
 * @author Joey
 * @version
 */
require_once 'Zend/Db/Table/Abstract.php';
class User_Model_Roles extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name = 'roles';
    protected $_primary = 'roleId';
    protected $_sequence = true;

    public function fetchRoleById($roleId)
    {
        $query = $this->select()->from($this->_name, array('roleId', 'role'))->where('roleId = ?', $roleId);
        $row = $this->fetchRow($query);
        return $row->role;
    }
    public function fetchIdByRole($roleName) {
        $query = $this->select()->from($this->_name, array('roleId', 'role'))->where('role = ?', $roleName);
        $row = $this->fetchRow($query);
        return $row->roleId;
    }
    public function fetchPrePopulate($roleName) {


    	//array('key' => 'pageId', 'value' => 'name')
    	$query = $this->select()->from($this->_name, array('key' => 'roleId', 'value' => 'role'))->where('role = ?', $roleName);
    	//$row = $this->fetchRow($query);
    	return $this->fetchRow($query);
    }
    public function fetchSelectOptions($order = 'DESC') {
        //array('key' => 'pageId', 'value' => 'name')
        $query = $this->select()->from($this->_name, array('key' => 'role', 'value' => 'publicName'))->order('roleId ' . $order);
        //$row = $this->fetchRow($query);
        return $this->fetchAll($query)->toArray();
    }
    public function fetchRoles()
    {
        $query = $this->select()
        ->from($this->_name, array('role'));
        return $this->fetchAll($query);
    }
    public function fetchAllRoles($excludeGuest = false, $defaultAdmin = false)
    {
    	$query = $this->select()->from($this->_name, array('key' => 'role', 'value' => 'publicName'));
    	if($excludeGuest) {
    	    $query->where('roleId != ?', 5);
    	}
    	if($defaultAdmin) {
    	    $query->order('roleId ASC');
    	}
    	else {
    	    $query->order('roleId DESC');
    	}
    	return $this->fetchAll($query)->toArray();
    }
}
