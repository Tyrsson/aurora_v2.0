<?php

require_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'User.php';

class Cms_Acl_Role_User implements Zend_Acl_Role_Interface
{

    protected $_roleId;
    public $_inheritsFrom = 'guest';
    public $_defaultRole = 'user';

    public function __construct()
    {
    	
    	return $this->getRoleId();
    }

    public function getRoleId()
    {
    	$this->user = new User_Model_User();

    	//Zend_Debug::dump($var)
    	try {
    	    switch(Zend_Auth::getInstance()->hasIdentity()) {
    	        case true :
    	            if(isset(Zend_Auth::getInstance()->getIdentity()->userId)) {
    	                $this->_roleId = $this->user->getUserRoleById(Zend_Auth::getInstance()->getIdentity()->userId);
    	                return  $this->_roleId;
    	            }
    	            break;

    	        case false :
    	            $this->_roleId = new Cms_Acl_Role_Guest();
    	            return $this->_roleId;
    	            break;
    	        default:
    	             //throw new Zend_Acl_Exception('Unknown role id');
    	            break;
    	    }
    	} catch (Exception $e) {
    	    echo $e->getMessage();
    	}

    }
    public function getDefaultRole()
    {
        return $this->_defaultRole;
    }
    public function getPrivsByRole($role)
    {
       //TODO: Design db table to hold privs
    }
    private function setPrivs()
    {
       //TODO: implement
    }
    public function __toString()
    {
        return (string) $this->getRoleId();
    }

}