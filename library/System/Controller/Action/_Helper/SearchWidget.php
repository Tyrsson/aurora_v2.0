<?php
/**
 *
 * @author Joey
 * @version 
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * SearchWidget Action Helper
 *
 * @uses actionHelper Search_Controller_Action_Helper
 */
class System_Controller_Action_Helper_SearchWidget extends Zend_Controller_Action_Helper_Abstract
{

    /**
     *
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
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
    }
    public function preDispatch()
    {
        $this->setRequest($this->getRequest());
    }
    public function search($queryData)
    {
        try {
        	
        	$index = Search_Service_Lucene::open(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'search');
        	
        	$post = $this->_request->getPost();
        	//Zend_Debug::dump($post);
        	if($post['searchState'] !== null && !empty($post['searchState']))
        	{
        		$searchState = $jsonData->getAbbreviation($post['searchState']);
        	}
        	
        	if($post['searchCat'] !== null && !empty($post['searchCat']))
        	{
        		$searchCat = $post['searchCat'];
        	}
        	
        	//multi term search
        	if(isset($searchCat) && isset( $searchState)) {
        		$hits = $index->find('"'.$searchState.'"^4 "'.$searchCat.'"');
        	}
        	elseif(isset($searchState) && !isset($searchCat)) {
        		$hits  = $index->find($searchState);
        	}
        	elseif(!isset($searchState) && isset($searchCat)) {
        		// single term search by category
        		$hits  = $index->find($searchCat);
        	}
        	
        	
        	$this->view->totalHits = count($hits);
        	$filteredHits = array();
        	$resultsArray = array();
        	foreach($hits as $i => $hit) {
        		$resultsArray[$i] = new stdClass();
        		$doc = $hit->getDocument();
        		foreach($doc->getFieldNames() as $field) {
        			$resultsArray[$i]->{$field} = $hit->{$field};
        		}
        	}
        	
        	$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($resultsArray));
        	
        	//TODO: Add a app setting to control the number of results per page
        	$paginator->setItemCountPerPage(10);
        	$paginator->setCurrentPageNumber($this->_request->page);
        	
        	$this->view->paginator = $paginator;
        	
        	
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
    }
    public function setRequest($request)
    {
        $this->_request = $request;
    }
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        // TODO Auto-generated 'direct' method
    }
}
