<?php
require_once ('Zend/Db/Table/Row/Abstract.php');
/** 
 * @author Joey Smith
 * 
 * 
 */

class User_Model_Row_User extends Zend_Db_Table_Row_Abstract
{
	
	/**
	 * Name of the class of the Zend_Db_Table_Abstract object.
	 *
	 * @var string
	 */
	protected $_tableClass = 'User_Model_User';
	
	
	public function getUser()
	{
		if(isset($this->_data))
		{
			return $this->_data;
		}
	}
	public function getCompanyName()
	{
		
	}
	public function getRole()
	{
		if(isset($this->_data))
		{
			return (string) $this->_data['role'];
		}
	}
	public function getData()
	{
		return $this->_data;
	}	
}