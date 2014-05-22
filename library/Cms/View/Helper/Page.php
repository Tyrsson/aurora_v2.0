<?php
/**
 *
 * @author jsmith
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Nodes helper
 *
 * @uses viewHelper Cms_View_Helper
 */
class Cms_View_Helper_Page extends Zend_View_Helper_Abstract 
{
	public $mapKey = 'Nodes';
	
	public $pageModel = 'Aurora_Model_Pages';
	
	public $nodeModel = 'Aurora_Model_ContentNodes';
	
	public $page;
	
	public $nodes;
	
	public $data = array();
	
	/**
	 *
	 * @var Zend_View_Interface
	 */
	public $view;
	
	/**
	 */
	public function page(Aurora_Model_Row_Page $page = null) {
	    
	    if($page != null) {
	      $this->setPage($page);
		  $nodeObject = new $this->nodeModel();
		  $this->setNodes($this->page->findDependentRowset($nodeObject, $this->mapKey, $nodeObject->select()->order('order ASC')));
	    }
        return $this;
	}
	public function getPageProperty($propName)
	{
	    //Zend_Debug::dump($this->nodes->toArray());
	    if(isset($this->page->$propName)) {
	        return $this->page->$propName;
	    }
	    $nodes = $this->nodes->toArray();
	    $nodeCount = count($this->nodes);
	    for ($i = 0; $i < $nodeCount; $i++) 
	    {
	        if(in_array($propName, $nodes[$i])) {
	            return $nodes[$i]['content'];
	        }
// 	        if(array_key_exists($propName, $this->nodes[$i]->toArray())) {
// 	            return $this->nodes[$i]['content'];
// 	        }
	    }
	}
// 	public function assemble($obj = false)
// 	{
// 	    $this->setData(array_merge($this->page->toArray(), $this->nodes->toArray()));
// 	    if($obj) {
// 	        (object) $this->data;
// 	    }
// 	    return $this->data;
// 	}
	/**
     * @return the $data
     */
    public function getData ()
    {
        return $this->data;
    }

	/**
     * @param multitype: $data
     */
    public function setData ($data)
    {
        $this->data = $data;
    }

	/**
	 * Sets the view field
	 * 
	 * @param $view Zend_View_Interface        	
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
	/**
     * @return the $page
     */
    public function getPage ()
    {
        return $this->page;
    }

	/**
     * @param field_type $page
     */
    public function setPage ($page)
    {
        $this->page = $page;
    }
	/**
     * @return the $nodes
     */
    public function getNodes ()
    {
        return $this->nodes;
    }

	/**
     * @param field_type $nodes
     */
    public function setNodes ($nodes)
    {
        $this->nodes = $nodes;
    }

	/**
     * @param multitype:string  $listNodes
     */
    public function setListNodes (array $listNodes)
    {

    }

    
    
}
