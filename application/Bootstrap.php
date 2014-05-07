<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    const DEFAULT_SKIN_NAME = 'default';
    const MOBILE_SKIN_NAME  = 'jquery.mobile';
    
    protected $db;
    protected $sessionConfig;
    protected $appSettings;
    protected $_logger;
    protected $_config;
    protected $_cache;
    protected $_isMobile = false;
    private   $_debug = false;
    
//     protected function _initRoutes()
//     {
//         $front = Zend_Controller_Front::getInstance();
//         $this->router = $front->getRouter();
    
//         $route = new Zend_Controller_Router_Route(
//                 ':cat/:page',
//                 array(
//                         'module'     => 'page',
//                         'controller' => 'index',
//                         'action'     => 'index',
//                         'cat'        => null,
//                         'page'        => 'Home',
//                         'format'     => 'html'
//                 ),
//                 array(
//                         'cat'     => '[a-zA-Z0-9_-]+',
//                         'page'     => '[a-zA-Z0-9_-]+',
//                         'format'  => '[a-z]+'
//                 )
//         );
//         $this->router->addRoute('landing', $route);
//     }
    protected function _initMysql() {
        $this->bootstrap('db');
        switch (APPLICATION_ENV) {
    
            case 'development' :
                //                 $profiler = new Zend_Db_Profiler_Firebug('System Queries');
                //                 $profiler->setEnabled(true);
                //                 $this->getPluginResource('db')->getDbAdapter()->setProfiler($profiler);
                break;
    
            case 'production' :
                Zend_Db_Table_Abstract::setDefaultMetadataCache($this->_cache);
                break;
        }
        // echo __METHOD__;
    }
    /**
     * Setup the logging
     */
    protected function _initLogging() {
        // table column mapping array
        $columnMapping = array(
                'userId' => 'userId',
                'userName' => 'userName',
                'timeStamp' => 'timeStamp',
                'priorityName' =>'priorityName',
                'priority' => 'priority',
                'message' => 'message');
    
        $this->bootstrap('frontController');
        $this->_logger = new System_Log();
        switch($this->_debug) {
            case true :
                $productionFilter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
                break;
            case false :
                $productionFilter = new Zend_Log_Filter_Priority(Zend_Log::INFO);
                break;
            default:
                $productionFilter = new Zend_Log_Filter_Priority(Zend_Log::INFO);
                break;
        }
        switch(APPLICATION_ENV) {
            case 'production' :
                $writer = new Zend_Log_Writer_Db(Zend_Db_Table_Abstract::getDefaultAdapter(), 'log', $columnMapping);
                $writer->addFilter($productionFilter);
                break;
            case 'development' :
                $writer = new Zend_Log_Writer_Firebug();
                break;
        }
        $this->_logger->addWriter($writer);
        Zend_Registry::set('log', $this->_logger);
        // echo __METHOD__;
    }
    protected function _initSession() {
        //if('production' == $this->getEnvironment()) {
        //$this->_logger->info('Bootstrap ' . __METHOD__);
        $this->sessionConfig = array(
                'name'           => 'session',
                'primary'        => 'id',
                'modifiedColumn' => 'modified',
                'dataColumn'     => 'data',
                'lifetimeColumn' => 'lifetime'
        );
        Zend_Session::setOptions(array(
        //'cookie_secure' => true, //only if using SSL
        //'use_only_cookies' => true,
        'gc_maxlifetime' => ( isset($this->appSettings->sessionLength) ) ? (int) $this->appSettings->sessionLength : 15 * 60, // use setting or fall back to 15 minutes
        'cookie_httponly' => true
        )
        );
    
        Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($this->sessionConfig));
        Zend_Session::start();
        // }
        //Zend_Session::regenerateId();
        // echo __METHOD__;
    }
    protected function _initSettings()
    {
        $table = new Zend_Db_Table('settings');
        Zend_Registry::set('appSettings', new stdClass());
        foreach($table->fetchAll() as $settings) {
            Zend_Registry::set($settings->variable, $settings->value);
        }
    }
    protected function _initSkin() {
        //Zend_Debug::dump($this->getAppNamespace());
        //$this->_logger->info('Bootstrap ' . __METHOD__);

        // make sure these are initialized for use
        $this->bootstrap('layout');
        $this->bootstrap('view');
        $this->bootstrap('useragent');

        $layout = $this->getResource('layout'); // get the layout object
        $view = $this->getResource('view'); //get the view object
        $ua = $this->getResource('useragent'); // get the user agent object
        
        $device = $ua->getDevice();
        
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);

        //TODO: Replace this with correct properties once db has been fully reintroduced 
        //$skin = new Admin_Model_SkinSettings();
        //$row = $skin->fetchCurrent();
        $row = new stdClass();
        $this->appSettings = new stdClass();
        
        $mobileSkinName = Zend_Registry::get('mobileSkinName');
        $row->skinName = 'default';
        
        if($device instanceof Zend_Http_UserAgent_Mobile && Zend_Registry::get('enableMobileSupport')) {
            
            
            if(isset($mobileSkinName) && !empty( $mobileSkinName )) 
            {
                $this->skinName = $mobileSkinName;
            }
            else {
                $this->skinName = self::MOBILE_SKIN_NAME;
            }
            
            $this->_isMobile = true;
            Zend_Registry::set('isMobile', true);
        }
        else {
        	Zend_Registry::set('isMobile', false);
            $this->skinName = $row->skinName;
        }
        
        Zend_Registry::set('skinName', $this->skinName);
        $isDefault = false;
       // die($this->skinName);
        /*
         * DO NOT MODIFY, WILL BREAK SKIN LOADING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        $viewRenderer->setViewBasePathSpec(APPLICATION_PATH . '/skins/' . $this->skinName)
        			->setViewScriptPathSpec(':module/:controller/:action.:suffix')
        			->setViewScriptPathNoControllerSpec(':action.:suffix');
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        $layout->setLayoutPath($viewRenderer->getViewBasePathSpec() . '/layouts');

        //Zend_View::setHelperPath(null);
        $view->addHelperPath('Zend/View/Helper', 'Zend_View_Helper');
        
        $view->addHelperPath("System/View/Helper/", "System_View_Helper");

        $view->addHelperPath("System/Dojo/View/Helper/", "System_Dojo_View_Helper");

        // add the default skins helper path
        $view->addHelperPath(APPLICATION_PATH . '/skins/' . self::DEFAULT_SKIN_NAME . '/helpers', ucfirst(self::DEFAULT_SKIN_NAME).'_View_Helper');

        if(is_dir($viewRenderer->getViewBasePathSpec() . '/' . $this->helpers)) {
        	$this->view->addHelperPath(APPLICATION_PATH . $viewRenderer->getViewBasePathSpec() . '/' . $this->helpers, ucfirst( $this->skinName ).'_View_Helper');
        }

        $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');


//         if($this->appSettings->enableFbOpenGraph) {
//         	$view->doctype('XHTML1_RDFA');
//         }
        
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

    }
    protected function _initActionHelpers()
    {
        //$this->_logger->info('Bootstrap ' . __METHOD__);
        Zend_Controller_Action_HelperBroker::addHelper(new System_Controller_Action_Helper_AdminAction());
    }
}

