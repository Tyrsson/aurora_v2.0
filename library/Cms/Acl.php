<?php
class Cms_Acl extends Zend_Acl
{
	public function __construct($auth = null)
        {

			$model = new Zend_Db_Table('roles');
			$roles = $model->fetchAll()->toArray();
			$roles = array_reverse($roles);
			
			foreach($roles as $role) {
				$this->addRole($role['role'], $role['parentRole']);
				if($role['isDefaultRole']) {
					
				}
			}

            // These must be strings to reduce the number of includes when loading the acl for CkFinder

            $this->addResource(new Zend_Acl_Resource('login')); //<- Allows the hiding of the login navigation tab
            $this->addResource(new Zend_Acl_Resource('logout')); //<- Allows the hiding of the logout navigation tab

            $this->addResource(new Zend_Acl_Resource('content'));
            
            $this->addResource(new Zend_Acl_Resource('register'));
            $this->addResource(new Zend_Acl_Resource('user'));

            $this->addResource(new Zend_Acl_Resource('settings'));

            
            $this->allow('guest', null, array('view'));
            
            
            $this->allow('moderator', array('content'), array('create', 'edit'));
            
            //$this->allow('admin', array('content'), array('create', 'delete'));
            
            // DO NOT MODIFY THESE
            $this->deny('guest', array('logout'), array('view'));
            $this->deny('user', array('login', 'register'), array('view'));
            
            
            $this->allow('admin');
            //$this->deny('admin', array('dxadmin-summary'));
            
            
            /**
             * The below prevents logged users from seeing the login/register tabs
             */
            //$this->deny(new System_Acl_Role_User(), null, array('guest:login', 'guest:register'));
        }
}