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
class System_Controller_Action_Helper_AdminAction extends Zend_Controller_Action_Helper_Abstract
{

    /**
     *
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    private $_auth;
    private $_acl;
    protected $_request;
    /**
     * Constructor: initialize plugin loader
     *
     * @return void
     */
    public function __construct ()
    {
        // TODO Auto-generated Constructor
        $this->pluginLoader = new Zend_Loader_PluginLoader();
        try {
            $this->_auth = Zend_Auth::getInstance();
            $this->_acl = new Zend_Acl();
            $this->_acl->addRole(new Zend_Acl_Role('guest'));
            $this->_acl->addRole(new Zend_Acl_Role('user', 'guest'));
            $this->_acl->addRole(new Zend_Acl_Role('admin', 'user'));
            
            // add the resources
            $this->_acl->add(new Zend_Acl_Resource('index'));
            $this->_acl->add(new Zend_Acl_Resource('admin'));
            $this->_acl->add(new Zend_Acl_Resource('error'));
            $this->_acl->add(new Zend_Acl_Resource('page'));
            $this->_acl->add(new Zend_Acl_Resource('menu'));
            $this->_acl->add(new Zend_Acl_Resource('menuitem'));
            $this->_acl->add(new Zend_Acl_Resource('user'));
            
            // set up the access rules
            $this->_acl->allow(null, array('index', 'error'));
            // a guest can only read content and login
            $this->_acl->allow('guest', 'page', array('index', 'open', 'list'));
            $this->_acl->allow('guest', 'menu', array('render'));
            $this->_acl->allow('guest', 'user', array('login'));
            // cms users can also work with content
            $this->_acl->allow('user', 'page', array('list', 'create', 'edit', 'delete'));
            // administrators can do anything
            $this->_acl->allow('admin', null);
            //Zend_Debug::dump();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    
    public function preDispatch()
    {
        $this->_request = $this->getRequest();

//         if($this->_auth->hasIdentity()) {
//             $identity = $this->_auth->getIdentity();
//             $role = strtolower($identity->role);
//         }else{
//             $role = 'guest';
//         }
//         if (!$this->_acl->isAllowed($role, $this->_request->controller, $this->_request->action)) {
//             if ($role == 'guest') {
//                 $this->_request->setControllerName('user');
//                 $this->_request->setActionName('login');
//             } else {
//                 $this->_request->setControllerName('error');
//                 $this->_request->setActionName('noauth');
//             }
//         }
//         else {
//             if($this->_request->controller === 'admin') {
//                 $controller = $this->getActionController();
//                 $controller->getHelper('layout')->setLayout('admin');
//             }
//         }
    }
    public function checkUser()
    {
        $controller = $this->getActionController();
        
        if($this->_auth->hasIdentity()) {
            $identity = $this->_auth->getIdentity();
            $role = strtolower($identity->role);
        }else{
            $role = 'guest';
        }
        if (!$this->_acl->isAllowed($role, $this->_request->controller, $this->_request->action)) {
            if ($role == 'guest') {
                $controller->redirect('/user');
                
                //$this->_request->setControllerName('user');
                //$this->_request->setActionName('login');
            } else {
                //$this->_request->setControllerName('error');
                //$this->_request->setActionName('noauth');
            }
        }
        else {
            if($this->_request->controller === 'admin') {
                $controller->getHelper('layout')->setLayout('admin');
            }
        }
        
    }
    
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        $this->checkUser();
        // TODO Auto-generated 'direct' method
    }
}
