<?php
/**
 *
 * @author Joey Smith
 * @version
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

class Cms_Controller_Action_Helper_Navigation extends Zend_Controller_Action_Helper_Abstract
{
	protected $_container;
	public $appSettings;
	protected $request;
	// constructor, set navigation container
	public function __construct(Zend_Navigation $container = null)
	{
	    //$this->appSettings = Zend_Registry::get('appSettings');
		if (null !== $container)
		{
			$this->_container = $container;
		}
		
	}
	// check current request and set active page
	public function preDispatch()
	{
	    $this->request = $this->getRequest();
	    
	    if (null === $this->_container)
	    {

	        try {
// 	            $this->conManager = new System_Db_Categories();
// 	            $this->conManager->getTree()->toNavigation('Pages', false);
 	            $this->_container = Zend_Registry::get ( 'Zend_Navigation' );
	            
	            /*
            	 * for this to work as expected
            	 * the <setting>$value</setting> must match exactly what is in the db
            	 * also the <hassetting>true</hassetting> must also be in the config
            	 */
//             	$pagesToCheck = $this->_container->findAllBy('hassetting', true);
//             	foreach ($pagesToCheck as $filteredPage) {
//             	    if(property_exists($this->appSettings, "$filteredPage->setting"))
//                 	{
//                 	   $filteredPage->visible = $this->appSettings->{$filteredPage->setting};
//                 	}
//                 }

	        } catch (Exception $e) {
	            echo $e->getMessage();
	        }
	        	
	    }
	    if (null === $this->_container)
	    {
	        throw new RuntimeException ( 'Navigation container unavailable' );
	    }
	    @$this->_container->findBy ( 'uri', $this->getRequest ()->getRequestUri () )->active = true;
	    return $this->_container;
	    
	    // temp fix to add php 5.4 support
		//@$this->getContainer ()->findBy ( 'uri', $this->getRequest ()->getRequestUri () )->active = true;
	}
	
	// retrieve navigation container
	public function getContainer()
	{
// 		if (null === $this->_container)
// 		{
// 			$this->_container = Zend_Registry::get ( 'Zend_Navigation' );

// 			//$this->_container->addPages(self::getModulePages());

// 			//$this->_container->addPages(self::getUserPages());
// 			try {
// 			    $this->conManager = new System_Db_Categories();
// 			    $container = $this->conManager->getTree()->toNavigation('children');
// 			    //$this->_container->addPages($container);
// 			    die(__FILE__ . ' :: ' . __LINE__);
// 			    Zend_Debug::dump($container, 'return value');
// 			} catch (Exception $e) {
// 			    echo $e->getMessage();
// 			}
			
// 		}
// 		if (null === $this->_container)
// 		{
// 			throw new RuntimeException ( 'Navigation container unavailable' );
// 		}
// 		return $this->_container;
	}
	public function getUserPages() {

		$pages = array();
		$pages[] = Zend_Navigation_Page::factory(array(
				'label' => 'Account Summary',
				'uri'   => '/user/account/summary/' . $this->user->userId,
				'resource' => 'user',
				'privilege' => 'user.account-editown',
				'order' => 5
			)
		);
		return $pages;

	}
// 	public function getModulePages()
// 	{
//     	$pages = new Page_Model_Page();
//    		$result = $pages->fetchMainMenu(array('visibility' => 'public'));
//     	$pages = array();
//     	$i = 2;
//     	$priv = 'page.guest.view'; // default for public pages

//     	foreach ($result as $page) :

//     	if($page->url == 'home' || $page->url == 'Home')
//     	{
//     	    //continue;
//     	    $home = $this->_container->findOneBy('uri', '/');
//     	    $home->id = $page->url;
//     	    $home->order = ($page->pageOrder !== null) ? $page->pageOrder : $i;
//     	    $home->resource = 'page';
//     	    $home->privilege = "page.$page->role.view";
//     	    $home->visible = $this->appSettings->enableHomeTab;
//     	}
//     	if($page->url !== 'home' && $page->url !== 'Home') {
//         	$pages[] = Zend_Navigation_Page::factory(array(
//                                                         'label' => ucfirst($page->name),
//         	                                            'id'    => $page->url,
//                                                         'uri'   => '/page?url=' . $page->url,
//         												'resource' => 'page',
//         												'privilege' => "page.$page->role.view",
//                                                         'order' => ($page->pageOrder !== null) ? $page->pageOrder : $i,
//                                                       )
//                                                 );
//     	}
//     	++$i;
//     	endforeach;
//     	/*
//     	 * for this to work as expected
//     	 * the <setting>$value</setting> must match exactly what is in the db
//     	 * also the <hassetting>true</hassetting> must also be in the config
//     	 */
//     	$pagesToCheck = $this->_container->findAllBy('hassetting', true);
//     	foreach ($pagesToCheck as $filteredPage) {
//     	    if(property_exists($this->appSettings, "$filteredPage->setting"))
//     	    {
//     	        $filteredPage->visible = $this->appSettings->{$filteredPage->setting};
//     	    }
//     	    //Zend_Debug::dump($filteredPage->toArray());
//     	}
//     	return $pages;
// 	}

}