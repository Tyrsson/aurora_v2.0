<?php

/**
 * User_Mode_User
 *
 * @author Joey
 * @version 1.1.1
 * @package Aurora
 * @subpackage User
 */
require_once 'System/Db/Table/Abstract.php';
require_once APPLICATION_PATH . '/modules/user/models/Row/User.php';
require_once APPLICATION_PATH . '/modules/user/models/Rowset/Users.php';

class User_Model_User extends System_Db_Table_Abstract
{

    public $isLogged = false;

    protected $_uStatus;

    /**
     *
     * @var (array) $_neededModels = array('form' => 'Zend_Form');
     *      create class properties that correspond to the array index as object instances of the array values string name
     */
    protected $_neededModels;

    protected $_resourceId;

    protected $_identity;

    protected $_role;

    protected $_acl;

    protected $_auth;

    protected $_name = 'user';

    //TODO:: Debug why this fails only for this table
    //protected $_primary = 'userId';

    protected $_sequence = true;

    protected $_rowClass = 'User_Model_Row_User';

    protected $_rowsetClass = 'User_Model_Rowset_Users';

    protected $_dependentTables = array(
        'Page_Model_Page',
        'User_Model_Profile',
        'User_Model_Locations',
        'Getaways_Model_Getaways',
        'Events_Model_Events'
    );
    
    public function init ()
    {
        parent::init();
    }

    public static function getName()
    {
        return self::$_name;
    }
    // check if user has a valid session
    public function checkSession()
    {
        self::setAuth();
        if ($this->_auth->hasIdentity()) {
            $this->isLogged = true;
            return true;
        } else {
            return false;
        }
    }

    public function getRole()
    {
        self::_setRole();
        return (string) $this->_role;
    }
    // Set auth object
    protected function setAuth()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    /**
     *
     * @param $userId (int)            
     */
    public function fetch($id)
    {
        $query = $this->select()
            ->from($this->_name, array(
            'userId',
            'role',
            'userName',
            'firstName',
            'lastName',
            'email',
            'uStatus',
            'registeredDate',
            'hash',
            'companyName'
        ))
            ->where('userId = ?', $id);
        
        $result = $this->fetchRow($query);
        
        return $result;
    }
    
    public function fetchUserDropDownList()
    {
        $query = $this->select()
        ->from($this->_name, array('key' => 'userId', 'value' => 'companyName'))
        ->where('companyName != ?', "")
        ->order('companyName');
        return $this->fetchAll($query)->toArray();
    }

    final protected function _setRole()
    {
        $this->_role = new User_Acl_Role_User();
    }

    public function setCompanyName($companyname)
    {
        $this->companyName = $companyname;
    }

    public function logOut()
    {
        if (self::checkSession()) {
            $this->_auth->clearIdentity();
            Zend_Session::destroy();
            if (Zend_Session::isDestroyed()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    /**
     * Zend_Acl_Resource
     */
    public function getUserRoleById($id)
    {
        // Zend_Debug::dump($id);
        if (null !== $id) {
            $query = $this->select()
                ->from('user', array(
                'userId',
                'role'
            ))
                ->where('userId = ?', $id);
            
            $result = $this->fetchRow($query);
            
            if (isset($result->role) && ! empty($result->role))
                
                return $result->role;
        } else {
            throw new Zend_Db_Exception('column role not returned');
        }
    }

    public function isAllowed($resource, $privilege)
    {
        return $this->_acl->isAllowed(self::getRole(), $resource, $privilege);
    }

    final public function checkAcl($privilege)
    {
        return $this->_acl->isAllowed(self::getRole(), $this, $privilege);
    }

    public function getTableName()
    {
        return $this->_name;
    }

    public function getOnePage($page = 1)
    {
        $acl = new User_Acl_Acl();
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            $requestingUser = $auth->getIdentity();
        }
        $query = $this->select();
        
        if ($requestingUser->role !== 'dxadmin') {
            $query->where('userId > ?', 0);
        }
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($query));
        $paginator->setItemCountPerPage(8);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }
}