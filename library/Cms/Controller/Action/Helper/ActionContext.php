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
class Cms_Controller_Action_Helper_ActionContext extends Zend_Controller_Action_Helper_Abstract
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
        $this->_acl = new Cms_Acl();
        $this->_auth = Zend_Auth::getInstance();
    }
    
    public function preDispatch()
    {
         $this->_request = $this->getRequest();
    }
    public function setupContext()
    {
    	$controller = $this->getActionController();
    	$this->_acl = new Cms_Acl();
    	$this->_auth = Zend_Auth::getInstance();
    	if($this->_auth->hasIdentity()) {
    		$this->identity = $this->_auth->getIdentity();
    		$this->role = strtolower($this->identity->role);
    	} else {
    		$this->role = 'guest';
    	}
    	// DO NOT REMOVE THIS CHECK !!!!!!!!!!!!!!!!!
    	Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($this->role);
    	
    	if (!$this->_acl->isAllowed($this->role, 'content', $this->_request->action)) {
    		if ($this->role == 'guest') {
    			$controller->forward('index', 'index', 'user', null);
    		} else {
    			$controller->forward('noauth', 'error', 'default', null);
    		}
    	}
    	else {
    		if($this->_request->controller === 'admin' || (isset($controller->isAdmin) && $controller->isAdmin) ) {
    			$controller->getHelper('layout')->setLayout('admin');
    		}
    	}
    }    
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        $this->setupContext();
        // TODO Auto-generated 'direct' method
    }
}
