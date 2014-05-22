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
class Cms_View_Helper_Nodes extends Zend_View_Helper_Abstract 
{
	public $mapKey = 'Nodes';
	public $pageModel = 'Aurora_Model_Pages';
	public $nodeModel = 'Aurora_Model_ContentNodes';
	/**
	 *
	 * @var Zend_View_Interface
	 */
	public $view;
	
	/**
	 */
	public function nodes(Aurora_Model_Row_Page $page) {
		$nodeObject = new $this->nodeModel();		
		return $page->findDependentRowset($nodeObject, $this->mapKey, $nodeObject->select()->order('order ASC'));
	}
	
	/**
	 * Sets the view field
	 * 
	 * @param $view Zend_View_Interface        	
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
