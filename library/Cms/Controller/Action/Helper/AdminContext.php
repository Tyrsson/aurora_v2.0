<?php
/**
 *
 * @author Joey
 * @version 
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * AdminAction Action Helper
 *
 * @uses actionHelper System_Controller_Action_Helper
 */
class Cms_Controller_Action_Helper_AdminContext extends Cms_Controller_Action_Helper_ActionContext
{

    public function checkContext()
    {
    	$this->setDefaultRole();
        $controller = $this->getActionController();
        
//         if($this->_auth->hasIdentity()) {
//             $identity = $this->_auth->getIdentity();
//             $role = strtolower($identity->role);
//         } else {
//             $role = 'guest';
//         }
        // DO NOT REMOVE THIS CHECK !!!!!!!!!!!!!!!!!
        //Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($role);
        
        if (!$this->_acl->isAllowed($this->role, 'content', $this->_request->action)) {
            if ($this->role == 'guest') {
                $controller->forward('index', 'index', 'user', null);
            } else {
                $controller->forward('noauth', 'error', 'default', null);
            }
        }
        else {
            if($this->_request->controller === 'admin' || $controller->isAdmin) {
                $controller->getHelper('layout')->setLayout('admin');
            }
        }
        
    }
    
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        $this->checkContext();
        // TODO Auto-generated 'direct' method
    }
}
